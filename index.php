<?php
session_start();
require_once 'db_connect.php';  // contains $pdo
require_once 'User.php';

function redirectWithError($msg) {
    $_SESSION['error'] = $msg;
    header("Location: index.php"); // your login page
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        redirectWithError("Please fill in all required fields.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        redirectWithError("Invalid email format.");
    }

    try {
        $user = new User($pdo);
        $userData = $user->login($email, $password);

        if ($userData) {
            // ✅ Set user data in session
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['fullname'] = $userData['fullname'];
            $_SESSION['email'] = $userData['email'];
            $_SESSION['address'] = $userData['address'] ?? 'Not available';
            $_SESSION['phone'] = $userData['mobile'] ?? 'Not available';
            $_SESSION['profile_pic'] = $userData['profile_pic'] ?? null;

            header("Location: home.php"); // redirect after login
            exit();
        } else {
            redirectWithError("Invalid email or password.");
        }
    } catch (Exception $e) {
        redirectWithError("Internal error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Rentopia</title>
  <link rel="stylesheet" href="login.css" />
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
</head>
<body>

<div class="form-container" role="main" aria-label="Login form">
  <h2>Login to Rentopia</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <p class="message error" role="alert"><?= htmlspecialchars($_SESSION['error']) ?></p>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <form action="" method="POST" novalidate>
    <label for="email" class="sr-only">Email</label>
    <input
      type="email"
      name="email"
      id="email"
      placeholder="Email"
      required
      value="<?= isset($email) ? htmlspecialchars($email) : '' ?>"
      autocomplete="email"
    >

    <label for="password" class="sr-only">Password</label>
    <div class="password-wrapper">
      <input
        type="password"
        name="password"
        id="password"
        placeholder="Password"
        required
        autocomplete="current-password"
      >
      <button
        type="button"
        class="toggle-password"
        aria-label="Show password while pressing"
      >
        <svg viewBox="0 0 24 24" aria-hidden="true" width="20" height="20">
          <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7z"/>
          <circle cx="12" cy="12" r="2.5"/>
        </svg>
      </button>
    </div>

    <button type="submit">Log In</button>
  </form>

  <p class="signup-link">
    Don't have an account?
    <a href="signup.php">Sign up here</a>
  </p>
  <p class="forgot-password">
  <a href="forgotpassword.php">Forgot Password?</a>
</p>
</div>

<script>
  const passwordInput = document.getElementById('password');
  const toggleBtn = document.querySelector('.toggle-password');

  toggleBtn.addEventListener('mousedown', () => passwordInput.type = 'text');
  toggleBtn.addEventListener('mouseup', () => passwordInput.type = 'password');
  toggleBtn.addEventListener('mouseleave', () => passwordInput.type = 'password');
  toggleBtn.addEventListener('touchstart', () => passwordInput.type = 'text');
  toggleBtn.addEventListener('touchend', () => passwordInput.type = 'password');
</script>

</body>
</html>
