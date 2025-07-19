<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: userlogin.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customer_id = $_SESSION['customer_id'];

// Fetch orders for this customer
$stmt = $conn->prepare("SELECT OrderID, Order_Date, TotalAmount, Status FROM ORDERS WHERE CustomerID = ? ORDER BY Order_Date DESC");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders - NEEDORE</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    background: linear-gradient(rgba(255,255,255,0.75), rgba(255,255,255,0.75)),
                url('https://img.freepik.com/free-photo/front-view-cyber-monday-composition_23-2149055981.jpg?semt=ais_hybrid&w=740') no-repeat center center/cover;
    margin: 0;
    padding: 40px;
	min-height: 85vh;
}


        .container {
            max-width: 900px;
            margin: auto;
            background: #f5d1eaff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: black;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: center;
        }

        th {
            background-color: #f5b7d2;
            color: black;
        }

        tr:nth-child(even) {
            background-color: #fff6fa;
        }

        .status {
            font-weight: bold;
            color: #333;
        }

        .back-link {
            margin-top: 25px;
            text-align: center;
        }

        .back-link a {
            text-decoration: none;
            color: black;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .no-orders {
            text-align: center;
            color: #555;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>My Orders</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Order Date</th>
                <th>Total Amount (₹)</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['OrderID']) ?></td>
                    <td><?= htmlspecialchars($row['Order_Date']) ?></td>
                    <td><?= number_format($row['TotalAmount'], 2) ?></td>
                    <td class="status"><?= htmlspecialchars($row['Status']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="no-orders">You have not placed any orders yet.</div>
    <?php endif; ?>

    <div class="back-link">
        <a href="userprofile.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
