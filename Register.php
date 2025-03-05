<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Coffee Hub - Register</title>
  <style>
    /* Import Google Font */
    @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;700&display=swap');
    
    /* Global Styling */
    body {
      font-family: 'Nunito', sans-serif;
      background: #6f4e37; /* Coffee brown solid background */
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .form-container {
      background: rgba(78, 52, 37, 0.9);
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 400px;
      color: #fff;
    }
    .form-container h1 {
      color: #d4a373;
      font-weight: 700;
      margin-bottom: 20px;
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
    }
    .form-container input:focus {
      border-color: #d4a373;
      outline: none;
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
    }
    .form-container a:hover {
      text-decoration: underline;
    }
    .success-message {
      color: #a5d6a7;
      font-weight: bold;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Register</h1>
    <form action="Register.php" method="POST" onsubmit="return validateForm()">
      <input type="text" name="username" placeholder="Username" required />
      <input type="tel" name="phone" placeholder="Phone Number" required />
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <a href="login.php"> <button type="submit">Register</button></a>
      <a href="login.php">Already have an account? Login</a>
    </form>
    <?php if (!empty($success_message)) { ?>
      <p class="success-message"><?php echo $success_message; ?></p>
    <?php } ?>
  </div>
  <script>
    function validateForm() {
      var username = document.querySelector('input[name="username"]').value.trim();
      var phone = document.querySelector('input[name="phone"]').value.trim();
      var email = document.querySelector('input[name="email"]').value.trim();
      var password = document.querySelector('input[name="password"]').value.trim();
      if (username === "" || phone === "" || email === "" || password === "") {
          alert("All fields are required.");
          return false;
      }
      return true;
    }
  </script>
</body>
</html>
