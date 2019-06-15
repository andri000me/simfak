<?php
session_start();
require_once './_partials/header.php';
require_once './model/getdata.php';

$barangs  = get_data( "SELECT barang.nama_barang,cart_barang.barang_id,cart_barang.jumlah 
                    FROM cart_barang LEFT OUTER JOIN barang ON cart_barang.barang_id = barang.id
                    WHERE cart_barang.akun_id = '$_SESSION[nim]'" );
$ruangans = get_data( "SELECT ruangan.nama_ruangan,cart_ruangan.ruangan_id,prodi.nama_prodi 
                    FROM cart_ruangan 
                        LEFT OUTER JOIN ruangan ON cart_ruangan.ruangan_id= ruangan.id
                        LEFT OUTER JOIN prodi ON ruangan.prodi_id= prodi.id
                    WHERE cart_ruangan.akun_id = '$_SESSION[nim]'" );
$user     = get_data( "SELECT akun.username,mahasiswa.nama_mahasiswa FROM akun LEFT OUTER JOIN mahasiswa ON akun.username = mahasiswa.nim WHERE username = '$_SESSION[nim]'" );
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
                        <h3 class="page-title">Daftar Peminjaman</h3>
                    </div>
                </div>
                <!-- End Page Header -->
	            <?php include('./components/alert.php')?>
                <!-- Small Stats Blocks -->
                <div class="row">
                    <div class="col-12 col-md-8 col-lg-8 mb-4">
                        <div class="card card-small">
                            <div class="card-header border-bottom">
                                <h6 class="text-uppercase mb-0">Detail Peminjaman</h6>
                                <div class="block-handle"></div>
                            </div>
                            <div class="card-body p-3">
                                <div class="form-group"><label for="nim">NIM peminjam</label>
                                    <input type="text" class="form-control col-sm-12 col-md-3" id="nim" name="nim" readonly
                                           value="<?php echo $_SESSION['nim'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nama">Peminjam</label>
                                    <input type="text" class="form-control col-sm-12 col-md-6" name="nama"
                                           placeholder="Atas nama peminjam" id="nama"
                                           value="<?php echo isset( $user[0]->nama_mahasiswa ) ? $user[0]->nama_mahasiswa : null ?>"
                                           autocomplete="off"/>
                                </div>
                                <div class="form-group">
                                    <label for="perihal">Perihal Permohonan</label>
                                    <textarea rows="4" type="text" id="perihal" class="form-control col-sm-12 col-md-6" name="perihal" placeholder="Perihal Permhonan perminjaman fasilitas kampus"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="peminjaman-date-range">Lama Peminjaman</label>
                                    <div id="peminjaman-date-range"
                                         class="input-daterange input-group input-group-sm mr-auto pl-0 col-md-6 col-sm-12">
                                        <input type="text" required autocomplete="off" class="input-sm form-control"
                                               name="start"
                                               placeholder="Mulai Peminjaman">
                                        <input type="text" required autocomplete="off" class="input-sm form-control"
                                               name="end"
                                               placeholder="Tanggal Pengembalian">
                                        <span class="input-group-append">
                                            <span class="input-group-text">
                                              <i class="material-icons"></i>
                                            </span>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" name="button" value="add" id="btn-ajukan"
                                            class="btn btn-primary" <?php echo (count( $barangs)=== 0 && count( $ruangans) === 0)?'disabled':null?> >Ajukan
                                        Peminjaman
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4 mb-4">
                        <div class="card card-small">
                            <div class="card-header border-bottom">
                                <h6 style="font-size: 14px;" class="mb-0 text-uppercase">Rincian Peminjaman Fasilitas
                                    Kampus</h6>
                            </div>
                            <div class="card-body p-0">
	                            <?php echo (count( $barangs)=== 0 && count( $ruangans) === 0)
                                    ?'<h6 style="text-align: center;margin-top:20px">Kosong</h6>'
                                    :null?>
								<?php if ( count( $barangs ) > 0 ): ?>
                                    <small class="text-uppercase p-2"><b>Barang</b></small>
                                    <ul class="list-group list-group-small list-group-flush" id="container-barang">
										<?php foreach ( $barangs as $barang ): ?>
                                            <li class="list-group-item d-flex px-3">
                                                <span class="text-semibold text-fiord-blue" id="barang"
                                                      data-barang="<?php echo $barang->barang_id ?>"><?php echo $barang->nama_barang ?></span>
                                                <span class="ml-auto text-right text-semibold text-reagent-gray"
                                                      data-jumlah="<?php echo $barang->jumlah ?>"><?php echo $barang->jumlah ?> Buah</span>
                                            </li>
										<?php endforeach; ?>
                                    </ul>
								<?php endif; ?>
								<?php if ( count( $ruangans ) > 0 ): ?>
                                    <small class="text-uppercase p-2"><b>Ruangan</b></small>
                                    <ul class="list-group list-group-small list-group-flush" id="container-ruangan">
										<?php foreach ( $ruangans as $ru => $ruangan ): ?>
                                            <li class="list-group-item d-flex px-3">
                                                <span class="text-semibold text-fiord-blue" id="ruangan"
                                                      data-ruangan="<?php echo $ruangan->ruangan_id ?>"><?php echo $ru + 1 . ". " . $ruangan->nama_ruangan . " ( $ruangan->nama_prodi )" ?></span>
                                            </li>
										<?php endforeach; ?>
                                    </ul>
								<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Small Stats Blocks -->
            </div>
			<?php include './_partials/footer-user.php' ?>
        </main>
    </div>
</div>
<?php require_once './_partials/js.php' ?>
<script>
    $('#peminjaman-date-range').datepicker({
        format: 'dd-mm-yyyy',
        startDate: new Date(),
    }).on('show',function () {
        let start = $('[name="start"]');
        let end = $('[name="end"]');
        let dateRange = $('#peminjaman-date-range');
        if (start.is('.is-invalid')) {
            start.removeClass('is-invalid');
        }
        if (end.is('.is-invalid')) {
            end.removeClass('is-invalid');
        }
        dateRange.has('div#passError').length ?
            $('#passError').remove():
            null;
    });
    $(document).ready(function () {
        let barang = [];
        let ruangan = [];
        let rincianTransaksi = {};
        let rangeDate = {};
        let akun_id = $('[name="nim"]').val();

        $('#container-barang>li').map(function (e, span) {
            let elem_id = $(span.children)[0];
            let elem_jum = $(span.children)[1];
            let id = $(elem_id).data('barang');
            let jum = $(elem_jum).data('jumlah');
            barang.push({id: id, jumlah: jum});
        });
        $('#container-ruangan>li').map(function (e,span){
            let elem_id = $(span.children)[0];
            let id = $(elem_id).data('ruangan');
            ruangan.push({id:id});
        });
        $('#btn-ajukan').on('click', () => {
            let start = $('[name="start"]');
            let end = $('[name="end"]');
            let dateRange = $('#peminjaman-date-range');
            let perihal = $('[name="perihal"]').val();
            console.log(perihal);
            if (start.val() === "") {
                if (!start.is('.is-invalid')) {
                    start.addClass('is-invalid');
                }
                if (!end.is('.is-invalid')) {
                    end.addClass('is-invalid');
                }
                !dateRange.has('div#passError').length ?
                    dateRange.append('<div id="passError" class="invalid-feedback">Waktu peminjaman tidak boleh kosong.</div>') :
                    null;
                return;
            }
            rangeDate.start = start.val();
            rangeDate.end = end.val();
            rincianTransaksi.barang = {data: barang, dueDate: rangeDate, akun_id: akun_id,perihal:perihal};
            rincianTransaksi.ruangan = {data: ruangan, dueDate: rangeDate, akun_id: akun_id,perihal:perihal};

            $.ajax({
                url: './model/peminjaman.php',
                method: "POST",
                data: {
                    button: "add",
                    kind: rincianTransaksi
                },
                success: function (res) {
                    JSON.parse(res).status === 'success'?
                        window.location.href = './peminjaman-user-do.php'
                        :null
                }
            })
        })
        $('[name="start"]').on('change', function () {

        })


    })
</script>
</body>

</html>