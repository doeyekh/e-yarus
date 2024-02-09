<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KantinModel;
use Hermawan\DataTables\DataTable;
use \Ramsey\Uuid\Uuid;

class Kantin extends BaseController
{
    function __construct()
    {
        $this->kantin = new KantinModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Kantin / Warung',
            'menu' => 'master',
            'sub' => 'kantin'
        ];
        return \view('admin/data-kantin',$data);
    }
    public function getData()
    {
        if($this->request->isAJAX())
        {
            $data = $this->kantin->getData();
            return DataTable::of($data)
                            ->addNumbering('nomor')
                            ->add('aksi',function($row){
                                $html = '<button type="button" id="'. $row->id_kantin.'" class="btn btn-info btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-pencil-square"></i> Edit</button>';
                                $html .= '<button type="button" id="'. $row->id_kantin.'" class="btn btn-success btn-sm btn-status"><i class="bi bi-power"></i>Active</button>';
                                return $html;
                            })
                            ->toJson(true);
        }
    }
    public function update(){
        if($this->request->isAJAX())
        {
            echo json_encode(
                $this->kantin->getData(['id_kantin'=> $this->request->getVar('id')])->first()
            );
        }
    }
    public function insert()
    {
        if($this->request->isAJAX())
        {
            $cek = $this->kantin->getData(['id_kantin'=> $this->request->getVar('idkantin')])->first();
            if($cek && $this->request->getVar('username') == $cek->username){
                $rulesuser = 'required';
                $erroruser = ['required'=> '{field} Tidak Boleh Kosong'];
            }else{
                $rulesuser = 'required|is_unique[kantin.username]';
                $erroruser = [
                    'required'=> '{field} Tidak Boleh Kosong',
                    'is_unique' => '{field} Sudah Terdaftar'
                    ];
            }

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Kantin / Warung',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                    ],
                'username' => [
                    'label' => 'Username',
                    'rules' => $rulesuser,
                    'errors' => $erroruser
                    ],
                'type' => [
                    'label' => 'Type',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ]
            ]);

            if(!$valid){
                $msg = [
                    'error' => [
                        'nama' => $this->validation->getError('nama'),
                        'username' => $this->validation->getError('username'),
                        'type' => $this->validation->getError('type')
                    ]
                ];
            }else{
                if($this->request->getVar('aksi')=='insert'){
                    if($this->kantin->insert([
                        'id_kantin' => Uuid::uuid4()->toString(),
                        'nama_kantin' => esc($this->request->getVar('nama')),
                        'username' => esc($this->request->getVar('username')),
                        'type' => esc($this->request->getVar('type')),
                        'is_active' => 1
                    ])){
                        $msg = [
                            'sukses' => [
                                'icon' => 'success',
                                'pesan' => 'Data Berhasil DiTambahkan',
                                'title' => 'Horee... !'
                            ]
                        ];
                    }
                }else{
                    if($this->kantin->update($this->request->getVar('idkantin'),
                    [
                        'nama_kantin' => esc($this->request->getVar('nama')),
                        'username' => esc($this->request->getVar('username')),
                        'type' => esc($this->request->getVar('type')),
                    ])){
                        $msg = [
                            'sukses' => [
                                'icon' => 'success',
                                'pesan' => 'Data Berhasil DiUpdate',
                                'title' => 'Horee... !'
                            ]
                        ];
                    }

                }
            }
            
            echo json_encode($msg);
        }
    }
}
