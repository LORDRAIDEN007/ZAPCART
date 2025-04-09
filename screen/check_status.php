<?php
require 'helpers/init_conn_db.php';
// Query to get the last row in the paymentchecks table (highest ID) and check its status
$sql = "SELECT * FROM paymentchecks ORDER BY id DESC LIMIT 1";

$result = $conn->query($sql);

// Check if a row was found
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['status' => $row['status']]);  // Send the status of the last item
} else {
    echo json_encode(['status' => 'No items found']);
}

$conn->close();
?>
