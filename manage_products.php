<?php
require_once 'db.php';
if ($conn->connect_error) die("Connection failed.");

if (!isset($_GET['admin_id'], $_GET['action'])) die("Invalid access");

$admin_id = intval($_GET['admin_id']);
$action = $_GET['action'];

$subcategories = $conn->query("SELECT * FROM SUBCATEGORY");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(rgba(255, 255, 255, 0.60), rgba(255, 255, 255, 0.60)),
                        url('https://png.pngtree.com/thumb_back/fh260/background/20210609/pngtree-3d-render-online-shopping-with-mobile-and-bag-image_727266.jpg') no-repeat center center/cover;
            display: flex;
            align-items: flex-start;  /* align top */
            justify-content: flex-start;  /* align left */
            padding: 60px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        select, button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            background-color: white;
        }

        select:focus {
            outline: none;
            border-color: #28a745;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .btn-back {
            display: block;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
            padding: 10px;
            background: #007bff;
            color: white;
            border-radius: 5px;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form method="GET" action="manage_action.php">
        <h2><?= ucfirst($action) ?> Product</h2>
        <input type="hidden" name="admin_id" value="<?= $admin_id ?>">
        <input type="hidden" name="action" value="<?= htmlspecialchars($action) ?>">

        <label>Select Subcategory:</label>
        <select name="subcat_id" required>
            <?php foreach ($subcategories as $s): ?>
                <option value="<?= $s['SubCategoryID'] ?>"><?= $s['SubCategoryName'] ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Proceed</button>

        <a class="btn-back" href="admin_dashboard.php?admin_id=<?= $admin_id ?>">Back to Dashboard</a>
    </form>
</div>

</body>
</html>
