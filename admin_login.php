<?php
session_start();
?>

<!-- Simple HTML Form -->
<!DOCTYPE html>
<html>
<head><title>Admin Login</title></head>
<body>
    <!-- Optional: Show error from URL query string -->
    <?php if (!empty($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>
    <h2>Admin Login</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post" action="login_process.php">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>