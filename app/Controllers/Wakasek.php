<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\LembagaModel;
use App\Models\WakasekModel;
use Hermawan\DataTables\DataTable;
use Ramsey\Uuid\Uuid;

class Wakasek extends BaseController
{
    function __construct()
    {
        $this->wakasek = new WakasekModel();
        $this->lembaga = new LembagaModel();
        $this->guru = new GuruModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Tugas Guru / Asyatid',
            'menu'  => 'guru',
            'sub'   => 'wakasek',
            'lembaga' => $this->lembaga->getData()->findAll(),
            'guru' => $this->guru->getData(['status'=> 1])->findAll()
        ];
        return view('admin/data-wakasek',$data);
    }
    public function getData()
    {
        if($this->request->isAJAX()){
            $data = $this->wakasek->getData(['id_tahun'=>getTahun()->id_tahun]);
            return DataTable::of($data)
            ->addNumbering('nomor')
            ->add('aksi',function($row){
                    $html = '<button type="button" id="'. $row->id_wakasek.'" class="btn btn-info btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-pencil-square"></i> Edit</button>';
                    if($row->is_active == 1 ) {
                        $html .= '<button type="button" data-id="0" id="'. $row->id_wakasek.'" class="btn btn-success btn-sm btn-status"><i class="bi bi-power"></i>Active</button>';
                    }else{
                        $html .= '<button type="button" data-id="1" id="'. $row->id_wakasek.'" class="btn btn-danger btn-sm btn-status"><i class="bi bi-power"></i>Non Active</button>';
                    }
                return $html;
            })
            ->toJson(true);
        }
    }
    public function edit()
    {
        if($this->request->isAJAX()){
            echo json_encode(
                $this->wakasek->getData(['id_wakasek'=>$this->request->getVar('id')])->first()
            );
        }
    }
    public function updateStatus()
    {
        if($this->request->isAJAX())
        {
            if($this->wakasek->update($this->request->getVar('id'),['is_active' => $this->request->getVar('status')])){
                $msg = ['sukses' => 'Berhasil'];
            }
            echo json_encode($msg);
        }
    }
    public function insert()
    {
        if($this->request->isAJAX()){
            $valid = $this->validate([
                'lembaga' => [
                    'label' => 'Lembaga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                    ]
                    ],
                'guru' => [
                    'label' => 'Lembaga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                    ]
                    ],
                'jabatan' => [
                    'label' => 'Lembaga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                    ]
                    ],
            ]);

            if(!$valid){
                $msg = [
                    'error'=> [
                        'lembaga' => $this->validation->getError('lembaga'),
                        'guru' => $this->validation->getError('guru'),
                        'jabatan' => $this->validation->getError('jabatan'),
                    ]
                ];
            }else{
                if($this->request->getVar('aksi')=='insert'){
                    if($this->wakasek->insert([
                        'id_wakasek' => Uuid::uuid4()->toString(),
                        'id_lembaga' => $this->request->getVar('lembaga'),
                        'id_tahun' => getTahun()->id_tahun,
                        'id_guru' => esc($this->request->getVar('guru')),
                        'jabatan' => esc($this->request->getVar('jabatan')),
                        'is_active' => 1
                    ])){
                        $msg = [
                            'sukses' => [
                                'icon' => 'success',
                                'pesan' => 'Data Berhasil Ditambahkan',
                                'head' => 'Horee'
                            ]
                        ];
                    }
                }
                if($this->request->getVar('aksi')=='update'){
                    if($this->wakasek->update($this->request->getVar('idwakasek'),[
                        'id_lembaga' => $this->request->getVar('lembaga'),
                        'id_guru' => esc($this->request->getVar('guru')),
                        'jabatan' => esc($this->request->getVar('jabatan')),
                    ])){
                        $msg = [
                            'sukses' => [
                                'icon' => 'success',
                                'pesan' => 'Data Berhasil Diperbaharui',
                                'head' => 'Horee'
                            ]
                        ];
                    }
                }
            }

            echo json_encode($msg);
        }
    }
}
