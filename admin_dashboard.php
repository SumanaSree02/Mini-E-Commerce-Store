<?php
$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (!isset($_GET['admin_id'])) die("Unauthorized access!");
$admin_id = intval($_GET['admin_id']);

$stmt = $conn->prepare("SELECT Name, Email FROM ADMIN WHERE AdminID = ?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $admin = $res->fetch_assoc();
    $adminName = $admin['Name'];
    $adminEmail = $admin['Email'];
} else {
    die("Admin not found.");
}

$orderCount = $conn->query("SELECT COUNT(*) as total FROM ORDERS")->fetch_assoc()['total'] ?? 0;
$customerCount = $conn->query("SELECT COUNT(*) as total FROM CUSTOMER")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - NEEDORE</title>
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
            background-color: #FFE4C4. ;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h2 {
            font-size: 22px;
            color: #5a2e1b;
            margin: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-info i {
            font-size: 22px;
            color: #333;
        }

        .admin-info span {
            font-weight: bold;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
        }

        .dashboard {
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 30px;
        }

        .card-row {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 40px;
        }

        .card {
            background: #FFE4C4;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .manage-card {
            transform: translateY(50%);
        }

        .btn, select, button {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
            font-size: 14px;
        }

        select {
    width: 100%;
    margin-top: 10px;
    padding: 10px;
    background-color: white; /* sets background to white */
    color: black;            /* ensures text is visible */
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}


        form {
            margin-top: 10px;
        }

        .footer {
            background: #FFE4C4;
            color: #333;
            padding: 15px;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>
<body>

<header>
    <h2>NEEDORE</h2>
    <div class="admin-info">
        <i class="fas fa-user-circle"></i>
        <span><?= htmlspecialchars($adminName) ?></span>
        <a href="admin_login.php" class="logout-btn">Logout</a>
    </div>
</header>

<div class="dashboard">
    <div class="card-row">
        <!-- Card 1 -->
        <div class="card" id="card1">
            <h3>No Of Orders</h3>
            <p style="font-size: 24px; color: green;"><b><?= $orderCount ?></b></p>
        </div>

        <!-- Card 3 (Manage Products) - shifted vertically -->
        <div class="card manage-card">
            <h3>Manage Products</h3>
            <form method="GET" action="manage_products.php">
                <input type="hidden" name="admin_id" value="<?= $admin_id ?>">
                <label for="action">Select Action:</label>
                <select name="action" required>
                    <option value="">-- Choose --</option>
                    <option value="add">Add Product</option>
                    <option value="edit">Edit Product</option>
                    <option value="delete">Delete Product</option>
                </select>
                <button type="submit">Next</button>
            </form>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="card" id="card2">
        <h3>Registered Customers</h3>
        <p style="font-size: 24px; color: #007bff;"><b><?= $customerCount ?></b></p>
    </div>
</div>

<div class="footer">
    Email: <?= htmlspecialchars($adminEmail) ?>
</div>

</body>
</html>
