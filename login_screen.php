<?php                                                    
	require "includes/db_connection.php";
	session_start(); 
	
	// An logged in user should NOT be able to see this page's contents
	// If a user does end up on this page while being logged on, they will be redirected to index.php
	if(isset($_SESSION['username'])) {
		header('refresh:1;url=/mini_project/index.php');
		die("Uh-oh! You're already logged in. This page will redirect.");
	}
?>

<!DOCTYPE html>
<html lang = "en">
<head>
	<!--CMP 408 System Internals and Cybersecurity-->
	<title>Raspberry Pi Web Interface - Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--CSS-->
	<link rel="stylesheet" href="css/style.css">

	<!--Bootstrap-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/>
	
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
						echo "<a class = 'link-item' href = 'login_screen.php' style = 'background-color:#bd0d00; color: #ffffff;'>Login</a>";
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
					//Display user prompt to login or register if they haven't already done so. 
					//This displays when there is no set session
					if(!isset($_SESSION['username'])){
							echo "<h3>This website is hosted on an Apache2 webserver running on the Raspberry Pi.<br></h3>";
							echo "<h3>In order to view the site contents and interact with the Raspberry Pi, please register or login to an existing account</h3>";
					}
				?>
			</div>
		</div>		

		<div class = "col-lg-12">
			<form id = "login" name = "login" action="includes/attempt_login.php" method="POST">
				<label for = "username">Username</label>
				<input type = "text" name="username" id="username" placeholder="Login with your username">

				<label for = "password">Password</label>
				<input type = "password" name="password" id="password" placeholder="Login with your password">

				<input type = "submit" value = "Submit" id="submit">
			</form>
		</div>
	</div>
</body>

</html>