<?php 
	session_start();
	$db = mysqli_connect("localhost", "root", "root", "Security424");//ivan
	//$db = mysqli_connect("localhost", "root", "", "424"); // Steven
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
					//session_start(); // Notice alert after login

					$delay=60; 
					header("Refresh: $delay;");
					if(isset($_SESSION["username"]))  
    				{  
			           if((time() - $_SESSION['last_login_timestamp']) > 59)  
			           {  
			                header("location:logout.php");
			                //echo "<meta http-equiv= 'refresh' content='0'>";
			           }  
			           else  
			           {  
			           		echo "<p>You will be logged out in ".$delay. "seconds.</p>";  
							$username = $_SESSION['username'];
							$sql = "SELECT loginCount FROM users WHERE username= '$username'";
							$result = $db->query($sql);
							$row = $result->fetch_assoc();
							echo "<p>You have logged in: ".$row['loginCount']." times.</p>"; 
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
				<a href="logout.php">Logout</a>
			</div>
	</body>
</html>
