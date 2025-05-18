<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database credentials
$host = "localhost";
$user = "root";
$password = ""; // default for XAMPP
$database = "rentopia";

// Try connecting
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("❌ Connection failed: " . $conn->connect_error);
} else {
  echo "✅ Connected to the MySQL database successfully!";
}

// Optional: check if 'users' table exists
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result && $result->num_rows > 0) {
  echo "<br>✅ 'users' table exists!";
} else {
  echo "<br>⚠️ 'users' table does not exist.";
}

$conn->close();
?>
