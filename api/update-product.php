<?php
include('../db/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $sql = "UPDATE products SET name='$name', price=$price, stock=$stock WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: ../admin/product-list.php");
    } else {
        echo "Error updating product: " . mysqli_error($conn);
    }
}