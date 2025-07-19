<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: userlogin.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$customer_id = $_SESSION['customer_id'];
$product_id = $_GET['product_id'] ?? null;

if (!$product_id) {
    header("Location: browse_products.php");
    exit();
}

// Fetch product info
$stmt = $conn->prepare("SELECT * FROM PRODUCT WHERE ProductID = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form data
    $name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $method = $_POST['payment_method'];
    $amount = $product['Price'];
    $status = "Success";

    // Insert into ORDERS
	$status = "Ordered";
$stmt = $conn->prepare("INSERT INTO ORDERS 
(CustomerID, Order_Date, TotalAmount, Status, Name, Phone, ShippingAddress, City, State, Pincode) 
VALUES (?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("idsssssss", $customer_id, $amount, $status, $name, $phone, $address, $city, $state, $pincode);
$stmt->execute();
$order_id = $stmt->insert_id;


    // Insert into PAYMENT
    $stmt = $conn->prepare("INSERT INTO PAYMENT (OrderID, PaymentDate, PaymentMethod, PaymentStatus, Amount)
                            VALUES (?, NOW(), ?, ?, ?)");
    $stmt->bind_param("issd", $order_id, $method, $status, $amount);
    $stmt->execute();

    header("Location: my_orders.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment - NEEDORE</title>
    <style>
        body {
            font-family: Arial;
            background: #fef2f8;
            padding: 40px;
        }
        .container {
            max-width: 650px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            margin: auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: black;
        }
        .product {
            text-align: center;
            margin-bottom: 30px;
        }
        .product img {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 8px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1.8px solid #d474cb;
            margin-bottom: 15px;

        }
        .submit-btn {
            margin-top: 15px;
            width: 100%;
            padding: 12px;
            background: #f5def5;
            color: #b014b0;
            font-size: 16px;
            border: 2px solid #e0aee0;
            border-radius: 6px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background: #f7c3f7;
            color: #a012a0;
        }
        .optional-fields {
            display: none;
        }
        .section-title {
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: black;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Shipping & Payment</h2>

    <div class="product">
        <img src="<?= htmlspecialchars($product['Image_URL']) ?>" alt="Product">
        <h3><?= htmlspecialchars($product['Name']) ?></h3>
        <p><strong>Price: ₹<?= number_format($product['Price'], 2) ?></strong></p>
    </div>

    <form method="POST" onsubmit="return validatePaymentForm();">
        <!-- Shipping Section -->
        <div class="section-title">Shipping Address</div>
        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" id="full_name" required>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" id="phone" maxlength="10" required>

        <label for="address">Full Address:</label>
        <input type="text" name="address" id="address" required>

        <label for="pincode">Pincode:</label>
        <input type="text" name="pincode" id="pincode" maxlength="6" required>

        <label for="city">City:</label>
        <input type="text" name="city" id="city" required>

        <label for="state">State:</label>
        <input type="text" name="state" id="state" required>

        <!-- Payment Section -->
        <div class="section-title">Payment Method</div>
        <label for="payment_method">Select Payment Method:</label>
        <select name="payment_method" id="payment_method" required onchange="togglePaymentFields()">
            <option value="">-- Choose Method --</option>
            <option value="COD">Cash on Delivery</option>
            <option value="UPI">UPI</option>
            <option value="Debit Card">Debit Card</option>
            <option value="Credit Card">Credit Card</option>
        </select>

        <div id="upi_field" class="optional-fields">
            <label for="upi_id">UPI ID:</label>
            <input type="text" id="upi_id" placeholder="example@upi">
        </div>

        <div id="card_fields" class="optional-fields">
            <label for="card_number">Card Number:</label>
            <input type="text" id="card_number" maxlength="16" placeholder="Enter 16-digit card number">

            <label for="card_expiry">Expiry Date:</label>
            <input type="text" id="card_expiry">

            <label for="card_cvv">CVV:</label>
            <input type="password" id="card_cvv" maxlength="3" placeholder="CVV">
        </div>

        <button type="submit" class="submit-btn">Confirm & Place Order</button>
    </form>

    <div class="back-link">
        <a href="browse_products.php">← Back to Browse</a>
    </div>
</div>

<script>
    function togglePaymentFields() {
        const method = document.getElementById('payment_method').value;
        document.getElementById('upi_field').style.display = (method === 'UPI') ? 'block' : 'none';
        document.getElementById('card_fields').style.display = (method === 'Debit Card' || method === 'Credit Card') ? 'block' : 'none';
    }

    function validatePaymentForm() {
        const method = document.getElementById('payment_method').value;

        if (method === 'UPI') {
            const upi = document.getElementById('upi_id').value.trim();
            if (upi === '') {
                alert("Please enter your UPI ID.");
                return false;
            }
        }

        if (method === 'Debit Card' || method === 'Credit Card') {
            const num = document.getElementById('card_number').value.trim();
            const exp = document.getElementById('card_expiry').value;
            const cvv = document.getElementById('card_cvv').value.trim();

            
            if (!exp) {
                alert("Please enter card expiry date.");
                return false;
            }
            if (cvv.length !== 3 || isNaN(cvv)) {
                alert("Please enter valid 3-digit CVV.");
                return false;
            }
        }

        return true;
    }
</script>
</body>
</html>
