<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🛒 SmartShop Admin Panel</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #d0f0ff, #f0d0ff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
        }

        header {
            width: 100%;
            background: linear-gradient(90deg, #4b6cb7, #182848);
            color: white;
            text-align: center;
            padding: 30px 10px;
            font-size: 42px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            letter-spacing: 1px;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-top: 80px;
        }

        .btn {
            background: linear-gradient(145deg, #ffffff, #d1d1d1);
            box-shadow: 8px 8px 20px #bcbcbc, -8px -8px 20px #ffffff;
            border: none;
            padding: 25px 50px;
            border-radius: 20px;
            font-size: 24px;
            color: #080606ff;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            width: 280px;
            font-weight: bold;
        }

        .btn:hover {
            background: linear-gradient(145deg, #f7f7f7, #d0d0d0);
            transform: scale(1.05);
            box-shadow: 10px 10px 25px #bcbcbc, -10px -10px 25px #ffffff;
        }

        footer {
            margin-top: auto;
            padding: 20px;
            color: #555;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            header {
                font-size: 30px;
                padding: 20px;
            }

            .btn {
                width: 90%;
                font-size: 20px;
                padding: 20px;
            }

            .button-container {
                margin-top: 40px;
            }
        }
    </style>
</head>
<body>

    <header>🛍️ SmartShop Admin Panel</header>

    <div class="button-container">
        <a href="admin/add-product.php" class="btn">➕ Add Product</a>
        <a href="admin/product-list.php" class="btn">📦 View Products</a>
        <a href="admin/sell-product.php" class="btn">💰 Sell Product</a>
        <a href="admin/sales-report.php" class="btn">📊 Sales Report</a> <!-- ✅ LINK FIXED -->
    </div>

    <footer>
        &copy; <?= date('Y') ?> SmartShop. All rights reserved.
    </footer>

</body>
</html>