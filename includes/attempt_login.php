<?php
require "db_connection.php";

//Switches on error reporting on the Apache2 webserver
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// If the username and password information has been successfully posted from the form on login_screen.php,
// Store that information inside variables, $username and $password respectively
if($_POST["username"] && $_POST["password"]) {
	$username = $_POST["username"];
	$password = $_POST["password"];

	// Protects against SQL Injections
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysqli_real_escape_string($conn, $_POST["username"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	
	$sql = "SELECT* FROM users.users WHERE username = '$username' && password = '$password'";
	$result = mysqli_query($conn, $sql) or die ("Bad SQL: $sql");

	// Check if the record exists by counting the table rows.
	// If there is no match, then either the user doesn't exist or the credentials are wrong
	$count = mysqli_num_rows($result);

	// If record found in database table
	if($count == 1) {		
		//Login successful
		$_SESSION["username"] = $username;
		echo "Successfully logged in! Page will redirect in a moment.";
		header("refresh:3;url=../index.php");
	}
	// If no record found in database table
	else {
		//Login failed
		echo "Failed login as no user found. Please try again";
		header("refresh:3;url=../login_screen.php");
	}
}
// If no information posted from login_screen.php
else {
	// Check for empty fields as these are not allowed
	// This code runs if both fields are empty AND if only one is empty
	if(empty($username) && empty($password)){
		echo "Failed login as fields cannot be empty. Please try again";
		header("refresh:1;url=../login_screen.php");
	}
}

