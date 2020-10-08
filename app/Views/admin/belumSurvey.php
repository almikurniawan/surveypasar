<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    Produk Belum disurvey
                </h3>
                <?= $grid ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>