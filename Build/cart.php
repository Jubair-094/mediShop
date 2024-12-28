<?php
session_start();
include 'db_connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items from the Sales table
$query = "SELECT Products.product_id, Products.product_name, Sales.quantity, Sales.total_price 
          FROM Sales 
          JOIN Products ON Sales.product_id = Products.product_id 
          WHERE Sales.user_id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching cart items: " . mysqli_error($conn));
}

// Handle removing items from the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_item'])) {
    $product_id = (int)$_POST['product_id']; // Sanitize input
    $delete_query = "DELETE FROM Sales WHERE product_id = $product_id AND user_id = $user_id";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: cart.php"); // Refresh page after removal
        exit();
    } else {
        echo "<p style='color: red;'>Failed to remove item: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead {
            background-color: #f2f2f2;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table td {
            text-align: center;
        }
        a {
            text-decoration: none;
            color: purple;
        }
        a:hover {
            text-decoration: underline;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .action-buttons form {
            display: inline;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Your Cart</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($cart_item = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($cart_item['product_name']) . "</td>";
                    echo "<td>" . (int)$cart_item['quantity'] . "</td>";
                    echo "<td>$" . number_format((float)$cart_item['total_price'], 2) . "</td>";
                    echo "<td class='action-buttons'>
                            <form method='POST' action=''>
                                <input type='hidden' name='product_id' value='" . $cart_item['product_id'] . "'>
                                <input class='btn' type='submit' name='remove_item' value='Remove'>
                            </form>
                            </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Your cart is empty. <a href='customer_dashboard.php'>Start Shopping</a></td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="action-buttons">
        <a href="customer_dashboard.php" class="btn">Back to Shopping</a>
        <a href="customer_checkout.php" class="btn">Checkout</a>
    </div>
</body>
</html>
