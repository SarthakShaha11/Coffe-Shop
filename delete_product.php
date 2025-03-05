<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete product image
    $result = $conn->query("SELECT image FROM products WHERE id=$id");
    $row = $result->fetch_assoc();
    if (file_exists($row['image'])) {
        unlink($row['image']);
    }

    // Delete product from database
    $sql = "DELETE FROM products WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Product deleted successfully!";
        header("Location: products.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
