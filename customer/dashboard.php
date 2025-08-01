<?php
include('../db/connection.php');

// Static user (for demo): customer id 1
$customer_id = 1;

$customer = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM customers WHERE id = $customer_id"));

$sales = mysqli_query($conn, "SELECT p.name FROM sales s JOIN products p ON s.product_id = p.id WHERE s.customer_id = $customer_id");
?>

<h2>Welcome <?= $customer['name'] ?></h2>
<p>Total Points: <?= $customer['points'] ?></p>

<h3>Products You Bought:</h3>
<ul>
<?php while ($s = mysqli_fetch_assoc($sales)) : ?>
    <li><?= $s['name'] ?></li>
<?php endwhile; ?>
</ul>