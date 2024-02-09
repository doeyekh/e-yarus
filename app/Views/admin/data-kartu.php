<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary btn-sm btnAdd">Generate Kartu</button>
        <button type="button" class="btn btn-warning btn-sm">Generate Ulang</button>
        <button type="button" class="btn btn-info btn-sm">Reset Password</button>
        <button type="button" class="btn btn-success btn-sm">Cetak Kartu</button>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabelData" class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col"><input type="checkbox" id="centangSantri"></th>
                        <th scope="col">Nama Santri</th>
                        <th scope="col">No RFId</th>
                        <th scope="col">No Kartu</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
            </table>
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
            ajax: '/admin/datakartu',
            order : [],
            columns :[
                {data : 'centang',orderable:false},
                {data : 'nama_santri'},
                {data : 'rf'},
                {data : 'qr'},
                {data:'info'},
                {data:'aksi'}
            ]
        })

        $(document).on('click','#centangSantri',function(e){
            if($(this).is(':checked')){
                $('.centangid').prop('checked',true)
            }else{
                $('.centangid').prop('checked',false)
            }
        })

        $(document).on('click','.btnAdd',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/kartu-santri',
                method : 'post',
                dataType : 'json',
                success : function(data) {
                    console.log(data)
                    Swal.fire(
                        data.sukses.title,
                                data.sukses.pesan,
                                data.sukses.icon
                    )
                    tabel.ajax.reload();
                }
            })
        })

    })
</script>
<?= $this->endSection() ?>