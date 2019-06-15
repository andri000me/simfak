<?php require_once './_partials/header.php' ?>
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
                        <div class="col-12 col-sm-4 text-center text-sm-left mb-4 mb-sm-0">
                            <span class="text-uppercase page-subtitle">Dashboard</span>
                            <h3 class="page-title">Daftar Peminjaman</h3>
                        </div>
                        <div class="offset-sm-4 col-4 d-flex col-12 col-sm-4 d-flex align-items-center">
                            <div id="transaction-history-date-range"
                                class="input-daterange input-group input-group-sm ml-auto">
                                <input type="text" class="input-sm form-control" name="start" placeholder="Start Date"
                                    id="analytics-overview-date-range-1">
                                <input type="text" class="input-sm form-control" name="end" placeholder="End Date"
                                    id="analytics-overview-date-range-2">
                                <span class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="material-icons"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- End Page Header -->
                    <!-- Transaction History Table -->
                    <div class="dataTables_wrapper no-footer">
                        <table class="transaction-history d-none dataTable no-footer dtr-inline">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc">#</th>
                                    <th class="sorting">Date</th>
                                    <th class="sorting">Peminjam</th>
                                    <th class="sorting">Pinjaman</th>
                                    <th class="sorting">Status</th>
                                    <th class="sorting">Jenis Pinjaman</th>
                                    <th class="sorting">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $j = [1,2,3,4,5,6]; foreach($j as $i):?>
                                <tr>
                                    <td>1</td>
                                    <td>October 31st 2017 <span class="text-sm">02:10 PM</span>
                                    </td>
                                    <td>Mrs. Chauncey McDermott</td>
                                    <td>68010</td>
                                    <td>
                                        <span class="text-warning">Pending</span>
                                    </td>
                                    <td>
                                        <span class="text-success">$269.75</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" class="btn btn-white">
                                                <i class="material-icons"></i>
                                            </button>
                                            <button type="button" class="btn btn-white">
                                                <i class="material-icons"></i>
                                            </button>
                                            <button type="button" class="btn btn-white">
                                                <i class="material-icons"></i>
                                            </button>
                                            <button type="button" class="btn btn-white">
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
</body>

</html>