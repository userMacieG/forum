<?php
	$database = mysqli_connect("localhost", "root", "", "forum") or die("[".mysqli_connect_errno()."] ".mysqli_connect_error());
	mysqli_set_charset($database, 'utf8');
?>
