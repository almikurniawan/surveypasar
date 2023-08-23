<div class="form-row">
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasusnohp']['class'] ?> tb-livepreview-subheader"><?= $field['kasusnohp']['title'] ?></label>
        <?= $field['kasusnohp']['field'] ?>
    </div>
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasustanggal']['class'] ?> tb-livepreview-subheader"><?= $field['kasustanggal']['title'] ?></label>
        <?= $field['kasustanggal']['field'] ?>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasusjudul']['class'] ?> tb-livepreview-subheader"><?= $field['kasusjudul']['title'] ?></label>
        <?= $field['kasusjudul']['field'] ?>
    </div>
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasusdeskripsi']['class'] ?> tb-livepreview-subheader"><?= $field['kasusdeskripsi']['title'] ?></label>
        <?= $field['kasusdeskripsi']['field'] ?>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasusurusan']['class'] ?> tb-livepreview-subheader"><?= $field['kasusurusan']['title'] ?></label>
        <?= $field['kasusurusan']['field'] ?>
    </div>
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['tantrib']['class'] ?> tb-livepreview-subheader"><?= $field['tantrib']['title'] ?></label>
        <?= $field['tantrib']['field'] ?>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasustanggalinformasi']['class'] ?> tb-livepreview-subheader"><?= $field['kasustanggalinformasi']['title'] ?></label>
        <?= $field['kasustanggalinformasi']['field'] ?>
    </div>
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasusnomorsurat']['class'] ?> tb-livepreview-subheader"><?= $field['kasusnomorsurat']['title'] ?></label>
        <?= $field['kasusnomorsurat']['field'] ?>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasusfoto']['class'] ?> tb-livepreview-subheader"><?= $field['kasusfoto']['title'] ?></label>
        <?= $field['kasusfoto']['field'] ?>
    </div>
    <div class="form-group col-sm-12 col-md-6">
        <div id='map' style='width: 100%; height: 300px;'></div>
        <script>
            var map;
            var marker;
            $(document).ready(function(){
                navigator.geolocation.getCurrentPosition(success, function(err){
                    alert("Permintaan lokasi tidak diijinkan");
                });
            })

            function success(pos){
                mapboxgl.accessToken = 'pk.eyJ1IjoiYWxtaWt1ciIsImEiOiJja2pvMHAxaDIycHR6MnltcGk0c2c1eHIxIn0.ohQlx8xbetxw4Ig0Gd-CPg';
                map = new mapboxgl.Map({
                    container: 'map', // container ID
                    style: 'mapbox://styles/mapbox/streets-v12', // style URL
                    center: [pos.coords.longitude, pos.coords.latitude], // starting position [lng, lat]
                    zoom: 16, // starting zoom
                });

                const el = document.createElement('div');
                el.className = 'marker';

                marker = new mapboxgl.Marker(el,{
                    draggable: true
                }).setLngLat([pos.coords.longitude, pos.coords.latitude]).addTo(map);
                
                $("#kasuslatitude").val(pos.coords.latitude);
                $("#kasuslongitude").val(pos.coords.longitude);

                marker.on('dragend', onDragEnd);
            }

            function onDragEnd() {
                const lngLat = marker.getLngLat();
                $("#kasuslatitude").val(lngLat.lat);
                $("#kasuslongitude").val(lngLat.lng);
            }

        </script>
    </div>
</div>

<div class="form-row">
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasuslatitude']['class'] ?> tb-livepreview-subheader"><?= $field['kasuslatitude']['title'] ?></label>
        <?= $field['kasuslatitude']['field'] ?>
    </div>
    <div class="form-group col-sm-12 col-md-6">
        <label class="<?= $field['kasuslongitude']['class'] ?> tb-livepreview-subheader"><?= $field['kasuslongitude']['title'] ?></label>
        <?= $field['kasuslongitude']['field'] ?>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-6">
        <?= $submit_btn . $cancel_btn?>
    </div>
</div>
<script type="text/javascript">
    function cancel_filter() {
        <?= $cancel_action?>
    }
</script>