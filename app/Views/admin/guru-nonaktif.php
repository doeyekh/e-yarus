<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>
<div class="card">
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

<!-- Button trigger modal -->


<?= $this->endSection() ?>
<?= $this->section('js'); ?>
<script>
    $(document).ready(function(){
        var tabel = $('#tabelData').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/gurunonaktif',
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
            text: "Guru Akan Di Aktifkan",
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
                data:{id:id,_method:'PUT',status:'nonaktif'},
                success : function(data){
                    Swal.fire(
                        'Deleted!',
                        'Guru Berhasil Di Aktifkan.',
                        'success'
                    )
                    tabel.ajax.reload();
                }
             })
                
            }
            })
            // e.preventDefault();
            
        })
    })
</script>
<?= $this->endSection() ?>