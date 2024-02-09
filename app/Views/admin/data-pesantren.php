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
                        <th scope="col">Nama Sekolah</th>
                        <th scope="col">Pimpinan </th>
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
                      <label for="nama" class="form-label col-md-2">Nama Lembaga</label>
                      <div class="col-md-10">
                          <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lembaga ...">
                          <div class="invalid-feedback errornama"></div>
                      </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label for="guru" class="form-label col-md-2">Kepala Sekolah</label>
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
                        <label for="alamat" class="form-label col-md-2">Alamat</label>
                        <div class="col-md-10">
                            <textarea name="alamat" id="alamat" class="form-control"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="aksi" id="aksi">
                    <input type="hidden" name="idlembaga" id="idlembaga">
                    <input type="hidden" name="jenis" id="jenis" value="2">
                    <input type="hidden" name="jenjang" id="jenjang">
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
            ajax: '/admin/datapesantren',
            order : [],
            columns :[
                {data : 'nomor',orderable:false},
                {data : 'nama_lembaga'},
                {data : 'nama_guru'},
                {data:'aksi'}
            ]
        })

        $(document).on('click','.btn-add',function(e){
            e.preventDefault();
            $('#formTambah')[0].reset();
            $('.modal-title').html('Tambah Data Sekolah')
            $('.btnSave').html('Tambah')
            $('#aksi').val('insert')
        })
        $(document).on('click','.btn-edit',function(e){
            e.preventDefault();
            var id = $(this).attr('id')
            $.ajax({
                url : '/admin/data-sekolah',
                data : {id:id,_method:'PUT'},
                method : 'post',
                dataType : 'json',
                success : function(data){
                    console.log(data);
                    $('#idlembaga').val(data.id_lembaga)
                    $('#nama').val(data.nama_lembaga)
                    $('#jenjang').val(data.jenjang)
                    $('#guru').val(data.id_guru)
                    $('#alamat').val(data.alamat)
                    $('.modal-title').html('Edit Data Sekolah')
                    $('.btnSave').html('Edit')
                    $('#aksi').val('update')
                }
            })
            
        })

        
        $(document).on('submit','#formTambah',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/data-sekolah',
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

                        if(data.error.guru){
                            $('#guru').addClass('is-invalid');
                            $('.errorguru').html(data.error.guru)
                        }else{
                            $('#guru').removeClass('is-invalid');
                            $('.errorguru').html()
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