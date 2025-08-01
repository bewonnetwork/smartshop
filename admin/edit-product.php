<?php
include('../db/connection.php');

if (!isset($_GET['id'])) {
    die("Product ID not provided.");
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");

if (!$result || mysqli_num_rows($result) === 0) {
    die("Product not found.");
}

$row = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $buy_price = $_POST['buy_price'];
    $sell_price = $_POST['sell_price'];
    $stock = $_POST['stock'];
    $display_price = $_POST['display_price'];

    $sql = "UPDATE products SET 
        name = '$name',
        code = '$code',
        buy_price = $buy_price,
        sell_price = $sell_price,
        stock = $stock,
        price = $display_price
        WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: product-list.php?updated=1");
        exit;
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>✏️ Edit Product</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }
        h2 {
            color: #333;
        }
        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"] {
            width: 300px;
            padding: 8px;
            margin-top: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

    <h2>✏️ Edit Product</h2>

    <form method="POST">
        <label>Product Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" required>

        <label>Product Code:</label>
        <input type="text" name="code" value="<?= htmlspecialchars($row['code']) ?>" required>

        <label>Buy Price:</label>
        <input type="number" name="buy_price" value="<?= $row['buy_price'] ?>" required>

        <label>Sell Price:</label>
        <input type="number" name="sell_price" value="<?= $row['sell_price'] ?>" required>

        <label>Total Stock:</label>
        <input type="number" name="stock" value="<?= $row['stock'] ?>" required>

        <label>Display Price (৳):</label>
        <input type="number" name="display_price" value="<?= $row['price'] ?>" required>

        <br>
        <button type="submit">✅ Update</button>
    </form>

</body>
</html>