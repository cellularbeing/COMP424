<?php 
	session_start();
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
				<h2>Hello <?php echo $_SESSION['username'];?></h2>
				<h4>Total Log in count:</h4>
				<p>In progress(see the db)</p>
			</div>
			<div>
				<a href="logout.php">Logout</a>
			</div>
		</div>
	</body>
</html>
