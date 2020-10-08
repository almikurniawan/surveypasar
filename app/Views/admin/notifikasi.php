<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    <?= $title ?>
                </h3>
                <?= $search . $grid ?>
            </div>
        </div>
    </div>
</div>
<script>
function detail(tanggal){
    showForm('800','600','_new','<?=base_url('admin/notifikasi/detail/')?>/'+tanggal);
}
</script>
<?= $this->endSection() ?>