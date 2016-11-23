<?php 
	session_start();

	$db = mysqli_connect("localhost", "root", "root", "Security424");
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
				<h2>Hi <?php echo $_SESSION['username'];?></h2>
				<?php	
					$username = $_SESSION['username'];
					$sql = "SELECT loginCount FROM users WHERE username= '$username'";
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					echo "<p>You have logged in: times.".$row['loginCount']."</p>";

					//echo "<p>You have logged in: times.".$testing."</p>";
				?>
			</div>
			<div>
				<a href="logout.php">Logout</a>
			</div>
		</div>
	</body>
</html>
