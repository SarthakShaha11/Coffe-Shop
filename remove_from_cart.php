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

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    // Delete the item from the cart
    $sql = "DELETE FROM cart WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Item removed successfully.";
    } else {
        $_SESSION['error'] = "Failed to remove item.";
    }
    
    $stmt->close();
    $conn->close();
    
    // Redirect back to cart page
    header("Location: cart.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: cart.php");
    exit();
}