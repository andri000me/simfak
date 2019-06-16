<?php
require './_partials/header.php';
require_once './router/index.php';
role( 'mahasiswa',true);
require_once './model/ruangan.php';
require_once './model/getdata.php';
if ( isset( $_GET['id'] ) ) {
	$ruangan = showRuangan( $_GET['id'] );
}
$prodis = get_data( 'SELECT * FROM prodi' );
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
                        <span class="text-uppercase page-subtitle">Ruangan</span>
                        <h3 class="page-title">Ruangan Editable</h3>
                    </div>
                </div>
                <!-- End Page Header -->
                <div class="row">
                    <div class="col-lg-8 mb-4">
                        <div class="card card-small mb-4">
                            <div class="card-header border-bottom">
                                <h6 class="m-0">Form <?php echo $_GET['f'] ?></h6>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item p-3">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <strong class="text-muted d-block mb-2">Forms</strong>
                                            <form action="./model/ruangan.php" method="post">
                                                <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon1">@</span>
                                                        </div>
                                                        <input type="text" name="nama" class="form-control"
                                                               placeholder="Nama Ruangan" aria-label="Username"
                                                               autocomplete="off"
                                                               value="<?php echo isset( $ruangan[0]->nama_ruangan ) ? $ruangan[0]->nama_ruangan : null ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <select class="form-control" name="prodi">
                                                        <option>Pilih Program Studi</option>
														<?php foreach ( $prodis as $prodi ): ?>
                                                            <option <?php echo ( isset( $ruangan[0]->prodi_id ) && $ruangan[0]->prodi_id == $prodi->id ) ? 'selected' : null ?>
                                                                    value="<?php echo $prodi->id ?>"><?php echo $prodi->nama_prodi ?></option>
														<?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <input type="hidden" name="id" class="form-control"
                                                       value="<?php echo isset( $ruangan[0]->id ) ? $ruangan[0]->id : null; ?>">
                                                <button class="btn btn-primary" name="button"
                                                        value="<?php echo $_GET['f'] ?>">Simpan
                                                </button>

                                            </form>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <strong class="text-muted d-block mb-2">Detail</strong>
                                            <p class="h6">Tuliskan Nama Ruangan berdasarkan Program Studi</p>
                                            <p class="h6">Pilih Program studi</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">

                    </div>
                </div>
            </div>
			<?php require './_partials/footer.php' ?>
        </main>
    </div>
</div>
<?php require_once './_partials/js.php' ?>
</body>

</html>