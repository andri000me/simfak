<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
require_once './_partials/header.php';
require_once './router/index.php';
role( 'mahasiswa',false);
require_once './model/getdata.php';
//TODO:add redirect if session not set
$get        = $_GET;
$table      = isset( $get['kind'] ) && $get['kind'] == 'barang' ? 'barang' : 'ruangan';
$objectName = isset( $get['kind'] ) && $get['kind'] == 'barang' ? 'nama_barang' : 'nama_ruangan';
$query      = isset( $get['kind'] ) && $get['kind'] == 'barang' ? "SELECT * FROM barang"
	: "SELECT ruangan.id,ruangan.nama_ruangan,ruangan.status,prodi.nama_prodi FROM ruangan LEFT OUTER JOIN prodi ON ruangan.prodi_id = prodi.id";
$datas      = get_data( $query );
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
                        <h3 class="page-title">Daftar fasilitas</h3>
                        <small style="color:red;"><i>* Klik item untuk menambahkan</i></small>
                    </div>
                    <div class="col-12 col-sm-4 d-flex align-items-center">
                        <div class="btn-group btn-group-sm btn-group-toggle d-inline-flex mb-4 mb-sm-0 mx-auto"
                             role="group" aria-label="Page actions">
                            <a href="./peminjaman-user-list.php?kind=ruangan"
                               class="btn btn-white <?php echo isset( $get['kind'] ) && $get['kind'] == 'ruangan' ? 'active' : null ?>">
                                Ruangan </a>
                            <a href="./peminjaman-user-list.php?kind=barang"
                               class="btn btn-white <?php echo isset( $get['kind'] ) && $get['kind'] == 'barang' ? 'active' : null ?>">
                                Barang </a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4 d-flex align-items-center">
                        <div class=" input-group input-group-sm ml-auto input-group-seamless">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="material-icons"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control form-control-sm file-manager-cards__search"
                                   placeholder="Search files">
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->
				<?php include './components/alert.php' ?>
                <!-- Small Stats Blocks -->
                <div class="row">
					<?php
					foreach ( $datas as $key => $item ):?>
                        <div class="col-12 col-md-6 col-lg-3 mb-4">
                            <form action="./model/keranjang.php" method="post">
                                <div class="stats-small card card-small">
                                    <button type="button" id="btn-modal-pinjam" data-toggle="modal"
                                            data-target="#myPinjam" <?php echo isset($item->status)&&$item->status == 1?'disabled':null?> data-user_id="<?php echo $_SESSION['nim'] ?>"
                                            data-item_id="<?php echo $item->id ?>" data-kind="<?php echo $table ?>"
										<?php echo $table == 'barang' ? "data-jumlah=$item->jumlah" : null ?>
                                            style="width: 40px; height: 40px; border-radius: 100%;position:relative;left:-5px;top:-5px;"
                                            class="btn btn-primary btn-sm btn-pill mb-0"><i
                                                class="material-icons">add</i></button>
                                    <div class="card-body px-0 pb-0 pt-1">
                                        <div class="d-flex px-3 align-items-start flex-column" style="height: 100px;">
                                            <div class="mt-0 mb-auto stats-small__data">
                                                <span class="stats-small__label mb-1 text-uppercase"><?php echo $table ?></span>
                                                <h6 class="stats-small__value count m-0"><?php echo $item->{$objectName} ?></h6>
                                            </div>
                                            <div class="h6">
												<?php if ( $get['kind'] == 'ruangan' ): ?>
                                                    <small>Ruangan ada di Prodi <?php echo $item->nama_prodi ?></small>
												<?php endif; ?>
												<?php if ( $get['kind'] == 'barang' ): ?>
                                                    <small>Stok sekitar <?php echo $item->jumlah ?> buah</small>
												<?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
					<?php endforeach; ?>
                </div>
                <!-- End Small Stats Blocks -->
            </div>
			<?php include './_partials/footer-user.php' ?>
			<?php include './components/modal-keranjang.php' ?>
        </main>
    </div>
</div>
<?php require_once './_partials/js.php' ?>
<script>
    $(document).on('click', '#btn-modal-pinjam', function () {
        let kind = $(this).data('kind');
        let item_id = $(this).data('item_id');
        let user_id = $(this).data('user_id');
        let jumlah_barang = $(this).data('jumlah');
        let stringAppend = '<div id="toAppend">';
        stringAppend += '<input type="hidden" name="kind" value="' + kind + '">' +
            '<input type="hidden" name="item_id" value="' + item_id + '">' +
            '<input type="hidden" name="user_id" value="' + user_id + '">';
        if (typeof jumlah_barang !== "undefined") {
            stringAppend += '<div id="jumlahBarang" data-jumlah ="' + jumlah_barang + '"></div>';
        }
        stringAppend += '</div>';
        if (kind === 'barang') {
            $('.modal-header>h6').html('Pinjam Barang');
            $('.modal-dialog').addClass('modal-sm');
            stringAppend += '<div class="form-group">' +
                '<label for="jumlahPinjam">Jumlah Peminjaman</label>' +
                '<input type="number" required id="jumlahPinjam" class="form-control" name="jumlah">' +
                '</div>'
        }
        if(kind === 'ruangan'){
            $('.modal-dialog').removeClass('modal-sm');
            $('.modal-header>h6').html('Pinjam Ruangan')
            stringAppend += '<div class="h6">Apakah anda ingin meminjam ruangan ini? </div>'
        }
        $('.modal-body').append(stringAppend);
    });
    $('#myPinjam').on('hidden.bs.modal', function () {
        $('#toAppend').remove();
    })
</script>
</body>

</html>