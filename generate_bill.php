<?php
session_start(); // Start the session

// Database connection
$servername = "localhost"; // Update with your server details
$username = "root"; // Update with your database username
$password = ""; // Update with your database password
$dbname = "ch"; // Update with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch payment data from session
$payment_data = isset($_SESSION['payment_data']) ? $_SESSION['payment_data'] : null;
$order_data = isset($_SESSION['order_data']) ? $_SESSION['order_data'] : null;

if ($payment_data) {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO payment (order_id, total_amount, transaction_id, payment_method, username, phone, address, date, product_id, product_name, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Check if statement preparation was successful
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssssssssss", 
        $payment_data['order_id'], 
        $payment_data['total_amount'], 
        $payment_data['transaction_id'], 
        $payment_data['payment_method'],
        $_POST['username'],
        $_POST['phone'],
        $_POST['address'],
        $_POST['date'],
        $_POST['product_id'],
        $_POST['product_name'],
        $_POST['price']
    );

    // Execute the statement
    if ($stmt->execute()) {
        // Fetch the last inserted payment ID
        $payment_id = $stmt->insert_id;

        // Display the bill
        echo "<h1>Bill Generated Successfully</h1>";
        echo "<p><strong>Payment ID:</strong> " . htmlspecialchars($payment_id) . "</p>";
        echo "<p><strong>Order ID:</strong> " . htmlspecialchars($payment_data['order_id']) . "</p>";
        echo "<p><strong>Transaction ID:</strong> " . htmlspecialchars($payment_data['transaction_id']) . "</p>";
        echo "<p><strong>Total Amount:</strong> " . htmlspecialchars($payment_data['total_amount']) . "</p>";
        echo "<p><strong>Payment Method:</strong> " . htmlspecialchars($payment_data['payment_method']) . "</p>";
        echo "<p><strong>Username:</strong> " . htmlspecialchars($_POST['username']) . "</p>";
        echo "<p><strong>Phone Number:</strong> " . htmlspecialchars($_POST['phone']) . "</p>";
        echo "<p><strong>Address:</strong> " . htmlspecialchars($_POST['address']) . "</p>";
        echo "<p><strong>Date:</strong> " . htmlspecialchars($_POST['date']) . "</p>";
        echo "<p><strong>Product ID:</strong> " . htmlspecialchars($_POST['product_id']) . "</p>";
        echo "<p><strong>Product Name:</strong> " . htmlspecialchars($_POST['product_name']) . "</p>";
        echo "<p><strong>Price:</strong> " . htmlspecialchars($_POST['price']) . "</p>";

        // Additional message for COD
        if ($payment_data['payment_method'] === 'cod') {
            echo "<p><strong>Note:</strong> Your order will be delivered to your address, and payment will be collected upon delivery.</p>";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Clear session data after processing
    unset($_SESSION['payment_data']);
    unset($_SESSION['order_data']);
} else {
    echo "No payment data found.";
}

// Close the statement if it was created
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?> 