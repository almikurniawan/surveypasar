<?= $this->extend('template/default') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <div class="card card-primary">
            <div class="card-body">
                <h3 class="card-title">
                    <?= $title ?>
                </h3>

                <div class="card bg-warning" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>

                <?= $filter1 ?>
                <div id="example">
                    <div class="demo-section k-content wide">
                        <div id="chart"></div>
                    </div>
                    <script>
                        function createChart() {
                            $("#chart").kendoChart({
                                title: {
                                    text: "Survey Pasar"
                                },
                                legend: {
                                    position: "bottom"
                                },
                                chartArea: {
                                    background: ""
                                },
                                seriesDefaults: {
                                    type: "line",
                                    style: "smooth"
                                },
                                series: <?= $series ?>,
                                valueAxis: {
                                    labels: {
                                        format: "Rp. {0}"
                                    },
                                    line: {
                                        visible: false
                                    },
                                    axisCrossingValue: 0
                                },
                                categoryAxis: {
                                    categories: <?= $category ?>,
                                    majorGridLines: {
                                        visible: false
                                    },
                                    labels: {
                                        rotation: "auto"
                                    }
                                },
                                tooltip: {
                                    visible: true,
                                    format: "{0}",
                                    template: "#= series.name #: #= value #"
                                }
                            });
                        }

                        $(document).ready(createChart);
                        $(document).bind("kendo:skinChange", createChart);
                    </script>
                </div>
                <h4 class="mt-5">Tren Surveyor per Produk</h4>
                <hr>
                <?= $filter_tren_svy_prod ?>
                <div class="row">
                    <div class="col-lg-12 demo-section k-content wide">
                        <div id="trensurveyorproduk" style="width: 100%; height: 500px;"></div>
                        <script>
                            function createChart() {
                                $("#trensurveyorproduk").kendoChart({
                                    title: {
                                        text: "Tren Surveyor per Produk"
                                    },
                                    legend: {
                                        position: "bottom"
                                    },
                                    chartArea: {
                                        background: ""
                                    },
                                    seriesDefaults: {
                                        type: "line",
                                        style: "smooth"
                                    },
                                    series: <?= json_encode($svy_produk['series']) ?>,
                                    valueAxis: {
                                        labels: {
                                            format: "{0}"
                                        },
                                        line: {
                                            visible: false
                                        },
                                        axisCrossingValue: -10
                                    },
                                    categoryAxis: {
                                        categories: <?= json_encode($svy_produk['categoryAxis']) ?>,
                                        majorGridLines: {
                                            visible: false
                                        },
                                        labels: {
                                            rotation: "auto"
                                        }
                                    },
                                    tooltip: {
                                        visible: true,
                                        format: "{0}%",
                                        template: "#= series.name #: #= value #"
                                    }
                                });
                            }

                            $(document).ready(createChart);
                            // $(document).bind("kendo:skinChange", createChart);
                        </script>
                    </div>
                </div>
                <h4 class="mt-5">Tren Surveyor per Pedagang</h4>
                <hr>
                <?= $filter_tren_svy_seller ?>
                <div class="row">
                    <div class="col-lg-12 demo-section k-content wide">
                        <div id="trensurveyorpedagang" style="width: 100%; height: 500px;"></div>
                        <script>
                            function createChart() {
                                $("#trensurveyorpedagang").kendoChart({
                                    title: {
                                        text: "Tren Surveyor per Pedagang"
                                    },
                                    legend: {
                                        position: "bottom"
                                    },
                                    chartArea: {
                                        background: ""
                                    },
                                    seriesDefaults: {
                                        type: "line",
                                        style: "smooth"
                                    },
                                    series: <?= json_encode($svy_pedagang['series']) ?>,
                                    valueAxis: {
                                        labels: {
                                            format: "{0}"
                                        },
                                        line: {
                                            visible: false
                                        },
                                        axisCrossingValue: -10
                                    },
                                    categoryAxis: {
                                        categories: <?= json_encode($svy_pedagang['categoryAxis']) ?>,
                                        majorGridLines: {
                                            visible: false
                                        },
                                        labels: {
                                            rotation: "auto"
                                        }
                                    },
                                    tooltip: {
                                        visible: true,
                                        format: "{0}%",
                                        template: "#= series.name #: #= value #"
                                    }
                                });
                            }

                            $(document).ready(createChart);
                            // $(document).bind("kendo:skinChange", createChart);
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>