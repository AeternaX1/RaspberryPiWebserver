<?php
	require "includes/db_connection.php";
	session_start();

	// This stops users jumping to page URL's without being logged in first
	// An unregistered user should NOT be able to see this page's contents
	// If a user does end up on this page without being logged on, they will be prompted to do so and then redirected to index.php
	if(!isset($_SESSION['username'])) {
		header('refresh:1;url=/mini_project/index.php');
		die("Uh-oh! You cannot view these pages without registering or logging in first. This page will redirect.");
	}
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
			<a class='link-item' href ='index.php'>Home</a>

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
					echo "<a class = 'link-item' href = 'led.php' style = 'background-color:#bd0d00; color: #ffffff;'>LED</a>";
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
					//Display username below Jumbotron when session HAS BEEN set
					// IE: when they have logged in
					if(isset($_SESSION['username'])){
						echo "<h3>Hello, {$_SESSION['username']}</h3>";
						echo "<h3>This website is hosted on an Apache2 webserver running on the Raspberry Pi.<br></h3>";
					}
				?>
			</div>
		</div>
		
		<!--GPIO LED CONTROLS-->
		<div class = "row">
			<!-- TURN ON/OFF RED LED -->
			<div class = "col-lg-4">
				<h3>Turn Red LED On</h3>

				<form action "index.php" method = "GET">
					<input class = "btn btn-danger" type = "submit" value = "Switch On" name = "red_on">
					<input class = "btn btn-danger" type = "submit" value = "Switch Off" name = "red_off">
				</form>

				<?php
					shell_exec("gpio -g mode 23 out");

					if(isset($_GET["red_off"])){
						shell_exec("gpio -g write 23 0");
					}

					else if(isset($_GET["red_on"])){
						shell_exec("gpio -g write 23 1");
					}
				?>
			</div>
			
			<!-- TURN ON/OFF BLUE LED -->
			<div class = "col-lg-4">
				<h3>Turn Blue LED On</h3>

				<form action "index.php" method = "GET">
					<input class = "btn btn-primary" type = "submit" value = "Switch On" name = "blue_on">
					<input class = "btn btn-primary" type = "submit" value = "Switch Off" name = "blue_off">
				</form>

				<?php
					shell_exec("gpio -g mode 20 out");

					if(isset($_GET["blue_off"])){
						shell_exec("gpio -g write 20 0");
					}

					else if(isset($_GET["blue_on"])){
						shell_exec("gpio -g write 20 1");
					}
				?>
			</div>

			<!-- TURN ON/OFF GREEN LED -->
			<div class = "col-lg-4">
				<h3>Turn Green LED On</h3>
				<form action "index.php" method = "GET">
					<input class = "btn btn-success" type = "submit" value = "Switch On" name = "green_on">
					<input class = "btn btn-success" type = "submit" value = "Switch Off" name = "green_off">
				</form>

				<?php
					shell_exec("gpio -g mode 25 out");

					if(isset($_GET["green_off"])){
						shell_exec("gpio -g write 25 0");
					}

					else if(isset($_GET["green_on"])){
						shell_exec("gpio -g write 25 1");
					}
				?>
			</div>
		</div>

		<!-- TURN ON/OFF MULTIPLE LEDs -->
		<div class = "row">
			<div class = "col-lg-12">
				<h3>Turn Multple LEDs On / Off</h3>
				<form action "index.php" method = "GET">
					<input class = "btn btn-info" type = "submit" value = "Turn All LEDs On" name = "all_led_on">
					<input class = "btn btn-info" type = "submit" value = "Turn All LEDs Off" name = "all_led_off">
				</form>

				<?php
					shell_exec("gpio -g mode 23 out");
					shell_exec("gpio -g mode 25 out");
					shell_exec("gpio -g mode 20 out");

					if(isset($_GET["all_led_on"])){
						shell_exec("gpio -g write 23 1");
						shell_exec("gpio -g write 25 1");
						shell_exec("gpio -g write 20 1");
					}

					if(isset($_GET["all_led_off"])){
						shell_exec("gpio -g write 23 0");
						shell_exec("gpio -g write 25 0");
						shell_exec("gpio -g write 20 0");
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
