<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include('config.php');
include('navbar.php');

// Fetch menu items
$sql = "SELECT * FROM menu_items";
$menu_items = mysqli_query($conn, $sql);

// Fetch orders
$sql = "SELECT o.id, s.name AS student_name, m.name AS item_name, o.quantity, o.order_date 
        FROM orders o 
        JOIN students s ON o.student_id = s.id 
        JOIN menu_items m ON o.item_id = m.id";
$orders = mysqli_query($conn, $sql);
?>

<h1>Admin Dashboard</h1>
<p>Manage Canteen and Student Information</p>

<h2>Menu Items</h2>
<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Actions</th>
    </tr>
    <?php while ($item = mysqli_fetch_assoc($menu_items)) : ?>
        <tr>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['description']; ?></td>
            <td><?php echo $item['price']; ?></td>
            <td>
                <a href="edit_item.php?id=<?php echo $item['id']; ?>">Edit</a>
                <a href="delete_item.php?id=<?php echo $item['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="add_item.php">Add New Item</a>

<h2>Orders</h2>
<table>
    <tr>
        <th>Order ID</th>
        <th>Student Name</th>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Order Date</th>
    </tr>
    <?php while ($order = mysqli_fetch_assoc($orders)) : ?>
        <tr>
            <td><?php echo $order['id']; ?></td>
            <td><?php echo $order['student_name']; ?></td>
            <td><?php echo $order['item_name']; ?></td>
            <td><?php echo $order['quantity']; ?></td>
            <td><?php echo $order['order_date']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="logout.php">Logout</a>