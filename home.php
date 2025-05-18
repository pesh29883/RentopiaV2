<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home - Rentopia</title>
    <link rel="stylesheet" href="home.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="container">
        <h1>Welcome to Rentopia!</h1>
            
        <?php if (isset($_GET['success'])): ?>
            <p class="message success"><?= htmlspecialchars($_GET['success']) ?></p>
        <?php endif; ?> 

        <p>You are now logged in. Start browsing items or manage your rentals from the menu above.</p>

        <!-- Product Listing -->
        <div class="item-list">
            <?php
            $products = [
                ['id' => 1, 'title' => 'Mountain Bike', 'desc' => 'Great for outdoor trails and weekend rides.', 'img' => 'resources\bicycle.webp'],
                ['id' => 2, 'title' => 'DSLR Camera', 'desc' => 'Perfect for high-quality photography and events.', 'img' => 'resources\dslr.avif'],
                ['id' => 3, 'title' => 'Camping Tent', 'desc' => 'Stay warm and dry while exploring the outdoors.', 'img' => 'resources\tent.jpg'],
                ['id' => 4, 'title' => 'Electric Scooter', 'desc' => 'Convenient for short commutes in the city.', 'img' => 'resources\electricscooter.webp'],
                ['id' => 5, 'title' => 'Car', 'desc' => 'Reliable and comfortable for weekend getaways.', 'img' => 'resources\car.jpg'],
                ['id' => 6, 'title' => 'Vacation House', 'desc' => 'If you are planning to have something to stay in during a vacation for a limited time this is for you.', 'img' => 'resources\vacationHouse.jpg'],
                ['id' => 7, 'title' => 'Power Tools', 'desc' => 'For fixing something that you want to do yourself.', 'img' => 'resources\powertools.jpg'],
                ['id' => 8, 'title' => 'Event Chair', 'desc' => 'Good for events and more.', 'img' => 'resources\eventChair.jpg'],
                ['id' => 9, 'title' => 'Projector', 'desc' => 'For movie marathon or something else.', 'img' => 'resources\projector.webp'],
                ['id' => 10, 'title' => 'Costume', 'desc' => 'For occasions and events.', 'img' => 'resources\costume.jpg'],
                ['id' => 11, 'title' => 'Snowboard', 'desc' => 'Hit the slopes with this premium snowboard.', 'img' => 'resources/snowboard.webp'],
                ['id' => 12, 'title' => 'GoPro Camera', 'desc' => 'Capture your adventures with this waterproof action cam.', 'img' => 'resources/gopro.jpg'],
                ['id' => 13, 'title' => 'Popcorn Machine', 'desc' => 'Add fun to parties with fresh popcorn!', 'img' => 'resources/popcornmachine.avif'],
                ['id' => 14, 'title' => 'Wedding Arch', 'desc' => 'Beautiful arch for weddings or romantic events.', 'img' => 'resources/weddingarch.jpg'],
                ['id' => 15, 'title' => 'VR Headset', 'desc' => 'Experience immersive gaming or simulations.', 'img' => 'resources/vrheadset.jpg'],
                ['id' => 16, 'title' => 'DJ Equipment', 'desc' => 'Full set for DJs to rock your event.', 'img' => 'resources/djequipment.jpg'],
                ['id' => 17, 'title' => 'Bouncy Castle', 'desc' => 'Perfect for kids’ parties and outdoor fun.', 'img' => 'resources/bouncycastle.jpg'],
                ['id' => 18, 'title' => 'Portable Generator', 'desc' => 'Reliable power backup for events or camping.', 'img' => 'resources/generator.jpg'],
                ['id' => 19, 'title' => 'Kayak', 'desc' => 'Paddle through rivers and lakes with this solo kayak.', 'img' => 'resources/kayak.jpg'],
                ['id' => 20, 'title' => '360 Photo Booth', 'desc' => 'Modern photo booth experience for weddings and events.', 'img' => 'resources/photobooth.jpg']
            ];

            foreach ($products as $id => $product): ?>
                <div class="item">
                    <a href="product.php?id=<?= $id ?>">
                        <img src="<?= $product['img'] ?>" alt="<?= htmlspecialchars($product['title']) ?>">
                    </a>
                    <div class="item-content">
                        <a class="item-title" href="product.php?id=<?= $id ?>"><?= htmlspecialchars($product['title']) ?></a>
                        <div class="item-description"><?= htmlspecialchars($product['desc']) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
