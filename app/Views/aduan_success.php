<?= $this->extend('template/default_public') ?>
<?= $this->section('content') ?>
<style>
    a {
        color: #7D7D7D;
        text-decoration: none;
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
    }

    a:hover {
        color: #7D7D7D;
        text-decoration: none;
        background-color: transparent;
        -webkit-text-decoration-skip: objects;
    }

    .inforide {
        box-shadow: 1px 2px 8px 0px #b5b0b0;
        background-color: white;
        border-radius: 8px;
        height: 125px;
    }

    .rideone img {
        width: 70%;
    }

    .ridetwo img {
        width: 60%;
    }

    .ridethree img {
        width: 50%;
    }

    .rideone {
        background-color: #e91e63;
        padding-top: 25px;
        border-radius: 8px 0px 0px 8px;
        text-align: center;
        height: 125px;
        margin-left: 15px;
    }

    .ridetwo {
        background-color: #f5b453;
        padding-top: 30px;
        border-radius: 8px 0px 0px 8px;
        text-align: center;
        height: 125px;
        margin-left: 15px;
    }

    .ridethree {
        background-color: #0ddad1;
        padding-top: 35px;
        border-radius: 8px 0px 0px 8px;
        text-align: center;
        height: 125px;
        margin-left: 15px;
    }

    .fontsty {
        margin-right: -15px;
    }

    .fontsty h2 {
        color: #6E6E6E;
        font-size: 35px;
        margin-top: 15px;
        text-align: right;
        margin-right: 30px;
    }

    .fontsty h4 {
        color: #6E6E6E;
        font-size: 25px;
        margin-top: 20px;
        text-align: right;
        margin-right: 30px;
    }
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
    <div class="col">
        <div class="card card-primary">
            <div class="card-body">     
                <div class="row">
                    <div class="col-md-12">
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
                        <center>
                            <img src = 'https://cdn-icons-png.flaticon.com/128/845/845646.png'/>
                            <h3 class="mt-4">Terima Kasih Atas Partisipasinya.</h3>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>