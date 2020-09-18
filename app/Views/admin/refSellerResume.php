<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    <?= $title ?>
                </h3>
                <button type="button" class="btn btn-primary" onclick="add()">
                    <i class="k-icon k-i-plus mr-1"></i>ADD ITEM
                </button>
                <?= $form ?>
            </div>
        </div>
    </div>
</div>
<script>
    function add(){
        showForm('800','600','_new','<?=base_url('admin/refSeller/add_produk/'.$id)?>');
    }
</script>
<?= $this->endSection() ?>