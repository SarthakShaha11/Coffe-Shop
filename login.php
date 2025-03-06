<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM usertable WHERE user_name = ? AND phone_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['User_id'] = $user['User_id'];
            $_SESSION['user_name'] = $user['user_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone_no'] = $user['phone_no'];
            header("Location: index.php");
            exit();
        } 
    } else {
        $error_message = "User not found!";
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
    <title>Coffee-Themed Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6f4e37, #3e2723);
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .form-container {
            background: rgba(51, 34, 17, 0.9);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 380px;
            text-align: center;
            color: #fff;
            backdrop-filter: blur(10px);
        }

        .form-container h1 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #d4a373;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-container input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 8px;
            font-size: 16px;
            background: rgba(229, 193, 159, 0.1);
            outline: none;
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-container input::placeholder {
            color: rgba(255,255,255,0.6);
        }

        .form-container input:focus {
            border-color: #d4a373;
            background: rgba(229, 193, 159, 0.2);
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background: #d4a373;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }

        .form-container button:hover {
            background: #c68f5d;
            transform: translateY(-2px);
        }

        .form-container a {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #d4a373;
            font-weight: 500;
            transition: 0.3s;
        }

        .form-container a:hover {
            color: #e5c19f;
        }

        .error-message {
            background: rgba(255,87,87,0.1);
            color: #ff5757;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Welcome Back</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required />
            </div>

            <div class="form-group">
                <input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" required />
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required />
            </div>

            <button type="submit">Login</button>
            <a href="Register.php">Don't have an account? Register</a>
            <a href="Admin_login.php">Admin Login</a>
        </form>
    </div>

    <script>
        function validateForm() {
            const username = document.querySelector('input[name="username"]').value.trim();
            const phone = document.querySelector('input[name="phone"]').value.trim();
            const password = document.querySelector('input[name="password"]').value.trim();

            if (username === "" || phone === "" || password === "") {
                alert("All fields are required.");
                return false;
            }

            if (!/^[0-9]{10}$/.test(phone)) {
                alert("Please enter a valid 10-digit phone number.");
                return false;
            }

            return true;
        }

        // Auto-hide error messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const error = document.querySelector('.error-message');
            if (error) {
                setTimeout(() => {
                    error.style.opacity = '0';
                    error.style.transition = 'opacity 0.5s ease';
                    setTimeout(() => error.remove(), 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>
