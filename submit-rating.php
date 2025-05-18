<!-- submit-rating.php -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $rating = $_POST['rating'];
    $rentals = json_decode(file_get_contents('rentals.json'), true);

    $rentals[$index]['rating'] = (int) $rating;
    file_put_contents('rentals.json', json_encode($rentals, JSON_PRETTY_PRINT));

    header("Location: rate-renter.php");
    exit();
}
?>