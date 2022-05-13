<?php
require "db_connection.php";

//Switches on error reporting on the Apache2 webserver
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// This stops users jumping to page URL's without being logged in first
// An unregistered user should NOT be able to see this page's contents
// If a user does end up on this page without being logged on, they will be prompted to do so and then redirected to index.php
if(!isset($_SESSION['username'])) {
	header('refresh:1;url=../index.php');
	die("Uh-oh! You cannot view these pages without registering or logging in first. This page will redirect.");
}
	
session_unset();
session_destroy();
echo "Successfully logged out of your account. Page will redirect in a moment.";
header('refresh:1;url=../index.php');
exit();
