<?php
require 'helpers/init_conn_db.php'; // Include the database connection and functions

$cartID = 1; // Replace with dynamic CartID if needed

// Fetch cart items
$items = fetchCartItems($conn, $cartID);

// Calculate total cost
$total = array_sum(array_column($items, 'TotalCost'));

// Fetch recommendations
$recommendations = fetchRecommendations($conn, 3);
?>

<table>
    <tr>
        <th>Product Name</th>
        <th>Subtotal</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= $item['ProductName'] ?></td>
            <td>₹<?= number_format($item['TotalCost'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2">Total: ₹<?= number_format($total, 2) ?></td>
    </tr>
</table>


