<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    Survey
                </h3>
                <?= $form ?>
            </div>
        </div>
    </div>
</div>
<?php
if(session()->getFlashdata('sukses')){?>
    <script>
        $(document).ready(function(){
            alert();
        })
        function alert(){
            kendo.alert("Sukses Survey");
        }
    </script>
<?php }?>
<?= $this->endSection() ?>