<?php

namespace App\Models;

use CodeIgniter\Model;

class KartuSantriModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kartusantri';
    protected $primaryKey       = 'id_kartu';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kartu','id_santri','rfid','nocard','qrcode','password','status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function get($id=[]){
        return $this->select('id_kartu,santri.id_santri,santri.nama_santri,rfid,nocard,qrcode,status')
                    ->join('santri','kartusantri.id_santri=santri.id_santri')
                    ->where($id);
    }
}
