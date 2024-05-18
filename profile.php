<?php
ob_start();
include 'inc/navbar.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: signup.php');
    exit;
}

$query = 'SELECT * from orders WHERE user=' . $_SESSION['user_id'];


$result = mysqli_query($conn, $query);

$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $id = $_SESSION['user_id'];
    if ($password == '') {
        $query = "UPDATE users SET name='$name' WHERE email='$email' AND id=$id";

        $result = mysqli_query($conn, $query);
    } else {
        $query = "UPDATE users SET name='$name', password='$password' WHERE email='$email' AND id=$id";

        $result = mysqli_query($conn, $query);
    }

    setcookie('name', $name, time() + 60 * 60 * 24 * 30);
    setcookie('email', $email, time() + 60 * 60 * 24 * 30);
}

ob_end_flush();
?>

<div class="profile-container">
    <div class="profile">
        <h1>Profile</h1>
        <i class="fa-solid fa-pen-to-square edit-profile" data-status="edit" onclick="editProfile()"></i>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input name="email" value="<?php echo $_COOKIE['email']; ?>" readonly id="profile-email" />
            <input type="text" value="<?php echo $_COOKIE['name']; ?>" class="profile-input" id="profile-name" name="name">
            <input type="text" placeholder="Enter new password here" class="profile-input" id="profile-pass" name="password">

            <input type="submit" value="Update Profile" name="submit">
        </form>

    </div>

    <div class="orders">
        <h2>Orders</h2>

        <table border="1">
            <tr>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php
            foreach ($orders as $order) { ?>
                <tr>
                    <td><?php echo $order['title'] ?></td>
                    <td><?php echo $order['quantity'] ?></td>
                    <td><?php echo $order['price'] ?></td>
                    <td><?php echo $order['order_date'] ?></td>
                    <td><?php echo $order['served'] ? 'Served' : 'Not served' ?></td>
                </tr>
            <?php
            }
            ?>
        </table>

    </div>
</div>

<?php
include 'inc/footer.php'; ?>