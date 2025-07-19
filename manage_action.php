<?php
$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if ($conn->connect_error) die("Connection failed.");

if (!isset($_GET['admin_id'], $_GET['action'], $_GET['subcat_id'])) die("Invalid access");

$admin_id = intval($_GET['admin_id']);
$action = $_GET['action'];
$subcat_id = intval($_GET['subcat_id']);

$productList = $conn->query("SELECT * FROM PRODUCT WHERE SubCategoryID = $subcat_id");

$selectedProduct = null;
if (isset($_POST['product_id'])) {
    $pid = intval($_POST['product_id']);
    $selectedProduct = $conn->query("SELECT * FROM PRODUCT WHERE ProductID = $pid")->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_action'])) {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $desc = $_POST['description'] ?? '';
    $img = $_POST['image_url'] ?? '';
    $stock = $_POST['stock'] ?? 0;
    $pid = $_POST['product_id'] ?? null;

    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO PRODUCT (Name, SubCategoryID, Price, Description, Image_URL, Stock_Quantity) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sidssi", $name, $subcat_id, $price, $desc, $img, $stock);
        $stmt->execute();
        echo "<script>
            alert('✅ Product added successfully!');
            setTimeout(() => {
                window.location.href = 'manage_products.php?admin_id=$admin_id&action=$action&subcat_id=$subcat_id';
            }, 500);
        </script>";
        exit;
    }

    if ($action === 'edit' && $pid) {
        $stmt = $conn->prepare("UPDATE PRODUCT SET Name = ?, Price = ?, Description = ?, Image_URL = ?, Stock_Quantity = ? WHERE ProductID = ?");
        $stmt->bind_param("sdssii", $name, $price, $desc, $img, $stock, $pid);
        $stmt->execute();
        echo "<script>
            alert('✅ Product updated successfully!');
            setTimeout(() => {
                window.location.href = 'manage_products.php?admin_id=$admin_id&action=$action&subcat_id=$subcat_id';
            }, 500);
        </script>";
        exit;
    }

    if ($action === 'delete' && $pid) {
        $stmt = $conn->prepare("DELETE FROM PRODUCT WHERE ProductID = ?");
        $stmt->bind_param("i", $pid);
        $stmt->execute();
        echo "<script>
            alert('🗑️ Product deleted successfully!');
            setTimeout(() => {
                window.location.href = 'manage_products.php?admin_id=$admin_id&action=$action&subcat_id=$subcat_id';
            }, 500);
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= ucfirst($action) ?> Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #FFE4C4;
        }

        .form-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            font-size: 15px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            margin-top: 20px;
            cursor: pointer;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            background: #28a745;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .product-select-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .product-card {
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            background: #f9f9f9;
            transition: border-color 0.2s;
        }

        .product-card.selected {
            border-color: #007bff;
            background-color: #e6f0ff;
        }

        .product-card input[type="radio"] {
            transform: scale(1.2);
            margin-bottom: 10px;
        }

        .product-name {
            font-size: 15px;
            font-weight: bold;
            margin-top: 8px;
        }

        .product-image {
            width: 100%;
            height: 130px;
            object-fit: contain;
            border-radius: 6px;
            background: #fff;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h2><?= ucfirst($action) ?> Product</h2>

    <form method="POST">
        <?php if ($action !== 'add'): ?>
            <label>Select Product:</label>
            <div class="product-select-grid">
                <?php foreach ($productList as $product): ?>
                    <?php $isChecked = isset($_POST['product_id']) && $_POST['product_id'] == $product['ProductID']; ?>
                    <label class="product-card <?= $isChecked ? 'selected' : '' ?>">
                        <input type="radio" name="product_id" value="<?= $product['ProductID'] ?>" <?= $isChecked ? 'checked' : '' ?> onchange="this.form.submit()">
                        <img src="<?= htmlspecialchars($product['Image_URL']) ?>" class="product-image" alt="Product Image">
                        <div class="product-name"><?= htmlspecialchars($product['Name']) ?></div>
                    </label>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($action === 'add' || ($action !== 'delete' && $selectedProduct)): ?>
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($selectedProduct['Name'] ?? '') ?>" required>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($selectedProduct['Price'] ?? '') ?>" required>

            <label>Description:</label>
            <textarea name="description"><?= htmlspecialchars($selectedProduct['Description'] ?? '') ?></textarea>

            <label>Image URL:</label>
            <input type="text" name="image_url" value="<?= htmlspecialchars($selectedProduct['Image_URL'] ?? '') ?>">

            <label>Stock Quantity:</label>
            <input type="number" name="stock" value="<?= htmlspecialchars($selectedProduct['Stock_Quantity'] ?? 0) ?>" required>
        <?php endif; ?>

        <button type="submit" name="submit_action"><?= ucfirst($action) ?> Product</button>
        <a href="admin_dashboard.php?admin_id=<?= $admin_id ?>" class="back-link">← Back to Dashboard</a>
    </form>
</div>

</body>
</html>
