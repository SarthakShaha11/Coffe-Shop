<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee-Themed Login</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #6f4e37; /* Coffee brown background color */
      background-image: url('path/to/your/coffee-image.jpg'); /* Optional coffee-related background image */
      background-size: cover; /* Cover the entire background */
      background-position: center; /* Center the image */
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background: rgba(51, 34, 17, 0.9);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      width: 380px;
      text-align: center;
      color: #fff;
    }
    .form-container h1 {
      margin-bottom: 20px;
      font-weight: 600;
      color: #d4a373;
    }
    .form-container input {
      width: 100%;
      padding: 12px;
      margin: 12px 0;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      background: #e5c19f;
      outline: none;
      color: #3e2723;
    }
    .form-container input:focus {
      border: 2px solid #d4a373;
    }
    .form-container button {
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
    .form-container button:hover {
      background: #3e2723;
      transform: scale(1.05);
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
      text-decoration: underline;
      color: #e5c19f;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Login Form</h1>
    <form action="login.php" method="POST" onsubmit="return validateForm()">
      <input type="text" name="username" placeholder="Username" required />
      <input type="tel" name="phone" placeholder="Phone Number" required />
      <input type="password" name="password" placeholder="Password" required />
      <a href="index.php"> <button type="submit">Login</button>
      <a href="Admin_login.php">Admin Login</a>
    </form>
  </div>
  <script>
    function validateForm() {
      var username = document.querySelector('input[name="username"]').value.trim();
      var phone = document.querySelector('input[name="phone"]').value.trim();
      var password = document.querySelector('input[name="password"]').value.trim();
      if (username === "" || phone === "" || password === "") {
          alert("All fields are required.");
          return false;
      }
      return true;
    }
  </script>
</body>
</html>
