<?php
$servername = "dyud5fa2qycz1o3v.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$user1 = "ulo9xf8ad5xednpc";
$pass = "mmlbrz7cagzqssyg";
$database = "itrdhg03zk2ikdkj";



// Create connection
$conn = new mysqli($servername, $user1, $pass, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>