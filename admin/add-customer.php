<?php
include('../db/connection.php');

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    if ($name !== '' && $phone !== '') {
        $stmt = mysqli_prepare($conn, "INSERT INTO customers (name, phone, created_at) VALUES (?, ?, NOW())");
        mysqli_stmt_bind_param($stmt, "ss", $name, $phone);
        if (mysqli_stmt_execute($stmt)) {
            $message = "✅ Customer added successfully!";
        } else {
            $message = "❌ Failed to add customer.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $message = "⚠️ All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>➕ Add New Customer</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #6dd5fa, #2980b9);
            margin: 0;
            padding: 0;
        }
        .container {
            width: 420px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 10px;
            animation: fadeIn 0.6s ease;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #34495e;
        }
        input[type="text"], input[type="tel"] {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s;
        }
        input:focus {
            border-color: #3498db;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #2ecc71;
            border: none;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #27ae60;
        }
        .message {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 16px;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            text-decoration: none;
            color: #fff;
            background: #2980b9;
            padding: 10px;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .back-link:hover {
            background: #1c5980;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>➕ Add New Customer</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label for="name">👤 Customer Name</label>
            <input type="text" name="name" id="name" required placeholder="Enter full name">

            <label for="phone">📞 Phone Number</label>
            <input type="tel" name="phone" id="phone" required placeholder="e.g. 017XXXXXXXX">

            <button type="submit">➕ Add Customer</button>
        </form>

        <a class="back-link" href="customer-list.php">📋 View All Customers</a>
    </div>
</body>
</html>