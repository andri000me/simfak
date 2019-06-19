<?php
//TODO:Tambahkan redirect untuk handling tidak login
//session_start();
require_once 'database.php';
function showBarang( $id = null ) {
	$db    = new Database();
	$query = 'SELECT * FROM barang';
	if ( $id != null ) {
		$query .= " WHERE id = $id";
	}
	if($db->query( $query )){
		return $db->fetch();
	}
}

function add( $post ) {
	$db     = new Database();
	$nama   = $post['nama'];
	$jumlah = $post['jumlah'];
	$waktu  = 'NOW()';
	$q      = "INSERT INTO barang(nama_barang, jumlah, waktu_penambahan) VALUES ('$nama','$jumlah',$waktu)";
	if($db->query( $q)){
		$db->close();
		$_SESSION['status'] = (object) [ 'status' => 'success', 'message' => 'Barang berhasil ditambahkan' ];
	}
	else $_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Barang gagal ditambahkan' ];
	header( "Location: ../barang-list.php" );

}
function edit($post){
	$db = new Database();
	$id = $post['id'];
	$nama = $post['nama'];
	$jumlah = $post['jumlah'];
	$waktu = 'NOW()';
	$q = "UPDATE barang SET nama_barang = '$nama',jumlah = '$jumlah',waktu_penambahan = $waktu WHERE id = $id";
	if($db->query( $q)){
		$db->close();
		$_SESSION['status'] = (object) ['status'=>'success','message'=>'Barang berhasil diedit'];
	}
	else $_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Barang gagal diedit' ];
	header( "Location: ../barang-list.php" );
}
function delete($id){
	$db = new Database();
	$q = "DELETE FROM barang WHERE id = $id";
	if($db->query( $q)){
		$db->close();
		$_SESSION['status'] = (object) ['status'=>'success','message'=>'Barang berhasil diedit'];
	}
	else $_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Barang gagal diedit' ];
	header( "Location: ../barang-list.php" );

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

?>