<?php
header('Content-Type: application/json');

// Database connection settings
$host = "localhost";
$dbname = "zapcart2db";
$username = "root";
$password = "root";

// External API endpoints
$script_alert_url = "http://localhost:8080/zapcart2.0/scripts/script_alert.php";
$script_cartitems_url = "http://localhost:8080/zapcart2.0/scripts/script_cartitems.php";

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Check if 'rfid' parameter is provided
if ((isset($_GET['rfid'])&& isset($_GET['shop_id']))) {
    $rfid = $_GET['rfid'];
    $shopId = $_GET['shop_id'];

    // Sanitize RFID value to prevent SQL injection
    $rfid = htmlspecialchars(strip_tags($rfid));

    // Query the product table for the provided RFID
    $stmt = $pdo->prepare("SELECT * FROM products WHERE RFIDTag = :rfid");
    $stmt->bindParam(':rfid', $rfid);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Fetch the product details
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check stock availability
        if ($product['Stock'] > 1) {
            // Deduct 1 from stock
            $updateStmt = $pdo->prepare("UPDATE products SET Stock = Stock - 1 WHERE ProductID = :product_id");
            $updateStmt->bindParam(':product_id', $product['ProductID']);
            $updateStmt->execute();

            // Call script_cartitems API to add to cartitems
            $cartItemResponse = file_get_contents($script_cartitems_url . "?product_id=" . $product['ProductID']."&shop_id=".$shopId);
            $cartItemResponse = json_decode($cartItemResponse, true);

            if ($cartItemResponse['status'] === "success") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Product added to cart successfully!",
                    "product" => $product
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to add product to cart.",
                    "error" => $cartItemResponse['message']
                ]);
            }
        }elseif ($product['Stock'] == 1) {
            $updateStmt = $pdo->prepare("UPDATE products SET Stock = Stock - 1 WHERE ProductID = :product_id");
            $updateStmt->bindParam(':product_id', $product['ProductID']);
            $updateStmt->execute();

            // Call script_cartitems API to add to cartitems
            $cartItemResponse = file_get_contents($script_cartitems_url . "?product_id=" . $product['ProductID']."&shop_id=".$shopId);
            $cartItemResponse = json_decode($cartItemResponse, true);

            if ($cartItemResponse['status'] === "success") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Product added to cart successfully!",
                    "product" => $product
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to add product to cart.",
                    "error" => $cartItemResponse['message']
                ]);
            }
            $alertMessage = "Product '" . $product['ProductName'] . "' is out of stock.";
            $alertResponse = file_get_contents(
                $script_alert_url . "?product_id=" . $product['ProductID']."&shop_id=".$shopId);
            $alertResponse = json_decode($alertResponse, true);

            if ($alertResponse['status'] === "success") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Product out of stock. Alert created",
                    "alert" => $alertResponse
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to create alert for out of stock product.",
                    "error" => $alertResponse['message']
                ]);
            }
        } else {
            // Stock is 0, call script_alert.php and delete the product entry
            $alertMessage = "Product '" . $product['ProductName'] . "' is out of stock.";
            $alertResponse = file_get_contents(
                $script_alert_url . "?product_id=" . $product['ProductID']."&shop_id=".$shopId);
            $alertResponse = json_decode($alertResponse, true);

            if ($alertResponse['status'] === "success") {
                echo json_encode([
                    "status" => "success",
                    "message" => "Product out of stock. Alert created",
                    "alert" => $alertResponse
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to create alert for out of stock product.",
                    "error" => $alertResponse['message']
                ]);
            }
        }
    } else {
        // No product found for the given RFID
        echo json_encode([
            "status" => "error",
            "message" => "No product found for the given RFID."
        ]);
    }
} else {
    // If 'rfid' parameter is not provided
    echo json_encode([
        "status" => "error",
        "message" => "No RFID value provided."
    ]);
}
?>
