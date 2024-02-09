<?php

namespace App\Models;

use CodeIgniter\Model;

class WakasekModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'wakasek';
    protected $primaryKey       = 'id_wakasek';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_wakasek','id_lembaga','id_tahun','id_guru','jabatan','is_active'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getData($id=[]){
        return $this->select('id_wakasek,guru.id_guru,guru.nama_guru,lembaga.nama_lembaga,lembaga.id_lembaga,jabatan,is_active')
                    ->join('guru','guru.id_guru=wakasek.id_guru')
                    ->join('lembaga','lembaga.id_lembaga=wakasek.id_lembaga')
                    ->where($id);
    }
}
