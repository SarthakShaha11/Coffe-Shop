<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style> 
        /* admin.css */

/* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to right, #8e44ad, #3498db);/* Deep dark blue for a premium feel */
    color: #ffffff; /* White text for contrast */
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




.sidebar .logo {
    padding: 20px;
    text-align: center;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    padding: 15px;
    text-align: left;
}

.sidebar ul li a {
    color:rgb(19, 161, 197);
    text-decoration: none;
    display: block;
    transition: background 0.3s;
}

.sidebar ul li a:hover {
    background: #34495e;
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

/* Main Content */
.main-content {
    margin-left: 250px; /* Ensure space for sidebar */
}


.cards {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.card-single {
    background:  #2980b9;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(27, 3, 207, 0.1);
    flex: 1;
    margin: 0 10px;
    transition: transform 0.3s;
}

.card-single:hover {
    transform: translateY(-5px);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #2980b9;
    color: #fff;
    padding: 10px;
    border-radius: 8px 8px 0 0;
}

.card-body {
    padding: 20px;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background: #2980b9;
    color: #fff;
}

/* Customer Styles */
.customer {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.customer img {
    border-radius: 50%;
    width: 50px;
    height: 50px;
    margin-right: 10px;
}
    </style>
</head>
<body>

    <div class="sidebar">
     
            <h2>The Coffee Hub</h2>
       
        <ul>
            <li><a href="Dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="products.php" class="active"><i class="fas fa-coffee"></i> Products</a></li>
            <li><a href="orders.php"><i class="fas fa-receipt"></i> Orders</a></li>
            <li><a href="Customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h2>Dashboard</h2>
            <div class="user-wrapper">
                <img src="admin.jpg" alt="Admin" class="admin-profile">
                <div>
                    <h4>Sarthak</h4>
                    <small>Super Admin</small>
                </div>
            </div>
        </header>

        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h3>54</h3>
                        <span>Orders</span>
                    </div>
                    <div>
                        <span class="fas fa-receipt"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h3>79</h3>
                        <span>Customers</span>
                    </div>
                    <div>
                        <span class="fas fa-users"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h3>$6,000</h3>
                        <span>Revenue</span>
                    </div>
                    <div>
                        <span class="fas fa-dollar-sign"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h3>20</h3>
                        <span>Products</span>
                    </div>
                    <div>
                        <span class="fas fa-coffee"></span>
                    </div>
                </div>
            </div>

            <div class="recent-grid">
                <div class="orders">
                    <div class="card">
                        <div class="card-header">
                            <h3>Recent Orders</h3>
                            <button>See all <span class="fas fa-arrow-right"></span></button>
                        </div>

                        <div class="card-body">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2345</td>
                                        <td>John Doe</td>
                                        <td>$45.99</td>
                                        <td><span class="status delivered">Delivered</span></td>
                                    </tr>
                                    <tr>
                                        <td>2346</td>
                                        <td>Jane Smith</td>
                                        <td>$15.99</td>
                                        <td><span class="status pending">Pending</span></td>
                                    </tr>
                                    <tr>
                                        <td>2347</td>
                                        <td>Mike Johnson</td>
                                        <td>$29.99</td>
                                        <td><span class="status delivered">Delivered</span></td>
                                    </tr>
                                    <tr>
                                        <td>2348</td>
                                        <td>Emily Davis</td>
                                        <td>$85.99</td>
                                        <td><span class="status in-progress">In Progress</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="customers">
                    <div class="card">
                        <div class="card-header">
                            <h3>New Customers</h3>
                            <button>See all <span class="fas fa-arrow-right"></span></button>
                        </div>

                        <div class="card-body">
                            <div class="customer">
                                <img src="customer1.jpg" alt="Customer">
                                <div>
                                    <h4>John Doe</h4>
                                    <small>Joined 10 minutes ago</small>
                                </div>
                            </div>

                            <div class="customer">
                                <img src="customer2.jpg" alt="Customer">
                                <div>
                                    <h4>Jane Smith</h4>
                                    <small>Joined 2 hours ago</small>
                                </div>
                            </div>

                            <div class="customer">
                                <img src="customer3.jpg" alt="Customer">
                                <div>
                                    <h4>Mike Johnson</h4>
                                    <small>Joined 1 day ago</small>
                                </div>
                            </div>

                            <div class="customer">
                                <img src="customer4.jpg" alt="Customer">
                                <div>
                                    <h4>Emily Davis</h4>
                                    <small>Joined 3 days ago</small>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
