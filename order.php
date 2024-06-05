<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_SESSION['student_id'];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO orders (student_id, item_id, quantity) VALUES ('$student_id', '$item_id', '$quantity')";

    if (mysqli_query($conn, $sql)) {
        echo "Order placed successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<a href="student_dashboard.php">Back to Dashboard</a>