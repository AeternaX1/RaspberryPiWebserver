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
	<title>Raspberry Pi Web Interface - Linux Commands</title>
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
					echo "<a class = 'link-item' href = 'led.php'>LED</a>";
				}
				
				//Show LINUX TERMINAL COMMANDS tab when session HAS BEEN set
				if(isset($_SESSION['username'])){
					echo "<a class = 'link-item' href = 'linux_commands.php' style = 'background-color:#bd0d00; color: #ffffff;'>Linux Terminal Commands</a>";
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
					///Display username below Jumbotron when session HAS BEEN set
					// IE: when they have logged in
					if(isset($_SESSION['username'])){
							echo "<h3>Hello, {$_SESSION['username']}</h3><br>";
							echo "<h3>This website is hosted on an Apache2 webserver running on the Raspberry Pi.<br>";
							echo "This webpage includes Python scripts which contain stored Linux terminal commands inside a 'cmd' variable.<br>";
							echo "PHP then executes that Python file on the webpage using 'exec_file'<br>";
							echo "This allows us to see command data that can normally only be run from the Rasbian terminal, right here on a webpage.<h3>";
					}
				?>
			</div>
		</div>
		
		<!-- Linux Commands Outputted to this HTML page via Python code being called via PHP shell_exec-->
		<div class = "row">
			<div class = "col-lg-4">
				<h3>Temperature</h3>
				<?php
					$command = escapeshellcmd('python python_scripts/rpi_temp.py');
					$output = shell_exec($command);
					echo $output;
				?>
			</div>

			<div class = "col-lg-4">
				<h3>Uptime</h3>
					<?php
						$command  = escapeshellcmd("python python_scripts/rpi_uptime.py");
						$output = shell_exec($command);
						echo $output;
					?>
			</div>

			<div class = "col-lg-4">
				<h3>Hostname and Private IP Address</h3>
				<?php
					$command  = escapeshellcmd("python python_scripts/rpi_hostname.py");
					$output = shell_exec($command);
					echo $output;
				?>
			</div>
		</div>

		<div class = "row">
			<div class = "col-lg-4">
				<h3>Free Memory Available</h3>
				<?php
					$command  = escapeshellcmd("python python_scripts/rpi_free.py");
					$output = shell_exec($command);
					echo $output;
				?>
			</div>

			<div class = "col-lg-4">
				<h3>Raspberry Pi Version</h3>
				<?php
					$command  = escapeshellcmd("python python_scripts/rpi_version.py");
					$output = shell_exec($command);
					echo $output;
				?>
			</div>

			<div class = "col-lg-4">
				<h3>CPU Info</h3>
				<?php
					$command  = escapeshellcmd("python python_scripts/rpi_cpuinfo.py");
					$output = shell_exec($command);
					echo $output;
				?>
			</div>
		</div>

		<div class = "row">
			<div class = "col-lg-4">
				<h3>vcgencmd Voltage</h3>
				<?php
					$command  = escapeshellcmd("python python_scripts/rpi_volts.py");
					$output = shell_exec($command);
					echo $output;
				?>
			</div>

			<div class = "col-lg-4">
				<h3>vcgencmd CPU / GPU Memory Split</h3>
				<?php
					$command  = escapeshellcmd("python python_scripts/rpi_cpugpu.py");
					$output = shell_exec($command);
					echo $output;
				?>
			</div>

			<div class = "col-lg-4">
				<h3>vcgencmd CPU Clock Speed</h3>
				<?php
					$command  = escapeshellcmd("python python_scripts/rpi_measure_clock.py");
					$output = shell_exec($command);
					echo $output;
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
