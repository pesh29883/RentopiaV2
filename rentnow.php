<?php
include 'header.php';
include 'db.php'; // contains $conn

// Get item ID from URL
$itemId = isset($_GET['item_id']) ? intval($_GET['item_id']) : 0;
$itemName = "Unknown Item";

// Fetch item name from database
if ($itemId > 0) {
    $stmt = $conn->prepare("SELECT name FROM products WHERE id = ?");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $stmt->bind_result($itemName);
    if (!$stmt->fetch()) {
        $itemName = "Unknown Item";  // if item not found in DB
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['renter-name'];
    $email = $_POST['renter-email'];
    $duration = $_POST['rental-duration'];
    $date = date('Y-m-d');

    $stmt = $conn->prepare("INSERT INTO rentals (name, email, duration, date, item) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $name, $email, $duration, $date, $itemName);

    if ($stmt->execute()) {
        header("Location: rentals.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Rent Now - Rentopia</title>
    <link rel="stylesheet" href="rentnow.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Confirm Your Rental</h2>
    <p><strong>Item:</strong> <?= htmlspecialchars($itemName) ?></p>

    <form method="POST" class="rental-form">
        <div class="form-group">
            <label for="renter-name">Name:</label>
            <input type="text" id="renter-name" name="renter-name" required>
        </div>

        <div class="form-group">
            <label for="renter-email">Email:</label>
            <input type="email" id="renter-email" name="renter-email" required>
        </div>

        <div class="form-group">
            <label for="rental-duration">Duration (days):</label>
            <input type="number" id="rental-duration" name="rental-duration" required>
        </div>

        <button type="submit" class="submit-btn">Confirm Rental</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
