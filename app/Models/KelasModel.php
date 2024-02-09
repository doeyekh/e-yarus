<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kelas';
    protected $primaryKey       = 'id_kelas';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kelas','id_lembaga','id_tahun','id_guru','level','nama_kelas'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getData($id=[])
    {
        return $this->select('id_kelas,lembaga.id_lembaga,lembaga.nama_lembaga,guru.id_guru,guru.nama_guru,level,nama_kelas,lembaga.jenis')
                    ->select('(SELECT count(*) FROM regis_siswa where regis_siswa.kelas_sekolah = kelas.id_kelas) as total_siswa')
                    ->select('(SELECT count(*) FROM regis_siswa where regis_siswa.kelas_pesantren = kelas.id_kelas) as total_santri')
                    ->join('lembaga','lembaga.id_lembaga=kelas.id_lembaga')
                    ->join('guru','guru.id_guru=kelas.id_guru')
                    ->where($id);
    }
}
