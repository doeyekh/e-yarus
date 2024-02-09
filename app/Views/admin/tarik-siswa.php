<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>

<form action="" id="formSimpan">
    <div class="card">
        <div class="card-header">
            <a href="<?= base_url('admin/tarik-siswa'); ?>" class="btn btn-success btn-sm"> <i class="bi bi-arrow-left-circle-fill"></i> Kembali</a>
            <button type="submit" class="btn btn-sm btn-primary float-end btnSimpan"> <i class="bi bi-floppy"></i> Simpan</button>
        </div>
        <div class="card-body">
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

        <div class="table-responsive-sm">
            <table id="tabelData" class="table table-hover table-xs">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="centangSantri"></th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tempat, Tgl Lahir</th>
                        <th scope="col">NIK / NISN</th>
                    </tr>
                </thead>
            </table>
        </div>
        
        </div>
    </div>
</form>


<?= $this->endSection() ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        var tabel = $('#tabelData').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/tariksantri',
            order : [],
            columns :[
                {data : 'aksi',orderable:false},
                {data : 'nama_santri'},
                {data : 'ttl'},
                {data : 'nipd'},
            ]
        })

        $(document).on('click','#centangSantri',function(e){
            if($(this).is(':checked')){
                $('.centangid').prop('checked',true)
            }else{
                $('.centangid').prop('checked',false)
            }
        })
       

        $(document).on('submit','#formSimpan',function(e){
            e.preventDefault();
            let total = $('.centangid:checked');
            if(total.length === 0 ){
                Swal.fire(
                    'Warning',
                    'Belum Ada Santri Yang Dipilih',
                    'warning'
                )
            }else{
                Swal.fire({
                    title : 'Salin Santri',
                    text : `Data Santri Sebanyak ${total.length } Santri Akan Disalin ?`,
                    showCancelButton : true,
                    confirmButtonColor : '#3085d6',
                    cancelButtonColor : '#bf0215',
                    confirmButtonText : 'Ya Salin'
                }).then((result) => {
                    $.ajax({
                    url : '/admin/tarik-siswa',
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

                        }else{
                            Swal.fire(
                                    data.sukses.title,
                                    data.sukses.pesan,
                                    data.sukses.icon
                                )
                            tabel.ajax.reload();
                        }
                    }
            })   
                })
            }
            
        })
    })
</script>
<?= $this->endSection() ?>