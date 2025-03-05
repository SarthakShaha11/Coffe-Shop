<?php
session_start();

// Check if order details exist
if (!isset($_SESSION['order_id']) || !isset($_SESSION['delivery_details'])) {
    header("Location: cart.php");
    exit();
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

        // Delete order from database
        $order_id = $_SESSION['order_id'];
        $stmt = $conn->prepare("DELETE FROM orders WHERE Order_id = ?");
        $stmt->bind_param("s", $order_id);
        $stmt->execute();
        $stmt->close();

        // Clear session variables
        unset($_SESSION['order_id']);
        unset($_SESSION['total_amount']);
        unset($_SESSION['cart_items']);
        unset($_SESSION['delivery_details']);

        header("Location: index.php");
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
        }
        .btn-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 30px;
        }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        .btn-payment {
            background: #6F4E37;
            color: white;
        }
        .btn-cancel {
            background: #dc3545;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <h1>Confirm Your Order</h1>
        
        <div class="order-summary">
            <h2>Order Details</h2>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($_SESSION['order_id']); ?></p>
            <p><strong>Total Amount:</strong> ₹<?php echo number_format($_SESSION['total_amount'], 2); ?></p>
            <p><strong>Delivery To:</strong> <?php echo htmlspecialchars($_SESSION['delivery_details']['name']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($_SESSION['delivery_details']['address']); ?></p>
        </div>

        <p>Please confirm if you want to proceed with the payment or cancel your order.</p>

        <form method="POST" class="btn-container">
            <button type="submit" name="proceed_payment" class="btn btn-payment">Proceed to Payment</button>
            <button type="submit" name="cancel_order" class="btn btn-cancel" onclick="return confirm('Are you sure you want to cancel your order?')">Cancel Order</button>
        </form>
    </div>
</body>
</html>