<?php

namespace App\Models;

use CodeIgniter\Model;

class SantriModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'santri';
    protected $primaryKey       = 'id_santri';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_santri','id_ortu','nama_santri','nik','nisn','jk','tmp_lahir','tgl_lahir','alamat','rt','rw','desa','kec','kab','prov','berkas','foto'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function get($id=[])
    {
        return $this
            ->join('ortu','santri.id_ortu=ortu.id_ortu')
            ->where($id);
    }
    function getData($id=[])
    {
        return $this->select('id_santri,nama_santri,tmp_lahir,tgl_lahir,nik,nisn')
                    ->where($id);
    }
}
