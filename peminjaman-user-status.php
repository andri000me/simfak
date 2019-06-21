<?php
//session_start();
//error_reporting( E_ALL );
//ini_set( 'display_errors', 1 );
require_once './_partials/header.php';
require_once './router/index.php';
role( 'mahasiswa', false );
require_once './model/getdata.php';
require_once './_partials/helper.php';
$listPBarang  = get_data( "SELECT DISTINCT akun_id,tanggal_transaksi,perihal,status FROM peminjaman_barang WHERE akun_id =  '$_SESSION[nim]'" );
$listPRuangan = get_data( "SELECT DISTINCT akun_id,tanggal_transaksi,perihal,status FROM peminjaman_ruangan WHERE akun_id =  '$_SESSION[nim]'" );

$listRiwayatBarang  = get_data( "SELECT DISTINCT akun_id,tanggal_transaksi,perihal,status FROM riwayat_barang WHERE akun_id =  '$_SESSION[nim]'" );
$listRiwayatRuangan = get_data( "SELECT DISTINCT akun_id,tanggal_transaksi,perihal,status FROM riwayat_ruangan WHERE akun_id =  '$_SESSION[nim]'" );

$mergedPengajuan = merged_Value( $listPRuangan, $listPBarang );
$mergedRiwayat   = merged_Value( $listRiwayatRuangan, $listRiwayatBarang );

function merged_Value( $a, $b ) {
	$mergedArr = array_merge( $a, $b );

	$mergedArr = array_map( 'json_encode', $mergedArr );
	$mergedArr = array_unique( $mergedArr );
	$merged    = array_map( 'json_decode', $mergedArr );

	return $merged;
}

function get_fasilitas( $perihal, $type ) {
	$q = '';
	if ( $type == 'barang' ) {
		$q = "SELECT b.nama_barang,pb.tanggal_transaksi,pb.jumlah,pb.perihal 
                    FROM peminjaman_barang pb
                    LEFT OUTER JOIN barang b ON pb.barang_id = b.id 
                    WHERE pb.akun_id = '$_SESSION[nim]' AND pb.perihal = '$perihal'";
	}
	if ( $type == 'ruangan' ) {
		$q = "SELECT r.nama_ruangan,pr.tanggal_transaksi,pr.perihal,p.nama_prodi
                    FROM peminjaman_ruangan pr 
                    LEFT OUTER JOIN ruangan r ON pr.ruangan_id = r.id
                    LEFT OUTER JOIN prodi p ON r.prodi_id = p.id
                    WHERE pr.akun_id = '$_SESSION[nim]' AND pr.perihal = '$perihal'";
	}

	return get_data( $q );
}

function get_riwayat( $perihal, $type ) {
	$q = '';
	if ( $type == 'barang' ) {
		$q = "SELECT b.nama_barang,pb.tanggal_transaksi,pb.jumlah,pb.perihal 
                    FROM riwayat_barang pb
                    LEFT OUTER JOIN barang b ON pb.barang_id = b.id 
                    WHERE pb.akun_id = '$_SESSION[nim]' AND pb.perihal = '$perihal'";
	}
	if ( $type == 'ruangan' ) {
		$q = "SELECT r.nama_ruangan,pr.tanggal_transaksi,pr.perihal,p.nama_prodi
                    FROM riwayat_ruangan pr 
                    LEFT OUTER JOIN ruangan r ON pr.ruangan_id = r.id
                    LEFT OUTER JOIN prodi p ON r.prodi_id = p.id
                    WHERE pr.akun_id = '$_SESSION[nim]' AND pr.perihal = '$perihal'";
	}

	return get_data( $q );
}

