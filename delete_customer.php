<?php
session_start();
include 'db_connect.php';

// Check if the user ID is set in the URL
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Get the user ID from the URL

    // Prepare the delete statement
    $sql = "DELETE FROM usertable WHERE User_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
} else {
    $_SESSION['message'] = "Invalid user ID!";
}

$conn->close();

// Redirect back to the customers page
header("Location: customers.php");
exit();
?>
