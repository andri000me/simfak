<?php
require './_partials/header.php';
require_once './router/index.php';
require_once './model/user.php';
require_once './model/getdata.php';
if(isset($_GET['id'])){
	$akuns = showAccounts($_GET['id']);
}
$levels = get_data('SELECT * FROM level');
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
              <span class="text-uppercase page-subtitle">Users</span>
              <h3 class="page-title">Users Editable</h3>
            </div>
          </div>
          <!-- End Page Header -->
          <div class="row">
              <div class="col-lg-8 mb-4">
                <div class="card card-small mb-4">
                  <div class="card-header border-bottom">
                    <h6 class="m-0">Form Edit</h6>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item p-3">
                      <div class="row">
                        <div class="col-sm-12 col-md-6">
                          <strong class="text-muted d-block mb-2">Forms</strong>
                          <form action="./model/user.php" method="post">
                            <div class="form-group">
                              <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">@</span>
                                </div>
                                  <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" autocomplete="off" value="<?php echo isset($akuns[0]->username)?$akuns[0]->username:null?>"> </div>
                            </div>
                            <div class="form-group">
                              <input type="password" name="password" class="form-control" id="inputPassword4" placeholder="Password" value="<?php echo isset($akuns[0]->password)?$akuns[0]->password:null ?>">
                            </div>
                              <div class="form-group">
                                  <select class="form-control" name="level">
                                      <option>Pilih level user</option>
	                                  <?php foreach ($levels as $level):?>
                                      <option <?php echo (isset($akuns[0]->level_id)&& $akuns[0]->level_id ==$level->id)?'selected':null?> value="<?php echo $level->id?>"><?php echo $level->nama_level ?></option>
	                                  <?php endforeach;?>
                                  </select>
                              </div>
                              <input type="hidden" name="id" class="form-control" value="<?php echo isset($akuns[0]->id)?$akuns[0]->id:null; ?>">
                              <button class="btn btn-primary" name="button" value="<?php echo $_GET['f']?>">Simpan</button>

                          </form>
                        </div>
                        <div class="col-sm-12 col-md-6">
                          <strong class="text-muted d-block mb-2">Detail</strong>
                            <p class="h6">Daftarkan Nomor identitas pengguna sebagai username</p>
                            <p class="h6">Password bisa generate otomatis</p>
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