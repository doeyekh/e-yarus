<?= $this->extend('template/admin') ; ?>
<?= $this->section('conten') ; ?>
<div class="card">
    <div class="card-header">
        Dashboard
    </div>
    <div class="card-body">
        <?= $db ?>
    </div>
</div>
<?= $this->endSection() ?>