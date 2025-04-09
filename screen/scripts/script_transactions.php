<?php
header('Content-Type: application/json');

// Database connection settings
$host = "localhost";
$dbname = "ZapCart2DB"; // Updated database name
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
if (isset($_GET['cart_id']) && isset($_GET['payment_method'])) {
    $cartId = $_GET['cart_id'];
    $paymentMethod = $_GET['payment_method'];

    // Validate payment method
    $validPaymentMethods = ['Cash', 'Card', 'Online'];
    if (!in_array($paymentMethod, $validPaymentMethods)) {
        echo json_encode(["status" => "error", "message" => "Invalid payment method."]);
        exit;
    }

    // Get ShopID from Carts table
    $shopStmt = $pdo->prepare("SELECT ShopID FROM Carts WHERE CartID = :cart_id");
    $shopStmt->bindParam(':cart_id', $cartId);
    $shopStmt->execute();
    $shopResult = $shopStmt->fetch(PDO::FETCH_ASSOC);

    if (!$shopResult) {
        echo json_encode(["status" => "error", "message" => "Cart not found."]);
        exit;
    }
    $shopId = $shopResult['ShopID'];

    // Calculate total amount for the given cart
    $stmt = $pdo->prepare("
        SELECT SUM(p.Price * c.Quantity) AS TotalAmount
        FROM CartItems c
        JOIN Products p ON c.ProductID = p.ProductID
        WHERE c.CartID = :cart_id
    ");
    $stmt->bindParam(':cart_id', $cartId);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['TotalAmount'] !== null) {
        $totalAmount = $result['TotalAmount'];

        // Insert the transaction into the Transactions table
        $insertStmt = $pdo->prepare("
            INSERT INTO Transactions (CartID, ShopID, TotalAmount, PaymentMethod, TransactionDate)
            VALUES (:cart_id, :shop_id, :total_amount, :payment_method, NOW())
        ");
        $insertStmt->bindParam(':cart_id', $cartId);
        $insertStmt->bindParam(':shop_id', $shopId);
        $insertStmt->bindParam(':total_amount', $totalAmount);
        $insertStmt->bindParam(':payment_method', $paymentMethod);

        if ($insertStmt->execute()) {
            // Update the cart status to 'Completed'
            $updateCartStmt = $pdo->prepare("UPDATE Carts SET Status = 'Completed' WHERE CartID = :cart_id");
            $updateCartStmt->bindParam(':cart_id', $cartId);
            $updateCartStmt->execute();

            // Delete all items from the cart
            $deleteCartItemsStmt = $pdo->prepare("DELETE FROM CartItems WHERE CartID = :cart_id");
            $deleteCartItemsStmt->bindParam(':cart_id', $cartId);
            $deleteCartItemsStmt->execute();

            echo json_encode([
                "status" => "success",
                "message" => "Transaction completed successfully. Cart items have been cleared.",
                "transaction" => [
                    "cart_id" => $cartId,
                    "shop_id" => $shopId,
                    "total_amount" => $totalAmount,
                    "payment_method" => $paymentMethod
                ]
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to create transaction."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No items found in the cart or invalid cart ID."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameters: 'cart_id' and 'payment_method'."]);
}

// Redirect to thank you page
header("Location: ../thanks.php");
?>
