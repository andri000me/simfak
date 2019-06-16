<?php
require_once 'model/notifikasi.php';
$session = $_SESSION;
$count_notif = get_count_notif( $session['level']);
$data_notif = get_data_notif($session['level']);
?>
<nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
  <form action="#" class="main-navbar__search w-100 d-none d-md-flex d-lg-flex">
    <div class="input-group input-group-seamless ml-3">
      <div class="input-group-prepend">
        <div class="input-group-text">
          <i class="fas fa-search"></i>
        </div>
      </div>
      <input class="navbar-search form-control" type="text" placeholder="Search for something..." aria-label="Search">
    </div>
  </form>
  <ul class="navbar-nav border-left flex-row ">
    <li class="nav-item border-right dropdown notifications">
      <a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <div class="nav-link-icon__wrapper">
          <i class="material-icons"></i>
          <span class="badge badge-pill badge-danger"><?php echo $count_notif[0]->number ?></span>
        </div>
      </a>
      <div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
	      <?php foreach ( $data_notif as $item_notif ):?>
        <a class="dropdown-item" href="<?php echo $item_notif->link ?>">
          <div class="notification__icon-wrapper">
            <div class="notification__icon">
              <i class="material-icons">info</i>
            </div>
          </div>
          <div class="notification__content">
            <span class="notification__category text-uppercase"><?php echo $item_notif->kategori?></span>
            <p><?php echo $item_notif->pesan?></p>
          </div>
        </a>
	      <?php endforeach;?>
<!--        <a class="dropdown-item notification__all text-center" href="#"> View all-->
<!--          Notifications </a>-->
      </div>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button"
        aria-haspopup="true" aria-expanded="false">
        <img class="user-avatar rounded-circle mr-2" src="../images/avatars/0.jpg" alt="User Avatar"> <span
          class="d-none d-md-inline-block"><?php echo $session['name']; ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-small">
<!--        <a class="dropdown-item" href="user-profile.html"><i class="material-icons"></i>-->
<!--          Profile</a>-->
<!--        <a class="dropdown-item" href="edit-user-profile.html"><i class="material-icons"></i> Edit Profile</a>-->
<!--        <a class="dropdown-item" href="file-manager-cards.html"><i class="material-icons"></i> Files</a>-->
<!--        <a class="dropdown-item" href="transaction-history.html"><i class="material-icons"></i> Transactions</a>-->
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="../model/user.php?f=logout">
          <i class="material-icons text-danger"></i> Logout </a>
      </div>
    </li>
  </ul>
  <nav class="nav">
    <a href="#" class="nav-link nav-link-icon toggle-sidebar d-sm-inline d-md-none text-center border-left"
      data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
      <i class="material-icons"></i>
    </a>
  </nav>
</nav>