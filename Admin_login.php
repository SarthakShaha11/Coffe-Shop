<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coffee_shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = trim(strtolower($_POST["username"])); // Normalize input
    $admin_password = $_POST["password"];

    // Use Prepared Statements to prevent SQL Injection
    $sql = "SELECT * FROM Admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verify hashed password
        if (password_verify($admin_password, $row["password"])) {
            $_SESSION["admin_logged_in"] = true;
            $_SESSION["admin_username"] = $admin_username;

            header("Location: Dashbord.php"); // Corrected redirection
            exit();
        } else {
            $_SESSION["error"] = "Invalid password!";
        }
    } else {
        $_SESSION["error"] = "Admin not found!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px 0px #aaa;
            border-radius: 8px;
            width: 320px;
            text-align: center;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
        /* Import Google Font */

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');



body {

    font-family: 'Poppins', sans-serif;

    background: linear-gradient(to right, #6f4e37, #3e2723); /* Coffee-themed gradient */

    display: flex;

    justify-content: center;

    align-items: center;

    height: 100vh;

    margin: 0;

}



.container {

    background: rgba(255, 255, 255, 0.95);

    padding: 30px;

    border-radius: 12px;

    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);

    width: 360px;

    text-align: center;

    transition: transform 0.3s ease-in-out;

}



.container:hover {

    transform: scale(1.03);

}



h2 {

    color: #6f4e37;

    margin-bottom: 20px;

    font-weight: 600;

}



input {

    width: 100%;

    padding: 12px;

    margin: 10px 0;

    border: 1px solid #d4a373;

    border-radius: 8px;

    font-size: 16px;

    background: #f5e1c0;

    outline: none;

    color: #3e2723;

    transition: 0.3s;

}



input:focus {

    border: 2px solid #6f4e37;

    background: #ffffff;

}



button {

    width: 100%;

    padding: 12px;

    background: #6f4e37;

    color: white;

    border: none;

    border-radius: 8px;

    font-size: 18px;

    font-weight: bold;

    cursor: pointer;

    transition: 0.3s;

}



button:hover {

    background: #3e2723;

    transform: scale(1.05);

}



.error {

    color: red;

    font-size: 14px;

    margin-bottom: 10px;

    font-weight: bold;

}



/* Responsive Design */

@media (max-width: 400px) {

    .container {

        width: 90%;

    }

}
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <?php if (isset($_SESSION["error"])): ?>
            <p class="error"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></p>
        <?php endif; ?>
        <form method="POST" action="admin_login.php">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
