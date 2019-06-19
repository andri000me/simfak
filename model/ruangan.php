<?php
//session_start();
require_once 'database.php';
function showRuangan($id = null){
	$db = new Database();
	$q = 'SELECT * FROM ruangan';
	if($id!= null){
		$q .= " WHERE id = $id";
	}
	$db->query( $q);
	return $db->fetch();
}
function showRuanganWithJoin($id = null){
	$db = new Database();
	$q = 'SELECT ruangan.id,ruangan.nama_ruangan,ruangan.status,prodi.nama_prodi FROM ruangan LEFT OUTER JOIN prodi ON ruangan.prodi_id = prodi.id';
	if($id!= null){
		$q .= " WHERE id = $id";
	}
	$db->query( $q);
	return $db->fetch();
}
function add( $post ) {
	$db     = new Database();
	$nama   = $post['nama'];
	$prodi_id = $post['prodi'];
	$q      = "INSERT INTO ruangan(nama_ruangan, prodi_id) VALUES ('$nama','$prodi_id')";
	if($db->query( $q)){
		$db->close();
		$_SESSION['status'] = (object) [ 'status' => 'success', 'message' => 'Ruangan berhasil ditambahkan' ];
	}
	else $_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Ruangan gagal ditambahkan' ];
	header( "Location: ../ruangan-list.php" );
}
function edit($post){
	$db = new Database();
	$id = $post['id'];
	$nama = $post['nama'];
	$prodi_id= $post['prodi'];
	$q = "UPDATE ruangan SET nama_ruangan = '$nama',prodi_id = '$prodi_id'WHERE id = $id";
	if($db->query( $q)){
		$db->close();
		$_SESSION['status'] = (object) ['status'=>'success','message'=>'Ruangan berhasil diedit'];
	}
	else $_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Ruangan gagal diedit' ];
	header( "Location: ../ruangan-list.php" );

}
function delete($id){
	$db = new Database();
	$q = "DELETE FROM ruangan WHERE id = $id";
	if($db->query( $q)){
		$db->close();
		$_SESSION['status'] = (object) ['status'=>'success','message'=>'Ruangan berhasil dihapus'];
	}
	else $_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Ruangan gagal dihapus' ];
	header( "Location: ../ruangan-list.php" );

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