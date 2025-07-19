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
$success = "";
$error = "";

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if ($name && $email && $phone && $address) {
        $stmt = $conn->prepare("UPDATE CUSTOMER SET Name = ?, Email = ?, Phone = ?, Address = ? WHERE CustomerID = ?");
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $customer_id);

        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
        } else {
            $error = "Failed to update profile. Please try again.";
        }
    } else {
        $error = "All fields are required.";
    }
}

// Fetch current profile data
$stmt = $conn->prepare("SELECT Name, Email, Phone, Address FROM CUSTOMER WHERE CustomerID = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $name = $row['Name'];
    $email = $row['Email'];
    $phone = $row['Phone'];
    $address = $row['Address'];
} else {
    $error = "Failed to retrieve profile.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile - NEEDORE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff0f5;
            padding: 40px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background:white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: black;
        }

        label {
            display: block;
            margin-top: 15px;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1.8px solid #d474cb;
        }

        .btn {
            background: #f7d4f7ff;
            color: #b014b0;
            border: 2px solid #e0aee0;
            font-weight:bold;
            border: 2px solid #e0aee0;
            padding: 10px 16px;
            margin-top: 20px;
            border: none;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background: #f7c3f7;
            color: #a012a0;

        }

        .message {
            margin-top: 15px;
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #000000ff;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>

    <?php if ($success): ?>
        <div class="message"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($name) ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($email) ?>" required>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="<?= htmlspecialchars($phone) ?>" required>

        <label for="address">Address:</label>
        <textarea name="address" id="address" rows="3" required><?= htmlspecialchars($address) ?></textarea>

        <button type="submit" class="btn">Update Profile</button>
    </form>

    <div class="back-link">
        <a href="userprofile.php">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>