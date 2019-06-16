<?php require_once './model/getdata.php';
$total_barang          = get_data( "SELECT jumlah FROM barang" );
$total_barang_dipinjam = get_data( "SELECT jumlah FROM peminjaman_barang" );
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

?>
<div class="row">
    <div class="col-lg col-md-6 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Barang</span>
                        <h6 class="stats-small__value count my-3"><?php echo $tot_barang_dipinjam . '/' . $tot_barang ?></h6>
                    </div>
                    <div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase"><?php echo round( ( $tot_barang_dipinjam / $tot_barang ) * 100, 2 ) ?>%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg col-md-6 col-sm-6 mb-4">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Ruangan</span>
                        <h6 class="stats-small__value count my-3"><?php echo $tot_ruangan_dipinjam . '/' . $tot_ruangan ?></h6>
                    </div>
                    <div class="stats-small__data">
                        <span class="stats-small__percentage stats-small__percentage--increase"><?php echo round( ( $tot_ruangan_dipinjam / $tot_ruangan ) * 100, 2 ) ?>%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--    <div class="col-lg col-md-4 col-sm-6 mb-4">-->
<!--        <div class="stats-small stats-small--1 card card-small">-->
<!--            <div class="card-body p-0 d-flex">-->
<!--                <div class="d-flex flex-column m-auto">-->
<!--                    <div class="stats-small__data text-center">-->
<!--                        <span class="stats-small__label text-uppercase">Comments</span>-->
<!--                        <h6 class="stats-small__value count my-3">8,147</h6>-->
<!--                    </div>-->
<!--                    <div class="stats-small__data">-->
<!--                        <span class="stats-small__percentage stats-small__percentage--decrease">3.8%</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <canvas height="120" class="blog-overview-stats-small-3"></canvas>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-lg col-md-4 col-sm-6 mb-4">-->
<!--        <div class="stats-small stats-small--1 card card-small">-->
<!--            <div class="card-body p-0 d-flex">-->
<!--                <div class="d-flex flex-column m-auto">-->
<!--                    <div class="stats-small__data text-center">-->
<!--                        <span class="stats-small__label text-uppercase">Users</span>-->
<!--                        <h6 class="stats-small__value count my-3">2,413</h6>-->
<!--                    </div>-->
<!--                    <div class="stats-small__data">-->
<!--                        <span class="stats-small__percentage stats-small__percentage--increase">12.4%</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <canvas height="120" class="blog-overview-stats-small-4"></canvas>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-lg col-md-4 col-sm-12 mb-4">-->
<!--        <div class="stats-small stats-small--1 card card-small">-->
<!--            <div class="card-body p-0 d-flex">-->
<!--                <div class="d-flex flex-column m-auto">-->
<!--                    <div class="stats-small__data text-center">-->
<!--                        <span class="stats-small__label text-uppercase">Subscribers</span>-->
<!--                        <h6 class="stats-small__value count my-3">17,281</h6>-->
<!--                    </div>-->
<!--                    <div class="stats-small__data">-->
<!--                        <span class="stats-small__percentage stats-small__percentage--decrease">2.4%</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <canvas height="120" class="blog-overview-stats-small-5"></canvas>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</div>