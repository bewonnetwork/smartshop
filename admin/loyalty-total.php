<?php
include('../db/connection.php');

// Loyalty Point summary per product
$sql = "SELECT 
            p.name AS product_name, 
            SUM(lp.points) AS total_points
        FROM loyalty_points lp
        JOIN products p ON lp.product_id = p.id
        GROUP BY lp.product_id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Loyalty Point Summary</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2>Loyalty Point Summary</h2>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Total Loyalty Points</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['product_name'] ?></td>
                        <td><?= $row['total_points'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No data found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>