<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_number = $_POST['roll_number'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE roll_number = '$roll_number'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['student_id'] = $row['id'];
        header("Location: student_dashboard.php");
    } else {
        echo "Invalid login credentials";
    }
}
?>

<form method="post" action="">
    Roll Number: <input type="text" name="roll_number" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Login">
</form>