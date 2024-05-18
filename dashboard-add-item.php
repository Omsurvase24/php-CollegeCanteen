<?php
ob_start();
include 'inc/navbar.php';

if (!isset($_SESSION['is_admin'])) {
    header('Location: signup.php');
    exit;
}

$message = "";

if (isset($_POST['submit'])) {
    $message = "";

    $title = $_POST['title'];
    $price = $_POST['price'];
    $availability = $_POST['availability'];

    if (!empty($_FILES['image']['name'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];

        $target_dir = "uploads/" . $file_name;

        move_uploaded_file($file_tmp, $target_dir);

        $price = intVal($price);
        $availability = $availability ? 1 : 0;;

        $query = "INSERT INTO food_items (title, image, price, availability) VALUES ('$title', 'uploads/$file_name', $price, $availability)";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $message = 'Food item added';
        } else {
            $message = 'Error occured, please try again';
        }
    }

    mysqli_close($conn);
}
ob_end_flush();
?>

<div class="dashboard-container">
    <?php include 'inc/aside.php'; ?>



    <div class="dashboard-add-item-container">
        <h2>Add Food Item</h2>
        <form class="add-item-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <div>
                <label for="image">Image</label>
                <input type="file" name="image">
            </div>
            <div>
                <label for="title">Title</label>
                <input type="text" name="title">
            </div>
            <div>
                <label for="price">Price</label>
                <input type="number" name="price">
            </div>
            <div>
                <label for="availability">Availability</label>
                <select name="availability">
                    <option value="">--- Choose a availability ---</option>
                    <option value="1" selected>Available</option>
                    <option value="0">Not available</option>
                </select>
            </div>
            <input type="submit" value="Submit" name="submit">

            <p><?php echo $message?></p>
        </form>
    </div>
</div>

<?php include 'inc/footer.php'; ?>