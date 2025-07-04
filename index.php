<!-- RESTAURANT STARTUP SCREEN -->
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salinas Restaurant</title>
    <link rel="stylesheet" href="css/indexStyling.css">
</head>


<body>
    <!-- Content goes here -->
    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="admin_login.php">Admin Login</a></li>
        </ul>
    </nav>
    <!-- Salinas Image -->

    <!-- Heading below main image. -->
    <h1>Welcome to Salinas Restaurant</h1>

    <!-- About Us Content-->
    <h2 class="center-text">About Us</h2>
    <h3 class="center-text">Our Staff</h3>
    <p>With over 20 years of experience cooking in the finest 
        restaurants, our chef is excited to present their vision 
        to you and all our guests. Our caring and committed staff 
        make sure you have a fantastic experience with us.</p>
    
    <h3 class="center-text">Dine In, Take Out & Catering Available</h3>
    <p>We have worked to package our meals in a way that lets
        you bring the quality of our meals into your home. 
        We always love seeing you in person, but even when we 
        can't, we ensure that your dining experience is top 
        notch! </p>
    
        <!-- Link the JS file just before the closing body tag -->
    <script src="js/cartBehavior.js"></script>
</body>
</html>