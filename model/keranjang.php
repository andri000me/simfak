<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
//session_start();

require_once 'database.php';

function add( $post ) {
	$db = new Database();
	switch ( $post['kind'] ) {
		case 'ruangan':
			$user_id = $post['user_id'];
			$ruangan_id = $post['item_id'];
			$q = "INSERT INTO cart_ruangan(ruangan_id,akun_id) VALUES ($ruangan_id,'$user_id')";
			if($db->query( $q )){
				$db->close();
				$_SESSION['status'] = (object) ['status'=>'success','message'=>'Ruangan berhasil ditambahkan'];
			}
			else $_SESSION['status'] = (object) ['status'=>'fail','message'=>'Ruangan gagal ditambahkan'];
			header( 'Location: ../peminjaman-user-list.php?kind=ruangan');
			break;
		case 'barang':
			$user_id = $post['user_id'];
			$barang_id = $post['item_id'];
			$jumlah = $post['jumlah'];
			$q = "INSERT INTO cart_barang(barang_id, akun_id,jumlah) VALUES ($barang_id,'$user_id',$jumlah)";
			if($db->query( $q )){
				$db->close();
				$_SESSION['status'] = (object) ['status'=>'success','message'=>'Barang berhasil ditambahkan'];
			}
			else $_SESSION['status'] = (object) ['status'=>'fail','message'=>'Barang gagal ditambahkan'];
			header( 'Location: ../peminjaman-user-list.php?kind=barang');
			break;
		default:
			return;
	}
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
