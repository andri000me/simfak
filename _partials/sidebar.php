<!--TODO:Tambahkan session untuk aktifkan list yang di klik-->
<aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
  <div class="main-navbar">
    <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
      <a class="navbar-brand w-100 mr-0" href="#" style="line-height: 25px;">
        <div class="d-table m-auto">
          <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 25px;"
            src="images/shards-dashboards-logo.svg" alt="Shards Dashboard">
          <span class="d-none d-md-inline ml-1">Shards Dashboard</span>
        </div>
      </a>
      <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
        <i class="material-icons"></i>
      </a>
    </nav>
  </div>
  <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
    <div class="input-group input-group-seamless ml-3">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <i class="fas fa-search"></i>
        </div>
      </div>
      <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
    </div>
  </form>
  <div class="nav-wrapper" style="overflow-y: auto;">
    <h6 class="main-sidebar__nav-title">Dashboards</h6>
    <ul class="nav nav--no-borders flex-column">
      <li class="nav-item">
        <a class="nav-link " href="/">
          <i class="material-icons">bar_chart</i>
          <span>Statistik</span>
        </a>
      </li>
      <?php if($_SESSION['level']=='admin'):?>
      <li class="nav-item">
        <a class="nav-link " href="peminjaman-list.php">
          <i class="material-icons"></i>
          <span>Peminjaman</span>
        </a>
      </li>
      <?php endif; ?>
<!--      <li class="nav-item">-->
<!--        <a class="nav-link " href="../peminjaman-list.php">-->
<!--          <i class="material-icons">info</i>-->
<!--          <span>Informasi</span>-->
<!--        </a>-->
<!--      </li>-->
    </ul>
    <h6 class="main-sidebar__nav-title">Master</h6>
    <ul class="nav nav--no-borders flex-column">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
          aria-expanded="true">
          <i class="material-icons"></i>
          <span>User Account</span>
        </a>
        <div class="dropdown-menu dropdown-menu-small">
          <a class="dropdown-item " href="user-management.php">Daftar Pengguna</a>
        </div>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
          aria-expanded="false">
          <i class="material-icons"></i>
          <span>File Managers</span>
        </a>
        <div class="dropdown-menu dropdown-menu-small">
          <a class="dropdown-item " href="file-manager-list.html">Files - List View</a>
          <a class="dropdown-item " href="file-manager-cards.html">Files - Cards View</a>
        </div>
      </li> -->
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
             aria-expanded="true">
              <i class="material-icons"></i>
              <span>Daftar Fasilitas</span>
          </a>
          <div class="dropdown-menu dropdown-menu-small">
              <a class="dropdown-item " href="barang-list.php">Barang</a>
              <a class="dropdown-item " href="ruangan-list.php">Ruangan</a>
          </div>
      </li>
    </ul>
  </div>
</aside>