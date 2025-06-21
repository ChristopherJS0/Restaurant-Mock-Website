<?php
    session_start();
    $mysqli = new mysqli("localhost", "root", "", "restaurant");
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usernameInput = trim($_POST['username']);
        $passwordInput = trim($_POST['password']);

        $stmt = $mysqli->prepare("SELECT username, password FROM admin WHERE username = ?");
        $stmt->bind_param("s", $usernameInput);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            // Username exists, now check the password
            $stmt->bind_result($usernameDB, $passwordDB);
            $stmt->fetch();

            if ($passwordInput === $passwordDB) {
                $_SESSION['username'] = $usernameDB;
                $_SESSION['loggedin'] = true;
                // Redirect to dashboard or welcome page
                header("Location: dashboard.php");
                exit();
            } else {
                // Incorrect password, redirect back with error
                header("Location: admin_login.php?error=Incorrect+password");
                exit();
            }
        } 
        else {
            // Username not found, redirect back with error
            header("Location: admin_login.php?error=Admin+not+found");
            exit();
        }
    }
    else{
        // Redirect to login page if not logged in
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header("Location: admin_login.php?error=Please+login+to+access+the+dashboard");
            exit();
        }
        elseif (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            header("Location: dashboard.php");
            exit();
        }
    }
?>