<?php
include('../db/connection.php');
$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer List</title>
</head>
<body>
    <h2>🧑‍🤝‍🧑 Customer List</h2>
    <?php if (isset($_GET['added'])): ?>
        <p style="color:green;">✅ Customer added successfully!</p>
    <?php endif; ?>

    <a href="add-customer.php">➕ Add New Customer</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Points</th>
            <th>Created At</th>
        </tr>
        <?php while ($c = mysqli_fetch_assoc($customers)): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['name']) ?></td>
                <td><?= htmlspecialchars($c['phone']) ?></td>
                <td><?= $c['points'] ?></td>
                <td><?= $c['created_at'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>