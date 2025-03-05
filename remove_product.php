<?php
session_start();

// Check if cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['message'] = "⚠️ Your cart is already empty.";
    header("Location: cart.php");
    exit();
}

// Check if 'id' is set in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Find and remove product from the session cart
    foreach ($_SESSION['cart'] as $index => $item) {
        if ($item['id'] == $product_id) {
            unset($_SESSION['cart'][$index]); // Remove item from cart
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
            $_SESSION['message'] = "✅ Product removed from cart!";
            header("Location: cart.php");
            exit();
        }
    }

    // If product was not found in the cart
    $_SESSION['message'] = "⚠️ Product not found in cart.";
} else {
    $_SESSION['message'] = "⚠️ Invalid product ID.";
}

// Redirect back to the cart
header("Location: cart.php");
exit();
?>
