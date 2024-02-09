<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'alumni';
    protected $primaryKey       = 'id_alumni';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_alumni','id_santri','tgl_keluar','alasan','tujuan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getData($id=[])
    {
        return $this->select('id_alumni,santri.nama_santri,santri.id_santri,alasan,tujuan')
                    ->join('santri','santri.id_santri=alumni.id_santri')
                    ->where($id);
    }
}
