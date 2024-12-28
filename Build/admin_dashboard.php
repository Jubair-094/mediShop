<?php
session_start();
include 'db_connection.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch all products for admin to manage
$query = "SELECT * FROM Products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Banner Section -->
    <div class="banner">
        <img src="images/admin-banner.jpg" alt="Admin Dashboard Banner">
    </div>

    <div class="container">
        <h1>Admin Dashboard</h1>
        <h2>Manage Products</h2>

        <div class="product-list">
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($product = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $product['product_name'] . "</td>";
                        echo "<td>" . $product['category'] . "</td>";
                        echo "<td>$" . $product['price'] . "</td>";
                        echo "<td>" . $product['stock'] . "</td>";
                        echo "<td>";
                        echo "<form action='update_stock.php' method='POST'>";
                        echo "<input type='hidden' name='product_id' value='" . $product['product_id'] . "'>";
                        echo "<input type='number' name='stock' value='" . $product['stock'] . "' min='0' required>";
                        echo "<input type='submit' value='Update'>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h2>Add New Product</h2>
        <form action="add_product.php" method="POST">
            <label for="product_name">Product Name:</label>
            <input type="text" name="product_name" required>
            <label for="category">Category:</label>
            <input type="text" name="category" required>
            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" required>
            <label for="stock">Stock:</label>
            <input type="number" name="stock" required>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea>
            <input type="submit" value="Add Product">
        </form>

        <a href="logout.php">Logout</a>
    </div>

</body>
</html>
