<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
require_once 'database.php';
function get_count_notif($penerima,$read = 0){
	$db = new Database();
	$q = "SELECT COUNT(*) as number FROM notifikasi WHERE penerima = '$penerima' AND read_status = $read";
	$db->query($q);
return $db->fetch();
}
function get_data_notif($penerima,$read = 0){
	$db = new Database();
	$q = "SELECT pesan,link,kategori from notifikasi WHERE penerima = '$penerima' AND read_status = $read";
	$db->query($q);
	return $db->fetch();
}
function send_notif($pengirim,$penerima,$pesan,$link,$kategori){
	$db = new Database();
	$q = "INSERT INTO notifikasi(pengirim, penerima, pesan,link,kategori) VALUES ('$pengirim','$penerima','$pesan','$link','$kategori')";
	$db->query( $q );
}
function update_notif($pengirim,$penerima,$pesan){
	$db = new Database();
	$q = "UPDATE notifikasi SET read_status = 1 WHERE pengirim = '$pengirim' AND penerima = '$penerima' AND pesan = '$pesan'";
	$db->query($q);
}
?>