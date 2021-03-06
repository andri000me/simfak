<?php
if ( session_status() == PHP_SESSION_NONE ) {
	session_start();
}
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );
require_once 'database.php';

//register only for mahasiswa
function register( $post ) {
	$database = new Database();
	$uname    = $post['nim'];
	$pass     = $post['password'];
	if ( checkAccount( $uname ) ) {
		$_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Anda sudah terdaftar' ];
	} else {
		$query = "INSERT INTO akun(username,password,level_id) values ('$uname','$pass',2)";
		if ( $database->query( $query ) ) {
			$query = "INSERT INTO `mahasiswa` (`nim`, `nama_mahasiswa`, `email_mahasiswa`) VALUES ('$post[nim]', '$post[nama]', NULL)";
			if($database->query($query)){
				$database->close();
				$_SESSION['status'] = (object) [ 'status' => 'success', 'message' => 'Anda berhasil registrasi' ];
			}
		}
	}

	header( "Location: ../user-register.php" );
}

//add user ony for admin
function addUser( $post ) {
	$database = new Database();
	$uname    = $post['username'];
	$pass     = $post['password'];
	$level    = $post['level'];
	if ( checkAccount( $uname, $level ) ) {
		$_SESSION['status'] = (object) [ 'status'  => 'fail',
		                                 'message' => 'Akun gagal di ditambahkan, user sudah ada.'
		];
	} else {
		$query = "INSERT INTO akun(username,password,level_id) values ('$uname','$pass',$level)";
		if ( $database->query( $query ) ) {
			$database->close();
			$_SESSION['status'] = (object) [ 'status' => 'success', 'message' => 'Akun berhasil di ditambahkan' ];
		} else {
			$_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Akun gagal di ditambahkan' ];
		}
	}
	header( "Location: ../user-management.php" );
}

function editUser( $post ) {
	$database = new Database();
	$uname    = $post['username'];
	$pass     = $post['password'];
	$id       = $post['id'];
	$q        = "UPDATE akun SET username = '$uname', password = '$pass' where id = $id";
	if ( $database->query( $q ) ) {
		$_SESSION['status'] = (object) [ 'status' => 'success', 'message' => 'Akun berhasil di update' ];
		header( "Location:../user-management.php" );
	}
}

function deleteUser( $id ) {
	$database = new Database();
	$q        = "DELETE FROM akun WHERE id = $id";
	if ( $database->query( $q ) ) {
		$_SESSION['status'] = (object) [ 'status' => 'success', 'message' => 'Akun berhasil di hapus' ];
		header( "Location:../user-management.php" );
	}
}

function login( $post ) {
	$database = new Database();
	$uname    = $post['nim'];
	$pass     = $post['pass'];
	$query    = "SELECT akun.id,akun.username,nama_level 
					FROM akun 
					LEFT OUTER JOIN level ON akun.level_id = level.id 
					WHERE akun.username = '$uname' AND password = '$pass'";
	if ( $database->query( $query ) ) {
		$results = $database->fetch();
		if ( count( $results ) > 0 ) {

			$_SESSION['id']    = $results[0]->id;
			$_SESSION['nim']   = $results[0]->username;;
			$_SESSION['level'] = $results[0]->nama_level;
			$_SESSION['login'] = true;

			$db = new Database();
			if ( $results[0]->nama_level != 'mahasiswa' ) {
				$q  = "SELECT nama_pegawai FROM pegawai WHERE pegawai.nik = '$uname'";
				$db->query( $q );
				$results = $db->fetch();
				$_SESSION['name'] = $results[0]->nama_pegawai;
			}
			else{
				$q  = "SELECT nama_mahasiswa FROM mahasiswa WHERE mahasiswa.nim = '$uname'";
				$db->query( $q );
				$results = $db->fetch();
				$_SESSION['name'] = $results[0]->nama_mahasiswa;
			}

			if ( $_SESSION['level'] != 'mahasiswa' ) {
				header( "Location: ../index.php" );
			} else {
				header( 'Location: ../peminjaman-user-list.php?kind=ruangan' );
			}

		} else {
			$_SESSION['status'] = (object) [ 'status' => 'fail', 'message' => 'Login gagal' ];
			header( "Location: ../user-login.php" );
		}
	}
}

function logout() {
	session_destroy();
	header( "Location: ../user-login.php" );
}

function checkAccount( $username, $level_id = null ) {
	$isExist  = false;
	$database = new Database();
	$query    = "SELECT * FROM akun WHERE username = '$username'";
	if ( $level_id != null ) {
		$query .= " AND level_id = $level_id";
	}
	if ( $database->query( $query ) ) {
		$results = $database->fetch();
		if ( count( $results ) > 0 ) {
			$isExist = true;
		}
	}

	return $isExist;
}

function showAccounts( $id = null, $join = null, $select = '*' ) {
	$db = new Database();
	$q  = "SELECT $select FROM akun";
	if ( $join != null ) {
		$q .= " LEFT OUTER JOIN $join[0] ON $join[1]";
	}
	if ( $id != null ) {
		$q .= " WHERE akun.id = '$id'";
	}
	$akuns = [];
	if ( $db->query( $q ) ) {
		$akuns = $db->fetch();
	}

	return $akuns;
}

if ( isset( $_GET['f'] ) ) {
	$get = $_GET;
	switch ( $get['f'] ) {
		case 'logout':
			logout();
			break;
		case 'delete':
			deleteUser( $get['id'] );
			break;
		default:
			return;
	}
}
if ( isset( $_POST['button'] ) ) {
	$post = $_POST;
	switch ( $post['button'] ) {
		case 'register':
			register( $post );
			break;
		case 'login':
			login( $post );
			break;
		case 'edit':
			editUser( $post );
			break;
		case 'add':
			addUser( $post );
			break;
		default:
			break;
	}
}