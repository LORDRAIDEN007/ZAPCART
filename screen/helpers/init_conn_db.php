<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "zapcart2db";

// Establish the database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Fetch cart items for a specific CartID.
 *
 * @param mysqli $conn Database connection object.
 * @param int $cartID Cart ID to fetch items for.
 * @return array Array of cart items.
 */
function fetchCartItems($conn, $cartID)
{
    $sql = "SELECT 
                cartitems.CartItemID, 
                cartitems.Quantity, 
                cartitems.Weight, 
                cartitems.Calories, 
                products.ProductName, 
                products.ShelfLocation, 
                (cartitems.Quantity * products.Price) AS TotalCost 
            FROM cartitems 
            JOIN products ON cartitems.ProductID = products.ProductID 
            WHERE cartitems.CartID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cartID);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    $stmt->close();
    return $items;
}

/**
 * Fetch AI-recommended products for a specific shop.
 *
 * @param mysqli $conn Database connection object.
 * @param int $shopID Shop ID to fetch recommendations for.
 * @param int $limit Number of recommendations to fetch.
 * @return array Array of recommended products.
 */
function fetchRecommendations($conn, $shopID, $limit = 3)
{
    $sql = "SELECT ProductName 
            FROM Products 
            ORDER BY RAND() LIMIT ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();

    $recommendations = [];
    while ($row = $result->fetch_assoc()) {
        $recommendations[] = $row['ProductName'];
    }

    $stmt->close();
    return $recommendations;
}

?>
