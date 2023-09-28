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
    function deletePasar(id) {
        kendo.confirm("Yakin ingin delete data ini?").then(function() {
            $.post("<?= base_url('admin/refPasar/delete') ?>", {
                id: id
            }, function(result) {
                if (result.status) {
                    kendo.alert(result.message);
                    gridReload();
                } else {
                    kendo.alert(result.message);
                }
            }, 'json');
        }, function() {});
    }

    function cetak(id){
        showForm(800,400,'cetak','<?= base_url("/admin/suratTugas/cetak")?>/'+id);
    }
</script>
<?= $this->endSection() ?>