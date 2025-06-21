<?php
    session_start();
    $mysqli = new mysqli("localhost", "root", "", "restaurant");
    
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: admin_login.php?error=Please+login+to+access+the+dashboard");
        echo "<h1>Access Denied</h1>";
        exit();
    }
    elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        echo "<h1>Welcome, " . htmlspecialchars($_SESSION['username']) . "</h1>";
        // Fetch all orders
        $result = $mysqli->query("SELECT orderID, userID, status, orderDate FROM orders ORDER BY orderDate DESC");
        if (!$result) {
            die("Query failed: " . $mysqli->error);
        }
    }
?>

<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
    <h2>Order Dashboard</h2>

    <table border="1" cellpadding="5">
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Status</th>
            <th>Order Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?= $row['orderID'] ?></td>
                <td><?= $row['userID'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['orderDate'] ?></td>
                <td>
                    <?php 
                        if ($row['status'] === 'pending') { 
                            echo '<form style="display:inline;" method="post" action="update_order.php">
                                    <input type="hidden" name="orderID" value="' . htmlspecialchars($row['orderID']) . '">
                                    <button name="action" value="fulfill">Fulfill</button>
                                    <button name="action" value="cancel">Cancel</button>
                                </form>';
                        }
                        elseif ($row['status'] === 'fulfilled'){echo "<em>Order Completed</em>";}
                        elseif ($row['status'] === 'cancelled'){ echo "<em>Order Cancelled</em>";}
                        else{ echo "<em>Order Pending</em>";}
                    ?>
                </td>
            </tr>
        <?php endwhile;?>
    </table>
    <p><a href="logout_process.php">Logout and Return Home</a></p>
</body>
</html>