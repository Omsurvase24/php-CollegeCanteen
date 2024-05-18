<?php
include 'config/database.php';

session_start();

?>


<html>

<head>
    <title>Modern Canteen</title>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <a href="index.php">
            <h2>Modern Canteen</h2>
        </a>

        <ul>
            <li><a href="cart.php"><i class="fa-solid fa-cart-plus"></i>Cart</a></li>

            <?php echo isset($_SESSION['user_id']) ? '<li><a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a></li>' : '' ?>

            <?php echo isset($_SESSION['user_id']) ? '' : '<li><a href="login.php" class="header-btn">Login</a></li>
            <li><a href="signup.php" class="header-btn">Signup</a></li>' ?>

            <?php echo isset($_SESSION['user_id']) ? '<li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>' : '' ?>

        </ul>
    </header>