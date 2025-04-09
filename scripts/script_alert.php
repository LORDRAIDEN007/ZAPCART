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

// Check required parameters
if (isset($_GET['product_id']) && isset($_GET['shop_id'])) {
    $productId = $_GET['product_id'];
    $shopId = $_GET['shop_id'];

    // Fetch product details
    $stmt = $pdo->prepare("SELECT ProductID, ProductName FROM products WHERE ProductID = :product_id");
    $stmt->bindParam(':product_id', $productId);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Insert alert into inventoryalerts table
        $alertMessage = "Product '" . $product['ProductName'] . "' is low in stock at Shop ID: " . $shopId;
        $alertStmt = $pdo->prepare("
            INSERT INTO InventoryAlerts (ShopID, ProductID, ProductName, AlertMessage, AlertDate) 
            VALUES (:shop_id, :product_id, :product_name, :alert_message, NOW())
        ");
        $alertStmt->bindParam(':shop_id', $shopId);
        $alertStmt->bindParam(':product_id', $product['ProductID']);
        $alertStmt->bindParam(':product_name', $product['ProductName']);
        $alertStmt->bindParam(':alert_message', $alertMessage);
        
        if ($alertStmt->execute()) {
            // Insert activity log
            $activityMessage = "Inventory alert created for product '" . $product['ProductName'] . "' at Shop ID: " . $shopId;
            $logStmt = $pdo->prepare("
                INSERT INTO ActivityLogs (ShopID, UserType, Activity, ActivityDate) 
                VALUES (:shop_id, 'System', :activity, NOW())
            ");
            $logStmt->bindParam(':shop_id', $shopId);
            $logStmt->bindParam(':activity', $activityMessage);
            $logStmt->execute();

            echo json_encode([
                "status" => "success",
                "message" => "Alert created and logged successfully.",
                "alert" => [
                    "ShopID" => $shopId,
                    "ProductID" => $product['ProductID'],
                    "ProductName" => $product['ProductName'],
                    "AlertMessage" => $alertMessage
                ]
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to create alert."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Product not found for the given ProductID."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameters: product_id and shop_id."]);
}
?>
