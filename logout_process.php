<?php
    session_start();
    session_unset();
    session_destroy();

    // Optional: redirect to login page
    header("Location: index.php?message=You+have+logged+out+successfully");
exit();