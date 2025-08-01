<?php
include('../db/connection.php');

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $code = $_POST['code'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $buy_price = $_POST['buy_price'];
    $sell_price = $_POST['sell_price'];

    $sql = "INSERT INTO products (name, code, price, stock, buy_price, sell_price, created_at)
            VALUES ('$name', '$code', '$price', '$stock', '$buy_price', '$sell_price', NOW())";

    if (mysqli_query($conn, $sql)) {
        $message = "✅ Product added successfully!";
        $success = true;
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>➕ Add Product</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(145deg, #d0f0fd, #c2f5d0); /* Blue-green smooth 3D effect */
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            width: 400px;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1f3b4d;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            transition: 0.3s ease;
        }

        input:focus {
            border-color: #00b894;
            box-shadow: 0 0 10px rgba(0, 184, 148, 0.3);
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 14px;
            font-size: 16px;
            background: linear-gradient(to right, #00b894, #0984e3);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background: linear-gradient(to right, #00cec9, #74b9ff);
        }

        .message {
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>➕ Add Product</h2>
        <form method="POST">
            <label>📦 Product Name:</label>
            <input type="text" name="name" required>

            <label>🔢 Product Code:</label>
            <input type="text" name="code" required>

            <label>💰 Buy Price:</label>
            <input type="number" name="buy_price" step="0.01" required>

            <label>💸 Sell Price:</label>
            <input type="number" name="sell_price" step="0.01" required>

            <label>📦 Total Stock:</label>
            <input type="number" name="stock" required>

            <label>💲 Display Price (৳):</label>
            <input type="number" name="price" step="0.01" required>

            <button type="submit">✅ Save Product</button>
        </form>

        <?php if ($message): ?>
            <div class="message <?= $success ? 'success' : 'error' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>