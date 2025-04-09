<?php
header('Content-Type: application/json');

// Database connection settings
$host = "localhost";
$dbname = "ZapCart2DB"; // Updated database name
$username = "root";
$password = "root";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}

// Check if 'product_id' and 'shop_id' parameters are provided
if (isset($_GET['product_id']) && isset($_GET['shop_id'])) {
    $productId = $_GET['product_id'];
    $shopId = $_GET['shop_id'];

    // Fetch product details from the 'Products' table
    $productStmt = $pdo->prepare("
        SELECT ProductID, ProductName, Weight, Calories 
        FROM Products 
        WHERE ProductID = :product_id
    ");
    $productStmt->bindParam(':product_id', $productId);
    $productStmt->execute();

    if ($productStmt->rowCount() > 0) {
        $product = $productStmt->fetch(PDO::FETCH_ASSOC);

        // Check for an active cart in the given shop
        $cartCheckStmt = $pdo->prepare("
            SELECT CartID FROM Carts 
            WHERE ShopID = :shop_id AND Status = 'Active' 
            LIMIT 1
        ");
        $cartCheckStmt->bindParam(':shop_id', $shopId);
        $cartCheckStmt->execute();

        if ($cartCheckStmt->rowCount() > 0) {
            // Use the existing active CartID
            $cart = $cartCheckStmt->fetch(PDO::FETCH_ASSOC);
            $cartId = $cart['CartID'];
        } else {
            // Create a new active cart for the shop
            $createCartStmt = $pdo->prepare("
                INSERT INTO Carts (ShopID, Status) 
                VALUES (:shop_id, 'Active')
            ");
            $createCartStmt->bindParam(':shop_id', $shopId);
            $createCartStmt->execute();
            $cartId = $pdo->lastInsertId();
        }

        // Check if product already exists in cart
        $cartItemCheckStmt = $pdo->prepare("
            SELECT CartItemID, Quantity FROM CartItems 
            WHERE CartID = :cart_id AND ProductID = :product_id
        ");
        $cartItemCheckStmt->bindParam(':cart_id', $cartId);
        $cartItemCheckStmt->bindParam(':product_id', $productId);
        $cartItemCheckStmt->execute();

        if ($cartItemCheckStmt->rowCount() > 0) {
            // Product exists, update quantity
            $cartItem = $cartItemCheckStmt->fetch(PDO::FETCH_ASSOC);
            $newQuantity = $cartItem['Quantity'] + 1;
            
            $updateCartItemStmt = $pdo->prepare("
                UPDATE CartItems 
                SET Quantity = :new_quantity 
                WHERE CartItemID = :cart_item_id
            ");
            $updateCartItemStmt->bindParam(':new_quantity', $newQuantity);
            $updateCartItemStmt->bindParam(':cart_item_id', $cartItem['CartItemID']);
            
            if ($updateCartItemStmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Product quantity updated in cart."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update product quantity."]);
            }
        } else {
            // Product is not in cart, insert new entry
            $insertCartItemStmt = $pdo->prepare("
                INSERT INTO CartItems (CartID, ProductID, ProductName, Quantity, Weight, Calories) 
                VALUES (:cart_id, :product_id, :product_name, 1, :weight, :calories)
            ");
            $insertCartItemStmt->bindParam(':cart_id', $cartId);
            $insertCartItemStmt->bindParam(':product_id', $productId);
            $insertCartItemStmt->bindParam(':product_name', $product['ProductName']);
            $insertCartItemStmt->bindParam(':weight', $product['Weight']);
            $insertCartItemStmt->bindParam(':calories', $product['Calories']);

            if ($insertCartItemStmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Item added to cart successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to add item to cart."]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameters."]);
}
?>
