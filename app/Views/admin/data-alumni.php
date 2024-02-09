<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive-sm">
            <table id="tabelData" class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Santri</th>
                        <th scope="col">Jenis Keluar</th>
                        <th scope="col">Tujuan</th>
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
            ajax: '/admin/dataalumni',
            order : [],
            columns :[
                {data : 'nomor',orderable:false},
                {data : 'nama_santri'},
                {data : 'alasan'},
                {data : 'tujuan'},
                {data:'aksi'}
            ]
        })

    })
</script>
<?= $this->endSection() ?>