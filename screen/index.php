<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZapCart - Shopping Cart</title>
    <script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
        

    <?php
    require 'helpers/init_conn_db.php'; // Include the database connection and functions

    $cartID = 1; // Replace with dynamic CartID if needed

    // Fetch cart items
    $items = fetchCartItems($conn, $cartID);

    // Calculate total cost
    $total = array_sum(array_column($items, 'TotalCost'));

    $shopID = 1; // Replace with dynamic ShopID if needed
$recommendations = fetchRecommendations($conn, $shopID);

    ?>

<div class="cart-container">
        <div class="cart-header">
            <h1>Your Cart</h1>
        </div>
        <div id="table"></div>
        <div class="recommendations">
    <h3>Recommended for You</h3>
    <?php if (!empty($recommendations)): ?>
        <div class="recommendation-list">
            <?php foreach ($recommendations as $productName): ?>
                <div class="recommendation-item">
                    <p><?= htmlspecialchars($productName) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No recommendations available at the moment.</p>
    <?php endif; ?>
</div>
<div class="checkout-container">
    <div class="coupon-section">
        <input type="text" placeholder="Enter coupon code">
        <button>Apply</button>
    </div>
    <div class="order-summary">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td>₹<span id="subtotal"></span></td>
            </tr>
            <tr>
                <td>Tax (18%):</td>
                <td>₹<span id="tax"></span></td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td><strong>₹<span id="cart-total"></span></strong></td>
            </tr>
        </table>
        <button class="checkout-btn" onclick="showPopup()">Proceed to Checkout</button>
    </div>
</div>
    
</div>





        
</div>

    <div class="overlay" id="overlay"></div>
<div class="popup" id="popup">
        <h2>Complete Your Purchase</h2>
        <div id="table2"></div>
        <div class="qr-code">
            <img src="assets/images/2.jpg" alt="QR Code for Payment">
        </div>
        <button class="checkout-btn" onclick="checkStatus()">Verify Payment Status</button>
        <button class="checkout-btn" style="background: #64748b; margin-top: 0.75rem;" onclick="hidePopup()">Cancel</button>
</div>

    <script>



function refreshTotal() {
    $.ajax({
        url: "get_total.php",
        success: function (result) {
            try {
                var response = JSON.parse(result);
                if (response.total !== undefined) {
                    let subtotal = parseFloat(response.total);
                    let tax = subtotal * 0.18; // 10% tax
                    let total = subtotal + tax; // Total including tax

                    $("#subtotal").text(subtotal.toFixed(2));
                    $("#tax").text(tax.toFixed(2));
                    $("#cart-total").text(total.toFixed(2));
                } else {
                    console.error("Invalid response structure:", response);
                }
            } catch (error) {
                console.error("Error parsing total response:", error);
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching total:", error);
        }
    });
}

// Call `refreshTotal` every second
setInterval(refreshTotal, 1000);

        function showPopup() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_total.php', true); // Fetch latest total
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.total !== undefined) {
                    var total = response.total; // Get updated total

                    // Now send the updated total to insert_payment.php
                    var xhr2 = new XMLHttpRequest();
                    xhr2.open('POST', 'insert_payment.php?amount=' + total, true);
                    xhr2.setRequestHeader('Content-Type', 'application/json');

                    var payload = JSON.stringify({ "amount": total });

                    xhr2.onreadystatechange = function () {
                        if (xhr2.readyState === 4) {
                            if (xhr2.status === 200) {
                                var response2 = JSON.parse(xhr2.responseText);
                                if (!response2.success) {
                                    alert("Error: " + response2.error);
                                }
                            } else {
                                alert("HTTP Error: " + xhr2.status);
                            }
                        }
                    };

                    xhr2.send(payload);

                    // Show the popup after fetching the total
                    document.getElementById("overlay").style.display = "block";
                    document.getElementById("popup").style.display = "block";

                } else {
                    alert("Error: Unable to fetch total.");
                }
            } catch (error) {
                console.error("Error parsing response:", error);
                alert("Invalid response from server.");
            }
        }
    };

    xhr.send();
}



        function hidePopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }

        function checkStatus() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'check_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // Request is complete
            if (xhr.status === 200) { // HTTP success
                try {
                    var response = JSON.parse(xhr.responseText); // Parse JSON response
                    console.log(response); // Debugging log
                    
                    // Check if the response status is 'complete'
                    if (response.status === "complete") {
                        // Redirect to the specified location
                        window.location.href = "scripts/script_transactions.php?cart_id=1&payment_method=Online";
                    } else {
                        alert("Status is not complete. Current status: " + response.status);
                    }
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                    alert("Invalid JSON response received.");
                }
            } else {
                alert("HTTP Error: " + xhr.status);
            }
        }
    };

    xhr.send(); // No data needs to be sent in the request
}


        function refresh() {
    $.ajax({
        url: "table.php",
        success: function (result) {
            $("#table").html(result);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching payment data:", error);
        }
    });
}
refresh();
// Call `refresh` every second
setInterval(refresh, 1000);



function refresh2() {
    $.ajax({
        url: "table2.php",
        success: function (result) {
            $("#table2").html(result);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching payment data:", error);
        }
    });
}
refresh2();
// Call `refresh` every second
setInterval(refresh2, 1000);






    </script>
</body>
</html>
