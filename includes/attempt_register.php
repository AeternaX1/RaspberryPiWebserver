<?php
require 'db_connection.php';

//Switches on error reporting on the Apache2 webserver
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_POST["username"] && $_POST["password"] && $_POST["email"]) {
	// Set parameters and execute
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// Protects against SQL Injections
	$username = stripslashes($username);
	$password = stripslashes($password);
	$email = stripslashes($email);
	$username = mysqli_real_escape_string($conn, $_POST["username"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);

	// Prepared statements; prepare and bind
	$stmt = $conn->prepare("INSERT INTO users.users (username, email, password) VALUES (?, ?, ?)");
	$stmt->bind_param("sss", $username, $email, $password);

	// $password_hash = password_hash($password, PASSWORD_BCRYPT);
	$stmt->execute();

	// Account successfully created, page will redirect allowing the user to login with their new credentials
	echo "New account created successfully! You can now login. Page will redirect to the login screen in 1 seconds.";
	header('refresh:1;url=../register_screen.php');
}
// If no information posted from login_screen.php
else {
	// Check for empty fields as these are not allowed
	// This code runs if both fields are empty AND if only one is empty
	if(empty($username) && empty($email) && empty($password)){
		echo "Failed registration as fields cannot be empty. Please try again";
		header("refresh:1;url=../register_screen.php");
	}
}

