<?php
$host = '127.0.0.1'; // ✅ Standard MySQL host for local development

$dbname = 'rentopiadb';  // Your database name
$username = 'root';  // Your database username
$password = 'admin';  // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>