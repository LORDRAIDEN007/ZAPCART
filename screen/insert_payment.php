<?php
header('Content-Type: application/json');

require 'helpers/init_conn_db.php';
// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['amount']) || !is_numeric($data['amount'])) {
    echo json_encode(["success" => false, "error" => "Invalid or missing amount"]);
    exit;
}

$amount = $data['amount'];
$status = "Incomplete";

// Insert into paymentchecks
$sql = "INSERT INTO paymentchecks (status, amount) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(["success" => false, "error" => $conn->error]);
    exit;
}

$stmt->bind_param("sd", $status, $amount);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
