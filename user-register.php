<?php 
session_start();
require_once './_partials/header.php' ?>

<body class="h-100" data-gr-c-s-loaded="true">
    <div class="container-fluid icon-sidebar-nav h-100 nav-wrapper mt-5">
        <div class="row h-100">
            <main class="main-content col">
                <div class="main-content-container container-fluid px-4 my-auto h-100">
                    <div class="row no-gutters h-100">
                        <div class="col-lg-4 col-md-6 auth-form mx-auto my-auto">
                            <?php
                            if(isset($_SESSION['status'])){
                                $status = $_SESSION['status'];
                                if($status == 'success'){
                                    echo '<div class="alert alert-success">Registrasi Berhasil <a href="./user-login.php">klik untuk login</a></div>';
                                }
                                if($status == 'fail'){
                                    echo '<div class="alert alert-danger">Akun sudah terdaftar<a href="./user-login.php">klik untuk login</a></div>';
                                }
                                session_destroy();
                            }
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <img class="auth-form__logo d-table mx-auto mb-3"
                                        src="images/shards-dashboards-logo.svg"
                                        alt="Shards Dashboards - Register Template">
                                    <h5 class="auth-form__title text-center mb-4">Buat akun untuk melakukan peminjaman
                                    </h5>
                                    <form method="POST" action="./model/user.php">
                                        <div class="form-group">
                                            <label for="nim">Masukkan NIM</label>
                                            <input type="text" class="form-control" id="nim"
                                                aria-describedby="emailHelp" placeholder="Enter ID" autocomplete="off"
                                                name="nim" required>
                                            <input type="text" class="form-control mt-1" id="mhs"
                                                aria-describedby="emailHelp" readonly placeholder="Nama Mhs"
                                                autocomplete="off">
                                        </div>
                                        <div class="form-group" id='inputPass'>
                                            <label for="pass">Password</label>
                                            <div class="row">
                                                <div class="col-sm-6" id='appendError'>
                                                    <input type="password" required name="password" class="form-control"
                                                        id="pass" placeholder="Password" autocomplete="off">

                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="password" required class="form-control" id="retypepass"
                                                        placeholder="Password Ulang" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="button" value='register'
                                            class="btn btn-pill btn-accent d-table mx-auto">Create
                                            Account</button>
                                    </form>
                                </div>
                                <!-- <div class="card-footer border-top">
                                    <ul class="auth-form__social-icons d-table mx-auto">
                                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-github"></i></a></li>
                                        <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="auth-form__meta d-flex mt-4">
                                <a href="#">Forgot your password?</a>
                                <a class="ml-auto" href="user-login.php">Sign In?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <?php require_once './_partials/js.php' ?>
    <script src="scripts/app/typeahead.js"></script>
    <!-- <script src="scripts/da"></script> -->
    <script>
        $(document).ready(function () {
            var $input = $('#nim')
            $input.typeahead({
                source: function (query, result) {
                    $.ajax({
                        url: "ajax.php?data=mahasiswa",
                        data: 'query=' + query,
                        type: "GET",
                        success: function (data) {
                            result($.map(JSON.parse(data), function (item) {
                                return item.nim;
                            }));
                        }
                    });
                },
                afterSelect: function (val) {
                    $.ajax({
                        url: "ajax.php?data=mahasiswa",
                        data: 'query=' + val,
                        type: "GET",
                        success: function (data) {
                            var mhs = JSON.parse(data);
                            if (mhs.length > 0) {
                                $('#mhs').val(mhs[0].nama_mahasiswa)
                            }

                        }
                    });
                },

            })

            function checkPass() {
                let retypePass = $('#retypepass').val();
                let pass = $("#pass").val();
                if (pass !== retypePass) {
                    $('#retypepass').addClass('is-invalid');
                    $('[name="button"]').attr('disabled', 'disabled');
                    $('#appendError').append(
                        '<div id="passError" class="invalid-feedback">Password tidak cocok.</div>');
                    $('#pass').addClass('is-invalid');
                }
            }

            function removeError() {
                $('#retypepass').removeClass('is-invalid');
                $('#passError').remove();
                $('[name="button"]').removeAttr('disabled', 'disabled');
                $('#pass').removeClass('is-invalid');
            }
            $('#retypepass').blur(function () {
                checkPass();
            })
            $('#pass').blur(function () {
                if ($('#retypepass').val().length !== 0) {
                    checkPass();
                }
            })
            $('#pass').focus(function () {
                removeError();
            })
            $('#retypepass').focus(function () {
                removeError();
            })
        });
    </script>
</body>

</html>