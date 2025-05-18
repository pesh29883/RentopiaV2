<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=test", "root", "");
    echo "PDO MySQL is working!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
