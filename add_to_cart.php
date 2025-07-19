<?php
session_start();
$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if (!isset($_SESSION['customer_id'])) {
    header("Location: userlogin.php");
    exit();
}

$customerId = $_SESSION['customer_id'];
if (!isset($_GET['ids'])) {
    echo "No items selected!";
    exit();
}

$stmt = $conn->prepare("SELECT CartID FROM CART WHERE CustomerID = ? ORDER BY CreatedAt DESC LIMIT 1");
$stmt->bind_param("i", $customerId);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $cartId = $res->fetch_assoc()['CartID'];
} else {
    $createCart = $conn->prepare("INSERT INTO CART (CustomerID, CreatedAt) VALUES (?, NOW())");
    $createCart->bind_param("i", $customerId);
    $createCart->execute();
    $cartId = $createCart->insert_id;
}

foreach ($_GET['ids'] as $productId) {
    $stmt = $conn->prepare("INSERT INTO CARTITEMS (CartID, ProductID, Quantity) VALUES (?, ?, 1)");
    $stmt->bind_param("ii", $cartId, $productId);
    $stmt->execute();
}

header("Location: cart.php");
exit();
?>
