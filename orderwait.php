<?php
session_start();

$customerName = isset($_POST['customerName']) && !empty(trim($_POST['customerName']))
    ? trim($_POST['customerName'])
    : " ";
$_SESSION['customerName'] = $customerName;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You for Your Order</title>
    <link rel="stylesheet" href="css/orderwait.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<div class="thank-you-box">
    <h1>Thank you<?= ($name = trim($customerName)) ? " $name" : "" ?>!</h1>
    <p>Your order has been received. We're preparing it now.</p>
    <p> Keep your name and order number handy 
        if you'd like to check your order status again!</p>   
    <a href="menu.php">Back to Menu</a>
</div>



</body>
</html>