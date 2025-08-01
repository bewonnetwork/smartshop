<?php
include('../db/connection.php');

// Fetch sales report
$query = "SELECT * FROM sales_report ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>📊 Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            padding: 30px;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>📊 Sales Report</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Product</th>
        <th>Qty</th>
        <th>Buy Price</th>
        <th>Sell Price</th>
        <th>Total</th>
        <th>Profit</th>
        <th>Date</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['buy_price'] ?></td>
            <td><?= $row['sell_price'] ?></td>
            <td><?= $row['total_price'] ?></td>
            <td><?= $row['profit'] ?></td>
            <td><?= $row['created_at'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>