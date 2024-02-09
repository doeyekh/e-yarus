<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>
<div class="card">
    <div class="card-header">
        <a href="<?= base_url() ?>admin/siswa-aktif" class="btn btn-success btn-sm"><i class="bi bi-arrow-left-square-fill"></i> Kembali</a>
        <button class="btn btn-primary btn-sm"><i class="bi bi-printer"></i> Cetak</button>
        <button class="btn btn-primary btn-sm"><i class="bi bi-credit-card-2-front"></i> Kartu</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="m-auto">
                    <div class="avatar avatar-xl">
                        <img src="<?= base_url() ?>assets/img/siswa/<?= $santri->foto ?>"  alt="foto <?= $santri->nama_santri ?>">
                    </div>
                </div>
                <form action="" id="uploadFoto">
                    <div class="input-group my-2">
                        <input type="file" class="form-control form-control-sm" id="foto" name="foto" aria-describedby="button-addon2" accept="image/png, image/jpg, image/jpeg">
                        <button class="btn btn-outline-primary btn-sm" type="submit" id="button-addon2">Upload</button>
                        <div class="invalid-feedback errorfoto"></div>
                    </div>
                </form>

                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" title="YouTube video" allowfullscreen></iframe>
                </div>

                <form action="" id="uploadFile">
                    <div class="input-group my-2">
                        <input type="file" class="form-control form-control-sm" id="file" name="file" aria-describedby="button-addon2" accept=".pdf">
                        <button class="btn btn-outline-primary btn-sm" type="submit" id="button-addon2">Upload</button>
                        <div class="invalid-feedback errorfoto"></div>
                    </div>
                </form>

            </div>
            <div class="col-md-9">
                <div class="alert alert-sm alert-info">Detail Santri</div>
                <form id="formTambah" autocomplete="off">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="idsantri" id="idsantri" value="<?= $santri->id_santri ?>">
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama" value="<?= $santri->nama_santri ?>">
                            <div class="invalid-feedback errornama"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nik" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="nik" name="nik" value="<?= $santri->nik ?>">
                            <div class="invalid-feedback errornik"></div>
                        </div>
                        <label for="nik" class="col-sm-2 col-form-label">NISN</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="nisn" name="nisn" value="<?= $santri->nisn ?>">
                            <div class="invalid-feedback errornisn"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="tmp" class="col-sm-3 col-form-label">Tmp, TGL Lahir</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" id="tmp" name="tmp" value="<?= $santri->tmp_lahir ?>">
                        </div>
                        <div class="col-sm-6">
                            <input type="date" class="form-control form-control-sm" id="tgl" name="tgl" value="<?= $santri->tgl_lahir ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                              <textarea class="form-control form-control-sm" name="alamat" id="alamat" rows="3"><?= $santri->alamat ?></textarea>
                        </div>  
                    </div>

                    <div class="row mb-3">
                        <label for="rt" class="col-sm-2 col-form-label">RT</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control form-control-sm" id="rt" name="rt" value="<?= $santri->rt ?>">
                        </div>
                        <label for="rw" class="col-sm-2 col-form-label">RW</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control form-control-sm" id="rw" name="rw" value="<?= $santri->rw ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="desa" class="col-sm-2 col-form-label">Desa</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="desa" name="desa" value="<?= $santri->desa ?>">
                        </div>
                        <label for="kec" class="col-sm-2 col-form-label">Kecamatan</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="kec" name="kec" value="<?= $santri->kec ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="kab" class="col-sm-2 col-form-label">Kabupaten</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="kab" name="kab" value="<?= $santri->kab ?>">
                        </div>
                        <label for="prov" class="col-sm-2 form-label form-label-sm">Provinsi</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="prov" name="prov" value="<?= $santri->prov ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-end">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="alert alert-primary">
            Detail Orang Tua
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <form id="formOrtu">
                    <div class="row mb-3">
                        <label for="ayah" class="col-sm-2 col-form-label">Orang Tua</label>
                        <div class="col-sm-10">
                            <input type="hidden" name="idsantri" value="<?= $santri->id_santri ?>">
                            <select name="ortu" id="ortu" class="form-select">
                                <?php foreach($ortu as $ortu) : ?>
                                    <option value="<?= $ortu->id_ortu ?>" <?= $santri->id_ortu == $ortu->id_ortu ? 'selected' : '' ?> ><?= 'Ayah : '. $ortu->nama_ayah .' || Ibu : '. $ortu->nama_ibu . ' || Username : ' .$ortu->username ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback errorortu"></div>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary float-end">Ubah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-primary">
            Registrasi
        </div>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Registrasi Siswa</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Riwayat Sekolah</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <form action="" id="formRegistrasi" class="mt-3">
                        <div class="row mb-2">
                            <label for="kelas" class="col-sm-3">Kelas Pesantren</label>
                                <div class="col-md-9">
                                        <select class="form-select form-select-sm" name="kelas" id="kelas">
                                            <option>Select one</option>
                                            <?php foreach($sekolah as $sekolah) : ?>
                                                <option value="<?= $sekolah->id_kelas ?>" <?= $sekolah->id_kelas == $registrasi->kelas_sekolah ? 'selected' : '' ?>><?= $sekolah->nama_kelas .' / '. $sekolah->nama_lembaga ?></option>
                                            <?php endforeach ?>
                                        </select>
                                </div>
                        </div>
                        <div class="row mb-2">
                            <label for="kelas" class="col-sm-3">Kelas Pesantren</label>
                                <div class="col-md-9">
                                        <select class="form-select form-select-sm" name="kelasp" id="kelasp">
                                            <option>Pilih Kelas</option>
                                            <?php foreach($pesantren as $pesantren) : ?>
                                                <option value="<?= $pesantren->id_kelas ?>" <?= $pesantren->id_kelas == $registrasi->kelas_pesantren ? 'selected' : '' ?>><?= $pesantren->nama_kelas .' / '. $pesantren->nama_lembaga ?></option>
                                            <?php endforeach ?>
                                        </select>
                                </div>
                        </div>
                        <div class="row mb-2">
                            <label for="kelas" class="col-sm-3">No NIS</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nis" id="nis" value="<?= $registrasi->nis ?>">
                                    <input type="hidden" class="form-control" name="idregistrasi" id="idregistrasi" value="<?= $registrasi->id_registrasi ?>">

                                </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Ubah</button>
                    </form>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-sm mt-2">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Pelajaran</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
    
        $(document).on('submit','#uploadFoto',function(e){
            e.preventDefault();
            var idsantri = $('#idsantri').val();
            $.ajax({
                url : '/admin/santri-upload/'+ idsantri,
                method : 'post',
                data : new FormData(this),
                enctype : 'multipart/form-data',
                processData: false,
                contentType: false,
                cache : false,
                dataType : 'json',
                success : function(respon){
                    console.log(respon)
                    if(respon.error){
                        if(respon.error.foto){
                            $('#foto').addClass('is-invalid');
                            $('.errorfoto').html(respon.error.foto);
                        }else{
                            $('#foto').removeClass('is-invalid');
                            $('.errorfoto').html('');
                        } 
                    }else{
                        Swal.fire(
                                    respon.sukses.title,
                                    respon.sukses.pesan,
                                    respon.sukses.icon
                                )
                            setInterval(function(){ location.reload(); }, 1000);
                    }
                },
                error:function(xhr, ajaxOptions, thrownError){
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError );
                }
            })
        })

        $(document).on('submit','#formRegistrasi',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/regis-santri',
                method : 'post',
                data : $(this).serialize(),
                dataType : 'json',
                success : function(data){
                    Swal.fire(
                        data.sukses.title,
                        data.sukses.pesan,
                        data.sukses.icon
                    )
                    setInterval(function(){ location.reload(); }, 1000);
                }
            })
        })

        $(document).on('submit','#formOrtu',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/ortu-santri',
                method : 'post',
                data : $(this).serialize(),
                dataType:'json',
                success : function(data){
                    Swal.fire(
                                data.sukses.title,
                                data.sukses.pesan,
                                data.sukses.icon
                            )
                        setInterval(function(){ location.reload(); }, 1000);
                }  
            })
        })
        $(document).on('submit','#formTambah',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/santri',
                method : 'post',
                data : $(this).serialize(),
                dataType:'json',
                success : function(data){
                    console.log(data)
                    if(data.error){
                        if(data.error.nama){
                            $('#nama').addClass('is-invalid');
                            $('.errornama').html(data.error.nama)
                        }else{
                            $('#nama').removeClass('is-invalid');
                            $('.errornama').html()
                        }

                        if(data.error.nik){
                            $('#nik').addClass('is-invalid');
                            $('.errornik').html(data.error.nik)
                        }else{
                            $('#nik').removeClass('is-invalid');
                            $('.errornik').html()
                        }
                        if(data.error.nisn){
                            $('#nisn').addClass('is-invalid');
                            $('.errornisn').html(data.error.nisn)
                        }else{
                            $('#nisn').removeClass('is-invalid');
                            $('.errornisn').html()
                        }
                    }else{
                        Swal.fire(
                                data.sukses.title,
                                data.sukses.pesan,
                                data.sukses.icon
                            )
                        setInterval(function(){ location.reload(); }, 1000);
                    }
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>