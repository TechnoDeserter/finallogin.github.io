<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "create_user_table";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
