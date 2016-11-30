<?php 
	session_start();
	//connect to db
	//$db = mysqli_connect("localhost", "root", "", "424"); // Steven
	$db = mysqli_connect("localhost", "root", "root", "Security424");//ivan
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Home Page</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<div class="header">
			<h1>Home Page</h1>
		</div>
	</head>
	<body>
		<div class="mainContent">
			<div>
				<h2><?php //echo htmlentities($_SESSION['username'], ENT_QUOTES | ENT_HTML5, 'UTF-8');?></h2>
				<?php	
					//session_start(); // Notice alert after login

					$delay=60; 
					header("Refresh: $delay;");
					if(isset($_SESSION["username"]))  
    				{  
			           if((time() - $_SESSION['last_login_timestamp']) > 59)  
			           {  
			           		$username = $_SESSION['username'];
			           		$date = date('Y-m-d H:i:s');
			           		$sql = "UPDATE users SET lastLogged='$date' WHERE username= '$username'";
			           		$db->query($sql);
			                header("location:logout.php");
			                //echo "<meta http-equiv= 'refresh' content='0'>";
			           }  
			           else  
			           {  
			           		$username = $_SESSION['username'];
			           		$sql = "SELECT token FROM users WHERE username= '$username'";
			           		$result = $db->query($sql);
			           		$row = $result->fetch_assoc();
			           		$loginToken = $row['token'];
			           		//$lastLogged = $row['lastLogged'];

			           		//echo "<p>Token: ".$loginToken." </p>";
			           	 	 
					        if(isset($_POST['auth_btn'])){
								$postToken = $_POST['token'];
					           	$sql = "SELECT token FROM users WHERE username= '$username'";
					           	$result = $db->query($sql);
					           	$row = $result->fetch_assoc();
					           	$loginToken = $row['token'];

					           	//$_SESSION['username'] = $username;	
								if($postToken == $loginToken){
									$sql = "UPDATE users SET token=-1 WHERE username= '$username'";
									$db->query($sql);
									header("Refresh:0");
								}

							}
					        else if(isset($_POST['passUpdate_btn'])){
								$pass = $_POST['newPassword'];

					           	$sql = "SELECT salt FROM users WHERE username= '$username'";
					           	$result = $db->query($sql);
					           	$row = $result->fetch_assoc();
					           	$salt = $row['salt'];
								$newPass = hash("sha512", $pass . $salt);
					           	$sql = "UPDATE users SET password = '$newPass' WHERE username= '$username'";
					           	$db->query($sql);
								$sql = "UPDATE users SET token=-1 WHERE username= '$username'";
								$db->query($sql);           	
					           	header("location: login.php");

							}							
			           		else if($loginToken == -2){ //registered flag
								echo "<h2>Password Reset.</h2>";
								echo "<p>Please enter a new password.</p>";
								echo "
								<form method='post' action='home.php'>
									<table>				
										<tr>
											<td>password:</td>
											<td><input type='password' name='newPassword' class='textInput'></td>
										</tr>
										<tr>
											<td></td>
											<td><input type='submit' name='passUpdate_btn' value='Update'></td>
										</tr>
									</table>
								</form>
								"; 
							}							
			           		else if($loginToken == -1){ //registered flag
								$sql = "SELECT firstName, lastName, loginCount, lastLogged FROM users WHERE username= '$username'";
								$result = $db->query($sql);
								$row = $result->fetch_assoc();

								echo "<h2>Hi ".$row['firstName']." ".$row['lastName']."!</h2>";
								echo "
									<table>
										<tr>
											<td>Username: </td>
											<td>".$username."</td>
										</tr>
										<tr>
											<td>Logged in: </td>
											<td>".$row['loginCount']." times</td>
										</tr>
										<tr>
											<td>Last Logged in: </td>
											<td>".$row['lastLogged']."</td>
										</tr>											
									</table><br>
								"; 
							}
							else {
								$_SESSION['username'] = $username;
								echo "<h2><font color='red'>You are not have not been authenticated.<font></h2><br>";
								echo "<p>Check your email for an authentication token.</p>";
								echo "
								<form method='post' action='home.php'>
									<table>				
										<tr>
											<td>Token:</td>
											<td><input type='password' name='token' class='textInput'></td>
										</tr>
										<tr>
											<td></td>
											<td><input type='submit' name='auth_btn' value='authenticate'></td>
										</tr>
									</table>
								</form>
								";
							}
           				}  
     				}  
			      	else  
			      	{  
			        	header('location:login.php');  
			      	}

					//echo "<p>You have logged in: times.".$testing."</p>";
				?>
			</div>
			<div>
				<?php
			      	echo "<p><font color='red'>You will be logged out in ".$delay. " seconds.</font></p>";
				?>
				<a href="logout.php">Logout</a>
			</div>
	</body>
</html>
