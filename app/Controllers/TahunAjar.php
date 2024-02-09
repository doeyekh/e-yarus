<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TahunModel;
use Ramsey\Uuid\Uuid;
use \Hermawan\DataTables\DataTable;

class TahunAjar extends BaseController
{
    function __construct()
    {
        $this->tahun = new TahunModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Tahun Pelajaran',
            'menu' => 'master',
            'sub' => 'tahun'
        ];
        return view('admin/tahun',$data);
    }
    public function update()
    {
        if($this->request->isAJAX()){
            if($this->tahun->update(getTahun()->id_tahun,['status'=>'0'])){
                $this->tahun->update($this->request->getVar('id'),['status'=> 1]);
            }
        }
    }
    public function getData()
    {
        if($this->request->isAJAX())
        {
            $builder = $this->tahun->getData();
            return DataTable::of($builder)
            ->addNumbering('nomor')
            ->add('aksi',function($row){
                if($row->status == '0'){
                    return '<button type="button" id="'. $row->id_tahun.'" class="btn btn-danger btn-sm btn-status"><i class="bi bi-power"></i> Non Active</button>';
                }else{
                    return '<button type="button" class="btn btn-success btn-sm"><i class="bi bi-power"></i> Active</button>';
                    
                }
            })
            ->toJson(true);
        }
    }
    public function insert()
    {
        if($this->request->isAJAX()){
            $uuid = Uuid::uuid4()->toString();
            if(date('m') > 6 ){
                $smt = 'Ganjil';
                $akademik = date('Y') . ' / ' . date('Y') + 1;
            }else{
                $smt = 'Genap';
                $akademik = date('Y') - 1 . ' / ' . date('Y');
            }
            $cek = $this->tahun->where([
                'tahun' => date('Y'),
                'akademik' => $akademik,
                'smt' => $smt
            ])->first();
            if($cek){
                $msg = [
                    'icon' => 'error',
                    'title' => 'Tahun Berhasil Sudah Terdaftar'
                ];
            }else{
                if($this->tahun->insert([
                    'id_tahun' => $uuid,
                    'tahun' => date('Y'),
                    'akademik' => $akademik,
                    'smt' => $smt,
                    'status' => '0'
                ])){
                    $msg = [
                        'icon' => 'success',
                        'title' => 'Tahun Berhasil Ditambah'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }
}
