<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrtuModel;
use Hermawan\DataTables\DataTable;
use Ramsey\Uuid\Uuid;

class OrangTua extends BaseController
{
    function __construct()
    {
        $this->ortu = new OrtuModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Orang Tua Siswa',
            'menu' => 'siswa',
            'sub'  => 'orang-tua'
        ];
        return view('admin/data-ortu',$data);
    }
    public function getData()
    {
        if($this->request->isAJAX()){
            $builder = $this->ortu->getData();
            return DataTable::of($builder)
                            ->addNumbering('nomor')
                            ->add('aksi',function($row){
                                $html = '<button type="button" class="btn btn-info btn-sm btn-edit me-1"><i class="bi bi-people"></i> '. $row->total_anak.' Anak </button>';
                                $html .= '<button type="button" id="'. $row->id_ortu.'" class="btn btn-info btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-pencil-square"></i> Edit</button>';
                                if($row->total_anak < 1 )
                                $html .= '<button type="button" id="'. $row->id_ortu.'" class="btn btn-danger btn-sm btn-status"><i class="bi bi-trash"></i>Delete</button>';
                                return $html;
                            })
                            ->toJson(true);
        }
    }
    public function edit()
    {
        if($this->request->isAJAX()){
            echo json_encode(
                $this->ortu->get(['id_ortu'=> $this->request->getVar('id')])->first()
            );
        }
    }

    public function Delete()
    {
        if($this->request->isAjax()){
            $this->ortu->delete($this->request->getVar('id')); 
        }
    }
    public function insertUpdate()
    {
        if($this->request->isAJAX())
        {
            $aksi = $this->request->getVar('aksi');
            $id = $this->request->getVar('idortu');
            $nikayah = $this->ortu->get(['nik_ayah'=>$this->request->getVar('nikayah')])->first();
            $nikibu = $this->ortu->getData(['nik_ibu'=>$this->request->getVar('nikibu')])->first();
            $username = $this->ortu->getData(['username'=>$this->request->getVar('username')])->first();
            $email = $this->ortu->getData(['email'=>$this->request->getVar('email')])->first();
            $idortu = $this->ortu->getData(['id_ortu'=>$this->request->getVar('idortu')])->first();
            if($nikayah && $this->request->getVar('aksi') =='update' && $idortu->nik_ayah==$this->request->getVar('nikayah')){
                $rulesnikayah = 'required';
                $errorrulnikayah = [
                    'required' => '{field} Tidak Boleh Kosong',
                ];
            }else{
                $rulesnikayah = 'required|is_unique[ortu.nik_ayah]';
                $errorrulnikayah = [
                    'required' => '{field} Tidak Boleh Kosong',
                    'is_unique' => '{field} Sudah Terdaftar'
                ];
            }
            if($nikibu && $this->request->getVar('aksi') =='update' && $idortu->nik_ibu==$this->request->getVar('nikibu')){
                $rulesnikibu = 'required';
                $errorrulnikibu = [
                    'required' => '{field} Tidak Boleh Kosong',
                ];
            }else{
                $rulesnikibu = 'required|is_unique[ortu.nik_ibu]';
                $errorrulnikibu = [
                    'required' => '{field} Tidak Boleh Kosong',
                    'is_unique' => '{field} Sudah Terdaftar'
                ];
            }
            if($username && $this->request->getVar('aksi')=='update' && $idortu->username==$this->request->getVar('username')){
                $ruleusername = 'required';
                $errorusername = [
                        'required' => '{field} Tidak Boleh Kosong',
                ];
            }else{
                $ruleusername = 'required|is_unique[ortu.username]';
                $errorusername = [
                        'required' => '{field} Tidak Boleh Kosong',
                        'is_unique' => 'Username Sudah Terdaftar'
                ];
            }
            if($email && $this->request->getVar('aksi')=='update' && $idortu->email==$this->request->getVar('email')){
                $ruleemail = 'required|valid_email';
                $erroremail = [
                    'required' => '{field} Tidak Boleh Kosong',
                    'valid_email' => 'Harap Masukan Email Yang Valid',
                ];
            }else{
                $ruleemail = 'required|valid_email|is_unique[ortu.email]';
                $erroremail = [
                    'required' => '{field} Tidak Boleh Kosong',
                    'valid_email' => 'Harap Masukan Email Yang Valid',
                    'is_unique' => '{field} Sudah Terdaftar'
                ];
            }
            $valid = $this->validate([
                'namaayah' => [
                    'label' => 'Nama Ayah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                    ],
                'nikayah' => [
                    'label' => 'NIK Ayah',
                    'rules' => $rulesnikayah,
                    'errors' => $errorrulnikayah
                    ],
                'namaibu' => [
                    'label' => 'Nama Ibu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                    ],
                'nikibu' => [
                    'label' => 'NIK Ibu',
                    'rules' => $rulesnikibu,
                    'errors' => $errorrulnikibu
                    ],
                'username' => [
                    'label' => 'Username',
                    'rules' => $ruleusername,
                    'errors' => $errorusername
                    ],
                'email' => [
                    'label' => 'Email',
                    'rules' => $ruleemail,
                    'errors' => $erroremail
                    ],
            ]);

            if(!$valid){
                $msg = [
                    'error' => $this->validator->getErrors()
                ];
            }else{
                $data = [
                    'nama_ayah' => esc($this->request->getVar('namaayah')),
                    'nik_ayah' => esc($this->request->getVar('nikayah')),
                    'pekerjaan_ayah' => esc($this->request->getVar('pekerjaanayah')),
                    'notelp_ayah' => esc($this->request->getVar('telpayah')),
                    'nama_ibu' => esc($this->request->getVar('namaibu')),
                    'nik_ibu' => esc($this->request->getVar('nikibu')),
                    'pekerjaan_ibu' => esc($this->request->getVar('pekerjaanibu')),
                    'notelp_ibu' => esc($this->request->getVar('telpibu')),
                    'username' => esc($this->request->getVar('username')),
                    'email' => esc($this->request->getVar('email')),
                ];
    
                if ($aksi == 'insert') {
                    $data['id_ortu'] = Uuid::uuid4()->toString();
                    $result = $this->ortu->insert($data);
                } elseif ($aksi == 'update') {
                    $result = $this->ortu->update($id, $data);
                }
    
                if ($result) {
                    $msg = [
                        'sukses' => [
                            'icon' => 'success',
                            'pesan' => 'Data Berhasil ' . ($aksi == 'insert' ? 'Ditambahkan' : 'Di Update'),
                            'title' => 'Horee... !'
                        ]
                    ];
                }
                
            }

            echo json_encode($msg);
        }
    }

}
