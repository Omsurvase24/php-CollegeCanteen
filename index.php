<?php
ob_start();

include 'inc/navbar.php';

$query = 'SELECT * from food_items';

$result = mysqli_query($conn, $query);

$food_items = mysqli_fetch_all($result, MYSQLI_ASSOC);

ob_end_flush();
?>

<div>
    <div class="home-banner">
        <div class="search">
            <form action="search.php" method="GET">
                <div><input type="text" name="search" placeholder="Search for food"> <i class="fa-solid fa-magnifying-glass"></i></div>
                <input type="submit" name="submit">
            </form>
        </div>
    </div>

    <div class="food-items-container">
        <h1>Food Menus</h1>
        <div class="food-items">
            <?php
            foreach ($food_items as $item) {
            ?>
                <div data-id="<?php echo $item['id'] ?>" class="item">
                    <img id="item-image" src="<?php echo $item['image'] ?>" alt="<?php echo $item['title'] ?>">
                    <div>
                        <h3 id="item-title"><?php echo $item['title']; ?></h3>
                        <p id="item-price">Rs. <?php echo $item['price']; ?></p>
                        <span><?php echo $item['availability'] ? 'Available'  : 'Not available'; ?></span>
                        <input type="number" id="item-quantity" name="quantity" value="1" min=1 >
                        <input type="submit" value="Add to cart" onclick="handleAddToCart(event, <?php echo $item['id'] ?>);" readonly>
                    </div>
                </div>
            <?php
            }

            ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>