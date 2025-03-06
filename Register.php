<?php
header('Content-Type: text/html; charset=utf-8');

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

$conn->set_charset("utf8mb4");

$success_message = '';
$error_message = '';

function validateUsername($username) {
    return preg_match('/^[a-zA-Z]+$/', $username);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate username
    if (!validateUsername($username)) {
        $error_message = "Username can only contain letters.";
    }
    // Validate phone number
    else if (!preg_match("/^\d{10}$/", $phone)) {
        $error_message = "Please enter a valid 10-digit phone number.";
    }
    else {
        // Check if username or email already exists
        $check_sql = "SELECT * FROM usertable WHERE user_name = ? OR email = ? OR phone_no = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("sss", $username, $email, $phone);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            $error_message = "Username, email, or phone number already exists!";
        } else {
            // Insert new user
            $insert_sql = "INSERT INTO usertable (user_name, email, password, phone_no) VALUES (?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("ssss", $username, $email, $password, $phone);

            if ($insert_stmt->execute()) {
                $success_message = "Registration successful! Redirecting to login...";
                header("refresh:2;url=login.php");
            } else {
                $error_message = "Registration failed. Please try again.";
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Coffee Hub - Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap" rel="stylesheet">
  <style>
    /* Import Google Font */
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap');
    
    /* Global Styling */
    body {
      font-family: 'Nunito', sans-serif;
      background: linear-gradient(135deg, #6f4e37, #3e2723);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .form-container {
      background: rgba(78, 52, 37, 0.9);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 400px;
      width: 100%;
      color: #fff;
      backdrop-filter: blur(10px);
    }
    .form-container h1 {
      color: #d4a373;
      font-weight: 700;
      margin-bottom: 20px;
      font-size: 28px;
    }
    .form-container input {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #d4a373;
      border-radius: 8px;
      font-size: 16px;
      background: #fff8f0;
      color: #6f4e37;
      transition: all 0.3s ease;
    }
    .form-container input:focus {
      border-color: #d4a373;
      outline: none;
      box-shadow: 0 0 5px rgba(212, 163, 115, 0.5);
    }
    .form-container input[type="tel"] {
      -moz-appearance: textfield;
    }
    .form-container input[type="tel"]::-webkit-outer-spin-button,
    .form-container input[type="tel"]::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }
    .form-container input[type="tel"]:invalid {
      border-color: #ff5757;
    }
    .form-container input[type="tel"]:valid {
      border-color: #4CAF50;
    }
    .form-container button {
      width: 100%;
      padding: 12px;
      background: #503626;
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
      background: #3e2723;
      transform: translateY(-2px);
    }
    .form-container button:disabled {
      background: #cccccc;
      cursor: not-allowed;
      transform: none;
    }
    .form-container a {
      display: block;
      margin-top: 15px;
      text-decoration: none;
      color: #d4a373;
      font-weight: bold;
      transition: 0.3s;
    }
    .form-container a:hover {
      color: #e5c19f;
      text-decoration: underline;
    }
    .error-message {
      background: rgba(255, 87, 87, 0.1);
      color: #ff5757;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
      animation: shake 0.5s ease-in-out;
    }
    .success-message {
      background: rgba(76, 175, 80, 0.1);
      color: #4CAF50;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
    }
    .loading {
      display: none;
      margin: 10px auto;
      width: 40px;
      height: 40px;
      border: 3px solid #f3f3f3;
      border-top: 3px solid #d4a373;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }
    @media (max-width: 480px) {
      .form-container {
        padding: 20px;
      }
      .form-container h1 {
        font-size: 24px;
      }
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Register</h1>
    
    <?php if (!empty($error_message)): ?>
      <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
      <div class="success-message">
        <?php echo htmlspecialchars($success_message); ?>
        <div class="loading" style="display: block;"></div>
      </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return validateForm()">
      <input type="text" 
             name="username" 
             placeholder="Username" 
             pattern="[a-zA-Z]+" 
             title="Username can only contain letters"
             maxlength="30" 
             required />
      <input type="tel" 
             name="phone" 
             placeholder="Phone Number (10 digits)" 
             pattern="[0-9]{10}" 
             maxlength="10"
             oninput="this.value = this.value.replace(/[^0-9]/g, '')"
             onkeypress="return onlyNumberKey(event)"
             required />
      <input type="email" 
             name="email" 
             placeholder="Email" 
             required />
      <input type="password" 
             name="password" 
             placeholder="Password" 
             minlength="6"
             required />
      <button type="submit">Register</button>
      <a href="login.php">Already have an account? Login</a>
    </form>
  </div>

  <script>
    function onlyNumberKey(evt) {
      var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
      if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) {
        return false;
      }
      return true;
    }

    function validateForm() {
      const username = document.querySelector('input[name="username"]').value.trim();
      const phone = document.querySelector('input[name="phone"]').value.trim();
      const email = document.querySelector('input[name="email"]').value.trim();
      const password = document.querySelector('input[name="password"]').value.trim();

      if (!/^[a-zA-Z]+$/.test(username)) {
        alert("Username can only contain letters.");
        return false;
      }

      if (username.length < 3 || username.length > 30) {
        alert("Username must be between 3 and 30 characters.");
        return false;
      }

      if (!/^\d{10}$/.test(phone)) {
        alert("Phone number must be exactly 10 digits.");
        return false;
      }

      if (/[^0-9]/.test(phone)) {
        alert("Phone number can only contain digits.");
        return false;
      }

      if (!/\S+@\S+\.\S+/.test(email)) {
        alert("Please enter a valid email address.");
        return false;
      }

      if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
      }

      const button = document.querySelector('button[type="submit"]');
      button.innerHTML = 'Registering...';
      button.disabled = true;

      return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
      const phoneInput = document.querySelector('input[name="phone"]');
      phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 10) {
          this.value = this.value.slice(0, 10);
        }
      });

      const usernameInput = document.querySelector('input[name="username"]');
      usernameInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-Z]/g, '');
      });

      const messages = document.querySelectorAll('.error-message, .success-message');
      messages.forEach(function(message) {
        setTimeout(() => {
          message.style.opacity = '0';
          message.style.transition = 'opacity 0.5s ease';
          setTimeout(() => message.remove(), 500);
        }, 5000);
      });
    });
  </script>
</body>
</html>
