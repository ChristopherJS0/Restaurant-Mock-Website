<?php

$mysqli = new mysqli("localhost", "root", "", "restaurant");
if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['orderID'], $_POST['action'])) {
    $orderID = intval($_POST['orderID']);
    $action = $_POST['action'];

    if ($action === 'fulfill') {
        $newStatus = 'fulfilled';
    } elseif ($action === 'cancel') {
        $newStatus = 'cancelled';
    } else {
        die("Invalid action.");
    }

    $stmt = $mysqli->prepare("UPDATE orders SET status = ? WHERE orderID = ?");
    $stmt->bind_param("si", $newStatus, $orderID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Order #$orderID updated to $newStatus.";
    } else {
        echo "No update made. (Order may not exist or is already updated.)";
    }

    $stmt->close();
    // Optional: Redirect back to dashboard
    header("Location: dashboard.php");
    exit;
} else {
    echo "Invalid request.";
}