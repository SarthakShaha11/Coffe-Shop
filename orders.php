<?php 
include 'db_connect.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Coffee Shop Admin</title>
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
            margin-bottom: 20px;
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
            background: rgba(255, 255, 255, 0.1);
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

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .orders-header h3 {
            font-size: 24px;
        }

        .orders-header input {
            padding: 10px;
            border-radius: 5px;
            border: none;
            width: 250px;
            font-size: 14px;
        }

        .orders-header button {
            background: #27ae60;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .orders-header button:hover {
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

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 14px;
        }

        .status.pending { background: #f1c40f; }
        .status.completed { background: #27ae60; }
        .status.cancelled { background: #e74c3c; }

    </style>
</head>
<body>

    <div class="sidebar">
        <h2>The Coffee Hub</h2>
        <ul>
            <li><a href="Dashbord.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fas fa-coffee"></i> Products</a></li>
            <li><a href="orders.php" class="active"><i class="fas fa-receipt"></i> Orders</a></li>
            <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h2>Orders</h2>
            <div class="user-wrapper">
                <img src="admin.jpg" alt="Admin" class="admin-profile">
                <div class="user-info">
                    <h4>Admin</h4>
                    <small>Super Admin</small>
                </div>
            </div>
        </header>

        <main>
            <div class="orders-header">
                <h3>All Orders</h3>
                <input type="text" id="orderSearch" placeholder="Search by Order ID or Customer Name...">
                <button id="filterOrdersBtn">Filter</button>
            </div>

            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT o.id, c.name AS customer_name, o.total, o.status 
                                  FROM orders o 
                                  JOIN customers c ON o.customer_id = c.id 
                                  ORDER BY o.id DESC";
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['customer_name']}</td>
                                    <td>";

                                // Fetch ordered products
                                $orderId = $row['id'];
                                $productQuery = "SELECT p.name, oi.quantity 
                                                 FROM order_items oi 
                                                 JOIN products p ON oi.product_id = p.id 
                                                 WHERE oi.order_id = $orderId";
                                $productResult = $conn->query($productQuery);

                                if ($productResult->num_rows > 0) {
                                    while ($productRow = $productResult->fetch_assoc()) {
                                        echo "{$productRow['name']} (x{$productRow['quantity']}), ";
                                    }
                                } else {
                                    echo "No products";
                                }

                                echo "</td>
                                    <td>2024-09-01</td>
                                    <td>\${$row['total']}</td>
                                    <td><span class='status {$row['status']}'>{$row['status']}</span></td>
                                    <td>
                                        <a href='edit_order.php?id={$row['id']}' class='btn edit-btn'>Edit</a>
                                        <a href='delete_order.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\")' class='btn delete-btn'>Delete</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No orders found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>
