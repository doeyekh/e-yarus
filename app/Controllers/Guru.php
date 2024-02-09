<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use Hermawan\DataTables\DataTable;
use Ramsey\Uuid\Uuid;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Guru extends BaseController
{
    function __construct()
    {
        $this->guru = new GuruModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Guru Aktif',
            'menu' => 'guru',
            'sub' => 'guru-aktif'
        ];
        return view('admin/guru-aktif',$data);
    }
    public function guruNon()
    {
        $data = [
            'title' => 'Daftar Guru Non Aktif',
            'menu' => 'guru',
            'sub' => 'guru-nonaktif'
        ];
        return view('admin/guru-nonaktif',$data);
    }
    public function import()
    {
        if($this->request->isAJAX()){
            $valid = $this->validate([
                'file' => [
                    'label' => 'File',
                    'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]',
                    'errors' =>[
                        'uploaded' => '{field} Belum Dipilih',
                        'ext_in' => '{field} Bukan File Excel'
                    ]
                ],
            ]);
            if(!$valid){
                $msg = [
                    'error' => [
                        'file' => $this->validation->getError('file')
                    ]
                    ];
            }else{
                $file = $this->request->getFile('file');
                $extensi = $file->getClientExtension();
                if($extensi == 'xls'){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }else{
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($file);
                $guru = $spreadsheet->getActiveSheet()->toArray();
                $sukses = $gagal = 0;
                foreach ($guru as $key => $value) {
                    if($key == '0'){
                        continue;
                    }
                    $nik = $value[2];
                    $email = $value[6];
                    $where = "nik='$nik' OR email='$email'";
                    if($this->guru->where($where)->first()){
                        $gagal++;
                    }else{
                        if($this->guru->insert([
                            'id_guru' => Uuid::uuid4()->toString(),
                            'nama_guru' => $value[1],
                            'nik' => $value[2],
                            'tmp_lahir' => $value[3],
                            'tgl_lahir' => $value[4],
                            'email' => $value[6],
                            'notelp' => $value[7],
                            'jk' => $value[5],
                            'alamat' => $value[8],
                            'password' => password_hash('12345',PASSWORD_DEFAULT),
                            'foto' => 'guru.jpg',
                            'status' => 1
                        ])){
                            $sukses++;
                        }
                    }
                }
                $msg=[
                    'sukses' =>[
                        'icon' => 'success',
                        'head' => 'Hore..!',
                        'pesan' => $sukses . ' Berhasil Di Tambahkan ,'. $gagal . ' Gagal Ditambahkan'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }
    public function getDataGuruActive()
    {
        if($this->request->isAJAX()){
            $builder = $this->guru->getData(['status'=> '1']);
            return DataTable::of($builder)
                            ->addNumbering('nomor')
                            ->add('ttl',function($row){
                                return $row->tmp_lahir . ', ' . tgl_indo($row->tgl_lahir) ;
                            })
                            ->add('aksi',function($row){
                                $html = '<button type="button" id="'. $row->id_guru.'" class="btn btn-info btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-pencil-square"></i> Edit</button>';
                                $html .= '<button type="button" id="'. $row->id_guru.'" class="btn btn-success btn-sm btn-status"><i class="bi bi-power"></i>Active</button>';
                                return $html;
                            })
                            ->toJson(true);
        }
    }
    public function getDataGuruNonActive()
    {
        if($this->request->isAJAX()){
            $builder = $this->guru->getData(['status'=> '0']);
            return DataTable::of($builder)
                            ->addNumbering('nomor')
                            ->add('ttl',function($row){
                                return $row->tmp_lahir . ', ' . tgl_indo($row->tgl_lahir) ;
                            })
                            ->add('aksi',function($row){
                                $html = '<button type="button" id="'. $row->id_guru.'" class="btn btn-danger btn-sm btn-status"><i class="bi bi-power"></i>Non Active</button>';
                                return $html;
                            })
                            ->toJson(true);
        }
    }
    public function insertUpdate()
    {
        if($this->request->isAJAX())
        {
            $cekguru = $this->guru->getData(['id_guru'=> $this->request->getVar('idguru')])->first();
            // if($cekguru){
                if($this->request->getVar('nik') == $cekguru->nik){
                    $rulesnik = 'required';
                    $errornik = ['required'=> '{field} Tidak Boleh Kosong'];
                }else{
                    $rulesnik = 'required|is_unique[guru.nik]';
                    $errornik = [
                        'required'=> '{field} Tidak Boleh Kosong',
                        'is_unique' => '{field} Sudah Terdaftar'
                    ];
                }
                if($this->request->getVar('email') == $cekguru->email){
                    $ruleemail = 'required|valid_email';
                    $erroremail = ['required'=> '{field} Tidak Boleh Kosong','valid_email' => 'Mohon Masukan Alamat Email Yang Valid'];
                }else{
                    $ruleemail = 'required|is_unique[guru.email]|valid_email';
                    $erroremail = [
                        'required' => '{field} Tidak Boleh Kosong',
                        'is_unique' => '{field} Sudah Terdaftar',
                        'valid_email' => 'Mohon Masukan Alamat Email Yang Valid'
                    ];
                }
            
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Guru',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Harus Diisi'
                    ]
                    ],
                'nik' => [
                    'label' => 'No NIK',
                    'rules' => $rulesnik,
                    'errors' => $errornik
                    ],
                'email' => [
                    'label' => 'Email',
                    'rules' => $ruleemail,
                    'errors' => $erroremail
                ]
            ]);

            if(!$valid){
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama'),
                        'nik' => $this->validation->getError('nik'),
                        'email' => $this->validation->getError('email'),
                    ]
                ];
            }else{
                if($this->request->getVar('aksi')=='insert'){
                    if($this->guru->insert([
                        'id_guru' => Uuid::uuid4()->toString(),
                        'nama_guru' => esc($this->request->getVar('nama')),
                        'nik' => esc($this->request->getVar('nik')),
                        'tmp_lahir' => esc($this->request->getVar('tmp')),
                        'tgl_lahir' => esc($this->request->getVar('tgl')),
                        'email' => esc($this->request->getVar('email')),
                        'notelp' => esc($this->request->getVar('telp')),
                        'jk' => esc($this->request->getVar('jk')),
                        'alamat' => esc($this->request->getVar('alamat')),
                        'password' => password_hash('12345',PASSWORD_DEFAULT),
                        'foto' => 'guru.jpg',
                        'status' => 1
                    ])){
                        $msg = [
                            'sukses' => [
                                'icon' => 'success',
                                'pesan' => 'Data Berhasil DiTambahkan',
                                'title' => 'Horee... !'
                            ]
                        ];
                    }
                }
                if($this->request->getVar('aksi')=='update'){
                    if($this->guru->update($this->request->getVar('idguru'),
                    [
                        'nama_guru' => esc($this->request->getVar('nama')),
                        'nik' => esc($this->request->getVar('nik')),
                        'tmp_lahir' => esc($this->request->getVar('tmp')),
                        'tgl_lahir' => esc($this->request->getVar('tgl')),
                        'email' => esc($this->request->getVar('email')),
                        'notelp' => esc($this->request->getVar('telp')),
                        'jk' => esc($this->request->getVar('jk')),
                        'alamat' => esc($this->request->getVar('alamat')),
                    ])){
                        $msg = [
                            'sukses' => [
                                'icon' => 'success',
                                'pesan' => 'Data Berhasil Di Update',
                                'title' => 'Horee... !'
                            ]
                        ];
                    }
                }
            }
            echo json_encode($msg);
        }
    }
    public function edit()
    {
        if($this->request->isAJAX()){
            echo json_encode(
                $this->guru->getData(['id_guru'=> $this->request->getVar('id')])->first()
            );
        }
    }
    public function updateStatus()
    {
        if($this->request->isAJAX())
        {
            if($this->request->getVar('status')=='aktif'){
                $this->guru->update($this->request->getVar('id'),['status'=> '0']);
            }else{
                $this->guru->update($this->request->getVar('id'),['status'=> '1']);
            }
        }
    }
}
