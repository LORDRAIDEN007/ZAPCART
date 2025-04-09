<?php
header('Content-Type: application/json');

// Database connection settings
$host = "localhost";
$dbname = "zapcart2db";
$username = "root";
$password = "root";

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Check if 'cart_id' parameter is provided
if (isset($_GET['cart_id'])) {
    $cartId = $_GET['cart_id'];

    // Update the cart status to 'Completed'
    $updateCartStmt = $pdo->prepare("UPDATE carts SET Status = 'Active' WHERE CartID = :cart_id");
    $updateCartStmt->bindParam(':cart_id', $cartId);

    if ($updateCartStmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Cart status updated to 'Completed'.",
            "cart_id" => $cartId
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update cart status."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameter: 'cart_id'."]);
}
header("location: ../index.php");
?>
