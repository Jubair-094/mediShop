<?php
include 'db_connection.php';

$query = "SELECT * FROM Products";
$result = mysqli_query($conn, $query);

while ($product = mysqli_fetch_assoc($result)) {
    echo "<div class='product'>";
    echo "<h3>" . $product['product_name'] . "</h3>";
    echo "<p>" . $product['description'] . "</p>";
    echo "<p>Price: $" . $product['price'] . "</p>";
    echo "<button>Add to Cart</button>";
    echo "</div>";
}
?>
