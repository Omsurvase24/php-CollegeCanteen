<?php
include 'inc/navbar.php' ?>

<div class="cart-container">
    <h1>Cart</h1>

    <p class="empty-cart-warning">Cart is empty <a href="index.php">Click here to see all food.</a></p>

    <div class="cart-items">

    </div>

    <h4 class="subtotal"></h4>



    <?php if (isset($_SESSION['user_id'])) { ?>
        <button onclick="handlePlaceOrder()" id="place-order">Place Order <i class="fa-solid fa-chevron-right"></i></button>
    <?php } else { ?>

        <p class="empty-cart-warning">Login in to place order <a href="login.php">Click here.</a></p>

    <?php } ?>

</div>

<?php include 'inc/footer.php' ?>