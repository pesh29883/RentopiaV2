<?php
session_start();

function redirectWithMessage($msg) {
    $_SESSION['message'] = $msg;
    header("Location: forgotpassword.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        redirectWithMessage("Please enter your email.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithMessage("Invalid email format.");
    } else {
        // TODO: Check if email exists in DB, send reset email
        // For now, simulate success:
        redirectWithMessage("If this email exists in our system, a password reset link has been sent.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Forgot Password - Rentopia</title>
  <link rel="stylesheet" href="login.css" />
</head>
<body>

<div class="form-container" role="main" aria-label="Forgot Password form">
  <h2>Forgot Password</h2>

  <?php if (isset($_SESSION['message'])): ?>
    <p class="message info" role="alert"><?= htmlspecialchars($_SESSION['message']) ?></p>
    <?php unset($_SESSION['message']); ?>
  <?php endif; ?>

  <form action="" method="POST" novalidate>
    <label for="email" class="sr-only">Email</label>
    <input
      type="email"
      name="email"
      id="email"
      placeholder="Enter your email"
      required
      autocomplete="email"
    >

    <button type="submit">Send Reset Link</button>
  </form>

  <p class="back-to-login">
    <a href="index.php">Back to Login</a>
  </p>
</div>

</body>
</html>
