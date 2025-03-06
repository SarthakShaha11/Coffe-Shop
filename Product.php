<?php
// index.php
// You can add PHP logic here if needed before the HTML output.

session_start(); // Add this at the top

// Database connection
$servername   = "localhost";
$db_username  = "root";
$db_password  = "";
$dbname       = "ch";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT product_id, name, price, image FROM product";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>THE COFFEE HUB</title>
  <link rel="stylesheet" href="Style-1.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <style>
    /* Global Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #d9c9b2; /* Updated to a coffee-related background color */
    }
    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #6F4E37;
      padding: 5px 6px;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 50;
    }
    .header .logo img {
      width: 50px;
      height: auto;
    }
    .navbar a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-size: 18px;
    }
    .icons i {
      color: white;
      font-size: 20px;
      margin-left: 15px;
      cursor: pointer;
      background-color: #6F4E37; /* Coffee related background color */
    }
    /* Products Section */
    .products {
      text-align: center;
      padding: 100px 20px 80px; /* extra bottom padding if needed */
      margin-top: 60px;
    }
    .products h1 {
      margin-bottom: 40px;
      color: #333;
    }
    .box-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 items per row */
        gap: 20px;
        justify-content: center;
    }

    /* Responsive Design */
    @media (max-width: 900px) {
        .box-container {
            grid-template-columns: repeat(2, 1fr); /* 2 per row on tablets */
        }
    }

    @media (max-width: 600px) {
        .box-container {
            grid-template-columns: repeat(1, 1fr); /* 1 per row on mobile */
        }
    }

    .box {
      background: white;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s, box-shadow 0.2s;
      cursor: pointer;
      position: relative;
    }
    .box:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    .box img {
      width: 100%;
      height: 120px;
      object-fit: cover;
      border-radius: 10px;
    }
    .box h3 {
      margin: 10px 0;
      color: #6F4E37;
    }
    .box p {
      margin: 5px 0 15px;
      font-weight: bold;
      color: #6F4E37;
      font-size: 1.2em;
    }
    .btn {
      background: #6F4E37;
      color: white;
      padding: 8px 15px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 16px;
    }
    .btn:hover {
      background: #56372e;
    }
    /* Footer */
    .footer {
      text-align: center;
      background: #6F4E37;
      color: white;
      padding: 5px;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
    
    /* Price styling */
    .price {
        color: #6F4E37;
        font-size: 1.3em;
        font-weight: bold;
        margin: 10px 0;
        display: block;
    }

    /* Optional: Add a subtle animation on price hover */
    .box:hover .price {
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }

    .button-container {
        display: flex;
        gap: 10px;
        justify-content: center;
        margin-top: 10px;
    }

    .action-form {
        display: inline-block;
    }

    .btn.add-btn {
        background: #6F4E37;
    }

    .btn.remove-btn {
        background: #dc3545;
    }

    .btn.remove-btn:hover {
        background: #bb2d3b;
    }

    .message {
        background: #f8d7da;
        color: #842029;
        padding: 10px;
        margin: 10px auto;
        border-radius: 5px;
        max-width: 600px;
        text-align: center;
        animation: fadeOut 5s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        70% { opacity: 1; }
        100% { opacity: 0; }
    }

    .button-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 15px;
    }

    .add-btn {
        background: #6F4E37;
    }

    .remove-btn {
        background: #dc3545;
        border: none;
        cursor: pointer;
    }

    .remove-btn:hover {
        background: #bb2d3b;
    }

    .alert {
        padding: 15px;
        margin: 20px auto;
        border-radius: 4px;
        max-width: 600px;
        text-align: center;
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
        position: fixed;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        animation: fadeOut 5s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        70% { opacity: 1; }
        100% { opacity: 0; visibility: hidden; }
    }

    .no-products {
        text-align: center;
        color: #6F4E37;
        font-size: 1.2em;
        margin: 20px 0;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header class="header">
    <a href="index.php" class="logo">
      <img src="logo.jpg" alt="The Coffee Hub Logo" />
    </a>
    <nav class="navbar" aria-label="Main Navigation">
      <a href="index.php">Home</a>
      <a href="Product.php">Products</a>
      <a href="Contact.php">Contact</a>
    </nav>
    <div class="icons">
      <i class="fas fa-search" id="search-btn"></i>
      <!-- Shopping Cart icon; when clicked, sends the user to add_to_cart.html -->
      <a href="cart.php"> <i class="fas fa-shopping-cart" id="cart-btn"></i></a>
    </div>
  </header>

  <!-- Products Section -->
  <section class="products" id="products">
    <h1>Our Products</h1>

    
    
    <div class="box-container">
      <?php
      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          ?>
          <div class="box">
            <img src="<?php echo htmlspecialchars($row["image"]); ?>" alt="<?php echo htmlspecialchars($row["name"]); ?>" />
            <h3><?php echo htmlspecialchars($row["name"]); ?></h3>
            <p>₹<?php echo number_format($row["price"], 2); ?></p>
            <div class="button-group">
              <!-- Add to Cart Form -->
              <form action="add_to_cart.php" method="POST" onsubmit="return addProductToCart();">
                <input type="hidden" name="product_id" value="<?php echo $row["product_id"]; ?>">
                <input type="hidden" name="name" value="<?php echo htmlspecialchars($row["name"]); ?>">
                <input type="hidden" name="price" value="<?php echo $row["price"]; ?>">
                <button type="submit" class="btn add-btn">Add to Cart</button>
              </form>
              
            
              </form>
            </div>
          </div>
          <?php
        }
      } else {
        echo "<p class='no-products'>No products available.</p>";
      }
      ?>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; 2024 The Coffee Hub. All rights reserved.</p>
  </footer>

  <script>
    function confirmRemove() {
        return confirm("Are you sure you want to remove this product? This action cannot be undone.");
    }

    // Auto-hide alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.getElementsByClassName('alert');
        if (alerts.length > 0) {
            setTimeout(function() {
                for (let alert of alerts) {
                    alert.style.display = 'none';
                }
            }, 5000);
        }
    });

    function addProductToCart() {
        alert("Product added to cart successfully!");
        return true;
    }

    // (Optional) Other icon listeners
    document.getElementById("menu-btn").addEventListener("click", function() {
      alert("Menu button clicked");
    });
    document.getElementById("search-btn").addEventListener("click", function() {
      alert("Search functionality coming soon");
    });
  </script>
</body>
</html> 