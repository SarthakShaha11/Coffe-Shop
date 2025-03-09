<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if session variables are set
if (!isset($_SESSION['order_id']) || !isset($_SESSION['total_amount'])) {
    die("Order ID or total amount not set in session.");
}

// Retrieve session variables
$order_id = $_SESSION['order_id'];
$total_amount = $_SESSION['total_amount'];
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'COD';
$transaction_id = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : null;

// Get delivery details from session
$delivery_details = isset($_SESSION['delivery_details']) ? $_SESSION['delivery_details'] : null;

// Fetch order items from the session or database
if (empty($_SESSION['order_items'])) {
    // Fetch order items from the database
    $stmt = $conn->prepare("SELECT o.*, p.name as product_name, p.price 
                             FROM orders o 
                             JOIN product p ON o.product_id = p.product_id 
                             WHERE o.order_id = ?");
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order_items = [];

    while ($row = $result->fetch_assoc()) {
        // Calculate subtotal here explicitly
        $subtotal = floatval($row['price']) * floatval($row['quantity']);
        $order_items[] = [
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'] ?? 'Unknown Product',
            'price' => floatval($row['price']),
            'quantity' => intval($row['quantity']),
            'subtotal' => $subtotal // Add subtotal here
        ];
    }

    $stmt->close();
    $_SESSION['order_items'] = $order_items; // Store in session
} else {
    $order_items = $_SESSION['order_items']; // Retrieve from session
}

// Insert payment details
$stmt = $conn->prepare("INSERT INTO payment (order_id, transaction_id, payment_method, price) VALUES (?, ?, ?, ?)");
$stmt->bind_param("sssd", $order_id, $transaction_id, $payment_method, $total_amount);

// After prepare statement
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// After execute
if (!$stmt->execute()) {
    die("Error executing statement: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill - The Coffee Hub</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #c2b280 0%, #6F4E37 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }

        .bill-container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .bill-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, #6F4E37, #c2b280);
        }

        h1 {
            color: #6F4E37;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 30px;
            font-size: 28px;
            position: relative;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, #6F4E37, #c2b280);
        }

        .customer-details {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-left: 5px solid #6F4E37;
            position: relative;
        }

        .customer-details::before {
            content: '☕';
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            color: #c2b280;
            opacity: 0.3;
        }

        .customer-info {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 15px;
            align-items: center;
        }

        .customer-info strong {
            color: #6F4E37;
            font-weight: 600;
        }

        .order-details {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            position: relative;
        }

        .order-id {
            background: linear-gradient(135deg, #6F4E37, #8B4513);
            color: #fff;
            padding: 8px 15px;
            border-radius: 25px;
            font-size: 16px;
            letter-spacing: 1px;
            display: inline-block;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 25px 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        th {
            background: linear-gradient(135deg, #6F4E37, #8B4513);
            color: #fff;
            padding: 15px;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-amount {
            background: linear-gradient(135deg, #6F4E37, #8B4513);
            color: #fff;
            padding: 15px 25px;
            border-radius: 8px;
            text-align: right;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .total-amount h3 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .transaction-info {
            margin-top: 15px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 3px solid #c2b280;
        }

        .divider {
            height: 2px;
            background: linear-gradient(90deg, #6F4E37, #c2b280);
            margin: 20px 0;
            border-radius: 1px;
        }

        h2 {
            color: #6F4E37;
            font-size: 20px;
            margin: 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #c2b280;
        }
        .home-link {
                    display: inline-block;
                    padding: 10px 20px;
                    background-color: #6F4E37; /* Dark green background */
                    color: white; /* White text */
                    text-decoration: none; /* Remove underline */
                    border-radius: 4px; /* Rounded corners */
                    font-weight: bold; /* Bold text */
                    transition: background 0.3s, transform 0.3s; /* Smooth transition */
                }

                .home-link:hover {
                    background-color: #5a3f2d; /* Darker green on hover */
                    transform: scale(1.05); /* Slightly enlarge on hover */
                }

                .home-link:active {
                    transform: scale(0.95); /* Slightly shrink on click */
                }
        .print-section {
            text-align: center;
            margin-top: 30px;
        }

        .print-button {
            background: linear-gradient(135deg, #6F4E37, #8B4513);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: transform 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .print-button:hover {
            transform: translateY(-2px);
        }

        @media print {
            body {
                background: white;
            }
            .bill-container {
                box-shadow: none;
                margin: 0;
                padding: 15px;
            }
            .order-id {
                background: #6F4E37 !important;
                -webkit-print-color-adjust: exact;
            }
            .print-section {
                display: none;
            }
        }

        @media (max-width: 600px) {
            .bill-container {
                padding: 15px;
                margin: 10px;
            }
            
            .customer-info {
                grid-template-columns: 1fr;
            }
            
            table {
                font-size: 14px;
            }
            
            th, td {
                padding: 8px;
            }
            
            .order-id {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <h1>The Coffee Hub - Payment Receipt</h1>
        
        <!-- Customer Details Section -->
        <div class="customer-details">
            <h2>Customer Information</h2>
            <?php if ($delivery_details): ?>
            <div class="customer-info">
                <strong>Name:</strong>
                <span><?php echo htmlspecialchars($delivery_details['name']); ?></span>
                
                <strong>Phone:</strong>
                <span><?php echo htmlspecialchars($delivery_details['phone']); ?></span>
                
                <strong>Address:</strong>
                <span><?php echo htmlspecialchars($delivery_details['address']); ?></span>
            </div>
            <?php else: ?>
            <p>Customer details not available</p>
            <?php endif; ?>
        </div>

        <!-- Order Details Section -->
        <div class="order-details">
            <p>
                <strong>Order ID:</strong> 
                <span class="order-id"><?php echo htmlspecialchars($order_id); ?></span>
            </p>
            <div class="transaction-info">
                <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
                <?php if($transaction_id): ?>
                    <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($transaction_id); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Order Items Section -->
        <h2>Order Items</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($order_items)): ?>
                    <?php foreach($order_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td>₹<?php echo number_format(floatval($item['price']), 2); ?></td>
                            <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                            <td>₹<?php echo number_format(floatval($item['subtotal']), 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No items in this order.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="total-amount">
            <h3>Total Amount: ₹<?php echo number_format(floatval($total_amount), 2); ?></h3>
        </div>

        <div class="print-section">
            <button onclick="window.print()" class="print-button">Print Receipt</button>
            <a href="index.php" class="home-link">GO to Home</a>
        </div>
    </div>
</body>
</html>
