<?php
require_once './model/getdata.php';
$totalCart = 0;
$countBarang = get_data("SELECT COUNT(*) as total FROM cart_barang WHERE akun_id = '$_SESSION[nim]'");
$countRuangan = get_data("SELECT COUNT(*) as total FROM cart_ruangan WHERE akun_id = '$_SESSION[nim]'");
$totalCart = $totalCart + $countBarang[0]->total+ $countRuangan[0]->total;
?>
<div class="header-navbar nav-wrapper collapse d-lg-flex p-0 bg-white border-top">
    <div class="container">
        <div class="row">
            <div class="col">
<!--                TODO:add active navbar-->
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                    <li class="nav-item">
                        <a href="peminjaman-user-list.php?kind=ruangan" class="nav-link active"><i
                                    class="material-icons">chrome_reader_mode</i> Daftar Fasilitas</a>
                    </li>
                    <li class="nav-item">
                        <a href="peminjaman-user-do.php" class="nav-link my-0">
                            <i class="material-icons">add_shopping_cart</i>
                            Peminjaman Fasilitas
                            <span class="badge badge-pill badge-danger" style="display: inline !important;"><?php echo $totalCart ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="peminjaman-user-status.php" class="nav-link"><i
                                    class="material-icons">announcement</i> Status Peminjaman</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>