<?php
// admin_login.php
$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT AdminID, Password FROM ADMIN WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $admin = $res->fetch_assoc();

        if ($admin['Password'] === $password) {
            header("Location: admin_dashboard.php?admin_id=" . $admin['AdminID']);
            exit();
        } else {
            $error = "❌ Incorrect password!";
        }
    } else {
        $error = "❌ Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - NEEDORE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 90vh;
    background: linear-gradient(rgba(255, 255, 255, 0.60), rgba(255, 255, 255, 0.60)),
    url('https://custom-images.strikinglycdn.com/res/hrscywv4p/image/upload/c_limit,fl_lossy,h_9000,w_1200,f_auto,q_auto/8103728/966407_423224.png') no-repeat center center/cover;
    display: flex;
    align-items: center;
    justify-content: flex-end; /* Aligns the form to the right */
    padding-right: 5%; /* Optional: add some right padding */
}

        form {
            background: #FFE4C4;
            backdrop-filter: blur(8px);
            padding: 2rem 2.5rem;
            border-radius: 20px;
            max-width: 400px;
            width: 100%;
            color: #333;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        }
        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-weight: bold;
            font-size: 1.8rem;
            color: #5a2e1b;
        }
        label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: 600;
            color: #4a1e0f;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #ff944d;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e67300;
        }
        .error {
            color: #cc0000;
            text-align: center;
            font-weight: 500;
            margin-bottom: 1rem;
        }
        .js-error {
            color: #900;
            background-color: #ffd2cc;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <form method="POST" onsubmit="return validateForm();">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <div id="jsError" class="js-error" style="display:none;"></div>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required placeholder="Enter your email">

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required placeholder="Enter your password"><br><br>

        <button type="submit">Login</button>
		<div style="text-align:center; margin-top: 1rem;">
    <a href="index.html" style="
        display:inline-block;
        padding:10px 20px;
        background-color:#f44336;
        color:white;
        text-decoration:none;
        border-radius:5px;
        font-weight:bold;
        transition: background-color 0.3s ease;
    ">
        ⬅ Back to Homepage
    </a>
</div>
    </form>
	

    <script>
        function validateForm() {
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const errorDiv = document.getElementById("jsError");
            errorDiv.style.display = "none";

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                errorDiv.innerText = "Please enter a valid email address.";
                errorDiv.style.display = "block";
                return false;
            }

            if (password.length < 6) {
                errorDiv.innerText = "Password must be at least 6 characters long.";
                errorDiv.style.display = "block";
                return false;
            }

            return true;
        }
    </script>
</body>
</html>