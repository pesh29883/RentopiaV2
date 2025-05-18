<?php
session_start();
require_once 'db_connect.php';
require_once 'User.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: login.php?error=Please fill all fields");
        exit();
    }

    $user = new User($pdo);
    $userData = $user->login($email, $password);

    if ($userData) {
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['fullname'] = $userData['fullname'];
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: login.php?error=Invalid email or password");
        exit();
    }
}
?>
