<?php

if ( empty( $_SESSION['level'] ) ) {
	echo '<script>window.location.href = "user-login.php"</script>';
}
function role( $role, $invers ) {
	$level        = $_SESSION['level'];
	$level_router = $level !== $role;
	if ( $invers ) {
		$level_router = ! $level_router;
	}
	switch ( $level ) {
		case 'mahasiswa':
			echo $level_router ? '<script>window.location.href = "error.php"</script>' : null;
			break;
		case 'admin':
			echo $level_router ? '<script>window.location.href = "error.php"</script>' : null;
			break;
		case 'bmn':
			echo $level_router ? '<script>window.location.href = "error.php"</script>' : null;
			break;
		case 'kabag umum':
			echo $level_router ? '<script>window.location.href = "error.php"</script>' : null;
			break;
		default:
			echo '<script>window.location.href = "index.php"</script>';
	}
}

