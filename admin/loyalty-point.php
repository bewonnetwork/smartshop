<?php
include('../db/connection.php');

$result = mysqli_query($conn, "SELECT * FROM customers");
?>

<h2>Loyalty Point Summary</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Name</th>
        <th>Total Points</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['points'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>