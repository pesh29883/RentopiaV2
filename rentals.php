<?php
include 'header.php';
include 'db.php'; // DB connection
?>

<div class="container">
    <h2>My Rentals</h2>
    <div class="item-list">

        <?php
        $result = $conn->query("SELECT * FROM rentals ORDER BY date DESC");

        if ($result->num_rows > 0) {
            while ($rental = $result->fetch_assoc()) {
                echo '<div class="item">';
                echo '<div class="item-content">';
                echo '<h3 class="item-title">' . htmlspecialchars($rental['item']) . '</h3>';
                echo '<p><strong>Name:</strong> ' . htmlspecialchars($rental['name']) . '</p>';
                echo '<p><strong>Email:</strong> ' . htmlspecialchars($rental['email']) . '</p>';
                echo '<p><strong>Duration:</strong> ' . htmlspecialchars($rental['duration']) . ' day(s)</p>';
                echo '<p><strong>Date:</strong> ' . htmlspecialchars($rental['date']) . '</p>';
                echo '</div></div>';
            }
        } else {
            echo "<p>You haven’t rented anything yet.</p>";
        }
        ?>
        
    </div>
</div>

<?php include 'footer.php'; ?>
