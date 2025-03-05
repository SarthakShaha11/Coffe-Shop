<?php
session_start();
$payment_id = isset($_SESSION['payment_id']) ? $_SESSION['payment_id'] : null;

if (!$payment_id) {
    die("No payment details found.");
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch payment details
$stmt = $conn->prepare("SELECT * FROM payment WHERE payment_id = ?");
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$result = $stmt->get_result();
$payment_details = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body>
    <h2>Payment Receipt</h2>
    <?php if ($payment_details): ?>
        <p><strong>Payment ID:</strong> <?php echo htmlspecialchars($payment_details['payment_id']); ?></p>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($payment_details['order_id']); ?></p>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($payment_details['transaction_id']); ?></p>
        <p><strong>Amount Paid:</strong> $<?php echo htmlspecialchars($payment_details['price']); ?></p>
    <?php else: ?>
        <p>No payment details found.</p>
    <?php endif; ?>
</body>
</html>
