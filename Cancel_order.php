<?php
session_start();

// Check if order details exist
if (!isset($_SESSION['order_id']) || !isset($_SESSION['delivery_details'])) {
    header("Location: cart.php");
    exit();
}

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

$order_id = $_SESSION['order_id'];
$delivery_details = $_SESSION['delivery_details'];

// Fetch order details including products
$sql = "SELECT o.*, p.name as product_name, p.image 
        FROM orders o 
        JOIN product p ON o.product_id = p.id 
        WHERE o.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order_items = $result->fetch_all(MYSQLI_ASSOC);

// Calculate total amount
$total_amount = 0;
foreach ($order_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['proceed_payment'])) {
        header("Location: payment.php");
        exit();
    } elseif (isset($_POST['cancel_order'])) {
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
        .header {
            background: #6F4E37;
            padding: 10px;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
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
        .order-summary p {
            margin: 10px 0;
            line-height: 1.6;
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
            transition: opacity 0.3s;
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
        .confirmation-message {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .customer-details {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .customer-details h2 {
            color: #6F4E37;
            margin-bottom: 15px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            width: 150px;
            font-weight: bold;
            color: #6F4E37;
        }
        .detail-value {
            flex: 1;
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
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><img src="images/<?php echo htmlspecialchars($item['image']); ?>" width="50" alt="Product"></td>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td>₹<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div class="total-amount">
                <h3>Total Amount: ₹<?php echo number_format($total_amount, 2); ?></h3>
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