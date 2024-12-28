
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
$query = "SELECT Products.product_name, Products.price, Sales.quantity 
          FROM Sales 
          JOIN Products ON Sales.product_id = Products.product_id 
          WHERE Sales.user_id = $user_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching cart items: " . mysqli_error($conn));
}

$total_amount = 0.00;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
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
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .total {
            text-align: center;
            font-weight: bold;
            font-size: 1.5em;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-right: 10px;
        }
        .btn:hover {
            background-color: #45a049;
        }
        a {
            text-decoration: none;
            color: purple;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Checkout</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($cart_item = mysqli_fetch_assoc($result)) {
                    $product_name = $cart_item['product_name'] ?? 'Unknown';
                    $price = $cart_item['price'] ?? 0.00;
                    $quantity = $cart_item['quantity'] ?? 0;
                    $subtotal = $price * $quantity;
                    $total_amount += $subtotal;

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($product_name) . "</td>";
                    echo "<td>$" . number_format($price, 2) . "</td>";
                    echo "<td>" . (int)$quantity . "</td>";
                    echo "<td>$" . number_format($subtotal, 2) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No items in your cart.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="total">
        <p>Total Amount: $<?php echo number_format($total_amount, 2); ?></p>
    </div>

    <button class="btn" onclick="window.print()">Print Bill</button>
    <a href="cart.php" class="btn">Back to Cart</a>
    <a href="customer_dashboard.php" class="btn">Back to Dashboard</a>
</body>
</html>

