<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Employee Dashboard</h1>
    <h2>Select Items for Billing</h2>
    <form action="checkout.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price (per unit)</th>
                    <th>Stock</th>
                    <th>Select Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db_connection.php';
                $query = "SELECT * FROM Products";
                $result = mysqli_query($conn, $query);

                while ($product = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$product['product_name']}</td>
                            <td>{$product['category']}</td>
                            <td>\${$product['price']}</td>
                            <td>{$product['stock']}</td>
                            <td>
                                <input type='number' name='quantity[{$product['product_id']}]' min='0' max='{$product['stock']}' value='0' style='width: 60px;'>
                                <input type='hidden' name='price[{$product['product_id']}]' value='{$product['price']}'>
                                <input type='hidden' name='name[{$product['product_id']}]' value='{$product['product_name']}'>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <button type="submit" name="checkout">Checkout</button>
    </form>
</body>
</html>
