<?php
ob_start();
include 'inc/navbar.php';


if (!isset($_SESSION['is_admin'])) {
    header('Location: signup.php');
    exit;
}


$query = 'SELECT users.name, users.email, orders.id, orders.order_date, orders.title, orders.price, orders.quantity, orders.served FROM orders JOIN users ON orders.user = users.id';


$result = mysqli_query($conn, $query);

$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

ob_end_flush();
?>

<div class="dashboard-container">
    <?php include 'inc/aside.php'; ?>

    <div class="dashboard-list-order">
        <h1>Orders</h1>

        <div>
            <table border="1" border-collapse>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>

                <?php foreach ($orders as $order) {

                    $checked = $order['served'] ? 'checked' : '';

                ?>

                    <tr>
                        <td><?php echo $order['id'] ?></td>
                        <td><?php echo $order['title'] ?></td>
                        <td><?php echo $order['quantity'] ?></td>
                        <td><?php echo $order['order_date'] ?></td>
                        <td><?php echo $order['name'] ?></td>
                        <td><?php echo $order['email'] ?></td>
                        <td>
                            <span id="span-<?php echo $order['id']; ?>"><?php echo $order['served']  ? 'Served' : 'Not served '; ?></span>
                            <input type="checkbox" <?php echo $checked ?> onchange="updateOrderStatus(event, <?php echo $order['id']; ?>)" id="checked-<?php echo $order['id'] ?>" />
                        </td>
                    </tr>
                <?php
                } ?>

            </table>
        </div>
    </div>

    <?php include 'inc/footer.php'; ?>