<?php
	session_start();
	require "includes/db_connection.php";
?>

<!DOCTYPE html>
<html lang = "en">
<head>
	<title>Raspberry Pi Web Interface - Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!--CSS-->
	<link rel="stylesheet" href="css/style.css">
	<!--Bootstrap-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!--jQuery 3.6.0-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
	<div class = "container-fluid">
		<nav>
			<!--Home tab always displayed, whether logged in or logged out-->
			<a class='link-item' href ='index.php' style = 'background-color:#bd0d00; color: #ffffff;'>Home</a>

			<?php
				//Show register tab when session NOT set
				if(!isset($_SESSION['username'])){
					echo "<a class = 'link-item' href = 'register_screen.php'>Register</a>";
				}

				//Show login tab when session NOT set
				if(!isset($_SESSION['username'])){
					echo "<a class = 'link-item' href = 'login_screen.php'>Login</a>";
				}

				//Show LED tab when session HAS BEEN set
				if(isset($_SESSION['username'])){
					echo "<a class = 'link-item' href = 'led.php'>LED</a>";
				}
				
				//Show LINUX TERMINAL COMMANDS tab when session HAS BEEN set
				if(isset($_SESSION['username'])){
					echo "<a class = 'link-item' href = 'linux_commands.php'>Linux Terminal Commands</a>";
				}
				
				//Show logout tab when session HAS BEEN set
				if(isset($_SESSION['username'])){
					echo "<a class = 'link-item' href = 'includes/attempt_logout.php'>Logout</a>";
				}
			?>
		</nav>

		<div class="jumbotron text-center bg-danger">
			<h1>Raspberry Pi Web Interface</h1>
			<h2>CMP408 System Internals & Cybersecurity</h2>
			<h3>Patrick Welsh</h3>
		</div>

		<div class = "row">
			<div class = "col-lg-12">
				<?php
					//Show username when session HAS BEEN set
					// IE: when they have logged in
					if(isset($_SESSION['username'])){
							echo "<h3>Hello, {$_SESSION['username']}</h3><br>";
							echo "<h3>This website is hosted on an Apache2 webserver running on the Raspberry Pi.<br></h3>";
					}
					
					//Display user prompt to login or register if they haven't already done so. 
					//This displays when there is no set session
					if(!isset($_SESSION['username'])){
							echo "<h3>This website is hosted on an Apache2 webserver running on the Raspberry Pi.<br></h3>";
							echo "<h3>In order to view the site contents and interact with the Raspberry Pi, please register or login to an existing account</h3>";
					}
				?>
			</div>
		</div>	

		<footer>
			<img src = "img/RPiLogo.png" style="height:200px; width:300px;">
			<h6>Patrick Welsh | Email Me Here: <a href = "mailto: 1805531@uad.ac.uk">1805531@uad.ac.uk</h6>
		</footer>
	</div>
<body>
<html>
