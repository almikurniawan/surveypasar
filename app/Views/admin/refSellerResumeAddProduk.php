<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    <?= $title ?>
                </h3>
                <?= $search_pilih_produk . $grid_pilih_produk ?>
            </div>
        </div>
    </div>
</div>
<script>
    function pilih(id) {
        // kendo.confirm("Yakin ingin delete data ini?").then(function() {
        $.post("<?= base_url('admin/refSeller/pilih') ?>", {
            id: id,
            id_seller: <?= $id_seller ?>
        }, function(result) {
            if (result.status) {
                kendo.alert(result.message);
                gridReload();
                window.opener.gridReload();

            } else {
                kendo.alert(result.message);
            }
        }, 'json');
        // }, function() {});
    }
</script>
<?= $this->endSection() ?>