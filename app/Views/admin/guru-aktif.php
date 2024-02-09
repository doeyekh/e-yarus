<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#modalId">
            Tambah
        </button>

        <button type="button" class="btn btn-success btn-import" data-bs-toggle="modal" data-bs-target="#modalImport">
            Import
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabelData" class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tempat, Tgl Lahir</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        
    </div>
</div>


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="modalImport" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" id="formImport">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Import Data Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="row mb-3">
                      <label for="email" class="form-label col-md-2">Pilih File</label>
                      <div class="col-md-7">
                          <input type="file" name="file" id="file" class="form-control" accept=".xlsx , .xls">
                          <div class="invalid-feedback errorfile"></div>
                      </div>
                      <div class="col-md-3">
                          <a href="<?= base_url() ?>template/templateguru.xlsx" class="btn btn-info "> <i class="bi bi-cloud-download"></i> Template</a>
                      </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
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
                      <label for="nama" class="form-label col-md-2">Nama Guru</label>
                      <div class="col-md-4">
                          <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Guru ...">
                          <div class="invalid-feedback errornama"></div>
                      </div>
                      <label for="nik" class="form-label col-md-2">NIK Guru</label>
                      <div class="col-md-4">
                          <input type="number" name="nik" id="nik" class="form-control" placeholder="NIK Guru ...">
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
                      <label for="email" class="form-label col-md-2">E-Mail</label>
                      <div class="col-md-4">
                          <input type="text" name="email" id="email" class="form-control" placeholder="Email Guru ...">
                          <div class="invalid-feedback erroremail"></div>
                      </div>
                      <label for="telp" class="form-label col-md-2">No Hp</label>
                      <div class="col-md-4">
                          <input type="number" name="telp" id="telp" class="form-control" placeholder="No Telp">
                          <div class="invalid-feedback errortelp"></div>
                      </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat" class="form-label col-md-2">Alamat</label>
                        <div class="col-md-10">
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jk" class="form-label col-md-2">Jenis Kelamin</label>
                        <div class="col-md-10">
                            <select name="jk" id="jk" class="form-select">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <input type="hidden" name="aksi" id="aksi">
                    <input type="hidden" name="idguru" id="idguru">
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
        var tabel = $('#tabelData').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/guruaktif',
            order : [],
            columns :[
                {data : 'nomor',orderable:false},
                {data : 'nama_guru'},
                {data : 'ttl'},
                {data : 'email'},
                {data:'aksi'}
            ]
        })
        const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary me-2',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
        })
        $(document).on('click','.btn-status',function(e){
            var id = $(this).attr('id');
            swalWithBootstrapButtons.fire({
            title: 'Apakah Anda Yakin ?',
            text: "Guru Akan Di Nonaktifkan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url : '/admin/guruaktif',
                method : 'post',
                data:{id:id,_method:'PUT',status:'aktif'},
                success : function(data){
                    Swal.fire(
                        'Deleted!',
                        'Guru Berhasil Di Non Aktifkan.',
                        'success'
                    )
                    tabel.ajax.reload();
                }
             })
                
            }
            })
            // e.preventDefault();
            
        })

        $(document).on('click','.btn-add',function(e){
            e.preventDefault();
            $('#formTambah')[0].reset();
            $('.modal-title').html('Tambah Data Guru')
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
                url : '/admin/guru-import',
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
                        $('#modalImport').modal('hide')
                    }
                }
            })
        })

        $(document).on('submit','#formTambah',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/guru-aktif',
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

                        if(data.error.email){
                            $('#email').addClass('is-invalid');
                            $('.erroremail').html(data.error.email)
                        }else{
                            $('#email').removeClass('is-invalid');
                            $('.erroremail').html()
                        }
                        if(data.error.nik){
                            $('#nik').addClass('is-invalid');
                            $('.errornik').html(data.error.nik)
                        }else{
                            $('#nik').removeClass('is-invalid');
                            $('.errornik').html()
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