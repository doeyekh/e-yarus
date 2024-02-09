<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\LembagaModel;
use \Hermawan\DataTables\DataTable;
use Ramsey\Uuid\Uuid;

class Kelas extends BaseController
{
    function __construct()
    {
        $this->guru = new GuruModel();
        $this->lembaga = new LembagaModel();
        $this->kelas = new KelasModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Kelas',
            'menu' => 'master',
            'sub'  => 'kelas',
            'guru' => $this->guru->getData(['status'=> 1])->findAll(),
            'lembaga' => $this->lembaga->findAll()
        ];
        return view('admin/data-kelas',$data);
    }

    public function getData()
    {
        if($this->request->isAJAX()){
            $where = ['id_tahun'=>getTahun()->id_tahun];
            $builder = $this->kelas->getData($where);
            return DataTable::of($builder)
                            ->addNumbering('nomor')
                            ->add('kelas',function($row){
                                return $row->nama_kelas .' / '. $row->level ;
                            })
                            ->add('aksi',function($row){
                                $html = '<button type="button" id="'. $row->id_kelas.'" class="btn btn-info btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-pencil-square"></i> Edit</button>';
                                if($row->jenis == 1)
                                    $html .= '<button type="button" class="btn btn-warning btn-sm me-1"><i class="bi bi-people-fill"></i> '. $row->total_siswa .' Siswa</button>';
                                if($row->jenis == 2)
                                    $html .= '<button type="button" class="btn btn-warning btn-sm me-1"><i class="bi bi-people"></i> '. $row->total_santri .' Santri</button>';
                                if($row->total_santri == 0 && $row->total_siswa == 0) 
                                $html .= '<button type="button" id="'. $row->id_kelas.'" class="btn btn-danger btn-sm btn-status"><i class="bi bi-trash3"></i>Hapus</button>';
                                return $html;
                            })
                            ->toJson(true);
        }
    }

    public function delete()
    {
        if($this->request->isAJAX())
        {
            $this->kelas->delete($this->request->getVar('id'));
        }
    }
    public function update()
    {
        if($this->request->isAJAX()){
            echo json_encode(
                $this->kelas->getData(['id_kelas'=> $this->request->getVar('id')])->first()
            );
        }
    }
    public function insertUpdate()
    {
        if($this->request->isAJAX())
        {
            $valid = $this->validate([
                'namakelas' => [
                    'label' => 'Nama Kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum diisi'
                    ]
                ],
                'lembaga' => [
                    'label' => 'Lembaga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum dipilih'
                    ]
                ],
                'guru' => [
                    'label' => 'Wali Kelas',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum dipilih'
                    ]
                ],
                'level' => [
                    'label' => 'Level',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum dipilih'
                    ]
                ],
            ]);

            if(!$valid){
                $msg = [
                    'error' => [
                        'namakelas' => $this->validation->getError('namakelas'),
                        'lembaga' => $this->validation->getError('lembaga'),
                        'guru' => $this->validation->getError('guru'),
                        'level' => $this->validation->getError('level')
                    ]
                ];
            }else{
                $data = [
                    'nama_kelas' => esc($this->request->getVar('namakelas')),
                    'level' => esc($this->request->getVar('level')),
                    'id_guru' => esc($this->request->getVar('guru')),
                    'id_lembaga' => esc($this->request->getVar('lembaga')),
                    'id_tahun' => getTahun()->id_tahun
                ];
                $aksi = $this->request->getVar('aksi');
                $id = $this->request->getVar('idkelas');
                if ($aksi == 'insert') {
                    $data['id_kelas'] = Uuid::uuid4()->toString();
                    $result = $this->kelas->insert($data);
                } elseif ($aksi == 'update') {
                    $result = $this->kelas->update($id, $data);
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
