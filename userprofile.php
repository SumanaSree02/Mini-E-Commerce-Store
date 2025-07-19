<?php
session_start();

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: userlogin.php");
    exit();
}

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

// Fetch user details
$customer_id = $_SESSION['customer_id'];
$stmt = $conn->prepare("SELECT Name, Email FROM CUSTOMER WHERE CustomerID = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $customerName = $row['Name'];
    $customerEmail = $row['Email'];
} else {
    $customerName = "User";
    $customerEmail = "Not Available";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - NEEDORE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(rgba(255, 255, 255, 0.60), rgba(255, 255, 255, 0.60)),
                        url('https://png.pngtree.com/thumb_back/fh260/background/20210609/pngtree-3d-render-online-shopping-with-mobile-and-bag-image_727266.jpg') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #FFFCF5;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h2 {
  font-size: 1.3rem;
  font-weight: 600;
  color: #393b3eff;
  letter-spacing: 1px;
  font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
  margin-right: 2rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info i {
            font-size: 22px;
            color: #333;
        }

        .user-info span {
            font-weight: bold;
            color: #5a2e1b;
        }

        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 14px;
            border-radius: 5px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .dashboard-wrapper {
    padding: 60px 60px;
}
.dashboard-columns {
    display: flex;
    align-items: flex-start;
    gap: 60px;
}
.dashboard-col {
    display: flex;
    flex-direction: column;
    gap: 30px;
}
.center-col {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    padding-top: 60px;
}
.card {
    background: #FFFCF5;
    width: 250px;
    height: 250px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    transition: transform 0.2s;
}
.card:hover {
    transform: scale(1.03);
}
.card i {
    font-size: 36px;
    margin-bottom: 10px;
    color: #5a2e1b;
}
.card a {
    text-decoration: none;
    font-weight: bold;
    color: #5a2e1b;
    font-size: 18px;
}

        .footer {
            background-color: #1F2937;
            padding: 15px;
            text-align: center;
            margin-top: auto;
            color: #D1D5DB;
        }
    </style>
</head>
<body>

<header>
    <h2>NEEDORE</h2>
    <div class="user-info">
        <i class="fas fa-user-circle"></i>
        <span><?= htmlspecialchars($customerName) ?></span>
        <a href="?logout=true" class="logout-btn">Logout</a>
    </div>
</header>
<div class="dashboard-wrapper">
    <div class="dashboard-columns">
        <div class="dashboard-col">
            <div class="card">
                <i class="fas fa-store"></i>
                <a href="browse_products.php">Browse Products</a>
            </div>
            <div class="card">
                <i class="fas fa-shopping-cart"></i>
                <a href="cart.php">My Cart</a>
            </div>
        </div>
        <div class="dashboard-col">
            <div class="card">
                <i class="fas fa-clipboard-list"></i>
                <a href="my_orders.php">My Orders</a>
            </div>
            <div class="card">
                <i class="fas fa-user-edit"></i>
                <a href="edit_profile.php">Edit Profile</a>
            </div>
        </div>
        <div class="dashboard-col center-col">
            <div class="card">
                <i class="fas fa-couch"></i>
                <a href="myroom.php">Design My Look</a>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    Logged in as: <?= htmlspecialchars($customerEmail) ?>
</div>

</body>
</html>
