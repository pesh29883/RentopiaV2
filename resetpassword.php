<?php
// reset_password.php
require_once 'db_connect.php'; // Your PDO connection here

// Change these:
$emailToReset = 'christonambowang@gmail.com'; // put user email here
$newPassword = '123123';    // new password you want to set

// Hash new password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Prepare update query
$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
if ($stmt->execute([$hashedPassword, $emailToReset])) {
    echo "Password reset successfully for $emailToReset";
} else {
    echo "Password reset failed.";
}
