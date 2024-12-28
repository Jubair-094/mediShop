<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Bill</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .bill-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #f4f4f4;
        }
        .print-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            border-radius: 5px;
        }
        .print-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <h1>Customer Bill</h1>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
                    $total = 0;
                    $_SESSION['cart'] = [];

                    foreach ($_POST['quantity'] as $product_id => $quantity) {
                        if ($quantity > 0) {
                            $price = $_POST['price'][$product_id];
                            $name = $_POST['name'][$product_id];
                            $subtotal = $price * $quantity;
                            $total += $subtotal;

                            // Add item to session for future use
                            $_SESSION['cart'][] = [
                                'name' => $name,
                                'price' => $price,
                                'quantity' => $quantity,
                                'subtotal' => $subtotal
                            ];

                            echo "<tr>
                                    <td>{$name}</td>
                                    <td>\${$price}</td>
                                    <td>{$quantity}</td>
                                    <td>\$" . number_format($subtotal, 2) . "</td>
                                </tr>";
                        }
                    }

                    echo "<tr>
                            <td colspan='3'><strong>Total</strong></td>
                            <td><strong>\$" . number_format($total, 2) . "</strong></td>
                        </tr>";
                } else {
                    echo "<tr>
                            <td colspan='4'>No items selected</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <button class="print-btn" onclick="window.print()">Print Bill</button>
    </div>
</body>
</html>
