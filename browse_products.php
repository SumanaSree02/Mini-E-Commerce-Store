<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: userlogin.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$customer_id = $_SESSION['customer_id'];

function fetchAll($query) {
    global $conn;
    $result = $conn->query($query);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

$step = $_GET['step'] ?? 'categories';
$id = $_GET['id'] ?? 0;

// Handle Add to Cart only (NOT Buy Now)
if ($step === 'add_to_cart' && isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);
    $stmt = $conn->prepare("SELECT CartID FROM CART WHERE CustomerID = ? ORDER BY CreatedAt DESC LIMIT 1");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $cart_id = ($res && $res->num_rows > 0) ? $res->fetch_assoc()['CartID'] : null;

    if (!$cart_id) {
        $stmt = $conn->prepare("INSERT INTO CART (CustomerID, CreatedAt) VALUES (?, NOW())");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $cart_id = $stmt->insert_id;
    }

    $stmt = $conn->prepare("SELECT CartItemID FROM CARTITEMS WHERE CartID = ? AND ProductID = ?");
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
    $exists = $stmt->get_result();

    if ($exists->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE CARTITEMS SET Quantity = Quantity + 1 WHERE CartID = ? AND ProductID = ?");
    } else {
        $stmt = $conn->prepare("INSERT INTO CARTITEMS (CartID, ProductID, Quantity) VALUES (?, ?, 1)");
    }
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();

    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Browse Products - NEEDORE</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f9f0f9 ;
    padding: 40px;
    margin: 0;
}
h2 {
    text-align: center;
    color: black;
    margin-bottom: 30px;
    font-size: 28px;
    letter-spacing: 0.5px;
    
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 30px;
}

.card {
     background: rgba(255, 255, 255, 0.25);
    border-radius: 16px;
     box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
    padding: 25px 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.1);
}

.card img {
    width: 100%;
    height: 210px;
    object-fit: contain;
    background: #fef5f8;
    padding: 12px;
    margin-bottom: 18px;
    border-radius: 10px;
    border: 1px solid #f3cbd9;
}

.btn {
    margin-top: 14px;
    padding: 10px 10px;
    background: #f5def5;
    color: #b014b0;
    border: 2px solid #e0aee0;
    font-weight: bold;
    border: none;
    text-decoration: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.btn:hover {
    background: #f7c3f7;
    color: #a012a0;
}


.icon {
    font-size: 35px;
    color:   #dd57ddff;
    margin: 18px 0;
}
.card a{
    font-size: 0.9rem;
}
.card h3{
    font-size:1rem;
    
}
    </style>
</head>
<body>

<h2>Browse Products</h2>

<?php
// icon mapping
$icons = [
    'Books and Stationary' => 'fa-book',
    'Electronics' => 'fa-tv',
    'Clothing' => 'fa-shirt',
    'Footwear' => 'fa-shoe-prints',
    'Beauty and Personal Care' => 'fa-face-smile',
    'Home and Living' => 'fa-couch',
    'Sports and Fitness' => 'fa-dumbbell',
    'Food and Beverages' => 'fa-utensils',
    'Toys' => 'fa-puzzle-piece'
];

if ($step === 'categories') {
    $categories = fetchAll("SELECT * FROM CATEGORY");
    echo '<div class="grid">';
    foreach ($categories as $cat) {
        $icon = $icons[$cat['CategoryName']] ?? 'fa-box';
        echo "<div class='card'>
                <h3>{$cat['CategoryName']}</h3>
                <i class='fas $icon icon'></i>
                <a class='btn' href='?step=subcategories&id={$cat['CategoryID']}'>View Subcategories</a>
              </div>";
    }
    echo '</div>';

    echo '<div style="text-align:center; margin-top:30px;">
            <a href="userprofile.php" class="btn">← Back to Dashboard</a>
          </div>';
}
elseif ($step === 'subcategories') {
    $subcats = fetchAll("SELECT * FROM SUBCATEGORY WHERE CategoryID = $id");
    echo '<div class="grid">';
    foreach ($subcats as $sub) {
        echo "<div class='card'>
                <h3>{$sub['SubCategoryName']}</h3>
                <i class='fas fa-box-open icon'></i>
                <a class='btn' href='?step=products&id={$sub['SubCategoryID']}'>View Products</a>
              </div>";
    }
    echo '</div>';
}
elseif ($step === 'products') {
    $products = fetchAll("SELECT * FROM PRODUCT WHERE SubCategoryID = $id");
    echo '<div class="grid">';
    foreach ($products as $p) {
        echo "<div class='card'>
                <img src='{$p['Image_URL']}' alt=''>
                <h4>{$p['Name']}</h4>
                <a class='btn' href='?step=product&id={$p['ProductID']}'>View Details</a>
              </div>";
    }
    echo '</div>';
}
elseif ($step === 'product') {
    $product = fetchAll("SELECT * FROM PRODUCT WHERE ProductID = $id")[0];
    echo "<div class='card'>
            <img src='{$product['Image_URL']}' alt=''>
            <h3>{$product['Name']}</h3>
            <p><strong>₹{$product['Price']}</strong></p>
            <p>{$product['Description']}</p>
            <a href='?step=add_to_cart&product_id={$product['ProductID']}' class='btn'>Add to Cart</a>
            <a href='payment.php?product_id={$product['ProductID']}' class='btn'>Buy Now</a>
          </div>";
}
?>

</body>
</html>