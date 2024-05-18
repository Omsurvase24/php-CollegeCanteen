<?php
ob_start();
include 'inc/navbar.php';

if (!isset($_SESSION['is_admin'])) {
    header('Location: signup.php');
    exit;
}


$query = "SELECT COUNT(*) AS user_count FROM users";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $user_count = $row['user_count'];
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

$query = "SELECT COUNT(*) AS order_count FROM orders WHERE DATE(order_date) = CURDATE()";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $order_count = $row['order_count'];
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

mysqli_close($conn);
ob_end_flush();
?>

<div class="dashboard-container">
    <?php include 'inc/aside.php'; ?>

    <div class="general-info">
        <div class="info">
            <div><i class="fa-solid fa-user"></i>
                <h2>Users</h2>
            </div>
            <span><?php echo $user_count ?></span>
        </div>

        <div class="info">
            <div>
                <i class="fa-solid fa-utensils"></i>
                <h2>Orders</h2>
            </div>

            <span><?php echo $order_count ?></span>
        </div>
    </div>

</div>


<?php include 'inc/footer.php'; ?>