<?php
session_start();
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
require_once 'database.php';

function add( $post ) {

	$db = new Database();
	$barangs = $post['kind']['barang'];
	$ruangans = $post['kind']['ruangan'];

	//insert barang
	if(isset($barangs['data'])){
		foreach ($barangs['data'] as $key=> $barang){
			$barang_id = $barang['id'];
			$jumlah = $barangs[ 'data' ][ $key ][ 'jumlah' ];
			$akun_id = $barangs['akun_id'];
			$perihal = $barangs['perihal'];
			$tanggal_transaksi = $barangs['dueDate']['start'];
			$tanggal_kembali = $barangs['dueDate']['end'];
			$q = "INSERT INTO peminjaman_barang(barang_id, jumlah, akun_id,perihal,tanggal_transaksi,tanggal_kembali) VALUES ('$barang_id','$jumlah','$akun_id','$perihal',STR_TO_DATE('$tanggal_transaksi','%d-%m-%Y'),STR_TO_DATE('$tanggal_kembali','%d-%m-%Y'))";
			$db->query($q);
		}
		//delete cart_barang
		$q = "DELETE FROM cart_barang WHERE akun_id = '$barangs[akun_id]'";
		$db->query( $q);
	}

	//insert ruangan
	if(isset($ruangans['data'])){
		foreach ($ruangans['data'] as $key=> $ruangan){
			$ruangan_id = $ruangan['id'];
			$akun_id = $ruangans['akun_id'];
			$perihal = $ruangans['perihal'];
			$tanggal_transaksi = $ruangans['dueDate']['start'];
			$tanggal_kembali = $ruangans['dueDate']['end'];
			$q = "INSERT INTO peminjaman_ruangan(ruangan_id, akun_id,perihal,tanggal_transaksi,tanggal_kembali) VALUES ('$ruangan_id','$akun_id','$perihal',STR_TO_DATE('$tanggal_transaksi','%d-%m-%Y'),STR_TO_DATE('$tanggal_kembali','%d-%m-%Y'))";
			$db->query($q);
		}
		//delete cart_ruangan
		$q = "DELETE FROM cart_ruangan WHERE akun_id = '$ruangans[akun_id]'";
		$db->query( $q);
	}

	//set success
	$_SESSION['status'] = (object)['status'=>'success','message'=>'Pengajuan sedang diproses'];
	echo json_encode( array('status'=>'success'));
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
