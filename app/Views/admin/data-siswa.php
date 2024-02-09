<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>

        <div class="collapse" id="collapseExample">
            <div class="card card-body">
            <form action="" id="formImport">
                <div class="alert alert-primary">Import Santri</div>
                <div class="row mb-3">
                        <label for="lembaga" class="form-label col-md-2">Kelas Sekolah</label>
                        <div class="col-md-4">
                            <select name="sekolah" id="sekolah" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach($sekolah as $value) : ?>
                                    <option value="<?= $value->id_kelas ?>"><?= $value->nama_kelas .' ( '. $value->nama_lembaga .' )' ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorlembaga"></div>
                        </div>
                        <label for="lembaga" class="form-label col-md-2">Pilih Sekolah</label>
                        <div class="col-md-4">
                            <select name="pesantren" id="pesantren" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach($pesantren as $data) : ?>
                                    <option value="<?= $data->id_kelas ?>"><?= $data->nama_kelas .' ( '. $data->nama_lembaga .' )' ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorlembaga"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                      <label for="email" class="form-label col-md-2">Pilih File</label>
                      <div class="col-md-6">
                          <input type="file" name="file" id="file" class="form-control" accept=".xlsx , .xls">
                          <div class="invalid-feedback errorfile"></div>
                      </div>
                      <div class="col-md-2">
                          <a href="<?= base_url() ?>template/templatesantri.xlsx" class="btn btn-info "> <i class="bi bi-cloud-download"></i> Template</a>
                      </div>
                      <div class="col-md-2">
                          <button type="submit" class="btn btn-primary btn-block">Import</button>
                      </div>
                    </div>

                
            
        </form>
            </div>
        </div>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary btn-sm btn-add" data-bs-toggle="modal" data-bs-target="#modalId">
            Tambah
        </button>

        <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Import
        </button>

        
        <a href="<?= base_url('admin/tarik-siswa'); ?>" class="btn btn-warning btn-sm">Salin Santri</a>

        
        <?php if(getTahun()->smt == 'Genap') : ?>
            <button type="button" class="btn btn-info btn-sm">
                Luluskan Bersama
            </button>
        <?php endif ?>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabelData" class="table table-hover table-xs">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tempat, Tgl Lahir</th>
                        <th scope="col">NIS / NISN</th>
                        <th scope="col">Username</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalId" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="formTambah" action="" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row mb-3">
                        <label for="lembaga" class="form-label col-md-2">Kelas Sekolah</label>
                        <div class="col-md-4">
                            <select name="sekolah" id="sekolah" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach($sekolah as $sekolah) : ?>
                                    <option value="<?= $sekolah->id_kelas ?>"><?= $sekolah->nama_kelas .' ( '. $sekolah->nama_lembaga .' )' ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorlembaga"></div>
                        </div>
                        <label for="lembaga" class="form-label col-md-2">Pilih Sekolah</label>
                        <div class="col-md-4">
                            <select name="pesantren" id="pesantren" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach($pesantren as $pesantren) : ?>
                                    <option value="<?= $pesantren->id_kelas ?>"><?= $pesantren->nama_kelas .' ( '. $pesantren->nama_lembaga .' )' ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorlembaga"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                      <label for="nama" class="form-label col-md-2">Nama Santri</label>
                      <div class="col-md-4">
                          <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Santri ...">
                          <div class="invalid-feedback errornama"></div>
                      </div>
                      <label for="nik" class="form-label col-md-2">NIK Santri</label>
                      <div class="col-md-4">
                          <input type="number" name="nik" id="nik" class="form-control" placeholder="NIK Santri ...">
                          <div class="invalid-feedback errornik"></div>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="tmp" class="form-label col-md-2">Tempat Lahir</label>
                      <div class="col-md-4">
                          <input type="text" name="tmp" id="tmp" class="form-control" placeholder="Tempat Lahir Guru ...">
                      </div>
                      <label for="tgl" class="form-label col-md-2">Tempat Lahir</label>
                      <div class="col-md-4">
                          <input type="date" name="tgl" id="tgl" class="form-control">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="nisn" class="form-label col-md-2">NISN</label>
                      <div class="col-md-4">
                          <input type="number" name="nisn" id="nisn" class="form-control" placeholder="NISN Siswa">
                          <div class="invalid-feedback errornisn"></div>
                      </div>
                      <label for="jk" class="form-label col-md-2">Jenis Kelamin</label>
                      <div class="col-md-4">
                            <select name="jk" id="jk" class="form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                      </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat" class="form-label col-md-2">Alamat</label>
                        <div class="col-md-10">
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="rt" class="form-label col-md-2">RT</label>
                        <div class="col-md-1">
                            <input type="number" name="rt" id="rt" class="form-control">
                        </div>
                        <label for="rw" class="form-label col-md-1">RW</label>
                        <div class="col-md-1">
                            <input type="number" name="rw" id="rw" class="form-control">
                        </div>
                        <label for="desa" class="form-label col-md-1">Desa</label>
                        <div class="col-md-2">
                            <input type="text" name="desa" id="desa" class="form-control">
                        </div>
                        <label for="kecamatan" class="form-label col-md-2">Kecamatan</label>
                        <div class="col-md-2">
                            <input type="text" name="kecamatan" id="kecamatan" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="ortu" class="form-label col-md-2">Anak Dari</label>
                        <div class="col-md-10">
                            <select name="ortu" id="ortu" class="choices form-select">
                                <option value="">Pilih Orang Tua</option>
                                <?php foreach($ortu as $ortu) : ?>
                                    <option value="<?= $ortu->id_ortu ?>"><?= 'Bapak : '. $ortu->nama_ayah .' / Ibu : '.$ortu->nama_ibu ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback errortu"></div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <input type="hidden" name="aksi" id="aksi">
                    <input type="hidden" name="idsantri" id="idsantri">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnSave">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal alumni -->
