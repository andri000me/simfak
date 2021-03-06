<?php
require_once 'model/notifikasi.php';
$session = $_SESSION;
$count_notif = get_count_notif($session['nim']);
$data_notif = get_data_notif($session['nim']);
?>
<div class="main-navbar  bg-white">
	<div class="container p-0">
		<!-- Main Navbar -->
		<nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
			<a class="navbar-brand" href="#" style="line-height: 25px;">
				<div class="d-table m-auto">
					<img id="main-logo" class="d-inline-block align-top mr-1 ml-3" style="max-width: 25px;" src="images/shards-dashboards-logo.svg" alt="Shards Dashboard">
					<span class="d-none d-md-inline ml-1">Shards Dashboard</span>
				</div>
			</a>
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
			<ul class="navbar-nav border-left flex-row border-right ml-auto">
				<li class="nav-item border-right dropdown notifications">
					<a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
						<img class="user-avatar rounded-circle mr-2" src="images/avatars/0.jpg" alt="User Avatar"> <span class="d-none d-md-inline-block"><?php echo $_SESSION['name'] ?></span>
					</a>
					<div class="dropdown-menu dropdown-menu-small">
<!--						<a class="dropdown-item" href="user-profile.html"><i class="material-icons"></i> Profile</a>-->
<!--						<a class="dropdown-item" href="edit-user-profile.html"><i class="material-icons"></i> Edit Profile</a>-->
<!--						<a class="dropdown-item" href="file-manager-cards.html"><i class="material-icons"></i> Files</a>-->
<!--						<a class="dropdown-item" href="transaction-history.html"><i class="material-icons"></i> Transactions</a>-->
						<div class="dropdown-divider"></div>
						<a class="dropdown-item text-danger" href="model/user.php?f=logout">
							<i class="material-icons text-danger"></i> Logout </a>
					</div>
				</li>
			</ul>
			<nav class="nav">
				<a href="#" class="nav-link nav-link-icon toggle-sidebar  d-inline d-lg-none text-center " data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
					<i class="material-icons"></i>
				</a>
			</nav>
		</nav>
	</div> <!-- / .container -->
</div> <!-- / .main-navbar -->