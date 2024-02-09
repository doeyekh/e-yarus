<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\LembagaModel;
use Hermawan\DataTables\DataTable;
use Ramsey\Uuid\Uuid;

class Sekolah extends BaseController
{
    function __construct()
    {
        $this->lembaga = new LembagaModel();
        $this->guru = new GuruModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Sekolah',
            'guru' => $this->guru->getData()->findAll(),
            'menu' => 'master',
            'sub' => 'sekolah'
        ];
        return view('admin/data-sekolah',$data);
    }

    public function pesantren()
    {
        $data = [
            'title' => 'Daftar Pesantren',
            'guru' => $this->guru->getData()->findAll(),
            'menu' => 'master',
            'sub' => 'pesantren'
        ];
        return view('admin/data-pesantren',$data);
    }
    public function getPesantren()
    {
        if($this->request->isAJAX()){
            $builder = $this->lembaga->getData(['jenis'=>2]);
            return DataTable::of($builder)
                ->addNumbering('nomor')
                ->add('aksi',function($row){
                    $html = '<button type="button" id="'. $row->id_lembaga.'" class="btn btn-info btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-pencil-square"></i> Edit</button>';
                    return $html;
                })
                ->toJson(true);
        }
    }
    public function getData()
    {
        if($this->request->isAJAX()){
            $builder = $this->lembaga->getData(['jenis'=>1]);
            return DataTable::of($builder)
                ->addNumbering('nomor')
                ->add('aksi',function($row){
                    $html = '<button type="button" id="'. $row->id_lembaga.'" class="btn btn-info btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#modalId"><i class="bi bi-pencil-square"></i> Edit</button>';
                    return $html;
                })
                ->toJson(true);
        }
    }
    public function getSekolah()
    {
        if($this->request->isAJAX()){
            echo json_encode(
                $this->lembaga->getData(['id_lembaga'=>$this->request->getVar('id')])->first()
            );
        }
    }
    public function insertSekolah()
    {
        if($this->request->isAJAX()){
            $valid = $this->validate([
                'nama'=>[
                    'label' => 'Nama Lembaga',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh kosong'
                    ]
                    ],
                'guru' => [
                    'label' => 'Kepala Sekolah',
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
                        'guru' => $this->validation->getError('guru'),
                    ]
                 ];
            }else{
                if($this->request->getVar('aksi')=='insert'){
                    if($this->lembaga->insert([
                        'id_lembaga' => Uuid::uuid4()->toString(),
                        'id_guru' => esc($this->request->getVar('guru')),
                        'nama_lembaga' => esc($this->request->getVar('nama')),
                        'jenis' => esc($this->request->getVar('jenis')),
                        'jenjang' => esc($this->request->getVar('jenjang')),
                        'alamat' => esc($this->request->getVar('alamat')),
                        'foto' => 'logo.jpg'
                    ])){
                        $msg = [
                            'sukses' => [
                                'title' => 'Horee',
                                'pesan' => 'Lembaga Berhasil di Tambahkan',
                                'icon' => 'success'
                            ]
                        ];
                    }
                }else{
                    if($this->lembaga->update($this->request->getVar('idlembaga'),[
                        'id_guru' => esc($this->request->getVar('guru')),
                        'nama_lembaga' => esc($this->request->getVar('nama')),
                        'jenjang' => esc($this->request->getVar('jenjang')),
                        'alamat' => esc($this->request->getVar('alamat')),
                    ])){
                        $msg = [
                            'sukses' => [
                                'title' => 'Horee',
                                'pesan' => 'Lembaga Berhasil di Update',
                                'icon' => 'success'
                            ]
                        ];
                    }
                }
            }
            echo json_encode($msg);
        }
    }
}
