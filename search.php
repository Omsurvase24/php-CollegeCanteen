<?php
ob_start();
include 'inc/navbar.php';

$data = array();

$query = "SELECT * FROM food_items WHERE title LIKE CONCAT('%', ?, '%')";
$prepared_statement = mysqli_prepare($conn, $query);

if ($prepared_statement) {
    mysqli_stmt_bind_param($prepared_statement, "s", $_GET['search']);
    mysqli_stmt_execute($prepared_statement);

    $result = mysqli_stmt_get_result($prepared_statement);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($data, $row);
        }
    }

    mysqli_stmt_close($prepared_statement);
} else {
    echo "Error preparing statement: " . mysqli_error($conn);
}

if (isset($_POST['submit'])) {
    header('Location: search.php?search=' . $_POST['search']);
}

ob_end_flush();
?>

<div>
    <div class="home-banner">
        <div class="search">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <div><input type="text" name="search" placeholder="Search for food"> <i class="fa-solid fa-magnifying-glass"></i></div>
                <input type="submit" value="Search" name="submit">
            </form>
        </div>
    </div>

    <div class="food-items-container">
        <?php echo count($data) == 0 ? '<h1>No such item ' . $_GET['search'] . '</h1>' : '<h1>Search Results For ' . $_GET['search'] . '</h1>' ?>

        <div class="food-items">
            <?php
            foreach ($data as $item) {
            ?>
                <div data-id="<?php echo $item['id'] ?>" class="item">
                    <img id="item-image" src="<?php echo $item['image'] ?>" alt="<?php echo $item['title'] ?>">
                    <div>
                        <h3 id="item-title"><?php echo $item['title']; ?></h3>
                        <p id="item-price">Rs. <?php echo $item['price']; ?></p>
                        <span><?php echo $item['availability'] ? 'Available'  : 'Not available'; ?></span>
                        <input type="number" id="item-quantity" name="quantity" value="1" min=1>
                        <input type="submit" value="Add to cart" name="submit" onclick="handleAddToCart(event, <?php echo $item['id'] ?>);">
                    </div>
                </div>
            <?php
            }

            ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>