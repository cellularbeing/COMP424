<?php 
	session_start();
	// connect to database
	$db = mysqli_connect("localhost", "root", "root", "Security424");

	if (isset($_POST['register_btn'])) {
		session_start();
		$username = $_POST['username'];
		$email = $_POST['email'];
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$loginCount = 1;

		if ($password == $password2) {
			// create user
			$password = md5($password); //hash password before storing for security purposes
			$sql = "INSERT INTO users(username, email, password, loginCount, lastName, firstName) VALUES('$username', '$email', '$password', '$loginCount', '$lastName', '$firstName')";
			mysqli_query($db, $sql);
			$_SESSION['message'] = "You are now logged in";
			$_SESSION['username'] = $username;
			header("location: home.php"); //redirect to home page
		}else{
			$_SESSION['message'] = "The two passwords do not match";
		}
	}
?>



<!DOCTYPE html>
<html>
	<head>
		<title>Registration Page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<div class="header">
			<h1>Registration Page</h1>
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

		<form method="post" action="register.php">
			<table>
				<tr>
					<td>First Name:</td>
					<td><input type="text" name="firstName" class="textInput"></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td><input type="text" name="lastName" class="textInput"></td>
				</tr>				
				<tr>
					<td>Email:</td>
					<td><input type="email" name="email" class="textInput"></td>
				</tr>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" class="textInput"></td>
				</tr>				
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" class="textInput"></td>
				</tr>
				<tr>
					<td>Please Retype Password:</td>
					<td><input type="password" name="password2" class="textInput"></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="register_btn" value="Register"></td>
				</tr>
			</table>
		</form>
		<div class=footerContent>
			<p>Already an account?</p>
			<a href="login.php">Login here!</a>
		</div>
	</div>
	</body>
</html>