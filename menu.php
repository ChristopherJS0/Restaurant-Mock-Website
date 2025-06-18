<?php
  session_start();
  $menu = simplexml_load_file("data/menuItem.xml");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Menu</title>
    <link rel="stylesheet" href="css/menu.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
  </head>
  <body>
    <nav>
      <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="menu.php">Menu</a></li>
      </ul>
    </nav>

    <!-- Main content area -->
    <div class="main-content">
      <h1>Menu</h1>
      <div id="main-content">
        <?php foreach ($menu->category as $category): ?>
          <section>
            <h2><?= $category['name'] ?></h2>      
            <?php foreach ($category->item as $item): ?>
              <div class="menu-item"
                data-name="<?= htmlspecialchars($item->name) ?>"
                data-price="<?= htmlspecialchars($item->price) ?>">  
                
      
                <h3><?= $item->name?></h3>
                <p><?= $item->description?></p>
                <p>Price: $<?= number_format((float)$item->price, 2) ?></p>      
              </div>
            <?php endforeach; ?>   
          </section>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Static sidebar for cart -->
    <form id="order-form" action="checkout.php" method="POST">
      
      <input type="hidden" name="cart_data" id="cart-data">
      <input type="hidden" name="total_amount" id="total-amount-input">

      <div class="cart-sidebar">
        <div>
          <div class="cart-header">Cart</div>
          <div class="cart-items">
                <!-- Cart items will be dynamically added here -->
          </div>
        </div>
        <div id="cart-total">
          <strong>Total:</strong> $<span id="total-amount">0.00</span>
        </div>
        <button type="submit" class="checkout-button">Continue to Checkout</button>
      </div>

    </form>

    <script src="js/cartBehavior.js"></script>          
  </body>
</html>