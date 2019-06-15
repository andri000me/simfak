<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
require_once 'database.php';
function get_count_notif($penerima){
	$db = new Database();
	$q = "SELECT COUNT(*) as number FROM notifikasi WHERE penerima = '$penerima'";
	$db->query($q);
return $db->fetch();
}
function get_data_notif($penerima){
	$db = new Database();
	$q = "SELECT pesan,link,kategori from notifikasi WHERE penerima = '$penerima'";
	$db->query($q);
	return $db->fetch();
}
?>