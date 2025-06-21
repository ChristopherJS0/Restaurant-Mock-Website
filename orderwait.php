<?php
    session_start();

    // Check if order has already been placed.
    function orderAlreadyPlaced($mysqli) {
            
        // Check if this session already submitted an order
        $orderID = null;
        if (isset($_SESSION['orderID'])) {
            $previousOrderID = $_SESSION['orderID'];
            $count = 0;

            // Look up the order in the database
            $stmt = $mysqli->prepare("SELECT COUNT(*) FROM orders WHERE orderID = ?");
            $stmt->bind_param("i", $previousOrderID);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();

            if ($count > 0) {
                echo "<p>You have already submitted an order with ID: $previousOrderID</p>";
                $orderID = $previousOrderID;
                $customerName = isset($_SESSION['customerName']) ? $_SESSION['customerName'] : "";
            }
        }
        return $orderID;
    }
    // Check if this customer exists in the database - doesn't account for guest users
    function customerExists($mysqli, $customerName) {
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $customerName);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0;
    }
    // Get the userID of an existing customer
    function getOldUserID($mysqli, $customerName) {
        // Check if the customer already exists
        $userID = null;
        $stmt = $mysqli->prepare("SELECT userID FROM users WHERE username = ?");
        $stmt->bind_param("s", $customerName);
        $stmt->execute();
        $stmt->bind_result($userID);
        $stmt->fetch();
        $stmt->close();

        return $userID;
    }
    // === Insert into `orders` ===
    function createOrder($mysqli, $customerName) {
         
        // === Insert into `users` ===
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
            // === Check if $customerName already exists as a user in the users table.      
            $stmt = $mysqli->prepare("INSERT INTO users (username) VALUES (?)");
            $stmt->bind_param("s", $customerName);
            $stmt->execute();
            $userID = $mysqli->insert_id;
        }

        $status = "pending";
        $stmt = $mysqli->prepare("INSERT INTO orders (userID, status) VALUES (?, ?)");
        $stmt->bind_param("is", $userID, $status);
        $stmt->execute();
        $orderID = $mysqli->insert_id;

        // === Decode cart and insert into `orderitems` ===
        $cartItems = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

        foreach ($cartItems as $index => $item) {
            $itemName = $item['name'];
            $itemNote = isset($_POST['description'][$index]) ? trim($_POST['description'][$index]) : null;
            $descriptions = isset($_POST['descriptions']) ? $_POST['descriptions'] : [];

            $stmt = $mysqli->prepare("INSERT INTO orderitems (orderID, itemName, itemDescription) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $orderID, $itemName, $itemNote);
            $stmt->execute();
        }
        // === Store order ID in session (optional for tracking) ===
        return $orderID;
    }
    // === Create order for existing user ===
    function createOrderForExistingUser($mysqli, $userID) {
        $status = "pending";
        $stmt = $mysqli->prepare("INSERT INTO orders (userID, status) VALUES (?, ?)");
        $stmt->bind_param("is", $userID, $status);
        $stmt->execute();
        $orderID = $mysqli->insert_id;

        // === Decode cart and insert into `orderitems` ===
        $cartItems = isset($_POST['cart_data']) ? json_decode($_POST['cart_data'], true) : [];

        foreach ($cartItems as $index => $item) {
            $itemName = $item['name'];
            $itemNote = isset($_POST['description'][$index]) ? trim($_POST['description'][$index]) : null;
            $descriptions = isset($_POST['descriptions']) ? $_POST['descriptions'] : [];

            $stmt = $mysqli->prepare("INSERT INTO orderitems (orderID, itemName, itemDescription) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $orderID, $itemName, $itemNote);
            $stmt->execute();
        }
        // === Store order ID in session (optional for tracking) ===
        return $orderID;
    }

    // === Connect to DB ===
    $mysqli = new mysqli("localhost", "root", "", "restaurant");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // === Process customer name ===
    $customerName = isset($_POST['customerName']) && !empty(trim($_POST['customerName']))
        ? trim($_POST['customerName'])
        : "";
    $_SESSION['customerName'] = $customerName;

    $orderID = orderAlreadyPlaced($mysqli);
    $oldCustomer = customerExists($mysqli, $customerName);

    if ($orderID === null) {
        // If no order ID was returned, it means an an order has not been placed yet.
        if (!$oldCustomer) {
            // If the customer does not exist, create a new order
            $orderID = createOrder($mysqli, $customerName);
        } else {
            // If the customer exists, retrieve their userID
            $userID = getOldUserID($mysqli, $customerName);
            // Create a new order for the existing user
            $orderID = createOrderForExistingUser($mysqli, $userID);
        }
        $_SESSION['orderID'] = $orderID;
    }
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
        <h2>Your order ID is <?= $orderID ?>.</h2>
        <p>Your order has been received. We're preparing it now.</p>  
        <a href="menu.php">Back to Menu</a>
    </div>
</body>
</html>