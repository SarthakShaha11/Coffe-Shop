<?php
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

// Check if the form data is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Check if the product already exists in the cart
    $stmt = $conn->prepare("SELECT product_id FROM cart WHERE product_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // If the product exists, update the quantity
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE product_id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "Product quantity updated successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        // If the product does not exist, insert it with quantity 1
        $stmt = $conn->prepare("INSERT INTO cart (product_id, product_name, product_price, quantity) VALUES (?, ?, ?, 1)");
        $stmt->bind_param("isd", $id, $name, $price);
        if ($stmt->execute()) {
            echo "Product added to cart successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

// Redirect back to the products page (optional)
header("Location: Product.php");
exit();
?> 