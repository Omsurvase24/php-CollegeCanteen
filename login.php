<?php
ob_start();
include 'inc/navbar.php';

$error = "";

if (isset($_POST['submit'])) {
    $error = "";
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(strlen($email) == 0 || strlen($password) ==0) {
        $error = "Email and password must not empty";
    }

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";

    $result = mysqli_query($conn, $query);


    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        setcookie('name', $row['name'], time() + 60 * 60 * 24 * 30);
        setcookie('email', $email, time() + 60 * 60 * 24 * 30);

        $_SESSION['user_id'] = $row['id'];

        if ($row['is_admin']) {
            $_SESSION['is_admin'] = $row['is_admin'];
        }


        header('Location: index.php');
        exit;
    } else {
        $error = "Please enter correct credentials";
    }

    mysqli_close($conn);
}

ob_end_flush();
?>


<div class="auth-container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="auth-form">
        <h1>Login</h1>
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

        <a href="signup.php">Click here to signup</a>
    </form>

    
</div>