?>
<body class="h-100" data-gr-c-s-loaded="true">
<div class="container-fluid">
    <div class="row h-100">
        <main class="main-content col-lg-12 col-md-12 col-sm-12 p-0">
            <!--Navbar-->
			<?php include( './_partials/navbar-user.php' ) ?>
			<?php include( './_partials/topbar-user.php' ) ?>
            <div class="main-content-container container">
                <!-- Page Header -->
                <div class="page-header row no-gutters py-4 d-flex justify-content-between">
                    <div class="col-12 col-sm-4 text-center text-sm-left mb-4 mb-sm-0">
                        <span class="text-uppercase page-subtitle">Peminjaman</span>
                        <h3 class="page-title">Status Peminjaman</h3>
                    </div>
                </div>
                <!-- End Page Header -->
	            <?php include('./components/alert.php')?>
                <div class="row">
                    <div class="col">
                        <div class="card card-small mb-4">
                            <div class="card-header border-bottom">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0">Status peminjaman fasilitas</h6>
                                </div>
                            </div>
                            <div class="card-body p-0 pb-3 text-center">
                                <table class="table mb-0">
                                    <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">No.</th>
                                        <th class="border-0">Tanggal Pengajuan</th>
                                        <th class="border-0">Perihal</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ( $mergedPengajuan as $key => $pengajuan ): ?>
                                        <tr>
                                            <td style="width: 5%;"><?php echo $key + 1 ?></td>
                                            <td><?php echo $pengajuan->tanggal_transaksi ?></td>
                                            <td><?php echo $pengajuan->perihal ?></td>
											<?php $progress = get_status_message( $pengajuan->status ) ?>
                                            <td style="width: 40%;">
                                                <div class="progress-wrapper">
                                                    <span class="progress-label d-flex justify-content-start font-weight-light"><?php echo $progress->message ?></span>
                                                    <div class="progress progress-sm mb-3">
                                                        <div id="progress-bar-status"
                                                             class="progress-bar bg-<?php echo $progress->color ?>"
                                                             role="progressbar"
                                                             style="width: <?php echo $progress->number ?>%"
                                                             aria-valuenow="<?php echo $progress->number ?>"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100">
                                                            <span class="progress-value font-weight-bold"><?php echo $progress->number ?>%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" id="btn-modal" class="btn btn-white"
                                                            data-toggle="collapse"
                                                            data-target="#collapseExample_<?php echo $key ?>"
                                                            aria-expanded="false" aria-controls="collapseExample">
                                                        <i class="material-icons">info</i> Detail
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <div class="collapse" id="collapseExample_<?php echo $key ?>">
                                                    <div class="d-flex flex-column align-items-start mb-4 border-bottom">
                                                        <div class="ml-5 font-weight-bold">
                                                            <span>Peminjam : </span><span><?php echo $_SESSION['name'] ?></span>
                                                        </div>
                                                        <div class="ml-5 font-italic font-weight-light">Rincian
                                                            fasilitas yang dipinjam
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-start border-bottom pb-2">
														<?php
														$pengajuan_barangs = get_fasilitas( $pengajuan->perihal, 'barang' );
														if ( count( $pengajuan_barangs ) > 0 ): ?>
                                                            <h6 class="ml-5 font-weight-bold text-uppercase">Barang</h6>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-6 col-xs-6">
                                                                        <div class="font-weight-light ml-5 pl-5">
                                                                            Nama Barang
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-xs-6">
                                                                        <div class="font-weight-light ml-5">Jumlah
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
															<?php foreach ( $pengajuan_barangs as $pb ): ?>
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-md-6 col-xs-6">
                                                                            <div class="font-weight-light ml-5 pl-5">
																				<?php echo $pb->nama_barang ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-xs-6">
                                                                            <div class="font-weight-light ml-5"><?php echo $pb->jumlah ?>
                                                                                Buah
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
															<?php endforeach; ?>
														<?php endif; ?>
														<?php
														$pengajuan_ruangans = get_fasilitas( $pengajuan->perihal, 'ruangan' );
														if ( count( $pengajuan_ruangans ) > 0 ): ?>
                                                            <h6 class="ml-5 font-weight-bold text-uppercase">
                                                                Ruangan</h6>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-6 col-xs-6">
                                                                        <div class="font-weight-light ml-5 pl-5">
                                                                            Nama Ruangan
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-xs-6">
                                                                        <div class="font-weight-light ml-5">Lokasi
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
															<?php foreach ( $pengajuan_ruangans as $pr ): ?>
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-md-6 col-xs-6">
                                                                            <div class="font-weight-light ml-5 pl-5">
																				<?php echo $pr->nama_ruangan ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-xs-6">
                                                                            <div class="font-weight-light ml-5"><?php echo $pr->nama_prodi ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
															<?php endforeach; ?>
														<?php endif; ?>
                                                    </div>
                                                    <div class="d-flex justify-content-end pt-2">
                                                        <form action="./model/peminjaman.php" method="post">
                                                            <input type="hidden" name="nim" value="<?php echo $pengajuan->akun_id ?>">
                                                            <input type="hidden" name="perihal" value="<?php echo $pengajuan->perihal ?>">
                                                            <input type="hidden" name="status" value="1">
                                                            <button type="submit" class="btn btn-primary" name="button" value="kembalikan" data-toggle="tiptool"
                                                                    data-placement="top" <?php echo $pengajuan->status!=1?'disabled':null?> title="Kembalikan Fasilitas">
                                                                Kembalikan Fasilitas
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
									<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card card-small mb-4">
                            <div class="card-header border-bottom">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0">Riwayat peminjaman fasilitas</h6>
                                </div>
                            </div>
                            <div class="card-body p-0 pb-3 text-center">
                                <table class="table mb-0">
                                    <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">No.</th>
                                        <th class="border-0">Tanggal Pengajuan</th>
                                        <th class="border-0">Perihal</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ( $mergedRiwayat as $key => $riwayat ): ?>
                                        <tr>
                                            <td style="width: 5%;"><?php echo $key + 1 ?></td>
                                            <td><?php echo $riwayat->tanggal_transaksi ?></td>
                                            <td><?php echo $riwayat->perihal ?></td>
                                            <td style="width: 40%;">
                                                <p class="text-<?php echo $riwayat->status == 1 ? $riwayat->status == 101 ? "warning" : "info" : "success"?>"><?php echo $riwayat->status == 1 ? $riwayat->status == 101 ? "Ditolak" : "Belum dicek" : "Dikembalikan"?></p>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" id="btn-modal" class="btn btn-white"
                                                            data-toggle="collapse"
                                                            data-target="#collapseRiwayat_<?php echo $key ?>"
                                                            aria-expanded="false" aria-controls="collapseExample">
                                                        <i class="material-icons">info</i> Detail
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <div class="collapse" id="collapseRiwayat_<?php echo $key ?>">
                                                    <div class="d-flex flex-column align-items-start mb-4 border-bottom">
                                                        <div class="ml-5 font-weight-bold">
                                                            <span>Peminjam : </span><span><?php echo $_SESSION['name'] ?></span>
                                                        </div>
                                                        <div class="ml-5 font-italic font-weight-light">Rincian
                                                            fasilitas yang dipinjam
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column align-items-start border-bottom pb-2">
														<?php
														$riwayat_barangs = get_riwayat( $riwayat->perihal, 'barang' );
														if ( count( $riwayat_barangs ) > 0 ): ?>
                                                            <h6 class="ml-5 font-weight-bold text-uppercase">Barang</h6>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-6 col-xs-6">
                                                                        <div class="font-weight-light ml-5 pl-5">
                                                                            Nama Barang
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-xs-6">
                                                                        <div class="font-weight-light ml-5">Jumlah
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
															<?php foreach ( $riwayat_barangs as $pb ): ?>
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-md-6 col-xs-6">
                                                                            <div class="font-weight-light ml-5 pl-5">
																				<?php echo $pb->nama_barang ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-xs-6">
                                                                            <div class="font-weight-light ml-5"><?php echo $pb->jumlah ?>
                                                                                Buah
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
															<?php endforeach; ?>
														<?php endif; ?>
														<?php
														$riwayat_ruangans = get_riwayat( $riwayat->perihal, 'ruangan' );
														if ( count( $riwayat_ruangans ) > 0 ): ?>
                                                            <h6 class="ml-5 font-weight-bold text-uppercase">
                                                                Ruangan</h6>
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-md-6 col-xs-6">
                                                                        <div class="font-weight-light ml-5 pl-5">
                                                                            Nama Ruangan
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-6 col-md-6 col-xs-6">
                                                                        <div class="font-weight-light ml-5">Lokasi
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
															<?php foreach ( $riwayat_ruangans as $pr ): ?>
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-md-6 col-xs-6">
                                                                            <div class="font-weight-light ml-5 pl-5">
																				<?php echo $pr->nama_ruangan ?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-6 col-md-6 col-xs-6">
                                                                            <div class="font-weight-light ml-5"><?php echo $pr->nama_prodi ?></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
															<?php endforeach; ?>
														<?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
									<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php include './_partials/footer-user.php' ?>
        </main>
    </div>
</div>
<?php require_once './_partials/js.php' ?>
</body>

</html>