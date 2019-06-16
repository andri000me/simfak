<?php 
session_start();
require_once './_partials/header.php';?>
<body class="h-100" data-gr-c-s-loaded="true">
    <div class="container-fluid icon-sidebar-nav h-100 nav-wrapper mt-5">
        <div class="row h-100">
            <main class="main-content col">
                <div class="main-content-container container-fluid px-4 my-auto h-100">
                    <div class="row no-gutters h-100">
                        <div class="col-lg-4 col-md-6 auth-form mx-auto my-auto">
                        <?php
                            require('./components/alert.php');
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <img class="auth-form__logo d-table mx-auto mb-3"
                                        src="images/shards-dashboards-logo.svg"
                                        alt="Shards Dashboards - Register Template">
                                    <h5 class="auth-form__title text-center mb-4">Buat akun untuk melakukan peminjaman</h5>
                                    <form method="POST" action="./model/user.php">
                                        <div class="form-group">
                                            <label for="nim">Masukkan NIM</label>
                                            <input type="text" class="form-control" id="nim" name="nim"
                                                aria-describedby="emailHelp" placeholder="Enter ID" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="pass">Password</label>
                                            <input type="password" class="form-control" id="pass" name="pass"
                                                placeholder="Password" autocomplete="off">
                                        </div>
                                        <button type="submit" name="button" value="login" class="btn btn-pill btn-accent d-table mx-auto">Log In</button>
                                    </form>
                                </div>
                            </div>
                            <div class="auth-form__meta d-flex mt-4">
                                <a href="#">Forgot your password?</a>
                                <a class="ml-auto" href="user-register.php">Sign Up?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php require_once './_partials/js.php' ?>
</body>

</html>