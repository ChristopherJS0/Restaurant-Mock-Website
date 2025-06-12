<?php $menu = simplexml_load_file("data/menuItem.xml");
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
          <li><a href="index.html">Home</a></li>
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
    <div class="cart-sidebar">
      <div>
        <div class="cart-header">Cart</div>
        <div class="cart-items">
          
        </div>
      </div>
      <button class="checkout-button">Submit Order</button>
    </div>
    <script src="js/cartBehavior.js"></script>          
  </body>
</html>