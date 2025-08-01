<?php
include('../db/connection.php');

// Search Product by Code
$search_code = '';
$selected_product_id = '';
if (isset($_POST['search_code'])) {
    $search_code = $_POST['search_code'];
    $search_query = mysqli_query($conn, "SELECT id FROM products WHERE code = '$search_code'");
    $result = mysqli_fetch_assoc($search_query);
    if ($result) {
        $selected_product_id = $result['id'];
    }
}

// Product list for dropdown
$product_result = mysqli_query($conn, "SELECT * FROM products");

// Variables
$admin_invoice = [];
$customer_invoice = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    // Get product details
    $product_query = mysqli_query($conn, "SELECT * FROM products WHERE id = $product_id");
    $product = mysqli_fetch_assoc($product_query);

    if ($product && $product['stock'] >= $quantity) {
        $product_name = $product['name'];
        $buy_price = $product['buy_price'];
        $sell_price = $product['sell_price'];

        $total_price = $sell_price * $quantity;
        $profit = ($sell_price - $buy_price) * $quantity;

        // VAT Calculation (e.g. 10%)
        $vat_percent = 10;
        $vat_amount = ($total_price * $vat_percent) / 100;
        $customer_total = $total_price + $vat_amount;

        // Update stock
        $new_stock = $product['stock'] - $quantity;
        mysqli_query($conn, "UPDATE products SET stock = $new_stock WHERE id = $product_id");

        // Insert into sales_report
        $insert = "INSERT INTO sales_report (product_id, product_name, quantity, buy_price, sell_price, total_price, profit, created_at) 
                   VALUES ($product_id, '$product_name', $quantity, $buy_price, $sell_price, $total_price, $profit, NOW())";
        mysqli_query($conn, $insert);

        // Admin invoice data
        $admin_invoice = [
            'product_name' => $product_name,
            'quantity' => $quantity,
            'buy_price' => $buy_price,
            'sell_price' => $sell_price,
            'total_price' => $total_price,
            'profit' => $profit,
            'date' => date('Y-m-d H:i:s')
        ];

        // Customer invoice data
        $customer_invoice = [
            'product_name' => $product_name,
            'quantity' => $quantity,
            'sell_price' => $sell_price,
            'vat_percent' => $vat_percent,
            'vat_amount' => $vat_amount,
            'grand_total' => $customer_total,
            'date' => date('Y-m-d H:i:s')
        ];

        $success = "✅ Sale recorded and invoices generated successfully!";
    } else {
        $error = "❌ Insufficient stock or product not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🧾 Sell Product & Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #d4f1f9, #c7ffe2);
            padding: 40px;
        }

        form {
            background: white;
            padding: 25px;
            max-width: 500px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            margin-bottom: 40px;
            margin-left: auto;
            margin-right: auto;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        select, input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
        }

        .message {
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
        }

        .success { color: green; }
        .error { color: red; }

        .invoice {
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            max-width: 700px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
            margin: 20px auto;
        }

        .invoice h3 {
            margin-top: 0;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .invoice table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .invoice th, .invoice td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        .print-btn {
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>🛒 Sell Product</h2>

<!-- 🔍 Product Code Search Form -->
<form method="POST">
    <label>🔍 Search Product by Code:</label>
    <input type="text" name="search_code" placeholder="Enter Product Code..." value="<?= htmlspecialchars($search_code) ?>">
    <button type="submit" style="background-color:#0069d9;">Search</button>
</form>

<!-- 🛒 Sell Product Form -->
<form method="POST">
    <label>Select Product:</label>
    <select name="product_id" required>
        <option value="">-- Select a Product --</option>
        <?php while ($row = mysqli_fetch_assoc($product_result)): ?>
            <option value="<?= $row['id'] ?>" <?= ($row['id'] == $selected_product_id) ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['name']) ?> (Code: <?= $row['code'] ?>, Stock: <?= $row['stock'] ?>)
            </option>
        <?php endwhile; ?>
    </select>

    <label>Quantity:</label>
    <input type="number" name="quantity" min="1" required>

    <button type="submit">✅ Sell</button>

    <?php if (isset($success)): ?>
        <div class="message success"><?= $success ?></div>
    <?php elseif (isset($error)): ?>
        <div class="message error"><?= $error ?></div>
    <?php endif; ?>
</form>

<!-- 🧾 Invoices -->
<?php if (!empty($admin_invoice)): ?>
    <div class="invoice" id="admin_invoice">
        <h3>📄 Admin Invoice</h3>
        <p><strong>Date:</strong> <?= $admin_invoice['date'] ?></p>
        <table>
            <tr><th>Product</th><td><?= htmlspecialchars($admin_invoice['product_name']) ?></td></tr>
            <tr><th>Quantity</th><td><?= $admin_invoice['quantity'] ?></td></tr>
            <tr><th>Buy Price</th><td><?= $admin_invoice['buy_price'] ?></td></tr>
            <tr><th>Sell Price</th><td><?= $admin_invoice['sell_price'] ?></td></tr>
            <tr><th>Total Price</th><td><?= $admin_invoice['total_price'] ?></td></tr>
            <tr><th>Profit</th><td><?= $admin_invoice['profit'] ?></td></tr>
        </table>
        <button class="print-btn" onclick="printSection('admin_invoice')">🖨️ Print Admin Copy</button>
    </div>
<?php endif; ?>

<?php if (!empty($customer_invoice)): ?>
    <div class="invoice" id="customer_invoice">
        <h3>🧾 Customer Invoice</h3>
        <p><strong>Date:</strong> <?= $customer_invoice['date'] ?></p>
        <table>
            <tr><th>Product</th><td><?= htmlspecialchars($customer_invoice['product_name']) ?></td></tr>
            <tr><th>Quantity</th><td><?= $customer_invoice['quantity'] ?></td></tr>
            <tr><th>Unit Price</th><td><?= $customer_invoice['sell_price'] ?></td></tr>
            <tr><th>Subtotal</th><td><?= $customer_invoice['sell_price'] * $customer_invoice['quantity'] ?></td></tr>
            <tr><th>VAT (<?= $customer_invoice['vat_percent'] ?>%)</th><td><?= $customer_invoice['vat_amount'] ?></td></tr>
            <tr><th>Grand Total</th><td><strong><?= $customer_invoice['grand_total'] ?></strong></td></tr>
        </table>
        <button class="print-btn" onclick="printSection('customer_invoice')">🖨️ Print Customer Copy</button>
    </div>
<?php endif; ?>

<script>
function printSection(id) {
    var content = document.getElementById(id).innerHTML;
    var printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write('<html><head><title>Invoice</title></head><body>');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
</script>

</body>
</html>