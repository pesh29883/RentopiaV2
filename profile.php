<?php
session_start();
include 'header.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php"); // redirect to login if not logged in
    exit();
}

$dsn = 'mysql:host=127.0.0.1;dbname=rentopiadb;charset=utf8mb4';
$dbUser = 'root';
$dbPass = 'admin';

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$profileUserEmail = $_SESSION['email']; // profile to show is logged-in user

// ==== HANDLE PROFILE UPDATE ====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_profile'])) {
    $updatedName = $_POST['edit_name'] ?? '';
    $updatedEmail = $_POST['edit_email'] ?? '';
    $updatedAddress = $_POST['edit_address'] ?? '';
    $updatedPhone = $_POST['edit_phone'] ?? '';
    $profilePicPath = null;

    // Handle image upload if a file was submitted
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = uniqid() . '_' . basename($_FILES['profile_pic']['name']);
        $targetFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFile)) {
            $profilePicPath = $targetFile;
        }
    }

    if ($profilePicPath) {
        $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, address = ?, phone = ?, profile_pic = ? WHERE email = ?");
        $stmt->execute([$updatedName, $updatedEmail, $updatedAddress, $updatedPhone, $profilePicPath, $profileUserEmail]);
        $_SESSION['profile_pic'] = $profilePicPath; // update session pic
    } else {
        $stmt = $pdo->prepare("UPDATE users SET fullname = ?, email = ?, address = ?, phone = ? WHERE email = ?");
        $stmt->execute([$updatedName, $updatedEmail, $updatedAddress, $updatedPhone, $profileUserEmail]);
    }

    // Update session data if email or name changed
    $_SESSION['fullname'] = $updatedName;
    $_SESSION['email'] = $updatedEmail;
    $_SESSION['address'] = $updatedAddress;
    $_SESSION['phone'] = $updatedPhone;

    // Redirect to avoid form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// ==== FETCH PROFILE INFO from DB for freshest data ====
$stmt = $pdo->prepare("SELECT fullname, email, address, phone, profile_pic FROM users WHERE email = ?");
$stmt->execute([$profileUserEmail]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $user = [
        'fullname' => $_SESSION['fullname'] ?? 'Unknown User',
        'email' => $_SESSION['email'],
        'address' => $_SESSION['address'] ?? 'Not available',
        'phone' => $_SESSION['phone'] ?? 'Not available',
        'profile_pic' => $_SESSION['profile_pic'] ?? null
    ];
}

$profilePic = $user['profile_pic'] && file_exists($user['profile_pic']) ? $user['profile_pic'] : 'resources/nopfp.webp';

?>

<div class="container">
    <h2>User Profile</h2>

    <!-- Profile Display -->
    <div id="profile-display" class="profile-display">
        <div class="profile-pic">
            <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture" id="profile-pic-img" style="max-width:150px; border-radius:50%;">
        </div>
        <p><strong>Name:</strong> <span id="user-name"><?php echo htmlspecialchars($user['fullname']); ?></span></p>
        <p><strong>Email:</strong> <span id="user-email"><?php echo htmlspecialchars($user['email']); ?></span></p>
        <p><strong>Address:</strong> <span id="user-address"><?php echo htmlspecialchars($user['address']); ?></span></p>
        <p><strong>Phone:</strong> <span id="user-phone"><?php echo htmlspecialchars($user['phone']); ?></span></p>

        <button id="edit-profile-btn" class="edit-btn">Edit Profile</button>
    </div>

    <!-- Profile Edit Form -->
    <div id="profile-edit" class="profile-edit" style="display: none;">
        <form method="POST" class="profile-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="edit-name">Name:</label>
                <input type="text" name="edit_name" id="edit-name" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-email">Email:</label>
                <input type="email" name="edit_email" id="edit-email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-address">Address:</label>
                <input type="text" name="edit_address" id="edit-address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>

            <div class="form-group">
                <label for="edit-phone">Phone:</label>
                <input type="text" name="edit_phone" id="edit-phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label for="profile-pic-upload">Profile Picture:</label>
                <input type="file" name="profile_pic" id="profile-pic-upload" accept="image/*">
            </div>

            <button type="submit" name="save_profile" class="submit-btn">Save Changes</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    const editBtn = document.getElementById('edit-profile-btn');
    const profileDisplay = document.getElementById('profile-display');
    const profileEdit = document.getElementById('profile-edit');

    editBtn.addEventListener('click', () => {
        profileDisplay.style.display = 'none';
        profileEdit.style.display = 'block';
    });
</script>
