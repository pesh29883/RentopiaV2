<?php
session_start();
require_once 'db_connect.php';
require_once 'User.php';

function redirectWithError($msg) {
    $_SESSION['error'] = $msg;
    header("Location: signup.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $terms = isset($_POST['terms']);

    // Server-side validation
    if (!$fullname || !$email || !$mobile || !$address || !$password || !$confirm_password) {
        redirectWithError("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithError("Invalid email format.");
    }

    if ($password !== $confirm_password) {
        redirectWithError("Password and Confirm Password do not match.");
    }

    if (!$terms) {
        redirectWithError("You must agree to the Terms and Services.");
    }

    try {
        $user = new User($pdo);

        // Check if email already exists
        if ($user->checkIfEmailExists($email)) {
            redirectWithError("Email is already registered. Please log in or use another email.");
        }

        // Create user (password will be hashed inside)
        $created = $user->createUser($fullname, $email, $password, $mobile, $address);

        if ($created) {
            // Redirect to login page with success message (optional)
            header("Location: index.php?success=Account created successfully. Please log in.");
            exit();
        } else {
            redirectWithError("Failed to create account. Please try again later.");
        }
    } catch (Exception $e) {
        redirectWithError("Internal error: " . $e->getMessage());
    }
} else {
    // Redirect to signup if accessed without POST
    header("Location: signup.php");
    exit();
}
