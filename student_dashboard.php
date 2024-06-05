<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');
include('navbar.php');

// Fetch student data
$student_id = $_SESSION['student_id'];
$sql = "SELECT * FROM students WHERE id = $student_id";
$result = mysqli_query($conn, $sql);
$student = mysqli_fetch_assoc($result);

// Fetch menu items
$sql = "SELECT * FROM menu_items";
$menu_items = mysqli_query($conn, $sql);
?>

<div class="welcome">
    <h1>Welcome, <?php echo $student['name']; ?></h1>
    <p>Roll Number: <?php echo $student['roll_number']; ?></p>
    <p>Branch: <?php echo $student['branch']; ?></p>
    <p>Year of Study: <?php echo $student['year_of_study']; ?></p>
</div>

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
                <form method="post" action="order.php">
                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                    <input type="number" name="quantity" min="1" value="1" required>
                    <input type="submit" value="Order">
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>