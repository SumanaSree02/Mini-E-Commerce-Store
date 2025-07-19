<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: userlogin.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "MiniEcommerceStore", 3300);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT ProductID, Name, Image_URL FROM PRODUCT";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Design My Room</title>
    <style>
        body { font-family: Arial; background-color: #f2f2f2; padding: 30px; }
        h2 { text-align: center; color: #5a2e1b; }
        #product-bar {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding: 15px;
            margin-bottom: 20px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #ccc;
            max-width: 900px;
            margin-inline: auto;
        }
        .product {
            width: 90px;
            height: 90px;
            border: 1px solid #aaa;
            border-radius: 8px;
            object-fit: contain;
            cursor: grab;
        }
        #room {
            width: 90%;
            height: 500px;
            margin: auto;
            border: 2px dashed #999;
            background: url('images/room-bg.jpg') center/cover no-repeat;
            border-radius: 12px;
            position: relative;
        }
        .drop-item {
            width: 90px;
            height: 90px;
            position: absolute;
            cursor: move;
            object-fit: contain;
        }
        #actions {
            text-align: center;
            margin-top: 25px;
        }
        button {
            padding: 10px 20px;
            margin: 0 12px;
            background-color: #5a2e1b;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #3e1d0d;
        }
    </style>
</head>
<body>
<h2>🛋️ Design Your Look</h2>

<div id="product-bar">
<?php while ($row = $result->fetch_assoc()): ?>
    <img src="<?= htmlspecialchars($row['Image_URL']) ?>"
         class="product"
         draggable="true"
         data-id="<?= $row['ProductID'] ?>"
         alt="<?= htmlspecialchars($row['Name']) ?>">
<?php endwhile; ?>
</div>

<div id="room" ondragover="allowDrop(event)" ondrop="drop(event)"></div>

<div id="actions">
    <button onclick="buyAllItems()">🛒 Buy All Items</button>
    <button onclick="clearRoom()">❌ Clear Room</button>
    <a href="userprofile.php"><button>← Back to Dashboard</button></a>
</div>

<script>
    let draggedItem;
    let droppedItems = [];

    document.querySelectorAll('.product').forEach(item => {
        item.addEventListener('dragstart', e => {
            draggedItem = e.target;
        });
    });

    function allowDrop(e) {
        e.preventDefault();
    }

    function drop(e) {
        e.preventDefault();
        const newItem = draggedItem.cloneNode(true);
        newItem.classList.add('drop-item');
        newItem.style.left = `${e.offsetX - 45}px`;
        newItem.style.top = `${e.offsetY - 45}px`;
        newItem.setAttribute('draggable', 'true');
        newItem.addEventListener('dragstart', ev => {
            draggedItem = ev.target;
        });

        // Double-click to delete only that item
        newItem.addEventListener('dblclick', () => {
            newItem.remove();
            const id = newItem.getAttribute('data-id');
            const index = droppedItems.indexOf(id);
            if (index !== -1) droppedItems.splice(index, 1);
        });

        document.getElementById('room').appendChild(newItem);
        droppedItems.push(draggedItem.getAttribute('data-id'));
    }

    function buyAllItems() {
        if (droppedItems.length === 0) {
            alert("You haven't added anything to your room yet!");
            return;
        }
        const uniqueIds = [...new Set(droppedItems)];
        const query = uniqueIds.map(id => `ids[]=${id}`).join('&');
        window.location.href = `add_to_cart.php?${query}`;
    }

    function clearRoom() {
        document.getElementById('room').innerHTML = "";
        droppedItems = [];
    }
</script>
</body>
</html>
