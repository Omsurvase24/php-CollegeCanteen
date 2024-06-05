<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('config.php');

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "UPDATE menu_items SET name='$name', description='$description', price='$price' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    $sql = "SELECT * FROM menu_items WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $item = mysqli_fetch_assoc($result);
}
?>

<form method="post" action="">
    Name: <input type="text" name="name" value="<?php echo $item['name']; ?>" required><br>
    Description: <textarea name="description" required><?php echo $item['description']; ?></textarea><br>
    Price: <input type="text" name="price" value="<?php echo $item['price']; ?>" required><br>
    <input type="submit" value="Update Item">
</form>
<a href="admin_dashboard.php">Back to Dashboard</a>