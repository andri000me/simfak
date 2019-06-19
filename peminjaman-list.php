<?php
require_once './_partials/header.php';
require_once './router/index.php';
role( 'mahasiswa',true);
require_once './model/peminjaman.php';
require_once './_partials/helper.php';
$mergedPeminjaman = [];
if($_SESSION['level'] == 'kabag umum'){
	$mergedPeminjaman = get_all_peminjaman('kabag umum');
}
else {
	$mergedPeminjaman = get_all_peminjaman();
}
$get              = $_GET;
//var_dump($mergedPeminjaman);
?>
<body class="h-100" data-gr-c-s-loaded="true">
<div class="container-fluid">
    <div class="row">
        <!-- Main Sidebar -->
		<?php require_once './_partials/sidebar.php' ?>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
            <div class="main-navbar sticky-top bg-white">
                <!-- Main Navbar -->
				<?php require_once './_partials/navbar.php' ?>
            </div> <!-- / .main-navbar -->
            <div class="main-content-container container-fluid px-4 mb-4">
                <!-- Page Header -->
                <div class="page-header row no-gutters py-4">
                    <div class="col-12 col-sm-12 text-center text-sm-left mb-4 mb-sm-0">
                        <span class="text-uppercase page-subtitle">Dashboard</span>
                        <h3 class="page-title">Daftar Peminjaman</h3>
                        <small class="font-weight-light text-danger">* Cetak surat terlebih dahulu sebelum menginfokan ke kabag umum</small>
                    </div>
                </div>
                <!-- End Page Header -->
	            <?php include './components/alert.php'?>
                <!-- Transaction History Table -->
                <table cellspacing="0"
                       class="transaction-history d-none dataTable no-footer dtr-inline display responsive nowrap">
                    <thead>
                    <tr role="row">
                        <th class="sorting_asc">#</th>
                        <th class="sorting">Waktu Peminjaman</th>
                        <th class="sorting">Waktu Pengembalian</th>
                        <th class="sorting">Peminjam</th>
                        <th class="sorting">Status</th>
                        <th class="none">Perihal</th>
                        <th class="none">Detail Peminjaman</th>
                        <th class="none" style="width: 20%;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach ( $mergedPeminjaman as $key => $peminjaman ): ?>
                        <tr>
                            <td><?php echo $key + 1 ?></td>
                            <td><?php echo $peminjaman->tanggal_transaksi ?></td>
                            <td><?php echo $peminjaman->tanggal_kembali ?></td>
                            <td><?php echo $peminjaman->nama_mahasiswa ?></td>

							<?php $status = get_status_message( $peminjaman->status ) ?>
                            <td class="text-<?php echo $status->color ?>"><?php
								echo $status->status; ?></td>
                            <td class="font-weight-bold"><?php echo $peminjaman->perihal?></td>
                            <td>
								<?php
								$barangs  = show_peminjaman( $peminjaman->perihal, 'barang', $peminjaman->akun_id );
								$ruangans = show_peminjaman( $peminjaman->perihal, 'ruangan', $peminjaman->akun_id );
								?>
                                <div class="m-0 p-0 float-left d-flex justify-content-between flex-column">
									<?php if ( count( $barangs ) > 0 ): ?>
                                        <h6 class="text-uppercase font-weight-normal">Barang</h6>
                                        <ul>
											<?php foreach ( $barangs as $barang ): ?>
                                                <li class="d-flex justify-content-between">
                                                    <div class="col-xs-6 font-weight-light"><?php echo $barang->nama_barang ?></div>
                                                    <div class="col-xs-6 font-weight-light"><?php echo $barang->jumlah ?></div>
                                                </li>
											<?php endforeach; ?>
                                        </ul>
									<?php endif; ?>
									<?php if ( count( $ruangans ) > 0 ): ?>
                                        <h6 class="text-uppercase font-weight-normal">Ruangan</h6>
                                        <ul>
											<?php foreach ( $ruangans as $ruangan ): ?>
                                                <li class="d-flex flex-column align-items-start">
                                                    <div class="col-xs-6 font-weight-light"><?php echo $ruangan->nama_ruangan ?></div>
                                                    <div class="col-xs-6 font-weight-light">
                                                        (<?php echo $ruangan->nama_prodi ?>)
                                                    </div>
                                                </li>
											<?php endforeach; ?>
                                        </ul>
									<?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
	                                <?php if($_SESSION['level'] == 'bmn'):?>
                                    <form action="./model/peminjaman.php" method="post">
                                        <input type="hidden" name="nim" value="<?php echo $peminjaman->akun_id ?>">
                                        <input type="hidden" name="perihal" value="<?php echo $peminjaman->perihal ?>">
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" name="button" <?php echo $peminjaman->status!=0?'disabled':null?> value="send" class="btn btn-white" data-toggle="tiptool"
                                                data-placement="top" title="Infokan ke Kabag">
                                            <i class="material-icons">mail</i>
                                        </button>
                                    </form>
                                    <!--                                  TODO:active button sending to kabag      -->
                                    <form action="./surat_pengajuan.php" method="post">
                                        <input type="hidden" name="nim" value="<?php echo $peminjaman->akun_id ?>">
                                        <input type="hidden" name="perihal" value="<?php echo $peminjaman->perihal ?>">
                                        <input type="hidden" name="status" value="1">
                                        <button type="submit" class="btn btn-white" name="button" value="print" data-toggle="tiptool"
                                                data-placement="top" <?php echo $peminjaman->status!=0?'disabled':null?> title="Cetak Surat Permohonan">
                                            <i class="material-icons">local_printshop</i>
                                        </button>
                                    </form>
	                                <?php endif;?>
	                                <?php if($_SESSION['level'] == 'direktur'):?>
                                        <form action="./model/peminjaman.php" method="post">
                                            <input type="hidden" name="nim" value="<?php echo $peminjaman->akun_id ?>">
                                            <input type="hidden" name="perihal" value="<?php echo $peminjaman->perihal ?>">
                                            <input type="hidden" name="status" value="1">
                                            <div class="btn-group btn-group-sm">
                                                <button type="submit" name="button" value="acceptdirektur" class="btn btn-white">
                                                    <span class="text-success"><i class="material-icons">check</i></span> Approve </button>
                                                <button type="submit" name="button" value="denydirektur" class="btn btn-white">
                                                    <span class="text-danger"><i class="material-icons">clear</i></span> Reject </button>
                                            </div>
                                        </form>
	                                <?php endif;?>
	                                <?php if($_SESSION['level'] == 'kabag umum'):?>
                                        <form action="./model/peminjaman.php" method="post">
                                            <input type="hidden" name="nim" value="<?php echo $peminjaman->akun_id ?>">
                                            <input type="hidden" name="perihal" value="<?php echo $peminjaman->perihal ?>">
                                            <div class="btn-group btn-group-sm">
                                                <button type="submit" name="button" value="accept" class="btn btn-white">
                                                    <span class="text-success"><i class="material-icons">check</i></span> Approve </button>
                                                <button type="submit" name="button" value="deny" class="btn btn-white">
                                                    <span class="text-danger"><i class="material-icons">clear</i></span> Reject </button>
                                            </div>
                                        </form>
	                                <?php endif;?>
                                    <!--                                  TODO:cetak surat permohonan(format surat)
                                            TODO:add kabag action, add notif to kabag, action kabag acc and decline permohonan-->
                                </div>
                            </td>
                        </tr>
					<?php endforeach; ?>
                    </tbody>
                </table>
                <!-- End Transaction History Table -->
            </div>
			<?php require_once './_partials/footer.php' ?>
        </main>
    </div>
</div>
<?php require_once './_partials/js.php' ?>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="tiptool"]').tooltip();
    })
</script>
</body>

</html>