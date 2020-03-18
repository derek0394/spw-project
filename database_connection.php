<?php
$servername = "localhost";
$user1 = "root";
$pass = "";
$database = "application";



// Create connection
$conn = new mysqli($servername, $user1, $pass, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>