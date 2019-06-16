<?php
require_once './_partials/header.php';
require_once './router/index.php';
role( 'mahasiswa',true);
require_once './model/barang.php';
$barangs  = showBarang();
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
			<div class="main-content-container container-fluid px-sm-4 mb-0">
				<!-- Page Header -->
				<div class="page-header row no-gutters py-4">
					<div class="col-12 col-sm-4 text-center text-sm-left mb-4 mb-0">
						<span class="text-uppercase page-subtitle">Master</span>
						<h3 class="page-title">Daftar Barang</h3>
					</div>
					<div class="offset-sm-4 col-4 d-flex col-12 col-sm-4 d-flex align-items-center justify-content-end">
						<a href="./barang-operation.php?f=add" class="btn btn-primary">Tambah Barang</a>
					</div>
				</div>
				<?php
				require('./components/alert.php');
				?>
				<!-- End Page Header -->
				<!-- Transaction History Table -->
				<div class="dataTables_wrapper no-footer">
					<table class="transaction-history d-none dataTable no-footer dtr-inline">
						<thead>
						<tr role="row">
							<th class="sorting_asc">#</th>
							<th class="sorting">Waktu Penambahan</th>
							<th class="sorting">Nama Barang</th>
							<th class="sorting">Jumlah</th>
							<th class="sorting">Actions</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ( $barangs as $bar => $barang ): ?>
							<tr>
								<td><?php echo $bar + 1 ?></td>
								<td><?php echo $barang->waktu_penambahan ?></td>
								<td><?php echo $barang->nama_barang ?></td>
								<td><?php echo $barang->jumlah ?></td>
								<td>
									<div class="btn-group btn-group-sm">
										<a href="barang-operation.php?f=edit&id=<?php echo $barang->id?>" class="btn btn-white">
											<i class="material-icons"></i>
										</a>
										<button type="button" id="btn-modal" class="btn btn-white"
										        data-toggle="modal"
										        data-target="#myModal" data-id="<?php echo $barang->id ?>">
											<i class="material-icons"></i>
										</button>
									</div>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<!-- End Transaction History Table -->
			</div>
			<?php require_once './_partials/footer.php' ?>
		</main>
	</div>
</div>
<?php require_once './_partials/js.php' ?>
<?php require_once './_partials/modal.php'?>
<script>
    $(document).on('click', '#btn-modal', function () {
        let id = $(this).data('id');
        $('.modal-body').append('<p id="textDialog" class="h6">Apakah anda yakin untuk menghapus barang?</p>');
        $('.modal-footer').append('<a href="./model/barang.php?f=delete&id=' + id + '" id="operation" class="btn btn-primary">Delete</a>');
    })
    $('#myModal').on('hidden.bs.modal',function () {
        $('#textDialog').remove();
        $('a#operation').remove();
    })

</script>
</body>

</html>