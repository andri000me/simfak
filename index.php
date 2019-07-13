<?php
require './_partials/header.php';
require_once './router/index.php';
role( 'mahasiswa',true);
require_once './model/getdata.php';
$total_barang          = get_data( "SELECT nama_barang,jumlah FROM barang" );
$total_barang_dipinjam = get_data( "SELECT barang.nama_barang,peminjaman_barang.jumlah FROM peminjaman_barang LEFT OUTER JOIN barang ON peminjaman_barang.barang_id = barang.id" );
$tot_barang            = 0;
$tot_barang_dipinjam   = 0;
foreach ( $total_barang as $tb ) {
	$tot_barang += $tb->jumlah;
}
foreach ( $total_barang_dipinjam as $tbd ) {
	$tot_barang_dipinjam += $tbd->jumlah;
}


$total_ruangan          = get_data( "SELECT COUNT(*) AS jumlah FROM ruangan" );
$total_ruangan_dipinjam = get_data( "SELECT COUNT(*) AS jumlah FROM peminjaman_ruangan" );
$tot_ruangan            = $total_ruangan[0]->jumlah;
$tot_ruangan_dipinjam   = $total_ruangan_dipinjam[0]->jumlah;

$ruangan_dipinjam = $tot_ruangan - $tot_ruangan_dipinjam;
$barang_dipinjam  = $tot_barang - $tot_barang_dipinjam;
$barangChart      = array( $barang_dipinjam,$tot_barang_dipinjam );
$ruanganChart     = array( $ruangan_dipinjam,$tot_ruangan_dipinjam  );
?>
<body class="h-100">
<div class="container-fluid">
    <div class="row">
        <!-- Main Sidebar -->
		<?php require './_partials/sidebar.php' ?>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
            <div class="main-navbar sticky-top bg-white">
                <!-- Main Navbar -->
				<?php require './_partials/navbar.php' ?>
            </div>
            <!-- / .main-navbar -->
            <div class="main-content-container container-fluid px-4">
                <!-- Page Header -->
                <div class="page-header row no-gutters py-4">
                    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                        <span class="text-uppercase page-subtitle">Dashboard</span>
                        <h3 class="page-title">Peminjaman Overview</h3>
                    </div>
                </div>
                <!-- End Page Header -->
                <!-- Small Stats Blocks -->
				<?php require './components/state_block.php' ?>
                <!-- End Small Stats Blocks -->
                <div class="row">
                    <!-- Users Stats -->
                    <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
                        <div class="card card-small">
                            <div class="card-header border-bottom">
                                <h6 class="m-0">Fasilitas</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row border-bottom py-2 bg-light">
                                    <div class="col-12 col-sm-6">
                                        <label for="chart-barang">Fasilitas Barang</label>
                                        <canvas height="130" style="max-width: 100% !important;"
                                                id="chart-barang"></canvas>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <label for="chart-barang">Fasilitas Ruangan</label>
                                        <canvas height="130" style="max-width: 100% !important;"
                                                id="chart-ruangan"></canvas>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End Users Stats -->
                    <!-- Users By Device Stats -->
<!--                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">-->
<!--                        <div class="card card-small h-100">-->
<!--                            <div class="card-header border-bottom">-->
<!--                                <h6 class="m-0">Users by device</h6>-->
<!--                            </div>-->
<!--                            <div class="card-body d-flex py-0">-->
<!--                                <canvas height="220" class="blog-users-by-device m-auto"></canvas>-->
<!--                            </div>-->
<!--                            <div class="card-footer border-top">-->
<!--                                <div class="row">-->
<!--                                    <div class="col">-->
<!--                                        <select class="custom-select custom-select-sm" style="max-width: 130px;">-->
<!--                                            <option selected>Last Week</option>-->
<!--                                            <option value="1">Today</option>-->
<!--                                            <option value="2">Last Month</option>-->
<!--                                            <option value="3">Last Year</option>-->
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                    <div class="col text-right view-report">-->
<!--                                        <a href="#">Full report &rarr;</a>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <!-- End Users By Device Stats -->
                </div>
                <div class="row">
                    <!-- Users Stats -->
                    <div class="col-lg-8 col-md-12 col-sm-12 mb-4">
                        <div class="card card-small">
                            <div class="card-header border-bottom">
                                <h6 class="m-0">Barang</h6>
                            </div>
                            <div class="card-body pt-0">
                                <div class="row border-bottom py-2 bg-light">
                                    <div class="col-12 col-sm-12">
                                        <label for="chart-barang">Detail Barang</label>
                                        <canvas height="130" style="max-width: 100% !important;"
                                                id="chart-detail-barang"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php require './_partials/footer.php' ?>
        </main>
    </div>
</div>
<?php require_once './_partials/js.php' ?>
<script>
    var configBarang = {
        type: 'pie',
        data: {
            datasets: [{
                data: <?php echo json_encode( $barangChart ) ?>,
                backgroundColor: [
                    'green',
                    'red',
                ],
                label: 'Barang'
            }],
            labels: [
                'Tersedia',
                'Dipinjam',
            ]
        },
        options: {
            responsive: true
        }
    };
    var configRuangan = {
        type: 'pie',
        data: {
            datasets: [{
                data: <?php echo json_encode( $ruanganChart ) ?>,
                backgroundColor: [
                    'green',
                    'orange',
                ],
                label: 'Ruangan'
            }],
            labels: [
                'Tersedia',
                'Dipinjam',
            ]
        },
        options: {
            responsive: true
        }
    };
    <?php $detail_barang = get_data("SELECT barang.nama_barang,peminjaman_barang.jumlah as dipinjam,barang.jumlah as total FROM peminjaman_barang RIGHT OUTER JOIN barang ON peminjaman_barang.barang_id = barang.id");
    ?>

    var configDetailBarang= {

        labels: [<?php foreach ($detail_barang as $br){echo "'$br->nama_barang',";} ?>],
        datasets: [{
            label: 'Tersedia',
            backgroundColor: 'green',
            stack: 'Stack 0',
            data: [<?php foreach ($detail_barang as $br){echo $br->total-$br->dipinjam. ",";} ?>]
        }, {
            label: 'Dipinjam',
            backgroundColor: 'red',
            stack: 'Stack 0',
            data: [<?php foreach ($detail_barang as $br){echo ($br->dipinjam?$br->dipinjam:0).",";} ?>]
        }]

    };
    window.onload = function () {
        var ctxb = document.getElementById('chart-barang').getContext('2d');
        var ctxr = document.getElementById('chart-ruangan').getContext('2d');
        var ctxdb = document.getElementById('chart-detail-barang').getContext('2d');
        window.myBar = new Chart(ctxdb, {
            type: 'horizontalBar',
            data: configDetailBarang,
            options: {
                title: {
                    display: true,
                },
                tooltips: {
                    mode: 'index',
                    intersect: true
                },
                responsive: true,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true
                    }]
                }
            }
        });
        window.myPieBarang = new Chart(ctxb, configBarang);
        window.myPieRuangan = new Chart(ctxr, configRuangan);
    };
</script>
</body>
</html>