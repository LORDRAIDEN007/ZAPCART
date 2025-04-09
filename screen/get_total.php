<?php
require 'helpers/init_conn_db.php'; // Include database connection

$cartID = 1; // Use dynamic CartID if needed

// Fetch latest cart items
$items = fetchCartItems($conn, $cartID);

// Calculate total cost dynamically
$total = array_sum(array_column($items, 'TotalCost'));

// Return total as JSON response
echo json_encode(['total' => $total]);
?>




