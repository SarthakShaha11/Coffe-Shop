<?php
session_start();

// Check if order details exist
if (!isset($_SESSION['order_id']) || !isset($_SESSION['delivery_details']) || !isset($_SESSION['cart_items'])) {
    header("Location: cart.php");
    exit();
}

// Get session data
$order_id = $_SESSION['order_id'];
$delivery_details = $_SESSION['delivery_details'];
$cart_items = $_SESSION['cart_items'];

// Calculate total amount
$total_amount = 0;
foreach ($cart_items as $item) {
    // Ensure price and quantity are set
    $price = $item['price'] ?? 0; // Default to 0 if not set
    $quantity = $item['quantity'] ?? 0; // Default to 0 if not set
    $total_amount += $price * $quantity;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['proceed_payment'])) {
        header("Location: payment.php");
        exit();
    } elseif (isset($_POST['cancel_order'])) {
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ch";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert into cancellation table
        $stmt = $conn->prepare("INSERT INTO cancelation (order_id, price) VALUES (?, ?)");
        $stmt->bind_param("id", $order_id, $total_amount);
        $stmt->execute();

        // Delete from orders table
        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();

        // Clear session variables
        unset($_SESSION['order_id']);
        unset($_SESSION['total_amount']);
        unset($_SESSION['cart_items']);
        unset($_SESSION['delivery_details']);

        header("Location: cart.php"); // Redirect to cart page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order - The Coffee Hub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #c2b280;
            margin: 0;
            padding: 20px;
        }
        .confirmation-container {
            max-width: 600px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #6F4E37;
            margin-bottom: 30px;
        }
        .order-summary {
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 4px;
            text-align: left;
        }
        .order-summary h2 {
            color: #6F4E37;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #6F4E37;
            color: white;
        }
        .total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
            color: #6F4E37;
        }
        .btn {
            padding: 12px 25px; /* Padding for the button */
            border: none; /* Remove default border */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Change cursor to pointer on hover */
            font-size: 16px; /* Font size */
            font-weight: bold; /* Bold text */
            transition: background 0.3s, transform 0.3s; /* Smooth transition for background and transform */
        }

        /* Primary button style */
        .btn-payment {
            background: #6F4E37; /* Dark green background */
            color: white; /* White text */
        }

        /* Cancel button style */
        .btn-cancel {
            background: #dc3545; /* Red background */
            color: white; /* White text */
        }

        /* Hover effect for buttons */
        .btn:hover {
            opacity: 0.9; /* Slightly transparent on hover */
            transform: scale(1.05); /* Slightly enlarge on hover */
        }

        /* Additional styles for button states */
        .btn:active {
            transform: scale(0.95); /* Slightly shrink on click */
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h1>Confirm Your Order</h1>
        
        <div class="customer-details">
            <h2>Customer Information</h2>
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span class="detail-value"><?php echo htmlspecialchars($delivery_details['name']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Phone:</span>
                <span class="detail-value"><?php echo htmlspecialchars($delivery_details['phone']); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Address:</span>
                <span class="detail-value"><?php echo htmlspecialchars($delivery_details['address']); ?></span>
            </div>
        </div>

        <div class="order-summary">
            <h2>Order Details</h2>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₹<?php echo number_format($item['price'] ?? 0, 2); ?></td>
                        <td>₹<?php echo number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 0), 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="total">
                <strong>Total Amount: ₹<?php echo number_format($total_amount, 2); ?></strong>
            </div>
        </div>

        <form method="POST" class="btn-container">
            <button type="submit" name="proceed_payment" class="btn btn-payment">Proceed to Payment</button>
            <button type="submit" name="cancel_order" class="btn btn-cancel" 
                    onclick="return confirm('Are you sure you want to cancel your order? This action cannot be undone.')">
                Cancel Order
            </button>
        </form>
    </div>
</body>
</html>