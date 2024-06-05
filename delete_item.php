<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('config.php');

$id = $_GET['id'];
$sql = "DELETE FROM menu_items WHERE id='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: admin_dashboard.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
