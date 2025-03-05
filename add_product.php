<?php 
include 'db_connect.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO products (name, category, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $category, $price, $image);
        
        if ($stmt->execute()) {
            header("Location: products.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="admin.css">
    <style>
      /* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    text-align: center;
    margin: 0;
    padding: 0;
}

/* Heading Styling */
h2 {
    color: #333;
    margin-top: 20px;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
}

/* Form Container */
form {
    background: #fff;
    padding: 20px;
    width: 40%;
    margin: 20px auto;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Labels */
label {
    display: block;
    font-weight: bold;
    margin-top: 10px;
    text-align: left;
}

/* Input Fields */
input[type="text"],
input[type="number"],
input[type="file"] {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

/* Submit Button */
button {
    margin-top: 15px;
    padding: 10px 20px;
    border: none;
    background-color: #28a745;
    color: white;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

button:hover {
    background-color: #218838;
}

      </style>
    
</head>
<body>
    <h2>Add Product</h2>
    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <label>Product Name:</label>
        <input type="text" name="name" required>
        
        <label>Category:</label>
        <input type="text" name="category" required>
        
        <label>Price:</label>
        <input type="number" name="price" step="0.01" required>
        
        <label>Product Image:</label>
        <input type="file" name="image" accept="image/*" required>
        
        <button type="submit">Add Product</button>
    </form>
</body>
</html>
