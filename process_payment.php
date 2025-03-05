<?php
session_start();

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

// Retrieve form data
$order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : '';
$transaction_id = uniqid(); // Generate a unique transaction ID

// Insert data into the payment table
$sql = "INSERT INTO payment (order_id, transaction_id, price) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssd", $order_id, $transaction_id, $total_amount);

if ($stmt->execute()) {
    // Store payment_id in session
    $_SESSION['payment_id'] = $stmt->insert_id;

    // Redirect to payment confirmation page
    header("Location: payment_success.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
