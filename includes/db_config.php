<?php
// Database configuration
$servername = 'localhost'; // Server name
$username = 'root'; // Database username
$password = 'root'; // Database password
$dbname = 'Tech_CMS'; // Database name

// Set the default timezone
date_default_timezone_set("Asia/Calcutta"); 

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Start a new session if one hasn't already been started
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>
