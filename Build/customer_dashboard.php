<?php
session_start();
include 'db_connection.php';

// Check if user is logged in and is a customer
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'customer') {
    header("Location: login.php");
    exit();
}

// Check if a search term is provided
$search_term = "";
if (isset($_POST['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search']);
    $query = "SELECT * FROM Products WHERE product_name LIKE '%$search_term%'";
} else {
    $query = "SELECT * FROM Products";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .search-box {
            margin: 20px 0;
            text-align: center;
        }
        .search-box input[type="text"] {
            padding: 10px;
            width: 300px;
            font-size: 16px;
        }
        .search-box button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-box button:hover {
            background-color: #0056b3;
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            width: 300px;
        }
        .product h3 {
            margin: 0 0 10px;
        }
        .product p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <!-- Banner Section -->
    <div class="banner">
        <img src="images/customer-banner.jpg" alt="Customer Dashboard Banner">
    </div>

    <div class="container">
        <h1>Welcome to the Medical Shop</h1>

        <!-- Search Section -->
        <div class="search-box">
            <form action="customer_dashboard.php" method="POST">
                <input type="text" name="search" placeholder="Search for a product..." value="<?php echo htmlspecialchars($search_term); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <h2>Available Products</h2>

        <div class="product-list">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($product = mysqli_fetch_assoc($result)) {
                    echo "<div class='product'>";
                    echo "<h3>" . htmlspecialchars($product['product_name']) . "</h3>";
                    echo "<p>" . htmlspecialchars($product['description']) . "</p>";
                    echo "<p>Price: $" . htmlspecialchars($product['price']) . "</p>";
                    echo "<form action='add_to_cart.php' method='POST'>";
                    echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($product['product_id']) . "'>";
                    echo "<input type='number' name='quantity' value='1' min='1' max='" . htmlspecialchars($product['stock']) . "' required>";
                    echo "<input type='submit' value='Add to Cart'>";
                    echo "</form>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products found matching your search.</p>";
            }
            ?>
        </div>

        <a href="cart.php">View Cart</a> | <a href="logout.php">Logout</a>
    </div>

</body>
</html>
