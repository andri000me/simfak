<?php
session_start();
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
require_once 'database.php';

function add( $post ) {

	$db       = new Database();
	$barangs  = $post['kind']['barang'];
	$ruangans = $post['kind']['ruangan'];

	//insert barang
	if ( isset( $barangs['data'] ) ) {
		foreach ( $barangs['data'] as $key => $barang ) {
			$barang_id         = $barang['id'];
			$jumlah            = $barangs['data'][ $key ]['jumlah'];
			$akun_id           = $barangs['akun_id'];
			$perihal           = $barangs['perihal'];
			$tanggal_transaksi = $barangs['dueDate']['start'];
			$tanggal_kembali   = $barangs['dueDate']['end'];
			$q                 = "INSERT INTO peminjaman_barang(barang_id, jumlah, akun_id,perihal,tanggal_transaksi,tanggal_kembali) VALUES ('$barang_id','$jumlah','$akun_id','$perihal',STR_TO_DATE('$tanggal_transaksi','%d-%m-%Y'),STR_TO_DATE('$tanggal_kembali','%d-%m-%Y'))";
			$db->query( $q );
		}
		//delete cart_barang
		$q = "DELETE FROM cart_barang WHERE akun_id = '$barangs[akun_id]'";
		$db->query( $q );
	}

	//insert ruangan
	if ( isset( $ruangans['data'] ) ) {
		foreach ( $ruangans['data'] as $key => $ruangan ) {
			$ruangan_id        = $ruangan['id'];
			$akun_id           = $ruangans['akun_id'];
			$perihal           = $ruangans['perihal'];
			$tanggal_transaksi = $ruangans['dueDate']['start'];
			$tanggal_kembali   = $ruangans['dueDate']['end'];
			$q                 = "INSERT INTO peminjaman_ruangan(ruangan_id, akun_id,perihal,tanggal_transaksi,tanggal_kembali) VALUES ('$ruangan_id','$akun_id','$perihal',STR_TO_DATE('$tanggal_transaksi','%d-%m-%Y'),STR_TO_DATE('$tanggal_kembali','%d-%m-%Y'))";
			$db->query( $q );
		}
		//delete cart_ruangan
		$q = "DELETE FROM cart_ruangan WHERE akun_id = '$ruangans[akun_id]'";
		$db->query( $q );
	}

	//set success
	$q = "INSERT INTO notifikasi(pengirim, penerima, pesan,link,kategori) VALUES ('$_SESSION[nim]','bmn','$_SESSION[name] mengajukan peminjaman fasilitas kampus.','../peminjaman-list.php','permohonan')";
	$db->query( $q );
	$_SESSION['status'] = (object) [ 'status' => 'success', 'message' => 'Pengajuan sedang diproses' ];
	echo json_encode( array( 'status' => 'success' ) );
}

function get_all_peminjaman() {
	$db = new Database();
	$db->query( "SELECT DISTINCT tanggal_transaksi,tanggal_kembali,status,perihal,m.nama_mahasiswa,pr.akun_id FROM peminjaman_ruangan pr LEFT OUTER JOIN mahasiswa m ON pr.akun_id = m.nim" );
	$listPBarang = $db->fetch();
	$db->query( "SELECT DISTINCT tanggal_transaksi,tanggal_kembali,status,perihal,m.nama_mahasiswa,pb.akun_id FROM peminjaman_barang pb LEFT OUTER JOIN mahasiswa m ON pb.akun_id = m.nim" );
	$listPRuangan = $db->fetch();

	$mergedArr = array_merge( $listPRuangan, $listPBarang );

	$mergedArr = array_map( 'json_encode', $mergedArr );
	$mergedArr = array_unique( $mergedArr );

	return $mergedPengajuan = array_map( 'json_decode', $mergedArr );
}

function show_peminjaman($perihal, $type ,$akun_id) {
	$db = new Database();
	$q = "";
	if ( $type == 'barang' ) {
		$q = "SELECT b.nama_barang,pb.tanggal_transaksi,pb.jumlah,pb.perihal 
                    FROM peminjaman_barang pb
                    LEFT OUTER JOIN barang b ON pb.barang_id = b.id 
                    WHERE pb.akun_id = '$akun_id' AND pb.perihal = '$perihal'";
	}
	if ( $type == 'ruangan' ) {
		$q = "SELECT r.nama_ruangan,pr.tanggal_transaksi,pr.perihal,p.nama_prodi
                    FROM peminjaman_ruangan pr 
                    LEFT OUTER JOIN ruangan r ON pr.ruangan_id = r.id
                    LEFT OUTER JOIN prodi p ON r.prodi_id = p.id
                    WHERE pr.akun_id = '$akun_id' AND pr.perihal = '$perihal'";
	}
	$db->query($q);
	return $db->fetch();
}

if ( isset( $_GET['f'] ) ) {
	$get = $_GET;
	switch ( $get['f'] ) {
		case 'delete':
			delete( $get['id'] );
			break;
		default:
			return;
	}
}
if ( isset( $_POST['button'] ) ) {
	$post = $_POST;
	switch ( $post['button'] ) {
		case 'edit':
			edit( $post );
			break;
		case 'add':
			add( $post );
			break;
		default:
			break;
	}
}
