<?php

namespace App\Models;

use CodeIgniter\Model;

class LembagaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lembaga';
    protected $primaryKey       = 'id_lembaga';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_lembaga','id_guru','nama_lembaga','jenis','jenjang','alamat','foto'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getData($id=[]){
        return $this->select('id_lembaga,lembaga.id_guru,nama_lembaga,jenis,jenjang,lembaga.alamat,lembaga.foto,guru.nama_guru')
                    ->join('guru','guru.id_guru=lembaga.id_guru')
                    ->where($id);
    }
}
