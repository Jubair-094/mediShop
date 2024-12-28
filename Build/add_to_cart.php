<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];

    $query = "INSERT INTO Sales (user_id, product_id, quantity, total_price) 
              SELECT $user_id, $product_id, $quantity, price * $quantity FROM Products WHERE product_id = $product_id";
    mysqli_query($conn, $query);

    header("Location: customer_dashboard.php");
}
?>
