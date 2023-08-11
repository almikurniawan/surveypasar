<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<style>
    .marker {
        background-image: url('https://icons.iconarchive.com/icons/icons-land/vista-map-markers/64/Map-Marker-Push-Pin-1-Pink-icon.png');
        background-size: cover;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>

<script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />

<div class="row">
    <div class="col-sm-12">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    <?= $title?>
                </h3>
                <div id='map' style='width: 100%; height: 500px;'></div>
            </div>
        </div>
    </div>
</div>
<script>
    var map;
    $(document).ready(function(){
        navigator.geolocation.getCurrentPosition(initMap, function(err){
            alert("Permintaan lokasi tidak diijinkan");
        });
    })

    function initMap(pos){
        mapboxgl.accessToken = 'pk.eyJ1IjoiYWxtaWt1ciIsImEiOiJja2pvMHAxaDIycHR6MnltcGk0c2c1eHIxIn0.ohQlx8xbetxw4Ig0Gd-CPg';
        map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v12', // style URL
            center: [pos.coords.longitude, pos.coords.latitude], // starting position [lng, lat]
            zoom: 11, // starting zoom
        });

        var kasus = <?= json_encode($kasus)?>;
        kasus.forEach(element => {   
            const el = document.createElement('div');
            el.className = 'marker';

            const popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
                `<strong>Judul</strong> : ${element.kasusjudul}<br/>` +
                `<strong>Tanggal</strong> : ${element.kasustanggal}<br/>` +
                `<strong>Urusan</strong> : ${element.urusannama}<br/>` +
                `<strong>Tantrib</strong> : ${element.tantrib}<br/>`  +
                `<strong>Status</strong> : ${element.statusname}<br/>` 
            );

            new mapboxgl.Marker(el,{
                draggable: false
            })
            .setLngLat([parseFloat(element.kasuslongitude), parseFloat(element.kasuslatitude)])
            .setPopup(popup)
            .addTo(map);
            
        });
        
    }
</script>
<?= $this->endSection() ?>