<?php
$servername = "127.0.0.1"; // Standard MySQL host for local development
$username = "root";
$password = "admin";
$dbname = "rentopiadb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
