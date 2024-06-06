<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    $sql = "DELETE FROM orders WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $order_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Order has been marked as served.";
    } else {
        $_SESSION['message'] = "Failed to mark order as served.";
    }

    mysqli_stmt_close($stmt);
}


header("Location: admin_dashboard.php");
exit();
