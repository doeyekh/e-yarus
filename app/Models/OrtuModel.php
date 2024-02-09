<?php

namespace App\Models;

use CodeIgniter\Model;

class OrtuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ortu';
    protected $primaryKey       = 'id_ortu';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_ortu','nama_ayah','nik_ayah','pekerjaan_ayah','notelp_ayah','nama_ibu','nik_ibu','pekerjaan_ibu','notelp_ibu','username','email'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getData($id=[]){
        return $this->select('id_ortu,nama_ayah,nama_ibu,nik_ayah,nik_ibu,notelp_ayah,notelp_ibu,email,username,pekerjaan_ayah,pekerjaan_ibu')  
                    ->select('(SELECT count(*) FROM santri where santri.id_ortu = ortu.id_ortu) as total_anak')
                    ->where($id);
    }

    function get($id=[]){
        return $this->where($id);
    }

}
