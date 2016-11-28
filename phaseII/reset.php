<?php 
	session_start();
	// connect to database
	$db = mysqli_connect("localhost", "root", "root", "Security424");//ivan
	//$db = mysqli_connect("localhost", "root", "", "424"); // Steven

	if (isset($_POST['reset_btn'])) {
		
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