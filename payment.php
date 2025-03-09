<?php
session_start(); // Start the session

// Check if necessary session variables exist
if (!isset($_SESSION['order_id']) || !isset($_SESSION['total_amount']) || !isset($_SESSION['cart_items'])) {
    // Redirect back to cart if session variables are missing
    header("Location: cart.php");
    exit();
}

// Initialize variables
$order_id = $_SESSION['order_id'];
$total_amount = $_SESSION['total_amount'];
$cart_items = $_SESSION['cart_items'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch payment details
$payment_id = isset($_SESSION['payment_id']) ? $_SESSION['payment_id'] : ''; 
$payment_details = null;

if ($payment_id) {
    $stmt = $conn->prepare("SELECT * FROM payment WHERE payment_id = ?");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $payment_details = $result->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>THE COFFEE HUB</title>
  <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #4B3D3D; /* Coffee-related background */
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    .tab {
        display: flex;
        justify-content: center;
        background-color: #6F4E37;
        padding: 10px 0;
    }

    .tab button {
        background-color: inherit;
        color: white;
        padding: 14px 20px;
        border: none;
        cursor: pointer;
        font-size: 17px;
        transition: background-color 0.3s;
        outline: none;
        flex: 1;
        text-align: center;
    }

    .tab button:hover {
        background-color: #575757;
    }

    .tab button.active {
        background-color: #4CAF50;
    }

    .tabcontent {
        display: none;
        padding: 20px;
        background-color: #fff;
        margin-top: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 50%;
        margin: 20px auto;
    }

    input[type="text"], input[type="password"], input[type="month"], input[type="submit"], input[type="reset"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    input[type="submit"], input[type="reset"] {
        background-color: #4CAF50;
        color: white;
        cursor: pointer;
        border: none;
    }

    input[type="submit"]:hover, input[type="reset"]:hover {
        background-color: #45a049;
    }

    .Bill-button {
        background-color: #f44336;
        color: white;
        padding: 10px 20px;
        margin: 20px auto;
        display: block;
        text-align: center;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
        text-decoration: none;
    }

    .Bill-button:hover {
        background-color: #d73833;
    }

    @media screen and (max-width: 768px) {
        .tabcontent {
            width: 90%;
        }

        .tab button {
            padding: 10px;
            font-size: 15px;
        }
    }

    select {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    
    #processingMessage {
        text-align: center;
    }
    
    .error-message {
        color: red;
        margin: 10px 0;
        padding: 10px;
        border: 1px solid red;
        border-radius: 4px;
        background-color: #fff3f3;
    }
  </style>

  <script>
    function openPaymentMethod(evt, methodName) {
        var tabcontent = document.getElementsByClassName("tabcontent");
        for (var i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";  
        }
        var tablinks = document.getElementsByClassName("tablinks");
        for (var i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(methodName).style.display = "block";  
        evt.currentTarget.className += " active";
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById("defaultOpen").click();
    });

    function showOrderPlaced() {
        // Show processing message
        var processingMsg = document.createElement('div');
        processingMsg.id = 'processingMessage';
        processingMsg.innerHTML = '<h3>Processing Payment...</h3><p>Please do not refresh or close this page.</p>';
        processingMsg.style.position = 'fixed';
        processingMsg.style.top = '50%';
        processingMsg.style.left = '50%';
        processingMsg.style.transform = 'translate(-50%, -50%)';
        processingMsg.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
        processingMsg.style.padding = '20px';
        processingMsg.style.borderRadius = '5px';
        processingMsg.style.boxShadow = '0 0 10px rgba(0,0,0,0.2)';
        processingMsg.style.zIndex = '1000';
        document.body.appendChild(processingMsg);
        
        // Disable the form
        var forms = document.getElementsByTagName('form');
        for(var i = 0; i < forms.length; i++) {
            forms[i].style.opacity = '0.5';
            forms[i].style.pointerEvents = 'none';
        }
        
        return true;
    }
  </script>
</head>
<body>

<header>...</header>

<main>
    <div class="payment-form">
        <div class="tab">
            <button class="tablinks" onclick="openPaymentMethod(event, 'CreditCard')" id="defaultOpen">Credit Card</button>
            <button class="tablinks" onclick="openPaymentMethod(event, 'DebitCard')">Debit Card</button>
            <button class="tablinks" onclick="openPaymentMethod(event, 'InternetBanking')">Internet Banking</button>
            <button class="tablinks" onclick="openPaymentMethod(event, 'WalletCashCard')">Wallet/Cash Card</button>
            <button class="tablinks" onclick="openPaymentMethod(event, 'COD')">Cash on Delivery</button>
        </div>

        <div id="CreditCard" class="tabcontent">
            <h3>Pay by Credit Card</h3>
            <form action="Bill.php" method="POST" onsubmit="return showOrderPlaced();">
                <p>Card Number</p>
                <input type="text" name="card" placeholder="Enter Card Number" pattern="[0-9]{16}" title="Please enter a valid 16-digit card number" required>
                <p>Expiration Date</p>
                <input type="month" name="month" required>
                <p>CVV/CVC</p>
                <input type="text" name="cvv" pattern="[0-9]{3,4}" title="Please enter a valid CVV (3 or 4 digits)" required>
                <p>Card Holder Name</p>
                <input type="text" name="name" placeholder="Enter Card Holder Name" required>

                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                <input type="hidden" name="total_amount" value="<?php echo number_format(floatval($total_amount), 2, '.', ''); ?>">
                <input type="hidden" name="payment_method" value="Credit Card">
                <input type="hidden" name="transaction_id" value="<?php echo uniqid('CC_'); ?>">

                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </form>
        </div>

        <div id="DebitCard" class="tabcontent">
            <h3>Pay by Debit Card</h3>
            <form action="Bill.php" method="POST" onsubmit="return showOrderPlaced();">
                <p>Card Number</p>
                <input type="text" name="card" placeholder="Enter Card Number" pattern="[0-9]{16}" title="Please enter a valid 16-digit card number" required>
                <p>Expiration Date</p>
                <input type="month" name="month" required>
                <p>CVV/CVC</p>
                <input type="text" name="cvv" pattern="[0-9]{3,4}" title="Please enter a valid CVV (3 or 4 digits)" required>
                <p>Card Holder Name</p>
                <input type="text" name="name" placeholder="Enter Card Holder Name" required>
                
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                <input type="hidden" name="total_amount" value="<?php echo number_format(floatval($total_amount), 2, '.', ''); ?>">
                <input type="hidden" name="payment_method" value="Debit Card">
                <input type="hidden" name="transaction_id" value="<?php echo uniqid('DC_'); ?>">
                
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </form>
        </div>

        <div id="InternetBanking" class="tabcontent">
            <h3>Pay by Internet Banking</h3>
            <form action="Bill.php" method="POST" onsubmit="return showOrderPlaced();">
                <p>Select Bank</p>
                <select name="bank_name" required>
                    <option value="">Select Your Bank</option>
                    <option value="State Bank of India">State Bank of India</option>
                    <option value="HDFC Bank">HDFC Bank</option>
                    <option value="ICICI Bank">ICICI Bank</option>
                    <option value="Axis Bank">Axis Bank</option>
                    <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
                    <option value="Punjab National Bank">Punjab National Bank</option>
                    <option value="Bank of Baroda">Bank of Baroda</option>
                    <option value="IDBI Bank">IDBI Bank</option>
                    <option value="Canara Bank">Canara Bank</option>
                    <option value="Other">Other</option>
                </select>
                
                <p>Account Number</p>
                <input type="text" name="account_number" placeholder="Enter Account Number" pattern="[0-9]{9,18}" title="Please enter a valid account number" required>
                
                <p>Account Type</p>
                <select name="account_type" required>
                    <option value="">Select Account Type</option>
                    <option value="saving">Saving</option>
                    <option value="current">Current</option>
                </select>
                
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                <input type="hidden" name="total_amount" value="<?php echo number_format(floatval($total_amount), 2, '.', ''); ?>">
                <input type="hidden" name="payment_method" value="Internet Banking">
                <input type="hidden" name="transaction_id" value="<?php echo uniqid('IB_'); ?>">
                
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </form>
        </div>

        <div id="WalletCashCard" class="tabcontent">
            <h3>Pay by Wallet/Cash Card</h3>
            <form action="Bill.php" method="POST" onsubmit="return showOrderPlaced();">
                <p>Card Number</p>
                <input type="text" name="card" placeholder="Enter Card Number" pattern="[0-9]{16}" title="Please enter a valid 16-digit card number" required>
                <p>Pin</p>
                <input type="password" name="pwd" placeholder="Enter Pin" pattern="[0-9]{4,6}" title="Please enter a valid PIN (4-6 digits)" required>
                
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                <input type="hidden" name="total_amount" value="<?php echo number_format(floatval($total_amount), 2, '.', ''); ?>">
                <input type="hidden" name="payment_method" value="Wallet/Cash Card">
                <input type="hidden" name="transaction_id" value="<?php echo uniqid('WC_'); ?>">
                
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </form>
        </div>

        <div id="COD" class="tabcontent">
            <h3>Cash on Delivery</h3>
            <form action="Bill.php" method="POST" onsubmit="return showOrderPlaced();">
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
                <input type="hidden" name="total_amount" value="<?php echo number_format(floatval($total_amount), 2, '.', ''); ?>">
                <input type="hidden" name="payment_method" value="Cash on Delivery">
                
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
</main>

<footer>...</footer>

<?php if ($payment_details): ?>
    <div class="payment-details">
        <h3>Payment Details</h3>
        <p><strong>Payment ID:</strong> <?php echo htmlspecialchars($payment_details['payment_id']); ?></p>
        <p><strong>Order ID:</strong> <?php echo htmlspecialchars($payment_details['order_id']); ?></p>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($payment_details['transaction_id']); ?></p>
        <p><strong>Price:</strong> <?php echo htmlspecialchars($payment_details['price']); ?></p>
    </div>
<?php else: ?>
    <p>No payment details found.</p>
<?php endif; ?>

</body>
</html>
