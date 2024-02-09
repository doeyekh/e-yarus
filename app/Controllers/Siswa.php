<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlumniModel;
use App\Models\KelasModel;
use App\Models\LembagaModel;
use App\Models\OrtuModel;
use App\Models\RegisSiswa;
use App\Models\SantriModel;
use Hermawan\DataTables\DataTable;
use Ramsey\Uuid\Uuid;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Siswa extends BaseController
{
    function __construct()
    {
        $this->lembaga = new LembagaModel();
        $this->ortu = new OrtuModel();
        $this->santri = new SantriModel();
        $this->registrasi = new RegisSiswa();
        $this->kelas = new KelasModel();
        $this->alumni = new AlumniModel();
    }
    public function index()
    {
        $kelas = $this->kelas->getData([
            'id_tahun' => getTahun()->id_tahun,
            'lembaga.jenis' => 1
        ])->findAll();
        $kelasp = $this->kelas->getData([
            'id_tahun' => getTahun()->id_tahun,
            'lembaga.jenis' => 2
        ])->findAll();
        $data = [
            'title' => 'Daftar Siswa Aktif',
            'menu' => 'siswa',
            'sub'  => 'siswa-aktif',
            'sekolah' => $kelas,
            'pesantren' => $kelasp,
            'ortu' => $this->ortu->findAll()
        ];
        return view('admin/data-siswa',$data);
    }
    public function tarikRegistrasi()
    {
        $kelas = $this->kelas->getData([
            'id_tahun' => getTahun()->id_tahun,
            'lembaga.jenis' => 1
        ])->findAll();
        $kelasp = $this->kelas->getData([
            'id_tahun' => getTahun()->id_tahun,
            'lembaga.jenis' => 2
        ])->findAll();
        $data = [
            'title' => 'Salin Registrasi Santri',
            'menu' => 'siswa',
            'sub'  => 'siswa-aktif',
            'sekolah' => $kelas,
            'pesantren' => $kelasp,
            'ortu' => $this->ortu->findAll()
        ];
        return view('admin/tarik-siswa',$data);
    }
    public function getTarikRegistrasi()
    {
        if($this->request->isAJAX()){
            $builder = $this->santri->getData();
            return DataTable::of($builder)
                            ->add('aksi',function($row){
                                $check = '<input type="checkbox" value="'.$row->id_santri.'" name="idsantri[]" class="centangid">';
                                return $check;
                            })
                            ->add('ttl',function($row){
                                return $row->tmp_lahir . ', ' . tgl_indo($row->tgl_lahir) ;
                            })
                            ->add('nipd',function($row){
                                return $row->nik .' / '. $row->nisn ;
                            })
                            ->toJson(true);
        }
    }
    
    public function salinRegistrasi()
    {
        if($this->request->isAJAX()){
            $idsantri = $this->request->getVar('idsantri');
            $sekolah = $this->kelas->getData(['id_kelas'=> $this->request->getVar('sekolah')])->first();
            $pesantren = $this->kelas->getData(['id_kelas'=> $this->request->getVar('pesantren')])->first();
            if($sekolah){
                $lembagaSekolah = $sekolah->id_lembaga;
                $kelasSekolah = $sekolah->id_kelas;
            }else{
                $lembagaSekolah = null;
                $kelasSekolah = null;
            }
            if($pesantren){
                $lembagaPesantren = $pesantren->id_lembaga;
                $kelasPesantren = $pesantren->id_kelas;
            }else{
                $lembagaPesantren = null;
                $kelasPesantren = null;
            }
            $jml = count($idsantri);
            $sukses = $gagal = $update = 0 ;
            for ($i=0; $i < $jml ; $i++) { 
                $ceksantri = $this->registrasi->getData(['id_tahun'=>getTahun()->id_tahun,'regis_siswa.id_santri' => $idsantri[$i]])->first();
                if($ceksantri){
                    if($ceksantri->status < 1 ){
                        $cekalumni = $this->alumni->getData(['alumni.id_santri'=> $ceksantri->id_santri])->first();
                        if($this->alumni->delete($cekalumni->id_alumni)){
                            if($this->registrasi->update($ceksantri->id_registrasi,['status'=> 1])){
                                $update++;
                            }
                        }
                    }else{
                        $gagal++;
                    }
                }else{
                    $cekalumni = $this->alumni->getData(['alumni.id_santri'=> $idsantri[$i]])->first();
                    if($cekalumni){
                        if($this->alumni->delete($cekalumni->id_alumni)){
                            $result = $this->registrasi->insert(
                                [
                                    'id_registrasi' => Uuid::uuid4()->toString(),
                                    'id_santri' => $idsantri[$i],
                                    'id_sekolah' => $lembagaSekolah,
                                    'id_pesantren' => $lembagaPesantren,
                                    'kelas_sekolah' => $kelasSekolah,
                                    'kelas_pesantren' => $kelasPesantren,
                                    'id_tahun' => getTahun()->id_tahun,
                                    'status' => 1
                                ]
                                );
                            if($result){
                                $sukses++;
                            }
                        }
                    }else{
                        $result = $this->registrasi->insert(
                            [
                                'id_registrasi' => Uuid::uuid4()->toString(),
                                'id_santri' => $idsantri[$i],
                                'id_sekolah' => $lembagaSekolah,
                                'id_pesantren' => $lembagaPesantren,
                                'kelas_sekolah' => $kelasSekolah,
                                'kelas_pesantren' => $kelasPesantren,
                                'id_tahun' => getTahun()->id_tahun,
                                'status' => 1
                            ]
                            );
                        if($result){
                            $sukses++;
                        }
                    }
                    
                }
            }
            $msg=[
                'sukses' =>[
                    'icon' => 'success',
                    'head' => 'Hore..!',
                    'pesan' => $sukses . ' Berhasil Di Tambahkan ,'. $update . ' Diperbaharui'. $gagal . ' Gagal Ditambahkan'
                ]
            ];
            echo json_encode($msg);
        }
    }

    public function getData()
    {
        if($this->request->isAJAX()){
            $where = ['status'=> '1','id_tahun'=>getTahun()->id_tahun];
            $builder = $this->registrasi->getData($where);
            return DataTable::of($builder)
                            ->addNumbering('nomor')
                            ->add('ttl',function($row){
                                return $row->tmp_lahir . ', ' . tgl_indo($row->tgl_lahir) ;
                            })
                            ->add('nipd',function($row){
                                return $row->nis .' / '. $row->nisn ;
                            })
                            ->add('aksi',function($row){
                                $html = '<a href="'. base_url('admin/santri/').$row->id_santri .'" class="btn btn-info btn-sm me-1"> <i class="bi bi-person-check"></i> Detail </a>';
                                $html .= '<button type="button" id="'. $row->id_santri.'" regis="'. $row->id_registrasi.'" class="btn btn-danger btn-sm btn-status" data-bs-toggle="modal" data-bs-target="#modalAlumni"><i class="bi bi-trash"></i> Hapus</button>';
                                return $html;
                            })
                            ->toJson(true);
        }
    }
    public function detail($id)
    {
        $santri = $this->santri->get(['id_santri'=>$id])->first();
        $registrasi = $this->registrasi->get([
            'santri.id_santri'=> $id,
            'id_tahun'=> getTahun()->id_tahun
            ])->first();
        $kelas = $this->kelas->getData([
                'id_tahun' => getTahun()->id_tahun,
                'lembaga.jenis' => 1
            ])->findAll();
        $kelasp = $this->kelas->getData([
                'id_tahun' => getTahun()->id_tahun,
                'lembaga.jenis' => 2
            ])->findAll();
        if($santri){
            $data = [
                'title' => 'Detail Santri ' . $santri->nama_santri,
                'menu' => 'siswa',
                'sub'  => 'siswa-aktif',
                'santri' => $santri,
                'ortu' => $this->ortu->get()->findAll(),
                'registrasi' => $registrasi,
                'sekolah' => $kelas,
                'pesantren' => $kelasp,
            ];
            return view('admin/detail-siswa',$data);
        }else{
           return redirect()->to(base_url().'admin/siswa-aktif');
        }
    }
    public function updateRegis()
    {
        if($this->request->isAJAX())
        {
            $sekolah = $this->kelas->getData(['id_kelas'=> $this->request->getVar('kelas')])->first();
            $pesantren = $this->kelas->getData(['id_kelas'=> $this->request->getVar('kelasp')])->first();
            $id = $this->request->getVar('idregistrasi');
            $result = $this->registrasi->update($id,[
                'nis' => esc($this->request->getVar('nis')),
                'kelas_pesantren' => $this->request->getVar('kelasp'),
                'kelas_sekolah' => $this->request->getVar('kelas'),
                'id_sekolah' => $sekolah->id_lembaga,
                'id_pesantren' => $pesantren->id_lembaga,
            ]);
            if($result){
                $msg = [
                    'sukses' => [
                        'icon' => 'success',
                        'pesan' => 'Data Berhasil Diupdate',
                        'title' => 'Horee... !'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }
    public function updateOrtu()
    {
        if($this->request->isAJAX())
        {
            $id = $this->request->getVar('idsantri');
            if($this->santri->update($id,[
                'id_ortu' => esc($this->request->getVar('ortu'))
            ])){
                $msg = [
                    'sukses' => [
                        'icon' => 'success',
                        'pesan' => 'Data Berhasil Diupdate',
                        'title' => 'Horee... !'
                    ]
                ];
            }

            echo json_encode($msg);
        }
    }
    public function update()
    {
        if($this->request->isAJAX())
        {
            $idsantri = $this->request->getVar('idsantri');
            $cek = $this->santri->get(['id_santri'=>$idsantri])->first();
            if($cek->nik == $this->request->getVar('nik')){
                $rulenik = 'required';
                $errornik = [
                    'required' => '{field} Tidak Boleh Kosong',
                ];
            }else{
                $rulenik = 'required|is_unique[santri.nik]';
                $errornik = [
                    'required' => '{field} Tidak Boleh Kosong',
                    'is_unique' => 'No NIK Sudah Terdaftar Silahkan Lakukan Tarik Data / Masukan No NIK Lain'
                ];
            }
            if($cek->nisn == $this->request->getVar('nisn')){
                $rulenisn = 'required';
                $errornisn = [
                    'required' => '{field} Tidak Boleh Kosong',
                ];
            }else{
                $rulenisn = 'required|is_unique[santri.nisn]';
                $errornisn = [
                    'required' => '{field} Tidak Boleh Kosong',
                    'is_unique' => 'No NIK Sudah Terdaftar Silahkan Lakukan Tarik Data / Masukan No NIK Lain'
                ];
            }

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Santri',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ],
                'nik' => [
                    'label' => 'NIK Santri',
                    'rules' => $rulenik,
                    'erros' => $errornik
                ],
                'nisn' => [
                    'label' => 'No NISN',
                    'rules' => $rulenisn,
                    'erros' => $errornisn
                ],
            ]);

            if(!$valid){
                $msg = [
                    'error' => $this->validator->getErrors()
                ];
            }else{
                if($this->santri->update($idsantri,[
                    'nama_santri' => esc($this->request->getVar('nama')),
                    'nik' => esc($this->request->getVar('nik')),
                    'nisn' => esc($this->request->getVar('nisn')),
                    'jk' => esc($this->request->getVar('jk')),
                    'tmp_lahir' => esc($this->request->getVar('tmp')),
                    'tgl_lahir' => esc($this->request->getVar('tgl')),
                    'alamat' => esc($this->request->getVar('alamat')),
                    'rt' => esc($this->request->getVar('rt')),
                    'rw' => esc($this->request->getVar('rw')),
                    'desa' => esc($this->request->getVar('desa')),
                    'kec' => esc($this->request->getVar('kec')),
                    'kab' => esc($this->request->getVar('kab')),
                    'prov' => esc($this->request->getVar('prov')),
                ])){
                    $msg = [
                        'sukses' => [
                            'icon' => 'success',
                            'pesan' => 'Data Berhasil Diupdate',
                            'title' => 'Horee... !'
                        ]
                    ];
                }
            }

            echo json_encode($msg);
        }
    }
    public function insert()
    {
        if($this->request->isAjax())
        {
            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Santri',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong'
                    ]
                ],
                'nik' => [
                    'label' => 'NIK Santri',
                    'rules' => 'required|is_unique[santri.nik]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'is_unique' => 'No NIK Sudah Terdaftar Silahkan Lakukan Tarik Data / Masukan No NIK Lain'
                    ]
                ],
                'nisn' => [
                    'label' => 'NISN',
                    'rules' => 'required|is_unique[santri.nisn]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'is_unique' => 'No NISN Sudah Terdaftar Silahkan Lakukan Tarik Data / Masukan No NISN Lain'
                    ]
                ],
                'ortu' => [
                    'label' => 'Orang Tua',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih',
                    ]
                ],
            ]);

            if(!$valid){
                $msg = [
                    'error' => $this->validator->getErrors()
                ];
            }else{
                $sekolah = $this->kelas->getData(['id_kelas'=> $this->request->getVar('sekolah')])->first();
                $pesantren = $this->kelas->getData(['id_kelas'=> $this->request->getVar('pesantren')])->first();
                $uuid = Uuid::uuid4()->toString();
                $data = [
                    'id_santri' => $uuid,
                    'nama_santri' => esc($this->request->getVar('nama')),
                    'nik' => esc($this->request->getVar('nik')),
                    'nisn' => esc($this->request->getVar('nisn')),
                    'jk' => esc($this->request->getVar('jk')),
                    'tmp_lahir' => esc($this->request->getVar('tmp')),
                    'tgl_lahir' => esc($this->request->getVar('tgl')),
                    'alamat' => esc($this->request->getVar('alamat')),
                    'rt' => esc($this->request->getVar('rt')),
                    'rw' => esc($this->request->getVar('rw')),
                    'desa' => esc($this->request->getVar('desa')),
                    'kec' => esc($this->request->getVar('kecamatan')),
                    'id_ortu' => esc($this->request->getVar('ortu')),
                    'foto' => 'user.jpg'
                ];
                if($this->santri->insert($data)){
                    $result = $this->registrasi->insert(
                        [
                            'id_registrasi' => Uuid::uuid4()->toString(),
                            'id_santri' => $uuid,
                            'id_sekolah' => $sekolah->id_lembaga,
                            'id_pesantren' => $pesantren->id_lembaga,
                            'kelas_sekolah' => $sekolah->id_kelas,
                            'kelas_pesantren' => $pesantren->id_kelas,
                            'id_tahun' => getTahun()->id_tahun,
                            'status' => 1
                        ]
                        );
                    if($result){
                        $msg = [
                            'sukses' => [
                                'icon' => 'success',
                                'pesan' => 'Data Berhasil Ditambahkan',
                                'title' => 'Horee... !'
                            ]
                        ];
                    }
                }
            }

            echo json_encode($msg);
        }
    }

    public function upload($id)
    {
        if($this->request->isAJAX())
        {
            $valid = $this->validate([
                'foto' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[foto]|max_size[foto,1024]|mime_in[foto,image/png,image/jpeg,image/jpg]|ext_in[foto,png,jpg,gif,jpeg]|is_image[foto]',
                    'errors' =>[
                        'uploaded' => '{field} Belum Dipilih',
                        'ext_in' => '{field} Bukan File Foto',
                        'mime_in' => 'Yang Anda Pilih Bukan File Foto',
                        'is_image' => '{field} Bukan Gambar',
                        'max_size' => 'Ukuran Foto Terlalu Besar',
                    ]
                    ],
            ]);
            if(!$valid){
                $msg = [
                    'error' =>[
                        'foto' => $this->validation->getError('foto'),
                    ]
                    ];
            }else{
                $foto = $this->request->getFile('foto');
                $sampul = $foto->getRandomName();
                $foto->move('assets/img/siswa/',$sampul);
                $siswa = $this->santri->get(['id_santri' => $id])->first();
                if($siswa->foto !='user.jpg'){
                    unlink('assets/img/siswa/'.$siswa->foto);
                }
                $data =['foto'=> $sampul];
                $save = $this->santri->update($id, $data);
                if($save){
                    $msg = [
                        'sukses' => [
                            'icon' => 'success',
                            'pesan' => 'Foto Berhasil DiUpdate',
                            'title' => 'Horee... !'
                        ]
                    ];
                }
            }

            echo json_encode($msg);
        }
    }
    public function regisAlumni()
    {
        if($this->request->isAJAX())
        {
            $valid = $this->validate([
                'alasan'=>[
                    'label' => 'Alasan Keluar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Belum Dipilih'
                    ]
                ]
            ]);
            if(!$valid){
                $msg = [
                    'error' => [
                        'alasan' => $this->validation->getError('alasan')
                    ]
                ];
            }else{
                $result = $this->registrasi->update($this->request->getVar('idreg'),['status'=> '0']);
                if($result){
                    $alumni = $this->alumni->insert([
                        'id_alumni' => Uuid::uuid4()->toString(),
                        'id_santri' => $this->request->getVar('idsan'),
                        'alasan' => $this->request->getVar('alasan'),
                        'tujuan' => $this->request->getVar('tujuan'),
                        'tgl_keluar' => date('Y-m-d')
                    ]);
                    if($alumni){
                        $msg = [
                            'sukses' => [
                                'icon' => 'success',
                                'pesan' => 'Siswa Telah Dipindahkan Ke Tabel Alumni',
                                'title' => 'Horee... !'
                            ]
                        ];
                    }
                }
            }

            echo json_encode($msg);
        }
    }

    public function indexAlumni()
    {
        $data = [
            'title' => 'Daftar Alumni',
            'menu' => 'siswa',
            'sub'  => 'alumni',
        ];
        return view('admin/data-alumni',$data);
    }
    public function getAlumni()
    {
        if($this->request->isAJAX())
        {
            $builder = $this->alumni->getData();
            return DataTable::of($builder)
                            ->addNumbering('nomor')
                            ->add('aksi',function($row){
                                $html = '<a href="'. base_url('admin/santri/').$row->id_santri .'" class="btn btn-info btn-sm me-1"> <i class="bi bi-person-check"></i> Detail </a>';
                                if($row->alasan == 'Mutasi')
                                    $html .= '<button type="button" id="'. $row->id_santri.'" class="btn btn-primary btn-sm btn-pindah" data-bs-toggle="modal" data-bs-target="#modalAlumni"><i class="bi bi-printer"></i> Surat Pindah </button>';
                                return $html;
                            })
                            ->toJson(true);
        }
    }
    public function importSantri()
    {
        if($this->request->isAJAX()){
            $valid = $this->validate([
                'file' => [
                    'label' => 'File',
                    'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]',
                    'errors' =>[
                        'uploaded' => '{field} Belum Dipilih',
                        'ext_in' => '{field} Bukan File Excel'
                    ]
                ],
            ]);
            if(!$valid){
                $msg = [
                    'error' => [
                        'file' => $this->validation->getError('file')
                    ]
                    ];
            }else{
                $file = $this->request->getFile('file');
                $extensi = $file->getClientExtension();
                if($extensi == 'xls'){
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }else{
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadsheet = $reader->load($file);
                $santri = $spreadsheet->getActiveSheet()->toArray();
                $sekolah = $this->kelas->getData(['id_kelas'=> $this->request->getVar('sekolah')])->first();
                $pesantren = $this->kelas->getData(['id_kelas'=> $this->request->getVar('pesantren')])->first();
                $sukses = $gagal = 0;
                foreach ($santri as $key => $value) {
                    if($key == '0'){
                        continue;
                    }
                    $nikayah = $value[16];
                    $cekortu = $this->ortu->get(['nik_ayah'=> $nikayah])->first();
                    $ceksantri = $this->santri->get(['nik' => $value[2]])->first();
                    if($ceksantri){
                        $gagal++;
                    }else{
                        if($cekortu){
                            // ortu terdaftar
                                $id_antri = Uuid::uuid6()->toString();
                                $siswabaru2 = $this->santri->insert([
                                    'id_santri' => $id_antri,
                                    'id_ortu' => $cekortu->id_ortu,
                                    'nama_santri' => $value[1],
                                    'nik' => $value[2],
                                    'nisn' => $value[3],
                                    'jk' => $value[6],
                                    'tmp_lahir' => $value[5],
                                    'tgl_lahir' => $value[6],
                                    'alamat' => $value[7],
                                    'rt' => $value[8],
                                    'rw' => $value[9],
                                    'desa' => $value[10],
                                    'kec' => $value[11],
                                    'kab' => $value[12],
                                    'prov' => $value[13],
                                    'foto' => 'user.jpg'
                                ]);
                                if($siswabaru2){
                                    $iregis = Uuid::uuid4()->toString();
                                    $regisbaru2 = $this->registrasi->insert([
                                        'id_registrasi' => $iregis,
                                        'id_santri' => $id_antri,
                                        'id_sekolah' => $sekolah->id_lembaga,
                                        'id_pesantren' => $pesantren->id_lembaga,
                                        'kelas_sekolah' => $sekolah->id_kelas,
                                        'kelas_pesantren' => $pesantren->id_kelas,
                                        'id_tahun' => getTahun()->id_tahun,
                                        'nis' => $value[4],
                                        'status' => '1'
                                    ]);
                                    if($regisbaru2){
                                        $sukses++;
                                    }
                                }
                        }else{
                            $idortu = Uuid::uuid4()->toString();
                            $ortubaru = $this->ortu->insert([
                                'id_ortu' => $idortu,
                                'nama_ayah' => $value[15],
                                'nik_ayah' => $nikayah,
                                'pekerjaan_ayah' => $value[17],
                                'notelp_ayah' => $value[18],
                                'nama_ibu' => $value[19],
                                'nik_ibu' => $value[20],
                                'pekerjaan_ibu' => $value[21],
                                'notelp_ibu' => $value[22],
                                'username' => createRandom(5),
                                'email'    => createRandom(4).'@yarus.com',
                            ]);
                            if($ortubaru){
                                // Tambah Santri
                                $id_santri = Uuid::uuid6()->toString();
                                $siswabaru = $this->santri->insert([
                                    'id_santri' => $id_santri,
                                    'id_ortu' => $idortu,
                                    'nama_santri' => $value[1],
                                    'nik' => $value[2],
                                    'nisn' => $value[3],
                                    'jk' => $value[6],
                                    'tmp_lahir' => $value[5],
                                    'tgl_lahir' => $value[6],
                                    'alamat' => $value[7],
                                    'rt' => $value[8],
                                    'rw' => $value[9],
                                    'desa' => $value[10],
                                    'kec' => $value[11],
                                    'kab' => $value[12],
                                    'prov' => $value[13],
                                    'foto' => 'user.jpg'
                                ]);
                                if($siswabaru){
                                    $idregis = Uuid::uuid4()->toString();
                                    $regisbaru = $this->registrasi->insert([
                                        'id_registrasi' => $idregis,
                                        'id_santri' => $id_santri,
                                        'id_sekolah' => $sekolah->id_lembaga,
                                        'id_pesantren' => $pesantren->id_lembaga,
                                        'kelas_sekolah' => $sekolah->id_kelas,
                                        'kelas_pesantren' => $pesantren->id_kelas,
                                        'id_tahun' => getTahun()->id_tahun,
                                        'nis' => $value[4],
                                        'status' => '1'
                                    ]);
                                    if($regisbaru){
                                        $sukses++;
                                    }
                                }
                            }
                        }
                    }
                }
                $msg=[
                    'sukses' =>[
                        'icon' => 'success',
                        'head' => 'Hore..!',
                        'pesan' => $sukses . ' Berhasil Di Tambahkan ,'. $gagal . ' Gagal Ditambahkan'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }
}
