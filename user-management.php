<?php
include( './_partials/header.php' );
require_once './model/user.php';
$akuns = showAccounts(null,['level','level_id = level.id'],'akun.id as akun_id,level.id as level_id,nama_level,username,password');
?>

<body class="h-100">
<div class="container-fluid">
    <div class="row">
        <!-- Main Sidebar -->
		<?php include( './_partials/sidebar.php' ) ?>
        <!-- End Main Sidebar -->
        <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
            <div class="main-navbar sticky-top bg-white">
                <!-- Main Navbar -->
				<?php include( './_partials/navbar.php' ) ?>
            </div>
            <!-- / .main-navbar -->
            <div class="main-content-container container-fluid px-4">
                <!-- Page Header -->
                <div class="page-header row no-gutters py-4">
                    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                        <span class="text-uppercase page-subtitle">Users</span>
                        <h3 class="page-title">Manajemen Akun Pengguna</h3>
                    </div>
                </div>
                <!-- End Page Header -->
                <div class="row">
                    <div class="col">
						<?php require( './components/alert.php' ); ?>
                        <div class="card card-small mb-4">
                            <div class="card-header border-bottom">
                                <div class="d-flex justify-content-between">
                                    <h6 class="m-0">Daftar Pengguna</h6>
                                    <a href="./user-operation.php?f=add" class="btn btn-primary">Tambah</a>
                                </div>
                            </div>
                            <div class="card-body p-0 pb-3 text-center">
                                <table class="table mb-0">
                                    <thead class="bg-light">
                                    <tr>
                                        <th class="border-0">No.</th>
                                        <th class="border-0">Identitas</th>
                                        <th class="border-0">Username</th>
                                        <th class="border-0">Password</th>
                                        <th class="border-0">Level</th>
                                        <th class="border-0">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
									<?php foreach ( $akuns as $key => $akun ): ?>
                                        <tr>
                                            <td><?php echo $key + 1 ?></td>
                                            <td><?php echo $akun->username ?></td>
                                            <td><?php echo $akun->username ?></td>
                                            <td><?php echo $akun->password ?></td>
                                            <td><?php echo $akun->nama_level ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="user-operation.php?f=edit&id=<?php echo $akun->akun_id ?>"
                                                       class="btn btn-white">
                                                        <i class="material-icons"></i>
                                                    </a>
                                                    <button type="button" id="btn-modal" class="btn btn-white"
                                                            data-toggle="modal"
                                                            data-target="#myModal" data-id="<?php echo $akun->akun_id ?>">
                                                        <i class="material-icons"></i>
                                                    </button>
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
			<?php include( './_partials/footer.php' ) ?>
        </main>
    </div>
</div>
<?php include( './_partials/js.php' ) ?>
<?php include( './_partials/modal.php' ) ?>
<script>
    $(document).on('click', '#btn-modal', function () {
        let id = $(this).data('id');
        $('.modal-body').append('<p id="textDialog" class="h6">Apakah anda yakin untuk menghapus user?</p>');
        $('.modal-footer').append('<a href="./model/user.php?f=delete&id=' + id + '" id="operation" class="btn btn-primary">Delete</a>');
    })
    $('#myModal').on('hidden.bs.modal',function () {
        $('#textDialog').remove();
        $('a#operation').remove();
    })

</script>

</body>

</html>


