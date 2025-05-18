<!-- rate-renter.php -->
<?php
include 'header.php';
$rentals = json_decode(file_get_contents('rentals.json'), true);
$currentLessorId = 'user123'; // Replace with session or login ID

foreach ($rentals as $index => $rental) {
    if ($rental['lessor_id'] === $currentLessorId && empty($rental['rating'])) {
        echo "<div class='rating-card'>
            <p><strong>Renter:</strong> {$rental['email']}</p>
            <form method='post' action='submit-rating.php'>
                <input type='hidden' name='index' value='{$index}'>
                <label>Rate renter:</label>
                <select name='rating' required>
                    <option value=''>--Select--</option>
                    <option value='1'>1</option>
                    <option value='2'>2</option>
                    <option value='3'>3</option>
                    <option value='4'>4</option>
                    <option value='5'>5</option>
                </select>
                <button type='submit'>Submit</button>
            </form>
        </div>";
    }
}
include 'footer.php';
?>



<?php
// Add this in profile.php where appropriate
$rentals = json_decode(file_get_contents('rentals.json'), true);
$currentUserEmail = 'renter@example.com'; // Get this from session
$ratings = [];

foreach ($rentals as $rental) {
    if ($rental['email'] === $currentUserEmail && isset($rental['rating'])) {
        $ratings[] = $rental['rating'];
    }
}

$averageRating = count($ratings) ? array_sum($ratings) / count($ratings) : null;

if ($averageRating !== null) {
    echo "<p><strong>Renter Rating:</strong> " . number_format($averageRating, 1) . " / 5</p>";
} else {
    echo "<p><strong>Renter Rating:</strong> No ratings yet.</p>";
}
?>