<div class="modal fade" id="modalAlumni" tabindex="-1" role="dialog" data-bs-backdrop="static" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="formAlumni" action="" method="post" autocomplete="off">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Form Alumni / Santri Non Aktif </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row mb-3">
                      <label for="alasan" class="form-label col-md-2">Keluar Karena</label>
                      <div class="col-md-10">
                          <select name="alasan" id="alasan" class="form-select form-select-sm">
                            <option value="">Jenis Keluar Santri</option>
                            <option value="Mutasi">Mutasi / Pindah</option>
                            <option value="Dikeluarkan">Dikeluarkan</option>
                            <option value="Mengundurkan">Mengundurkan Diri</option>
                            <option value="Wafat">Wafat / Meninggal</option>
                          </select>
                          <div class="invalid-feedback erroralasan"></div>
                      </div>
                    </div>


                    <div class="row mb-3 tj">
                      <label for="tujuan" class="form-label col-md-2">Sekolah Tujuan</label>
                      <div class="col-md-10">
                          <input type="text" name="tujuan" id="tujuan" class="form-control" placeholder="Tempat Tujuan ...">
                      </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <input type="hidden" name="idsan" id="idsan">
                    <input type="hidden" name="idreg" id="idreg">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btnSave">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<?= $this->endSection() ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
       $('.tj').hide();
        var tabel = $('#tabelData').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/santri',
            order : [],
            columns :[
                {data : 'nomor',orderable:false},
                {data : 'nama_santri'},
                {data : 'ttl'},
                {data : 'nipd'},
                {data : 'username'},
                {data:'aksi'}
            ]
        })
        
        $(document).on('click','.btn-status',function(e){
            var id = $(this).attr('id');
            var regis = $(this).attr('regis');
            $('#idsan').val(id);
            $('#idreg').val(regis)
        })

        $(document).on('click','#alasan',function(e){
            var alasan = $(this).val();
            if(alasan == 'Mutasi'){
                $('.tj').show();
            }else{
                $('.tj').hide();
            }
        })

        $(document).on('submit','#formAlumni',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/alumni-santri',
                method : 'post',
                data : $(this).serialize(),
                dataType:'json',
                success : function(data){
                    console.log(data)
                    if(data.error){
                        if(data.error.alasan){
                            $('#alasan').addClass('is-invalid');
                            $('.erroralasan').html(data.error.alasan)
                        }else{
                            $('#alasan').removeClass('is-invalid');
                            $('.erroralasan').html()
                        }
                        
                    }else{
                        Swal.fire(
                                data.sukses.title,
                                data.sukses.pesan,
                                data.sukses.icon
                            )
                        $('#modalAlumni').modal('hide');
                        tabel.ajax.reload();
                        $('#formAlumni')[0].reset();
                        $('.tj').hide();
                    }
                }
            })
        })

        $(document).on('click','.btn-add',function(e){
            e.preventDefault();
            $('#formTambah')[0].reset();
            $('.modal-title').html('Tambah Data Santri')
            $('.btnSave').html('Tambah')
            $('#aksi').val('insert')
        })
        $(document).on('click','.btn-edit',function(e){
            e.preventDefault();
            var id = $(this).attr('id')
            $.ajax({
                url : '/admin/guru-aktif',
                data : {id:id,_method:'PUT'},
                method : 'post',
                dataType : 'json',
                success : function(data){
                    console.log(data);
                    $('#idguru').val(data.id_guru)
                    $('#nama').val(data.nama_guru)
                    $('#nik').val(data.nik)
                    $('#tmp').val(data.tmp_lahir)
                    $('#tgl').val(data.tgl_lahir)
                    $('#email').val(data.email)
                    $('#alamat').val(data.alamat)
                    $('#telp').val(data.notelp)
                    $('#jk').val(data.jk)
                    $('.modal-title').html('Edit Data Guru')
                    $('.btnSave').html('Edit')
                    $('#aksi').val('update')
                }
            })
            
        })

        $(document).on('submit','#formImport',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/santri-import',
                method : 'post',
                data : new FormData(this),
                enctype : 'multipart/form-data',
                processData: false,
                contentType: false,
                cache : false,
                dataType : 'json',
                success:function(data){
                    if(data.error){
                        if(data.error.file){
                            $('.errorfile').html(data.error.file)
                            $('#file').addClass('is-invalid')
                        }else{
                            $('.errorfile').html()
                            $('#file').removeClass('is-invalid');
                        }
                    }else{
                        Swal.fire(
                            data.sukses.head,
                            data.sukses.pesan,
                            data.sukses.icon,
                        )
                        tabel.ajax.reload();
                        $('#formImport')[0].reset();
                        setInterval(function(){ location.reload(); }, 3000);
                    }
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
                        if(data.error.lembaga){
                            $('#lembaga').addClass('is-invalid');
                            $('.errorlembaga').html(data.error.lembaga)
                        }else{
                            $('#lembaga').removeClass('is-invalid');
                            $('.errorlembaga').html()
                        }
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
                        if(data.error.ortu){
                            $('#ortu').addClass('is-invalid');
                            $('.errortu').html(data.error.ortu)
                        }else{
                            $('#ortu').removeClass('is-invalid');
                            $('.errortu').html()
                        }
                    }else{
                        Swal.fire(
                                data.sukses.title,
                                data.sukses.pesan,
                                data.sukses.icon
                            )
                        $('#modalId').modal('hide');
                        tabel.ajax.reload();
                        $('#formTambah')[0].reset();
                    }
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>