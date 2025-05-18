<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Sign Up - Rentopia</title>
    <link rel="stylesheet" href="signup.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <style>
        .password-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }

        .password-wrapper input {
            padding-right: 40px; /* space for icon */
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 30%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            transition: color 0.2s ease;
        }

        .toggle-password:hover,
        .toggle-password:focus {
            color: #007bff;
            outline: none;
        }

        .toggle-password svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        /* Styles for terms checkbox and error */
        .terms-wrapper {
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        /* Error message styling */
        .input-error {
            color: red;
            font-size: 0.65rem;
            margin-top: .0.05rem;
            display: none;
        }

        #terms-error {
            display: none;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="form-container" role="main">
    <h2>Create Your Account</h2>

    <?php if ($error): ?>
        <div class="message error" role="alert"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form id="signup-form" action="signup_process.php" method="POST" novalidate>
        <input type="text" name="fullname" placeholder="Full Name" required autocomplete="name" />
        <div class="input-error" aria-live="polite"></div>

        <input type="email" name="email" placeholder="Email Address" required autocomplete="email" />
        <div class="input-error" aria-live="polite"></div>

        <input type="tel" name="mobile" placeholder="Mobile Number" autocomplete="tel" required />
        <div class="input-error" aria-live="polite"></div>

        <input type="text" name="address" placeholder="Address" autocomplete="street-address" required />
        <div class="input-error" aria-live="polite"></div>

        <div class="password-wrapper">
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Password"
                required
                autocomplete="new-password"
                aria-describedby="password-toggle-desc"
                
            />
            <div class="input-error" aria-live="polite"></div>
            <button
                type="button"
                class="toggle-password"
                onclick="togglePassword('password', this)"
                aria-label="Toggle password visibility"
                aria-pressed="false"
                id="toggle-password-btn"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />
                    <circle cx="12" cy="12" r="2.5" />
                </svg>
            </button>
            
        </div>
        
        

        <div class="password-wrapper">
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                placeholder="Confirm Password"
                required
                autocomplete="new-password"
                aria-describedby="confirm-password-toggle-desc"
                
            />
            
            <div class="input-error" aria-live="polite"></div>
            <button
                type="button"
                class="toggle-password"
                onclick="togglePassword('confirm_password', this)"
                aria-label="Toggle confirm password visibility"
                aria-pressed="false"
                id="toggle-confirm-password-btn"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 12a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />
                    <circle cx="12" cy="12" r="2.5" />
                </svg>
            </button>
        </div>
        <div id="confirm-password-error" class="input-error" aria-live="polite"></div>

        

        <button type="submit">Sign Up</button>
        <div class="terms-wrapper">
            <label>
                <input type="checkbox" name="terms" id="terms" required />
                I agree to the <a href="terms.html" target="_blank" rel="noopener">Terms and Services</a>
            </label>
            <div id="terms-error" role="alert">You must agree to the Terms and Services to sign up.</div>
        </div>
    </form>

    <p>Already have an account? <a href="index.php">Log in here</a></p>
</div>

<script>
    const eyeOpenSVG = `
      <path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7z"/>
      <circle cx="12" cy="12" r="2.5"/>
    `;

    const eyeClosedSVG = `
      <path d="M17.94 17.94L6.06 6.06"/>
      <path d="M21 12s-3 7-9 7-9-7-9-7 3-7 9-7 9 7 9 7z"/>
      <path d="M12 9a3 3 0 0 1 3 3 2.99 2.99 0 0 1-5.196 2.104"/>
    `;

    function showPassword(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const svg = btn.querySelector('svg');
        field.type = 'text';
        svg.innerHTML = eyeClosedSVG;
        btn.setAttribute('aria-pressed', 'true');
    }

    function hidePassword(fieldId, btn) {
        const field = document.getElementById(fieldId);
        const svg = btn.querySelector('svg');
        field.type = 'password';
        svg.innerHTML = eyeOpenSVG;
        btn.setAttribute('aria-pressed', 'false');
    }

    document.addEventListener('DOMContentLoaded', () => {
      // Password toggle for main password
      const toggleBtn = document.getElementById('toggle-password-btn');
      const fieldId = 'password';

      toggleBtn.addEventListener('mousedown', () => showPassword(fieldId, toggleBtn));
      toggleBtn.addEventListener('touchstart', () => showPassword(fieldId, toggleBtn));

      toggleBtn.addEventListener('mouseup', () => hidePassword(fieldId, toggleBtn));
      toggleBtn.addEventListener('mouseleave', () => hidePassword(fieldId, toggleBtn));
      toggleBtn.addEventListener('touchend', () => hidePassword(fieldId, toggleBtn));
      toggleBtn.addEventListener('touchcancel', () => hidePassword(fieldId, toggleBtn));

      // Password toggle for confirm password
      const toggleConfirmBtn = document.getElementById('toggle-confirm-password-btn');
      const confirmFieldId = 'confirm_password';

      toggleConfirmBtn.addEventListener('mousedown', () => showPassword(confirmFieldId, toggleConfirmBtn));
      toggleConfirmBtn.addEventListener('touchstart', () => showPassword(confirmFieldId, toggleConfirmBtn));

      toggleConfirmBtn.addEventListener('mouseup', () => hidePassword(confirmFieldId, toggleConfirmBtn));
      toggleConfirmBtn.addEventListener('mouseleave', () => hidePassword(confirmFieldId, toggleConfirmBtn));
      toggleConfirmBtn.addEventListener('touchend', () => hidePassword(confirmFieldId, toggleConfirmBtn));
      toggleConfirmBtn.addEventListener('touchcancel', () => hidePassword(confirmFieldId, toggleConfirmBtn));

      // Form submission validation
      const form = document.getElementById('signup-form');
      form.addEventListener('submit', function(event) {
        // Clear all previous errors
        const allErrorDivs = form.querySelectorAll('.input-error');
        allErrorDivs.forEach(div => {
          div.textContent = '';
          div.style.display = 'none';
        });

        let isValid = true;

        // Validate all required fields for empty values
        const requiredFields = [
          'fullname',
          'email',
          'mobile',
          'address',
          'password',
          'confirm_password'
        ];

        for (const fieldName of requiredFields) {
          const input = form.querySelector(`[name="${fieldName}"]`);
          const errorDiv = input.nextElementSibling;

          if (!input.value.trim()) {
            errorDiv.textContent = 'This field is required.';
            errorDiv.style.display = 'block';
            if (isValid) {
              input.focus();
            }
            isValid = false;
          }
        }

        // Password match validation (only if both filled)
        const password = form.querySelector('[name="password"]').value.trim();
        const confirmPassword = form.querySelector('[name="confirm_password"]').value.trim();
        const confirmErrorDiv = document.getElementById('confirm-password-error');

        if (password && confirmPassword && password !== confirmPassword) {
          confirmErrorDiv.textContent = 'Password and Confirm Password do not match.';
          confirmErrorDiv.style.display = 'block';
          if (isValid) {
            form.querySelector('[name="confirm_password"]').focus();
          }
          isValid = false;
        }

        // Terms checkbox validation
        const termsCheckbox = document.getElementById('terms');
        const termsErrorDiv = document.getElementById('terms-error');
        if (!termsCheckbox.checked) {
          termsErrorDiv.style.display = 'block';
          if (isValid) {
            termsCheckbox.focus();
          }
          isValid = false;
        } else {
          termsErrorDiv.style.display = 'none';
        }

        if (!isValid) {
          event.preventDefault();
        }
      });
    });
</script>

</body>
</html>
