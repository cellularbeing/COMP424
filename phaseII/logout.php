<?php
	//$db = mysqli_connect("localhost", "root", "", "424"); // Steven
	$db = mysqli_connect("localhost", "root", "root", "Security424");//ivan
	session_start();
	$username = $_SESSION['username'];
	$date = date('Y-m-d H:i:s');
	$sql = "UPDATE users SET lastLogged='$date' WHERE username= '$username'";
	$db->query($sql);	
	session_destroy();
	unset($_SESSION['username']);
	$_SESSION['message'] = "You are now logged out";
	header("location: login.php");
?>