<?php
include('../db/connection.php');

// Search functionality
$search_code = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_code = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM products WHERE code LIKE '%$search_code%' ORDER BY id DESC";
} else {
    $sql = "SELECT * FROM products ORDER BY id DESC";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>📦 Product List</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .header-bar {
            background: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            margin: 0;
            position: relative;
        }

        .header-bar form {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .header-bar input[type="text"] {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
        }

        .header-bar button {
            padding: 6px 12px;
            background: #fff;
            color: #4CAF50;
            border: none;
            border-radius: 4px;
            margin-left: 5px;
            cursor: pointer;
        }

        .header-bar button:hover {
            background: #e8f5e9;
        }

        table {
            border-collapse: collapse;
            width: 95%;
            margin: 30px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
            color: #333;
        }

        a.btn {
            padding: 8px 14px;
            text-decoration: none;
            background: #007bff;
            color: white;
            border-radius: 6px;
            transition: 0.3s;
            display: inline-block;
        }

        a.btn:hover {
            background-color: #0056b3;
        }

        a.btn.delete {
            background: #dc3545;
        }

        a.btn.delete:hover {
            background: #a71d2a;
        }

        a.btn.sell {
            background: #ff9800;
        }

        a.btn.sell:hover {
            background: #e68900;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            width: 95%;
            margin: 20px auto;
            padding: 12px;
            border-radius: 5px;
            text-align: center;
        }

        .out-of-stock {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="header-bar">
    <h2>📦 Product List</h2>
    <form method="GET">
        <input type="text" name="search" placeholder="🔍 Product Code" value="<?= htmlspecialchars($search_code) ?>">
        <button type="submit">Search</button>
    </form>
</div>

<?php if (isset($_GET['sold']) && $_GET['sold'] == 1 && isset($_GET['name'])): ?>
    <div class="success">
        ✅ Sold: <strong><?= htmlspecialchars($_GET['name']) ?></strong> (ID: <?= intval($_GET['id']) ?>) successfully!
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Code</th>
            <th>Price (৳)</th>
            <th>Stock</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['code']) ?></td>
                    <td><?= number_format($row['price'], 2) ?></td>
                    <td><?= $row['stock'] ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a class="btn" href="edit-product.php?id=<?= $row['id'] ?>">✏️ Edit</a>
                        <a class="btn delete" href="../api/delete-product.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');">🗑️ Delete</a>

                        <?php if ($row['stock'] > 0): ?>
                            <a class="btn sell" href="sell-product.php?id=<?= $row['id'] ?>">💰 Sell</a>
                        <?php else: ?>
                            <span class="out-of-stock">Out of Stock</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No products found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>