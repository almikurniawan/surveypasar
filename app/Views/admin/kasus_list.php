<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    <?= $title?>
                </h3>
                <?php
                        if (session()->getFlashdata('success')) {
                            echo '<div class="alert alert-success" role="alert">
                                            ' . session()->getFlashdata('success') . '
                                        </div>';
                        }
                        ?>
                        <?php
                        if (session()->getFlashdata('danger')) {
                            echo '<div class="alert alert-danger" role="alert">
                                            ' . session()->getFlashdata('danger') . '
                                        </div>';
                        }
                        ?>
                <?= $search . $grid ?>
            </div>
        </div>
    </div>
</div>
<script>
    
</script>
<?= $this->endSection() ?>