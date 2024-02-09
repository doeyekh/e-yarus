<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-primary btn-add">Tambah</button>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabelData" class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Status</th>
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
            ajax: '/admin/tahunajar',
            order : [],
            columns :[
                {data : 'nomor'},
                {data : 'akademik'},
                {data : 'smt'},
                {data : 'aksi'},
            ]
        })
        $(document).on('click','.btn-status',function(e){
            var id = $(this).attr('id');
            e.preventDefault();
            $.ajax({
                url : '/admin/tahun-ajar',
                method : 'post',
                data:{id:id,_method:'PUT'},
                success : function(data){
                    tabel.ajax.reload();
                }
            })
        })
        $(document).on('click','.btn-add',function(e){
            e.preventDefault();
            $.ajax({
                url : '/admin/tahun-ajar',
                method : 'post',
                dataType : 'json',
                success : function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: data.icon,
                        title: data.title
                    })
                    tabel.ajax.reload();
                }
            })
        })
    })
</script>
<?= $this->endSection() ?>