<?php

namespace App\Models;

use CodeIgniter\Model;

class RegisSiswa extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'regis_siswa';
    protected $primaryKey       = 'id_registrasi';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_registrasi','id_santri','id_sekolah','id_pesantren','kelas_sekolah','kelas_pesantren','id_tahun','nis','status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    function getData($id=[]){
        return $this->select('id_registrasi,santri.id_santri,santri.nama_santri,santri.tmp_lahir,santri.tgl_lahir,santri.nisn,nis,ortu.username,status')
                    ->join('santri','regis_siswa.id_santri = santri.id_santri')
                    ->join('ortu','santri.id_ortu=ortu.id_ortu')
                    ->where($id);
    }

    function getTarik($id=[]){
        return $this->select('id_registrasi,santri.id_santri,santri.nama_santri,santri.tmp_lahir,santri.tgl_lahir,santri.nisn,nis,ortu.username,status,id_tahun')
                    ->join('santri','regis_siswa.id_santri = santri.id_santri', 'left')
                    ->join('ortu','santri.id_ortu=ortu.id_ortu')
                    ->where($id);
    }

    function get($id=[]){
        return $this->join('santri','regis_siswa.id_santri=santri.id_santri')
                    ->where($id);
    }
}
