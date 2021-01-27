<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h1 class="card-title">
                    <?= $title ?>
                </h1>
                <?= $search ?>
                <div class="table-responsive">
                <?= $grid ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>