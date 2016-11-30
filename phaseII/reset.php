<?php 
	session_start();
	require 'theMailer.php';
	// connect to database
	$db = mysqli_connect("localhost", "root", "P@_427!,K-^c612", "Security424");//login

	if (isset($_POST['reset_btn'])) {
		$email = $_POST['email'];
		$sql = "SELECT username, token, salt FROM users WHERE email= '$email'";
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$username = $row['username'];
		$salt = $row['salt'];
		$token = $row['token'];
		$passwordReset = substr(md5(uniqid(rand(),true)),0,8);
		$password = hash("sha512", $passwordReset . $salt);
		$sql = "UPDATE users SET password='$password' WHERE username= '$username'";
		$db->query($sql);
		$sql = "UPDATE users SET token=-2 WHERE username= '$username'";
		$db->query($sql);
		$subject = "COMP424 Password Reset";
		$body= "Hello ".$username.",\r\nPlease use this as your temporary password: ".$passwordReset." to log in.";
		sendMail($email, $subject, $body);
		header("location: login.php");
	}	
?>

<!DOCTYPE html>
<html>
	<head>
		<title>User Reset Page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<div class="header">
			<h1>Reset Page</h1>
		</div>	
	</head>
<body>
		<?php
			if ($error) {
				echo "<div id='error_msg'>".$_SESSION['message']."</div>";
				unset($_SESSION['message']);
			}
		?>
	<div class="mainContent">
		<form method="post" action="reset.php">
			<table>				
				<tr>
					<td>Email:</td>
					<td><input type="email" name="email" class="textInput"></td>
				</tr>				
				<tr>
					<td></td>
					<td><input type="submit" name="reset_btn" value="reset"></td>
				</tr>
			</table>
		</form>
		<div class=footerContent>
			<p>Login Page</p>
			<a href="login.php">Login here!</a>
		</div>
	</div>
	</body>
</html>