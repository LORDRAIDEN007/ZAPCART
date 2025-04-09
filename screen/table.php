<?php
require 'helpers/init_conn_db.php'; // Include the database connection and functions

$cartID = 1; // Replace with dynamic CartID if needed

// Fetch cart items
$items = fetchCartItems($conn, $cartID);

// Calculate total cost
$total = array_sum(array_column($items, 'TotalCost'));

// Fetch recommendations (assuming ShopID is linked to Cart)
$shopID = 1; // Replace with dynamic ShopID if needed
$recommendations = fetchRecommendations($conn, $shopID);
?>

<table >
    <tr>
        <th>Item ID</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Weight (kg)</th>
        <th>Calories</th>
        <th>Shelf Location</th>
        <th>Subtotal</th>
    </tr>
    <?php foreach ($items as $item): ?>
        <tr>
            <td><?= $item['CartItemID'] ?></td>
            <td><?= htmlspecialchars($item['ProductName']) ?></td>
            <td><?= $item['Quantity'] ?></td>
            <td><?= $item['Weight'] ?> kg</td>
            <td><?= $item['Calories'] ?> kcal</td>
            <td><?= htmlspecialchars($item['ShelfLocation']) ?></td>
            <td>₹<?= number_format($item['TotalCost'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
    <!-- <tr>
        <td colspan="6"><strong>Total</strong></td>
        <td><strong>₹<?= number_format($total, 2) ?></strong></td>
    </tr> -->
</table>


