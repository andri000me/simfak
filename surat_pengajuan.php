<?php $post = $_POST;
require_once './model/getdata.php';
require_once './model/peminjaman.php';
$barangs  = show_peminjaman( $post['perihal'], 'barang', $post['nim'] );
$ruangans = show_peminjaman( $post['perihal'], 'ruangan', $post['nim'] );
$pemohon  = get_data( "SELECT nama_mahasiswa FROM mahasiswa WHERE nim = '$post[nim]'" );

header( "Content-Type: application/vnd.msword" );

$tanggal = date( 'd-m-Y' );
header( "Expires: 0" );
header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
header( "content-disposition: attachment;filename=Surat Pengajuan Magang " . $tanggal . ".doc" )
?>
<html
        xmlns:o='urn:schemas-microsoft-com:office:office'
        xmlns:w='urn:schemas-microsoft-com:office:word'
        xmlns='http://www.w3.org/TR/REC-html40'
>
<head>
    <meta charset="utf-8">
    <title>Surat Pengajuan Magang</title>
    <title>Generate a document Word</title>
    <!--[if gte mso 9]-->
    <xml>
        <w:WordDocument>
            <w:View>Print</w:View>
            <w:Zoom>90</w:Zoom>
            <w:DoNotOptimizeForBrowser/>
        </w:WordDocument>
    </xml>
    <!-- [endif]-->
    <style type="text/css">

        @page {
            margin: 0;
        }

        body {
            font-family: "Bookman Old Style", serif;
            font-size: 12pt;
            font-style: normal;
            font-variant: normal;
            font-weight: 400;
            margin: 0;
        }

        p#to {
            text-align: left;
            margin: 0;
        }

        @page Section1 {
            size: 21cm 29.7cm;
            margin: 1cm 2cm 2cm 2cm;
            mso-page-orientation: portrait;
            mso-footer: f1;
        }

        div.Section1 {
            page: Section1;
        }
    </style>
</head>
<body>
<div class="Section1">
<!--    <img src="images/header2.png" width="100%" height="100%">-->
    <hr style="color: #000; border: solid black 4px;height: 4px;">
    <table>
        <tr>
            <td><p style="text-align: left;">Nomor</p></td>
            <td>:</td>
            <td><p>B/<?php echo 'urut' ?>/PL40/PK.01.06/<?php echo date( "Y" ); ?></p></td>
            <td><p style="text-align: right;"><?php echo date( 'd-M-Y' ) ?></p></td>
        </tr>
        <tr>
            <td>
                <p style="text-align: left;">Hal</p>
            </td>
            <td>:</td>
            <td colspan="2">Permohonan Pengajuan Fasilitas Kampus</td>
        </tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td colspan="4"><br><br>
                <p id="to">Kepada Yth.</p></td>
        </tr>
        <tr>
            <td colspan="4"><p id="to">Ketua Bagian Umum bla bla bla</p></td>
        </tr>
        <tr>
            <td colspan="4"><p id="to">Di- Tempat</p></td>
        </tr>
        <tr>
            <td colspan="4">
                <br>

                <p style="text-align: justify; font-size: 12pt;line-height: 150%;">Dalam
                    rangka <?php echo $post['perihal'] ?> kami
                    memohon untuk meminjam fasilitas kampus dengan rincian dibawah ini:</p>
            </td>
        </tr>
        <br>

    </table>
    <br>
	<?php if ( count( $barangs ) > 0 ): ?>
        <br>
        <table width="80%" align="center" style="border: 1px solid black; border-collapse: collapse;">
            <thead>
            <tr>
                <td width="5%" style="border: 1px solid black; text-align: center;">No</td>
                <td width="45%" style="border: 1px solid black; text-align: center;">Nama Barang</td>
                <td width="25%" style="border: 1px solid black; text-align: center;">Jumlah</td>
                <td width="25%" style="border: 1px solid black; text-align: center;">Kategori</td>
            </tr>
            </thead>
            <tbody>
			<?php
			foreach ( $barangs as $i => $barang ): ?>
                <tr>
                    <td style="border: 1px solid black;"><p style="text-align: center;"><?php echo $i + 1 ?></p>
                    </td>
                    <td style="border: 1px solid black;"><p style="text-align: left;">
                            &nbsp;<?php echo $barang->nama_barang ?></p></td>
                    <td style="border: 1px solid black;"><p
                                style="text-align: center;"><?php echo $barang->jumlah ?></p>
                    </td>
                    <td><p style="text-align: center;">Barang</p></td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>
	<?php endif; ?>
	<?php if ( count( $ruangans ) > 0 ): ?>

        <br>
        <table width="80%" align="center" style="border: 1px solid black; border-collapse: collapse;">
            <thead>
            <tr>
                <td width="5%" style="border: 1px solid black; text-align: center;">No</td>
                <td width="45%" style="border: 1px solid black; text-align: center;">Nama Ruangan</td>
                <td width="25%" style="border: 1px solid black; text-align: center;">Tempat</td>
                <td width="25%" style="border: 1px solid black; text-align: center;">Kategori</td>
            </tr>
            </thead>
            <tbody>
			<?php
			foreach ( $ruangans as $i => $ruangan ): ?>
                <tr>
                    <td style="border: 1px solid black;"><p style="text-align: center;"><?php echo $i + 1 ?></p>
                    </td>
                    <td style="border: 1px solid black;"><p style="text-align: left;">
                            &nbsp;<?php echo $ruangan->nama_ruangan ?></p></td>
                    <td style="border: 1px solid black;"><p
                                style="text-align: center;"><?php echo $ruangan->nama_prodi ?></p>
                    </td>
                    <td><p style="text-align: center;">Ruangan</p></td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>
	<?php endif; ?>
    <br>
    <p style="text-align: justify; font-size: 12pt;line-height: 150%;">Demikian permohonan ini disampaikan, atas
        perhatian dan perkenannya
        diucapkan terima kasih.</p>
    <br>
    <br>
    <div style="align-items:flex-end;">
        <table style="font-size: 12pt;" width="40%" align="right">
            <tbody>
            <tr>
                <td>
                    Pelaihari, <?php echo date( "d-M-Y" ); ?>
                </td>
            </tr>
            <tr>

                <td>
                    <br><br><br><br><br>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="margin:0"><?php echo $pemohon[0]->nama_mahasiswa ?></p>
                    <p style="margin:0">NIM <?php echo $post['nim'] ?></p>
                    </br>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>