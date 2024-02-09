<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#modalId">
            Tambah
        </button>

    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabelData" class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Ayah</th>
                        <th scope="col">Nama Ibu</th>
                        <th scope="col">E-Mail</th>
                        <th scope="col">Username</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        
    </div>
</div>


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->

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
                      <label for="nama" class="form-label col-md-2">Nama Ayah</label>
                      <div class="col-md-4">
                          <input type="text" name="namaayah" id="namaayah" class="form-control" placeholder="Nama Ayah ...">
                          <div class="invalid-feedback errornamaayah"></div>
                      </div>
                      <label for="nik" class="form-label col-md-2">NIK Ayah</label>
                      <div class="col-md-4">
                          <input type="number" name="nikayah" id="nikayah" class="form-control" placeholder="NIK Ayah ...">
                          <div class="invalid-feedback errornikayah"></div>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="tmp" class="form-label col-md-2">Pekerjaan Ayah</label>
                      <div class="col-md-4">
                          <input type="text" name="pekerjaanayah" id="pekerjaanayah" class="form-control" placeholder="Pekerjaan Ayah ...">
                      </div>
                      <label for="tgl" class="form-label col-md-2">Telp Ayah</label>
                      <div class="col-md-4">
                          <input type="number" name="telpayah" id="telpayah" class="form-control" placeholder="telpayah">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="namaibu" class="form-label col-md-2">Nama Ibu</label>
                      <div class="col-md-4">
                          <input type="text" name="namaibu" id="namaibu" class="form-control" placeholder="Nama Ibu ...">
                          <div class="invalid-feedback errornamaibu"></div>
                      </div>
                      <label for="nik" class="form-label col-md-2">NIK Ibu</label>
                      <div class="col-md-4">
                          <input type="number" name="nikibu" id="nikibu" class="form-control" placeholder="NIK Ibu ...">
                          <div class="invalid-feedback errornikibu"></div>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <label for="tmp" class="form-label col-md-2">Pekerjaan Ibu</label>
                      <div class="col-md-4">
                          <input type="text" name="pekerjaanibu" id="pekerjaanibu" class="form-control" placeholder="Pekerjaan Ibu ...">
                      </div>
                      <label for="tgl" class="form-label col-md-2">Telp Ibu</label>
                      <div class="col-md-4">
                          <input type="number" name="telpibu" id="telpibu" class="form-control" placeholder="telp Ibu">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="username" class="form-label col-md-2">Username</label>
                      <div class="col-md-10">
                          <input type="text" name="username" id="username" class="form-control" placeholder="Username...">
                          <div class="invalid-feedback errorusername"></div>
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="email" class="form-label col-md-2">E-Mail</label>
                      <div class="col-md-10">
                          <input type="text" name="email" id="email" class="form-control" placeholder="Email...">
                          <div class="invalid-feedback erroremail"></div>
                      </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="aksi" id="aksi">
                    <input type="hidden" name="idortu" id="idortu">
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
            ajax: '/admin/data-ortu',
            order : [],
            columns :[
                {data : 'nomor',orderable:false},
                {data : 'nama_ayah'},
                {data : 'nama_ibu'},
                {data : 'email'},
                {data : 'username'},
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
            text: "Data Yang Dihapus Tidak Dapat Dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                url : '/admin/orang-tua',
                method : 'post',
                data:{id:id,_method:'DELETE'},
                success : function(data){
                    Swal.fire(
                        'Deleted!',
                        'Orang Tua Berhasil Dihapus.',
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
            $('.modal-title').html('Tambah Data Orang Tua')
            $('.btnSave').html('Tambah')
            $('#aksi').val('insert')
        })
        $(document).on('click','.btn-edit',function(e){
            e.preventDefault();
            var id = $(this).attr('id')
            $.ajax({
                url : '/admin/orang-tua',
                data : {id:id,_method:'PUT'},
                method : 'post',
                dataType : 'json',
                success : function(data){
                    console.log(data);
                    $('#idortu').val(data.id_ortu)
                    $('#namaayah').val(data.nama_ayah)
                    $('#nikayah').val(data.nik_ayah)
                    $('#telpayah').val(data.notelp_ayah)
                    $('#pekerjaanayah').val(data.pekerjaan_ayah)
                    $('#namaibu').val(data.nama_ibu)
                    $('#nikibu').val(data.nik_ibu)
                    $('#telpibu').val(data.notelp_ibu)
                    $('#pekerjaanibu').val(data.pekerjaan_ibu)
                    $('#username').val(data.username)
                    $('#email').val(data.email)
                    $('.modal-title').html('Edit Data Orang Tua')
                    $('.btnSave').html('Edit')
                    $('#aksi').val('update')
                }
            })
            
        })


        $(document).on('submit','#formTambah',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/orang-tua',
                method : 'post',
                data : $(this).serialize(),
                dataType:'json',
                success : function(data){
                    console.log(data)
                    if(data.error){
                        if(data.error.namaayah){
                            $('#namaayah').addClass('is-invalid');
                            $('.errornamaayah').html(data.error.namaayah)
                        }else{
                            $('#namaayah').removeClass('is-invalid');
                            $('.errornamaayah').html()
                        }
                        if(data.error.namaibu){
                            $('#namaibu').addClass('is-invalid');
                            $('.errornamaibu').html(data.error.namaibu)
                        }else{
                            $('#namaibu').removeClass('is-invalid');
                            $('.errornamaibu').html()
                        }
                        if(data.error.nikayah){
                            $('#nikayah').addClass('is-invalid');
                            $('.errornikayah').html(data.error.nikayah)
                        }else{
                            $('#nikayah').removeClass('is-invalid');
                            $('.errornikayah').html()
                        }
                        if(data.error.nikibu){
                            $('#nikibu').addClass('is-invalid');
                            $('.errornikibu').html(data.error.nikibu)
                        }else{
                            $('#nikibu').removeClass('is-invalid');
                            $('.errornikibu').html()
                        }
                        if(data.error.username){
                            $('#username').addClass('is-invalid');
                            $('.errorusername').html(data.error.username)
                        }else{
                            $('#username').removeClass('is-invalid');
                            $('.errorusername').html()
                        }
                        if(data.error.email){
                            $('#email').addClass('is-invalid');
                            $('.erroremail').html(data.error.email)
                        }else{
                            $('#email').removeClass('is-invalid');
                            $('.erroremail').html()
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