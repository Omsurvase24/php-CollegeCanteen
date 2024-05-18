<?php
ob_start();

include 'inc/navbar.php';

if (isset($_SESSION['used_id'])) {
    header('Location: index.php');
    exit;
}

$error = "";

if (isset($_POST['submit'])) {
    $error = "";

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $error = "Email already in use.";
    } else {
        $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $id = mysqli_insert_id($conn);

            $_SESSION['user_id'] = $id;


            setcookie('name', $name, time() + 60 * 60 * 24 * 30);
            setcookie('email', $email, time() + 60 * 60 * 24 * 30);

            header('Location: index.php');
            exit;
        } else {
            echo 'Error occured';
        }
    }

    mysqli_close($conn);
}

ob_end_flush();
?>


<div class="auth-container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="auth-form">
        <h1>Signup</h1>
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>
        <input type="submit" value="Submit" name="submit">

        <p><?php echo $error?></p>

        <a href="login.php">Click here to login</a>

    </form>
</div>