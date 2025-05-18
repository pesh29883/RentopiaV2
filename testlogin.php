<?php
require_once 'db_connect.php';

$email = 'christonambowang@gmail.com'; // change to the user you want to test
$password = 'james29883'; // change to their password

$stmt = $pdo->prepare("SELECT * FROM users WHERE LOWER(email) = ?");
$stmt->execute([strtolower(trim($email))]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "User found: " . $user['email'] . "<br>";
    echo "Password hash in DB: " . $user['password'] . "<br>";
    if (password_verify($password, $user['password'])) {
        echo "Password matches! Login success.";
    } else {
        echo "Password does NOT match.";
    }
} else {
    echo "No user found with this email.";
}
?>
