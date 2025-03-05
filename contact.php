<?php
// Initialize variables
$messageSent = false;
$feedback = "";

// Process the form if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize inputs
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Validate required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $feedback = "All fields are required!";
    } else {
        // Email recipient (change this to your email)
        $to = "your-email@example.com";  
        $headers  = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        $emailBody  = "Name: $name\n";
        $emailBody .= "Email: $email\n";
        $emailBody .= "Subject: $subject\n\n";
        $emailBody .= "Message:\n$message\n";

        // Attempt to send the email
        if (mail($to, $subject, $emailBody, $headers)) {
            $feedback = "Your message has been sent!";
            $messageSent = true;
        } else {
            $feedback = "Error sending message.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contact Us</title>
  <link rel="stylesheet" href="Style-1.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <style>
    /* Global Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #d1b19b;
    }
    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #6F4E37;
      padding: 5px 6px;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 50;
    }
    .header .logo img {
      width: 50px;
      height: auto;
    }
    .navbar a {
      color: white;
      margin: 0 15px;
      text-decoration: none;
      font-size: 18px;
    }
    .icons i {
      color: white;
      font-size: 20px;
      margin-left: 15px;
      cursor: pointer;
    }
    /* Form Section */
    .contact-container {
      padding: 100px 20px 80px;
      margin-top: 60px;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
      background: white;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .contact-container h2 {
      text-align: center;
      color: #333;
    }
    .contact-container form {
      display: flex;
      flex-direction: column;
    }
    .contact-container label {
      margin-top: 10px;
      font-weight: bold;
    }
    .contact-container input,
    .contact-container textarea {
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .contact-container button {
      margin-top: 15px;
      padding: 10px;
      background: #6F4E37;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 16px;
      cursor: pointer;
    }
    .contact-container button:hover {
      background: #56372e;
    }
    /* Footer */
    .footer {
      text-align: center;
      background: #6F4E37;
      color: white;
      padding: 5px;
      position: fixed;
      width: 100%;
      bottom: 0;
    }
    .feedback {
      text-align: center;
      margin: 20px 0;
      font-size: 18px;
      color: #6F4E37;
    }
  </style>
</head>
<body>
  <!-- Corrected Header -->
  <div class="header">
    <a href="index.php" class="logo">
      <img src="logo.jpg" alt="The Coffee Hub Logo">
    </a>
    <div class="navbar">
      <a href="index.php">Home</a>
      <a href="product.php">Products</a>
      <a href="contact.php">Contact</a>
    </div>
    <div class="icons">
      <i class="fas fa-search"></i>
      <a herf="cart.php"><i class="fas fa-shopping-cart"></i></a>
    </div>
  </div>

  <div class="contact-container">
    <h2>Contact Us</h2>
    
    <!-- Display feedback message if available -->
    <?php if (!empty($feedback)) : ?>
      <div class="feedback"><?php echo $feedback; ?></div>
    <?php endif; ?>
    
    <!-- Only show the form if the message hasn't been sent successfully -->
    <?php if (!$messageSent) : ?>
      <form action="contact.php" method="POST">
          <label for="name">Name:</label>
          <input type="text" id="name" name="name" required>

          <label for="email">Email:</label>
          <input type="email" id="email" name="email" required>

          <label for="subject">Subject:</label>
          <input type="text" id="subject" name="subject" required>

          <label for="message">Message:</label>
          <textarea id="message" name="message" rows="5" required></textarea>

          <button type="submit">Send</button>
      </form>
    <?php endif; ?>
  </div>

  <div class="footer">
    &copy; <?php echo date("Y"); ?> Your Company. All rights reserved.
  </div>
</body>
</html>
