<?php 
	session_start();
	require 'theMailer.php';
	// connect to database
	$db = mysqli_connect("localhost", "root", "root", "Security424");//ivan
    //$db = mysqli_connect("localhost", "root", "", "424"); // Steven
	$error = false;
	

	if (isset($_POST['register_btn'])) {

		if($_POST['g-recaptcha-response']){ 
			//session_start(); // Notice alert
			$username = $_POST['username'];
			$email = $_POST['email'];
			$firstName = $_POST['firstName'];
			$lastName = $_POST['lastName'];
			$password = $_POST['password'];
			$password2 = $_POST['password2'];
			$loginCount = 0;
			$_SESSION['message'] = "Error:";
	        $captcha=$_POST['g-recaptcha-response'];
			$salt = substr(md5(uniqid(rand(),true)),0,12); // Create random salt
			$token = substr(md5(uniqid(rand(),true)),0,8);

	        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LeNugwUAAAAAIpFDAFi9d53x2nEs3IHP-BexsbS&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
			
			//Check if username already exists in DB
			if($stmt = $db->prepare("SELECT username FROM users WHERE username = ?")){ 
				$stmt->bind_param('s',$username);
				$stmt->execute();
				$stmt->store_result();
				$rows = $stmt->num_rows();
				$stmt->close();
			}
			
			if($rows > 0){ 
				$error = true;
				$_SESSION['message'] = $_SESSION['message'] . "<br>" . "Username already exists";
			}
			
			if($email === ""){ 
				$error = true;
				$_SESSION['message'] = $_SESSION['message'] . "<br>" . "Email required";
			}
			
			// check if password matches
			if ($password === $password2) {	
			}else{
				$error = true;
				$_SESSION['message'] = $_SESSION['message'] . "<br>" . "The two passwords do not match";
			}
			
			//create user
			if(!$error && $response.success){
				$password = hash("sha512", $password . $salt);
				if($stmt = $db->prepare("INSERT INTO users(username, email, password, salt, loginCount, lastName, firstName, token) VALUES(?, ?, ?, ?, ?, ?, ?, ?)")){ 
					$stmt->bind_param('ssssisss', $username, $email, $password, $salt, $loginCount, $lastName, $firstName, $token);
					$stmt->execute();
					$stmt->close();
				}
				$subject = "COMP424 Authentication Token";
				$body= "Please use this token: ".$token." in the authentication page to complete registration.";
				sendMail($email, $subject, $body);
				$_SESSION['message'] = "You are now logged in";
				$_SESSION['username'] = $username;
				header("location: home.php"); //redirect to home page
			}
		}
		else{
			$error = true;
			$_SESSION['message'] = "missing captca :'(";
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
		<script src='https://www.google.com/recaptcha/api.js'></script>	
	</head>
<body>
		<?php
			if ($error) {
				echo "<div id='error_msg'>".$_SESSION['message']."</div>";
				unset($_SESSION['message']);
			}
		?>
	<div class="mainContent">
	
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
			<div class="g-recaptcha" data-sitekey="6LeNugwUAAAAAEUZIiKESYpHzq18PP8tsotd5hzm"></div>
		</form>
		<div class=footerContent>
			<p>Already an account?</p>
			<a href="login.php">Login here!</a>
		</div>
	</div>
	</body>
</html>