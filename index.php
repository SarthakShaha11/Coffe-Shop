<?php
// index.php

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
$sql = "SELECT product_id, name, price, image FROM Product";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>THE COFFEE HUB</title>
  <link rel="stylesheet" href="Style-1.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <style>
    /* General Styling */
    body {
      font-family: Arial, sans-serif;
      background-color: #C4A484; /* Coffee-like beige color */
      background-image: url('path/to/your/coffee-image.jpg'); /* Background image */
      background-size: cover; /* Cover the entire background */
      background-position: center; /* Center the image */
      margin: 0;
      padding: 0;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #6F4E37;
      padding: 1px 0px;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 50;
    }

    .header .logo img {
      width: 60px;
      height: auto;
    }

    .navbar {
      display: flex;
      gap: 15px;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      padding: 8px 12px;
    }

    /* Icons */
    .icons {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .icons i {
      color: white;
      font-size: 24px;
      cursor: pointer;
    }

    /* Search bar */
    .search-form {
      display: none;
    }

    /* Hero Section */
    .home {
      text-align: center;
      padding: 120px 20px 50px;
    }

    .home img {
      width: 100%;
      max-width: 700px;
      height: auto;
      border-radius: 10px;
    }

    /* Buttons */
    .btn, button {
      display: inline-block;
      padding: 12px 20px;
      margin-top: 10px;
      background: #6F4E37;
      color: white;
      border: none;
      cursor: pointer;
      text-decoration: none;
      font-size: 16px;
      border-radius: 5px;
    }

    button {
      margin-left: 10px;
    }

    /* Footer */
    .footer {
      text-align: center;
      background: #6F4E37;
      color: white;
      padding: 2px;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
  </style>
</head>

<body>

<header class="header">
  <a href="index.html" class="logo">
    <img src="logo.jpg" alt="The Coffee Hub Logo">
  </a>

  <nav class="navbar" aria-label="Main Navigation">
    <a href="index.php">Home</a>
    <a href="Product.php">Products</a>
    <a href="contact.php">Contact</a>
  </nav>

  <div class="icons">
    <i class="fas fa-search" id="search-btn"></i>
   <a herf="cart.php"><i class="fas fa-shopping-cart" id="cart-btn"></i></a>
  </div>
</header>

<section class="home" id="home">
  <div class="content">
    <img src="bg.jpg" alt="Background Image">
    <h3>Fresh Coffee in the Morning</h3>
    <p>Experience the rich and bold flavors of our exquisite coffee blends, crafted to awaken your senses and start your day right. We roast the best organic coffee! Experience the highest quality 100% Arabica coffee beans from along the equatorial belt. We focus on roasting delicious certified organic coffee and Fair Trade Certified coffee. Indulge yourself and drink the best organic coffee!</p>
    <a href="contact.php" class="btn">Get it now</a> <br>

    <a href="Product.php" class="btn">Product</a>
  </div>
</section>



<footer class="footer">
  <p>&copy; 2024 The Coffee Hub. All rights reserved.</p>
</footer>

<script src="Script-1.js"></script>

</body>
</html>
