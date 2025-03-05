<?php 
include 'db_connect.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Coffee Shop Admin</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #8e44ad, #3498db);
            color: white;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background: #2c3e50;
    color: rgb(16, 178, 219);
    width: 250px;
    height: 100vh;
    position: fixed;
    transition: all 0.3s;
    left: 0;
    top: 0;
        }

        .sidebar h2 {
            text-align: center;
            font-size: 22px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 15px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar ul li:hover {
            background: #1a252f;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 16px;
        }

        .main-content {
            margin-left: 240px;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .user-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-profile {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
        }

        .user-info h4 {
            margin: 0;
            font-size: 16px;
        }

        .user-info small {
            color: #ddd;
        }

        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .products-header h3 {
            font-size: 24px;
        }

        .products-header button {
            background: #27ae60;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .products-header button:hover {
            background: #2ecc71;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #2980b9;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            transition: 0.3s;
        }

        .edit-btn {
            background: #f39c12;
            color: white;
        }

        .delete-btn {
            background: #e74c3c;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <h2>The Coffee Hub</h2>
        <ul>
            <li><a href="Dashbord.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="products.php" class="active"><i class="fas fa-coffee"></i> Products</a></li>
            <li><a href="orders.php"><i class="fas fa-receipt"></i> Orders</a></li>
            <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h2>Products</h2>
            <div class="user-wrapper">
                <img src="admin.jpg" alt="Admin" class="admin-profile">
                <div class="user-info">
                    <h4>Admin</h4>
                    <small>Super Admin</small>
                </div>
            </div>
        </header>

        <main>
            <div class="products-header">
                <h3>All Products</h3>
                <button id="addProductBtn">Add Product</button>
            </div>

            <div class="products-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM products");

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['id']}</td>
                                        <td>{$row['name']}</td>
                                        <td>{$row['category']}</td>
                                        <td>\${$row['price']}</td>
                                        <td><img src='uploads/{$row['image']}' class='product-img'></td>
                                        <td>
                                            <a href='edit_product.php?id={$row['id']}' class='btn edit-btn'>Edit</a>
                                            <a href='delete_product.php?id={$row['id']}' class='btn delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No products found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('addProductBtn').addEventListener('click', function() {
            alert("Redirecting to Add Product Page!");
            window.location.href = "add_product.php";
        });
    </script>

</body>
</html>
