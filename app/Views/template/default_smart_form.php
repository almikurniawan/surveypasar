<?php
foreach ($field as $key => $value) {?>
    <div class="form-group">
        <label class="<?= $value['class']?>"><?= $value['title']?></label>
        <?= $value['field']?>
    </div>
<?php }?>
<?= $submit_btn . $cancel_btn?>
<script type="text/javascript">
    function cancel_filter() {
        <?= $cancel_action?>
    }
</script>