<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function checkIfEmailExists($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    public function createUser($fullname, $email, $password, $mobile, $address) {
        // Hash the password before saving
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO users (fullname, email, password, mobile, address) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$fullname, $email, $hashedPassword, $mobile, $address]);
    }

    public function login($email, $password) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        error_log("User found for email: $email");
        if (password_verify($password, $user['password'])) {
            return $user;
        } else {
            error_log("Password mismatch for email: $email");
        }
    } else {
        error_log("No user found with email: $email");
    }
    return false;
}

}
?>
