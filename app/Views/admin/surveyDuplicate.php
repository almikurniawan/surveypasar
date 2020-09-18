<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body text-center">
                <h3 class="card-title">
                    Warning
                </h3>
                <h4><b>Maaf, </b>pedagang sudah di survey di tanggal ini. <button onclick="window.history.back();" class="btn btn-primary">Kembali</button></h4>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>