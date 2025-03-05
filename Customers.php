<?php 
include 'db_connect.php'; 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Coffee Shop Admin</title>
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

        .customers-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .customers-header h3 {
            font-size: 24px;
        }

        .customers-header button {
            background: #27ae60;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }

        .customers-header button:hover {
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

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
            border-radius: 5px;
        }

        .close-btn {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <h2>The Coffee Hub</h2>
        <ul>
            <li><a href="Dashbord.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="products.php"><i class="fas fa-coffee"></i> Products</a></li>
            <li><a href="orders.php"><i class="fas fa-receipt"></i> Orders</a></li>
            <li><a href="customers.php" class="active"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h2>Customers</h2>
            <div class="user-wrapper">
                <img src="admin.jpg" alt="Admin" class="admin-profile">
                <div class="user-info">
                    <h4>Admin</h4>
                    <small>Super Admin</small>
                </div>
            </div>
        </header>

        <main>
            <div class="customers-header">
                <h3>All Customers</h3>
                <button id="addCustomerBtn">Add Customer</button>
            </div>

            <div class="customers-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM customers");
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['email']}</td>
                                    <td>
                                        <button onclick='editCustomer({$row["id"]}, \"{$row["name"]}\", \"{$row["email"]}\")' class='btn edit-btn'>Edit</button>
                                        <a href='delete_customer.php?id={$row["id"]}' onclick='return confirm(\"Are you sure?\")' class='btn delete-btn'>Delete</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No customers found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('addCustomerBtn').addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = "Add Customer";
            document.getElementById('customerId').value = "";
            document.getElementById('customerName').value = "";
            document.getElementById('customerEmail').value = "";
            document.getElementById('customerModal').style.display = 'block';
        });

        function editCustomer(id, name, email) {
            document.getElementById('modalTitle').textContent = "Edit Customer";
            document.getElementById('customerId').value = id;
            document.getElementById('customerName').value = name;
            document.getElementById('customerEmail').value = email;
            document.getElementById('customerModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('customerModal').style.display = 'none';
        }
    </script>

</body>
</html>
