<?php
if ( isset( $_SESSION['status'] ) ) {
	$state = $_SESSION['status'];
	if ( $state->status == 'success' ) {
		echo "<div class='alert alert-success'>$state->message</div>";
	}
	if ( $state->status == 'fail' ) {
		echo "<div class='alert alert-danger'>$state->message</div>";
	}
}
unset($_SESSION['status']);

