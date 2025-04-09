<?php
    require 'helpers/init_conn_db.php';

    // Query to fetch cart items
    $sql = "SELECT 
                cartitems.CartItemID, 
                cartitems.Quantity, 
                products.ProductName, 
                (cartitems.Quantity * products.price) AS TotalCost 
            FROM cartitems 
            JOIN products ON cartitems.ProductID = products.ProductID 
            WHERE cartitems.CartID = ?";

    $cartID = 1; // Assuming you are fetching for CartID = 1. Replace as needed.
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cartID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display items and calculate total cost
    $total = 0;

    echo "<h2>Shopping Cart</h2>";
    echo "<table>";
    echo "<tr><th>Item ID</th><th>Product Name</th><th>Quantity</th><th>Cost</th></tr>";

    $items = [];
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['CartItemID'] . "</td>";
        echo "<td>" . $row['ProductName'] . "</td>";
        echo "<td>" . $row['Quantity'] . "</td>";
        echo "<td>" . $row['TotalCost'] . "</td>";
        echo "</tr>";

        $total += $row['TotalCost'];

        $items[] = $row;
    }

    echo "<tr><td colspan='2'>Total</td><td colspan='2'>rs" . number_format($total, 2) . "</td></tr>";
    echo "</table>";

    $stmt->close();
    $conn->close();
    ?>
