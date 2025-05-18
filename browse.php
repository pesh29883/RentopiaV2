<?php include 'header.php'; ?>
<!-- Main Content -->
<div class="container">
    <h1>Browse Available Items</h1>

    <div class="category-filter">
    <button class="category-btn active" data-category="all">
        <img src="resources/icons/box-alt.png" alt="All" class="icon"> All
    </button>
    <button class="category-btn" data-category="outdoor">
        <img src="resources/icons/bench-tree.png" alt="Outdoor" class="icon"> Outdoor
    </button>
    <button class="category-btn" data-category="electronics">
        <img src="resources/icons/laptop-mobile.png" alt="Electronics" class="icon"> Electronics
    </button>
    <button class="category-btn" data-category="transport">
        <img src="resources/icons/cars.png" alt="Transport" class="icon"> Transport
    </button>
    <button class="category-btn" data-category="accommodation">
        <img src="resources/icons/people-roof.png" alt="Accommodation" class="icon"> Accommodation
    </button>
    <button class="category-btn" data-category="tools">
        <img src="resources/icons/tools.png" alt="Tools" class="icon"> Tools
    </button>
    <button class="category-btn" data-category="event">
        <img src="resources/icons/party-horn.png" alt="Event" class="icon"> Events
    </button>
</div>
    <!-- Search Box -->
    <input type="text" id="searchBox" placeholder="Search items..." class="search-box" />

    <!-- Item List -->
    <div class="item-list" id="itemList">
        <?php
            $items = [
                ['id' => 1, 'title' => 'Mountain Bike', 'desc' => 'Great for outdoor trails and weekend rides.', 'img' => 'resources/bicycle.webp', 'category' => 'outdoor'],
                ['id' => 2, 'title' => 'DSLR Camera', 'desc' => 'Perfect for high-quality photography and events.', 'img' => 'resources/dslr.avif', 'category' => 'electronics'],
                ['id' => 3, 'title' => 'Camping Tent', 'desc' => 'Stay warm and dry while exploring the outdoors.', 'img' => 'resources/tent.jpg', 'category' => 'outdoor'],
                ['id' => 4, 'title' => 'Electric Scooter', 'desc' => 'Convenient for short commutes in the city.', 'img' => 'resources/electricscooter.webp', 'category' => 'transport'],
                ['id' => 5, 'title' => 'Car', 'desc' => 'Reliable and comfortable for weekend getaways.', 'img' => 'resources/car.jpg', 'category' => 'transport'],
                ['id' => 6, 'title' => 'Vacation House', 'desc' => 'If you are planning to have something to stay in during a vacation for a limited time this is for you.', 'img' => 'resources/vacationHouse.jpg', 'category' => 'accommodation'],
                ['id' => 7, 'title' => 'Power Tools', 'desc' => 'For fixing something that you want to do yourself.', 'img' => 'resources/powertools.jpg', 'category' => 'tools'],
                ['id' => 8, 'title' => 'Event Chair', 'desc' => 'Good for events and more.', 'img' => 'resources/eventChair.jpg', 'category' => 'event'],
                ['id' => 9, 'title' => 'Projector', 'desc' => 'For movie marathon or something else.', 'img' => 'resources/projector.webp', 'category' => 'electronics'],
                ['id' => 10, 'title' => 'Costume', 'desc' => 'For occasions and events.', 'img' => 'resources/costume.jpg', 'category' => 'event'],
                ['id' => 11, 'title' => 'Snowboard', 'desc' => 'Hit the slopes...', 'img' => 'resources/snowboard.webp', 'category' => 'outdoor'],
                ['id' => 12, 'title' => 'GoPro Camera', 'desc' => 'Capture adventures...', 'img' => 'resources/gopro.jpg', 'category' => 'electronics'],
                ['id' => 13, 'title' => 'Popcorn Machine', 'desc' => 'Add fun to parties...', 'img' => 'resources/popcornmachine.avif', 'category' => 'event'],
                ['id' => 14, 'title' => 'Wedding Arch', 'desc' => 'Beautiful arch...', 'img' => 'resources/weddingarch.jpg', 'category' => 'event'],
                ['id' => 15, 'title' => 'VR Headset', 'desc' => 'Experience immersive...', 'img' => 'resources/vrheadset.jpg', 'category' => 'electronics'],
                ['id' => 16, 'title' => 'DJ Equipment', 'desc' => 'Full set for DJs...', 'img' => 'resources/djequipment.jpg', 'category' => 'event'],
                ['id' => 17, 'title' => 'Bouncy Castle', 'desc' => 'Perfect for kids...', 'img' => 'resources/bouncycastle.jpg', 'category' => 'event'],
                ['id' => 18, 'title' => 'Portable Generator', 'desc' => 'Reliable power...', 'img' => 'resources/generator.jpg', 'category' => 'tools'],
                ['id' => 19, 'title' => 'Kayak', 'desc' => 'Paddle through...', 'img' => 'resources/kayak.jpg', 'category' => 'outdoor'],
                ['id' => 20, 'title' => '360 Photo Booth', 'desc' => 'Modern photo booth...', 'img' => 'resources/photobooth.jpg', 'category' => 'event'],

            ];

            foreach ($items as $item) {
                echo "
                <div class='item' data-title='" . strtolower($item['title']) . "' data-category='{$item['category']}'>
                    <a href='product.php?id={$item['id']}'>
                        <img src='{$item['img']}' alt='{$item['title']}'>
                    </a>
                    <div class='item-content'>
                        <a class='item-title' href='product.php?id={$item['id']}'>{$item['title']}</a>
                        <div class='item-description'>{$item['desc']}</div>
                    </div>
                </div>
                ";
            }
        ?>
    </div>
</div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- JavaScript for search and category filter -->
<script>
    const searchBox = document.getElementById("searchBox");
    const items = document.querySelectorAll(".item");
    const categoryButtons = document.querySelectorAll(".category-btn");

    let activeCategory = "all";

    function filterItems() {
        const query = searchBox.value.toLowerCase();

        items.forEach(item => {
            const title = item.dataset.title;
            const category = item.dataset.category;

            const matchesSearch = title.includes(query);
            const matchesCategory = activeCategory === "all" || category === activeCategory;

            item.style.display = (matchesSearch && matchesCategory) ? "block" : "none";
        });
    }

    searchBox.addEventListener("input", filterItems);

    categoryButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            categoryButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            activeCategory = btn.dataset.category;
            filterItems();
        });
    });
</script>

</body>
</html>
