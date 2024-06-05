<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $roll_number = $_POST['roll_number'];
    $branch = $_POST['branch'];
    $year_of_study = $_POST['year_of_study'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO students (name, roll_number, branch, year_of_study, password) VALUES ('$name', '$roll_number', '$branch', '$year_of_study', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registeration</title>
    <link rel="stylesheet" href="auth.css">
</head>

<body>
    <form method="post" action="">
        Name: <input type="text" name="name" required><br>
        Roll Number: <input type="text" name="roll_number" required><br>
        Branch: <input type="text" name="branch" required><br>
        Year of Study: <input type="number" name="year_of_study" required><br>
        Password: <input type="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</body>

</html>