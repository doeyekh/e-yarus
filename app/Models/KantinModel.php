<?php

namespace App\Models;

use CodeIgniter\Model;

class KantinModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kantin';
    protected $primaryKey       = 'id_kantin';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kantin','nama_kantin','username','type','is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getData($id=[]){
        return $this->select('id_kantin,nama_kantin,username,type,is_active')
                    ->where($id);
    }
}
