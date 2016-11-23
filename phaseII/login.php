<?php 
	session_start();
	// connect to database
	//$db = mysqli_connect("localhost", "root", "root", "Security424");
    $db = mysqli_connect("localhost", "root", "", "424"); // Steven

	if (isset($_POST['login_btn'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password = md5($password); // remember we hashed password before storing last time
		$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$result = mysqli_query($db, $sql);
		if (mysqli_num_rows($result) == 1) {
			$query = "UPDATE users SET loginCount=loginCount + 1 WHERE username='$username'";
			mysqli_query($db, $query);
			$_SESSION['username'] = $username;
			header("location: home.php"); //redirect to home page
		}else{
			$_SESSION['message'] = "Username/password combination incorrect";
		}
	}
?>



<!DOCTYPE html>
<html>
	<head>
		<title>Login Page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<div class="header">
			<h1>Login Page</h1>
		</div>		
	</head>
	<body>

		<div class="mainContent">
			<?php
				if (isset($_SESSION['message'])) {
					echo "<div id='error_msg'>".$_SESSION['message']."</div>";
					unset($_SESSION['message']);
				}
			?>


			<form method="post" action="login.php">
				<table>
					<tr>
						<td>Username:</td>
						<td><input type="text" name="username" class="textInput"></td>
					</tr>

					<tr>
						<td>Password:</td>
						<td><input type="password" name="password" class="textInput"></td>
					</tr>

					<tr>
						<td></td>
						<td><input type="submit" name="login_btn" value="Login"></td>
					</tr>
				</table>
			</form>

			<div class=footerContent>
				<p>Don't have an account?</p>
				<a href="register.php">Register here!</a>
			</div>
		</div>
	</body>
</html>