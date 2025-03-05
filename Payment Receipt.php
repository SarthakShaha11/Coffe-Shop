<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order details from POST or SESSION
$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : $_SESSION['order_id'];
$total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : floatval($_SESSION['total_amount']);
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'COD';
$transaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : null;

// Get order items from session or database
$order_items = isset($_SESSION['order_items']) ? $_SESSION['order_items'] : array();

// If session doesn't have items, fetch from database
if (empty($order_items)) {
    $stmt = $conn->prepare("SELECT o.*, p.name as product_name, p.image, p.price 
                           FROM orders o 
                           JOIN product p ON o.product_id = p.product_id 
                           WHERE o.Order_id = ?");
    $stmt->bind_param("s", $order_id); // Changed to string because order_id is now alphanumeric
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()) {
        $order_items[] = $row;
    }
    $stmt->close();
}

// Calculate total if not provided
if ($total_amount <= 0) {
    $total_amount = 0;
    foreach ($order_items as $item) {
        $total_amount += floatval($item['price']) * ($item['quantity'] ?? 1);
    }
}

// Insert payment details into database
$stmt = $conn->prepare("INSERT INTO payment (order_id, transaction_id, payment_method, price) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssd", $order_id, $transaction_id, $payment_method, $total_amount);
$stmt->execute();
$payment_id = $stmt->insert_id;
$stmt->close();

// Fetch user details
$user_details = null;
if(isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE User_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $user_details = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill - The Coffee Hub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #4B3D3D;
            margin: 0;
            padding: 20px;
        }
        .bill-container {
            background-color: white;
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .bill-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .bill-details {
            margin-bottom: 20px;
        }
        .bill-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .bill-table th, .bill-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .bill-table th {
            background-color: #6F4E37;
            color: white;
        }
        .total-amount {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
        }
        .print-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        .print-button:hover {
            background-color: #45a049;
        }
        @media print {
            .print-button {
                display: none;
            }
            body {
                background-color: white;
            }
        }
        .order-items {
            margin: 20px 0;
        }
        
        .order-items table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .order-items th, .order-items td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        .order-items th {
            background-color: #6F4E37;
            color: white;
        }
        
        .product-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }
        
    </style>
</head>

<body>
    <div class="bill-container">
        <div class="bill-header">
            <h1>The Coffee Hub</h1>
            <h2>Payment Receipt</h2>
        </div>

        <div class="bill-details">
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
            <p><strong>Date:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
            <?php if($transaction_id): ?>
                <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_id); ?></p>
            <?php endif; ?>
        </div>

        <?php if($user_details): ?>
        <div class="customer-details">
            <h3>Customer Details</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_details['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_details['phone']); ?></p>
        </div>
        <?php endif; ?>

        <div class="order-items">
            <h3>Order Items</h3>
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
                    <?php foreach($order_items as $item): ?>
                    <tr>
                        <td>
                            <img src="images/<?php echo htmlspecialchars($item['image'] ?? ''); ?>" 
                                 alt="<?php echo htmlspecialchars($item['product_name'] ?? $item['name'] ?? ''); ?>" 
                                 class="product-image">
                        </td>
                        <td><?php echo htmlspecialchars($item['product_name'] ?? $item['name'] ?? ''); ?></td>
                        <td>₹<?php echo number_format(floatval($item['price']), 2); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity'] ?? 1); ?></td>
                        <td>₹<?php echo number_format(floatval($item['price']) * ($item['quantity'] ?? 1), 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="total-amount">
            <h3>Total Amount: ₹<?php echo number_format(floatval($total_amount), 2); ?></h3>
        </div>

        <button class="print-button" onclick="window.print()">Print Receipt</button>
    </div>
</body>

</html>