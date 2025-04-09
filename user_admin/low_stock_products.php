<?php require 'helpers/init_conn_db.php'; ?>
<?php


$query = "SELECT * FROM products WHERE stock < 10";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>{$row['ProductName']} - Stock: {$row['Stock']}</div>";
    }
} else {
    echo "No products with low stock.";
}

$conn->close();
?>
