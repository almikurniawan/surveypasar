<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    <?= $title ?>
                </h3>
                <a href="<?= base_url("admin/validasi/approve/".$id)?>" class="btn btn-primary"><i class="k-icon k-i-check"></i> Approve</a>
                <a href="<?= base_url("admin/validasi/reject/".$id)?>" class="btn btn-danger float-right"><i class="k-icon k-i-close"></i> Reject</a>
                <?= $grid ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>