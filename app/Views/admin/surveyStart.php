<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    Survey
                    <p class="text-right">Tanggal : <?=$tanggal?></p>
                </h3>

                <?= $form ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>