<?php
include 'db_connect.php';

$id = $_POST['id'] ?? null;
$name = $_POST['name'];
$email = $_POST['email'];

if ($id) {
    // Update existing customer
    $stmt = $conn->prepare("UPDATE customers SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);
} else {
    // Insert new customer
    $stmt = $conn->prepare("INSERT INTO customers (name, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $email);
}

if ($stmt->execute()) {
    header("Location: customers.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
