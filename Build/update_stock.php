<?php
session_start();
include 'db_connection.php';

// Check if the user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Check if stock update data has been posted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && isset($_POST['stock'])) {
    $product_id = $_POST['product_id'];
    $new_stock = $_POST['stock'];

    // Prepare and execute the query to update stock
    $query = "UPDATE Products SET stock = ? WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $new_stock, $product_id); // Bind the stock and product ID as integers

    if ($stmt->execute()) {
        // Redirect back to admin dashboard after successful update
        header("Location: admin_dashboard.php");
    } else {
        echo "Error updating stock.";
    }

    $stmt->close();
} else {
    echo "Invalid data.";
}

$conn->close();
?>
