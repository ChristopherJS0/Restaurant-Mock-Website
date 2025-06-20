<?php
// Start PHP section to get cart data sent from previous page
session_start();
$cartItems = [];
$totalPrice = 0.00;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cart_data'])) {
    $cartJson = $_POST['cart_data'];
    $cartItems = json_decode($cartJson, true);

    // Calculate total price server-side (optional, for security)
    foreach ($cartItems as $item) {
        $totalPrice += floatval($item['price']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout</title>
    <link rel="stylesheet" href="css/checkout.css" />
</head>
<body>

    <h1>Checkout</h1>

    <form id="checkout-form" method="POST" action="orderwait.php">
        <label for="customerName">Enter your name (optional):</label><br/>
        <input type="text" id="customerName" name="customerName" placeholder="Leave blank to be saved as Guest123" /><br/><br/>

        <h2>Your Order</h2>
        <table id="order-table">
            <thead>
            <tr><th>Item Name</th><th>Price</th><th>Note</th><th>Remove</th></tr>
            </thead>
            <tbody>
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $index => $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>$<?= number_format(floatval($item['price']), 2) ?></td>
                    <td><input type="text" name="description[<?= $index ?>]" ></td>
                    <td><button type="button" class="remove-btn">Remove</button></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4">Your cart is empty.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

        <p><strong>Total: $<span id="total-price"><?= number_format($totalPrice, 2) ?></span></strong></p>

        <!-- Hidden inputs to send updated cart data -->
        <input type="hidden" name="cart_data" id="cartDataInput" value="<?= htmlspecialchars(json_encode($cartItems)) ?>" />
        <input type="hidden" name="totalPrice" id="totalPriceInput" value="<?= number_format($totalPrice, 2) ?>" />
        <button type="submit">Submit Order</button>
    </form>
    <script src="js/checkoutBehavior.js"></script>

</body>
</html>