<?php
$servername = "localhost";
$username = "userdb";
$password = "passdb";
$database = "namedn";

// Create connection
$connect = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
