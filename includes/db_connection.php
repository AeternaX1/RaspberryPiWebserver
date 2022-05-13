<?php
session_start();

// Store login details inside variables
$db_server = "localhost";
$db_username = "root";
$db_password = "PgHFPpLmW";

// Create connection
$conn = mysqli_connect($db_server, $db_username, $db_password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
else {
	// echo "Connected Successfully! ";
}
