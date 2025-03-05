<?php
session_start();
$payment_id = isset($_SESSION['payment_id']) ? $_SESSION['payment_id'] : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>
<body>
    <h2>Payment Successful!</h2>
    <p>Your payment ID: <strong><?php echo htmlspecialchars($payment_id); ?></strong></p>
    <a href="index.php">Go Back to Home</a>
</body>
</html>
