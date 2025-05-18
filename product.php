<?php include 'header.php'; ?>
<?php include 'products.php'; // Include the products array ?>

<?php
// Get the product ID from the URL
$productId = isset($_GET['id']) ? $_GET['id'] : 1;

// Find the product based on the ID
$product = null;
foreach ($products as $p) {
    if ($p['id'] == $productId) {
        $product = $p;
        break;
    }
}
?>

<div class="container">
  <?php if ($product): ?>
    <h1 class="product-title"><?php echo $product['name']; ?></h1>
    <div class="product-details">
      <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
      <p class="product-description"><?php echo $product['description']; ?></p>
      <a href="rentnow.php?id=<?php echo $product['id']; ?>" class="rent-button">Rent Now</a>
    </div>
  <?php else: ?>
    <p>Product not found.</p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

