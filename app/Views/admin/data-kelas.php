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
                        <th scope="col">Nama Kelas / Level</th>
                        <th scope="col">Wali Kelas </th>
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
                      <label for="lembaga" class="form-label col-md-2">Nama Lembaga</label>
                      <div class="col-md-10">
                            <select name="lembaga" id="lembaga" class="form-select">
                                <option value="">Pilih Lembaga</option>
                                <?php foreach($lembaga as $lembaga) : ?>
                                    <option value="<?= $lembaga->id_lembaga ?>"><?= $lembaga->nama_lembaga ?></option>
                                <?php endforeach ?>
                            </select>
                          <div class="invalid-feedback errorlembaga"></div>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="guru" class="form-label col-md-2">Wali Kelas</label>
                        <div class="col-md-10">
                            <select name="guru" id="guru" class="form-select">
                                <option value="">-Pilih Guru -</option>
                                <?php foreach($guru as $guru) : ?>
                                    <option value="<?= $guru->id_guru ?>"><?= $guru->nama_guru ?></option>
                                    <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback errorguru"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="level" class="form-label col-md-2">Level</label>
                        <div class="col-md-4">
                            <select name="level" id="level" class="form-select">
                                <option value="">Pilih Level</option>
                                <?php for ($i=1; $i < 13 ; $i++) : ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor ?>
                            </select>
                            <div class="invalid-feedback errorlevel"></div>
                        </div>
                        <label for="namakelas" class="form-label col-md-2">Nama Kelas</label>
                        <div class="col-md-4">
                            <input type="text" name="namakelas" id="namakelas" class="form-control" placeholder="Nama Kelas">
                            <div class="invalid-feedback errornama">sasa</div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="aksi" id="aksi">
                    <input type="hidden" name="idkelas" id="idkelas">
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
            ajax: '/admin/datakelas',
            order : [],
            columns :[
                {data : 'nomor',orderable:false},
                {data : 'kelas'},
                {data : 'nama_guru'},
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
                url : '/admin/data-kelas',
                method : 'post',
                data:{id:id,_method:'DELETE'},
                success : function(data){
                    Swal.fire(
                        'Deleted!',
                        'Kelas Berhasil Dihapus.',
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
            $('.modal-title').html('Tambah Data Kelas')
            $('.btnSave').html('Tambah')
            $('#aksi').val('insert')
        })
        $(document).on('click','.btn-edit',function(e){
            e.preventDefault();
            var id = $(this).attr('id')
            $.ajax({
                url : '/admin/data-kelas',
                data : {id:id,_method:'PUT'},
                method : 'post',
                dataType : 'json',
                success : function(data){
                    console.log(data);
                    $('#idkelas').val(data.id_kelas)
                    $('#namakelas').val(data.nama_kelas)
                    $('#level').val(data.level)
                    $('#guru').val(data.id_guru)
                    $('#lembaga').val(data.id_lembaga)
                    $('.modal-title').html('Edit Data Kelas')
                    $('.btnSave').html('Edit')
                    $('#aksi').val('update')
                }
            })
            
        })

        
        $(document).on('submit','#formTambah',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/data-kelas',
                method : 'post',
                data : $(this).serialize(),
                dataType:'json',
                success : function(data){
                    console.log(data)
                    if(data.error){

                        if(data.error.namakelas){
                            $('#namakelas').addClass('is-invalid');
                            $('.errornama').html(data.error.namakelas)
                        }else{
                            $('#namakelas').removeClass('is-invalid');
                            $('.errornama').html()
                        }

                        if(data.error.guru){
                            $('#guru').addClass('is-invalid');
                            $('.errorguru').html(data.error.guru)
                        }else{
                            $('#guru').removeClass('is-invalid');
                            $('.errorguru').html()
                        }

                        if(data.error.lembaga){
                            $('#lembaga').addClass('is-invalid');
                            $('.errorlembaga').html(data.error.lembaga)
                        }else{
                            $('#lembaga').removeClass('is-invalid');
                            $('.errorlembaga').html()
                        }

                        if(data.error.level){
                            $('#level').addClass('is-invalid');
                            $('.errorlevel').html(data.error.lembaga)
                        }else{
                            $('#level').removeClass('is-invalid');
                            $('.errorlevel').html()
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