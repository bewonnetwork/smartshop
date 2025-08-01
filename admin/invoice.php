<?php
include('../db/connection.php');

if (!isset($_GET['invoice_id'])) {
    echo "Invalid invoice ID.";
    exit;
}

$invoice_id = $_GET['invoice_id'];

// Invoice & Customer Info
$sale_sql = "SELECT sr.*, c.name AS customer_name, c.phone FROM sales_report sr
             JOIN customers c ON sr.customer_id = c.id
             WHERE sr.id = $invoice_id";
$sale = mysqli_fetch_assoc(mysqli_query($conn, $sale_sql));

// Product Info
$item_sql = "SELECT si.*, p.name, p.code FROM sales_items si 
             JOIN products p ON si.product_id = p.id 
             WHERE si.sales_report_id = $invoice_id";
$items = mysqli_query($conn, $item_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>🧾 Invoice #<?= $invoice_id ?></title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 30px; }
        .invoice-box { background: #fff; border: 1px solid #ccc; padding: 25px; max-width: 800px; margin: auto; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #ecf0f1; }
        .qr { width: 60px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>🧾 Invoice #<?= $invoice_id ?></h2>
        <p><strong>Customer:</strong> <?= $sale['customer_name'] ?> (<?= $sale['phone'] ?>)</p>
        <p><strong>Date:</strong> <?= $sale['created_at'] ?></p>

        <table>
            <tr>
                <th>Product</th>
                <th>Code</th>
                <th>QR</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
            <?php while ($item = mysqli_fetch_assoc($items)): ?>
                <tr>
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['code'] ?></td>
                    <td>
                        <img class="qr" src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data=<?= urlencode($item['code']) ?>" alt="QR">
                    </td>
                    <td><?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= number_format($item['total'], 2) ?></td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="5" style="text-align:right;"><strong>Grand Total</strong></td>
                <td><strong><?= number_format($sale['total_amount'], 2) ?></strong></td>
            </tr>
        </table>
    </div>
</body>
</html>