<?php 
	session_start();
	// connect to database
	//$db = mysqli_connect("localhost", "root", "root", "Security424");//ivan
    $db = mysqli_connect("localhost", "root", "", "424"); // Steven

	if (isset($_POST['login_btn'])) {

		$_SESSION['last_login_timestamp'] = time();
		$username = $_POST['username'];
		$password = $_POST['password'];
		
        //Check database for entered username and grab user salt, protected against SQL injection
		if($stmt = $db->prepare("SELECT password,salt FROM users WHERE username = ?")){
			$stmt->bind_param("s",$username);
			$stmt->execute();
			$stmt->bind_result($passwordDB,$salt);
			$stmt->fetch();
			$password = hash("sha512", $password . $salt); //hash password with appended salt
			$stmt->close();
		}
	
		//Check hashed entered password with password in database
		if($password === $passwordDB){
			if($stmt = $db->prepare("UPDATE users SET loginCount=loginCount + 1 WHERE username=?")){ // increase login count, protected against SQL injection
				$stmt->bind_param("s",$username);
				$stmt->execute();
				$stmt->close();
			}
			$_SESSION['username'] = $username;
			header("location: home.php"); //redirect to home page 
		}
		else{
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