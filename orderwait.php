<?php
    session_start();

    // === [1] Connect to DB ===
    $mysqli = new mysqli("localhost", "root", "", "restaurant");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // === [2] Process customer name ===
    $customerName = isset($_POST['customerName']) && !empty(trim($_POST['customerName']))
        ? trim($_POST['customerName'])
        : "";
    $_SESSION['customerName'] = $customerName;

    // === [3] Insert into `users` ===
    if ($customerName === "") {
        // Generate guest name (e.g., Guest123 based on ID)
        $stmt = $mysqli->prepare("INSERT INTO users (username) VALUES ('')");
        $stmt->execute();
        $userID = $mysqli->insert_id;
        $guestName = "Guest" . $userID;

        // Update username with GuestID
        $stmt = $mysqli->prepare("UPDATE users SET username = ? WHERE userID = ?");
        $stmt->bind_param("si", $guestName, $userID);
        $stmt->execute();

        $customerName = $guestName;
    } else {
        $stmt = $mysqli->prepare("INSERT INTO users (username) VALUES (?)");
        $stmt->bind_param("s", $customerName);
        $stmt->execute();
        $userID = $mysqli->insert_id;
    }

    // === [4] Insert into `orders` ===
    $status = "pending";
    $stmt = $mysqli->prepare("INSERT INTO orders (userID, status) VALUES (?, ?)");
    $stmt->bind_param("is", $userID, $status);
    $stmt->execute();
    $orderID = $mysqli->insert_id;

    // === [5] Decode cart and insert into `orderitems` ===
    $cartItems = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

    foreach ($cartItems as $index => $item) {
        $itemName = $item['name'];
        $itemNote = isset($_POST['description'][$index]) ? trim($_POST['description'][$index]) : null;
        $descriptions = isset($_POST['descriptions']) ? $_POST['descriptions'] : [];

        $stmt = $mysqli->prepare("INSERT INTO orderitems (orderID, itemName, itemDescription) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $orderID, $itemName, $itemNote);
        $stmt->execute();
    }

    // === [6] Store order ID in session (optional for tracking) ===
    $_SESSION['orderID'] = $orderID;
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
        <h2>Your order id is <?= $orderID ?>.</h2>
        <p>Your order has been received. We're preparing it now.</p>
        <p> Keep your name and order number handy 
            if you'd like to check your order status again!</p>   
        <a href="menu.php">Back to Menu</a>
    </div>

</body>
</html>