<?php
session_start();

// Database connection
$servername   = "localhost";
$db_username  = "root";
$db_password  = "";
$dbname       = "ch";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart items from the database
$sql = "SELECT * FROM cart";
$result = $conn->query($sql);

// Calculate total amount
$total_amount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $total_amount += $row["product_price"] * $row["quantity"];
    }
}

// Generate order ID (using timestamp and random number for uniqueness)
$order_id = 'ORD_' . time() . '_' . rand(1000, 9999);

// Store in session
$_SESSION['order_id'] = $order_id;
$_SESSION['total_amount'] = $total_amount;
$_SESSION['cart_items'] = [];

// Store cart items in session
if ($result->num_rows > 0) {
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
        $_SESSION['cart_items'][] = $row;
    }
}

// Redirect if "Place Order" button is clicked
if (isset($_POST['proceed_to_order'])) {
    $_SESSION['order_id'] = $order_id;
    $_SESSION['total_amount'] = $total_amount;
    
    // Store cart items with product details
    $cart_items = [];
    if ($result->num_rows > 0) {
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            $cart_items[] = [
                'product_id'   => $row['product_id'],
                'product_name' => $row['product_name'],
                'price'        => $row['product_price'],
                'quantity'     => $row['quantity'],
                'subtotal'     => $row['product_price'] * $row['quantity']
            ];
        }
    }
    $_SESSION['cart_items'] = $cart_items;

    // Redirect to Order.php
    header("Location: Order.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Cart - The Coffee Hub</title>
  <link rel="stylesheet" href="Style1.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
  
  <script>
    function confirmDelete() {
      return confirm("Are you sure you want to remove this item from your cart?");
    }
  </script>

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #c2b280;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #6F4E37;
      padding: 5px 6px;
      position: fixed;
      width: 100%;
      top: 0;
    }

    .header .logo img {
      width: 50px;
      height: auto;
    }

    .navbar {
      display: flex;
      gap: 20px;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      padding: 8px 10px;
    }

    .icons {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .icons i {
      color: white;
      font-size: 20px;
      cursor: pointer;
    }

    table {
      width: 90%;
      margin: 0 auto;
      border-collapse: collapse;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      overflow: hidden;
      background: white;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 12px;
      text-align: center;
    }
    th {
      background: #6F4E37;
      color: white;
      font-weight: bold;
    }
    tr:nth-child(even) {
      background-color: #f9f9f9;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    td[colspan="5"] {
      text-align: center;
      font-weight: bold;
      color: #6F4E37;
    }
    h1 {
      text-align: center;
      margin-top: 100px;
      color: #6F4E37;
    }

    .btn {
      padding: 10px 15px;
      background: #6F4E37;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.3s;
      display: inline-block;
    }
    .btn:hover {
      background: #56372e;
    }
    .action-btns {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin: 20px auto;
    }
    .footer {
      text-align: center;
      background: #6F4E37;
      color: white;
      padding: 10px;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
    .total-row {
        background-color: #f5f5f5;
        font-size: 1.1em;
    }
    .total-row td {
        padding: 15px;
    }
    .action-btns form {
        display: inline-block;
    }
    .action-btns button.btn {
        border: none;
        cursor: pointer;
        font-size: 1em;
    }
  </style>
</head>
<body>

<header class="header">
  <a href="index.php" class="logo">
    <img src="logo.jpg" alt="The Coffee Hub Logo" />
  </a>
  <nav class="navbar">
    <a href="index.php">Home</a>
    <a href="product.php">Products</a>
    <a href="contact.php">Contact</a>
  </nav>
  <div class="icons">
    <a href="search.php"><i class="fas fa-search"></i></a>
    <a href="cart.php"><i class="fas fa-shopping-cart"></i></a>
  </div>
</header>

<h1>Your Cart</h1>

<table>
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Price (₹)</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            $result->data_seek(0);
            while ($row = $result->fetch_assoc()) {
                $subtotal = $row["product_price"] * $row["quantity"];
                echo "<tr>
                        <td>{$row['product_id']}</td>
                        <td>{$row['product_name']}</td>
                        <td>₹" . number_format($row['product_price'], 2) . "</td>
                        <td>{$row['quantity']}</td>
                        <td>₹" . number_format($subtotal, 2) . "</td>
                        <td><a href='remove_from_cart.php?id={$row['product_id']}' class='btn' onclick='return confirmDelete()'>Remove</a></td>
                      </tr>";
            }
        } else {
            echo '<tr><td colspan="6">Your cart is empty.</td></tr>';
        }
        ?>
    </tbody>
</table>

<div class="action-btns">
    <a href="product.php" class="btn">Continue Shopping</a>
    <form method="POST">
        <button type="submit" name="proceed_to_order" class="btn">Place Order</button>
    </form>
</div>

<footer class="footer">&copy; 2024 The Coffee Hub. All rights reserved.</footer>

</body>
</html>
