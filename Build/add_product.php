<?php
session_start();
include 'db_connection.php'; // Ensure this line is present to include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    // Prepare and execute the query to add the product
    $query = "INSERT INTO Products (product_name, category, price, stock, description) 
                VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdis", $product_name, $category, $price, $stock, $description); // Bind the parameters

    if ($stmt->execute()) {
        // Redirect to admin dashboard on success
        header("Location: admin_dashboard.php");
    } else {
        echo "Error adding product.";
    }

    $stmt->close();
}

$conn->close();
?>
