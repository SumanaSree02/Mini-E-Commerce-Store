<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// Login logic
if (isset($_POST['login'])) {
    $name = trim($_POST['login_name']);
    $email = trim($_POST['login_email']);

    if ($name === "" || $email === "") {
        $error = "Please enter both name and email.";
    } else {
        $stmt = $conn->prepare("SELECT CustomerID FROM CUSTOMER WHERE Name = ? AND Email = ?");
        $stmt->bind_param("ss", $name, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($customerID);
            $stmt->fetch();
            $_SESSION['customer_id'] = $customerID;
            header("Location: userprofile.php");
            exit();
        } else {
            $error = "User not found. Please register.";
        }
    }
}

// Registration logic
if (isset($_POST['register'])) {
    $name = trim($_POST['reg_name']);
    $email = trim($_POST['reg_email']);
    $phone = trim($_POST['reg_phone']);
    $address = trim($_POST['reg_address']);

    if ($name === "" || $email === "" || $phone === "" || $address === "") {
        $error = "Please fill in all registration fields.";
    } else {
        $check = $conn->prepare("SELECT CustomerID FROM CUSTOMER WHERE Email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already registered. Please login.";
        } else {
            $stmt = $conn->prepare("INSERT INTO CUSTOMER (CustomerID, Name, Email, Phone, Address, CreatedAt) VALUES (NULL, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssss", $name, $email, $phone, $address);
            if ($stmt->execute()) {
                $success = "Registration successful. You can now login.";
            } else {
                $error = "Registration failed. Try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login & Registration</title>
    <style>
	body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    background: linear-gradient(rgba(255, 255, 255, 0.60), rgba(255, 255, 255, 0.60)),
    url('https://img.freepik.com/premium-photo/concept-spring-shopping-season-sale-space-text_185193-98819.jpg?semt=ais_hybrid&w=740') no-repeat center center/cover;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1rem;
}

.card {
    background: white;
    padding: 2rem;
    width: 100%;
    max-width: 400px;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    animation: fadeIn 0.5s ease-in;
}

.card h2 {
    font-size: 1.8rem;
    font-weight: bold;
    margin-bottom: 6px;
    color: #333;
}

.card p {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 20px;
}

.card input {
    width: 100%;
    padding: 12px;
    margin: 10px 0 18px;
    border-radius: 8px;
    border: 1.8px solid #d474cb;
    font-size: 1rem;
    transition: 0.3s;
}

.card input:focus {
    outline: none;
    border-color: #c800b6;
    box-shadow: 0 0 5px rgba(200, 0, 182, 0.2);
}

.card button {
    width: 100%;
    padding: 12px;
    background: #f5def5;
    color: #b014b0;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
    margin-top: 10px;
}

.card button:hover {
    background: #f7c3f7;
    color: #a012a0;
}

.switch-link {
    margin-top: 15px;
    font-size: 0.9rem;
    color: #444;
}

.switch-link a {
    color: #c800b6;
    text-decoration: none;
    font-weight: bold;
}

.switch-link a:hover {
    text-decoration: underline;
}

.error, .success {
    text-align: center;
    margin-bottom: 10px;
    font-weight: bold;
    padding: 10px;
    border-radius: 6px;
    font-size: 0.9rem;
}

.error {
    color: #b4003f;
    background-color: #ffd5de;
    border: 1px solid #f5b4c2;
}

.success {
    color: #2d7c2d;
    background-color: #d9f5d9;
    border: 1px solid #b4e1b4;
}

.hidden {
    display: none;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ✅ Responsive Enhancements */
@media (max-width: 600px) {
    .card {
        padding: 1.5rem;
        max-width: 90vw;
    }

    .card h2 {
        font-size: 1.5rem;
    }

    .card input, .card button {
        font-size: 0.95rem;
    }

    .switch-link {
        font-size: 0.85rem;
    }
}

	</style>

    <script>
        function toggleForm(show) {
            document.getElementById('login-form').style.display = show === 'login' ? 'block' : 'none';
            document.getElementById('register-form').style.display = show === 'register' ? 'block' : 'none';
        }

        function validateLoginForm() {
            const name = document.forms["loginForm"]["login_name"].value.trim();
            const email = document.forms["loginForm"]["login_email"].value.trim();

            if (name === "" || email === "") {
                alert("Please enter both name and email.");
                return false;
            }
            return true;
        }

        function validateRegisterForm() {
            const name = document.forms["registerForm"]["reg_name"].value.trim();
            const email = document.forms["registerForm"]["reg_email"].value.trim();
            const phone = document.forms["registerForm"]["reg_phone"].value.trim();
            const address = document.forms["registerForm"]["reg_address"].value.trim();

            if (name === "" || email === "" || phone === "" || address === "") {
                alert("Please fill in all registration fields.");
                return false;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            const phonePattern = /^[0-9]{10}$/;
            if (!phonePattern.test(phone)) {
                alert("Phone number must be 10 digits.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    
    <div class="card">
        <!-- Login Form -->
        <div id="login-form">
            <h2>User Login</h2>
            <?php if ($error != "" && isset($_POST['login'])) echo "<p class='error'>$error</p>"; ?>
            <form name="loginForm" method="POST" onsubmit="return validateLoginForm()">
    <input type="text" name="login_name" placeholder="Enter your name">
    <input type="email" name="login_email" placeholder="Enter your email">
    <button type="submit" name="login">Login</button>
</form>

<!-- Back to Homepage Button -->

<div class="switch-link">
    New user? <a href="javascript:void(0)" onclick="toggleForm('register')">Register</a>
</div>
        </div>
<div style="text-align:center; margin-top: 1rem;">
    <a href="index.html" style="
        display: inline-block;
        padding: 10px 20px;
        background: #f5def5;
        color: #b014b0;
        
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        font-size: 14px;
        transition: all 0.3s ease;
    " 
    onmouseover="this.style.background='#ebcceb'; this.style.color='#800080'; "
    onmouseout="this.style.background='#f5def5'; this.style.color='#b014b0'; ">
        ⬅ Back to Homepage
    </a>
</div>

        <!-- Registration Form -->
        <div id="register-form" class="hidden">
            <h2>User Registration</h2>
            <?php
                if ($error != "" && isset($_POST['register'])) echo "<p class='error'>$error</p>";
                if ($success != "") echo "<p class='success'>$success</p>";
            ?>
            <form name="registerForm" method="POST" onsubmit="return validateRegisterForm()">
                <input type="text" name="reg_name" placeholder="Enter your name">
                <input type="email" name="reg_email" placeholder="Enter your email">
                <input type="text" name="reg_phone" placeholder="Phone Number">
                <input type="text" name="reg_address" placeholder="Address">
                <button type="submit" name="register">Register</button>
            </form>
            <div class="switch-link">
                Already registered? <a href="javascript:void(0)" onclick="toggleForm('login')">Login</a>
            </div>
        </div>
    </div>

    <script>
        // Keep correct form open after submission
        <?php
        if (isset($_POST['register'])) {
            echo "toggleForm('register');";
        } else {
            echo "toggleForm('login');";
        }
        ?>
    </script>
</body>
</html>