<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ECommerce</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Great+Vibes&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <nav class="navbar">
      <h1><a href="#">Grab Your Meal</a></h1>
      <ul class="links">
        <li><a href="" class="link">Home</a></li>
        <li><a href="" class="link">Menu</a></li>
      </ul>
      <div id="your-cart-btn">
        <i class="fa-solid fa-cart-shopping"></i>
        <div class="cart-item-no">0</div>
      </div>
    </nav>
    <section class="menu" id="menu">
      <div class="heading">
        <h1 class="title">Our Menu</h1>
        <div class="btns"></div>
      </div>
      <div class="menu-container"></div>
    </section>
    <aside class="cart-overlay">
      <div class="cart">
        <i class="fa fa-remove"></i>
        <h1>Your Cart</h1>
        <div class="cart-content"></div>
        <div class="cart-footer">
          <h3>Your Total: $<span class="cart-total">99.98</span></h3>
          <button class="clear-cart">Clear Cart</button>
        </div>
      </div>
    </aside>
    <script src="./app.js"></script>
  </body>
</html>
