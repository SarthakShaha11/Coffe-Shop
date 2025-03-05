<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM customers WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: customers.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
