<?php
$servername = "localhost";
$username = "bituser";
$password = "fqdwsear";
$database = "bitnorte";

// Create connection
$connect = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
