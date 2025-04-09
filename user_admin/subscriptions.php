<?php
include_once 'sub-views/header.php'; 
require 'helpers/init_conn_db.php'; // Ensure this file connects to zapcart2db

// Fetch current user subscription details
$shopOwnerID = $_SESSION['shopOwnerID']; // Assuming user is logged in
$query = "SELECT SubscriptionPlan, SubscriptionStartDate, SubscriptionEndDate FROM shopowners WHERE ShopOwnerID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $shopOwnerID);
$stmt->execute();
$result = $stmt->get_result();
$subscription = $result->fetch_assoc();

// Fetch available subscription plans
$plansQuery = "SELECT * FROM subscriptionplans ORDER BY PlanID ASC";
$plansResult = $conn->query($plansQuery);
$plans = $plansResult->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subscription - ZapCart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    /* General styling */
    body, html {
        margin: 0 !important;
        padding: 0 !important;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }

    .container-fluid {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Page Title */
    h2 {
        font-weight: bold;
        color: #333;
        margin-top: 20px;
    }

    /* Current Subscription Card */
    .card {
        border-radius: 15px;
        background-color: #fff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 20px;
        max-width: 600px;
        margin: 0 auto 30px;
    }

    /* Subscription Plans Layout */
    .row {
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    /* Plan Cards */
    .plan-card {
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        background: #fff;
        min-height: 350px; /* Increased height */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .plan-card:hover {
        transform: scale(1.05);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
    }

    .plan-card h3 {
        color: #007bff;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .plan-card p {
        color: #555;
        margin-bottom: 15px;
    }

    .plan-card .btn {
        width: 100%;
        font-size: 18px;
        padding: 10px;
    }

    /* Subscription Popup Overlay */
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    /* Subscription Popup Box */
    .popup {
        background: white;
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        width: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Popup Title */
    .popup h4 {
        font-size: 20px;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    /* Price Text */
    .popup p {
        color: #555;
        font-size: 16px;
        margin-bottom: 15px;
    }

    /* QR Code Styling */
    .popup img {
        width: 220px;
        border-radius: 8px;
        margin: 10px 0;
        box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
    }

    /* Buttons in Popup */
    .popup button {
        width: 100%;
        font-size: 16px;
        padding: 10px;
        margin-top: 10px;
        border-radius: 6px;
        font-weight: bold;
    }

    .popup .btn-success {
        background-color: #28a745;
        border: none;
        transition: background 0.3s ease-in-out;
    }

    .popup .btn-success:hover {
        background-color: #218838;
    }

    .popup .btn-danger {
        background-color: #dc3545;
        border: none;
        transition: background 0.3s ease-in-out;
    }

    .popup .btn-danger:hover {
        background-color: #c82333;
    }

    /* Close Button */
    .popup .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        color: #666;
        cursor: pointer;
    }

    .popup .close-btn:hover {
        color: #000;
    }

    /* Popup Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Responsive Design */
    @media (max-width: 500px) {
        .popup {
            width: 90%;
            padding: 20px;
        }
    }

</style>

</head>
<body class="container-fluid mt-0"> <!-- Removed mt-5 -->

    <!-- Debugging for extra space (Uncomment if needed) -->
    <div id="debug-space"></div>

    <h2 class="text-center mb-4">Manage Your Subscription</h2>
    
    <div class="card p-3 mb-4">
        <h4>Current Subscription: <strong><?php echo ucfirst($subscription['SubscriptionPlan']); ?></strong></h4>
        <p>Start Date: <?php echo $subscription['SubscriptionStartDate']; ?></p>
        <p>End Date: <?php echo $subscription['SubscriptionEndDate'] ?? 'N/A'; ?></p>
    </div>

    <div class="row text-center">
        <?php foreach ($plans as $plan) { ?>
            <div class="col-md-4">
                <div class="plan-card p-4 bg-light">
                    <h3><?php echo $plan['PlanName']; ?></h3>
                    <p><strong>₹<?php echo number_format($plan['Price'], 2); ?></strong> for <?php echo $plan['DurationInDays']; ?> days</p>
                    <p><?php echo nl2br($plan['Features']); ?></p>
                    <button class="btn btn-primary" onclick="showPopup(<?php echo $plan['PlanID']; ?>, '<?php echo $plan['PlanName']; ?>', <?php echo $plan['Price']; ?>)">Subscribe</button>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <!-- Subscription Popup -->
    <div class="popup-overlay" id="popup-overlay">
        <div class="popup">
            <h4 id="popup-title"></h4>
            <p id="popup-price"></p>
            <img src="assets/images/2.jpg" alt="Scan to Pay" width="200">
            <p>Scan the QR code to proceed with the payment.</p>
            <button class="btn btn-success" onclick="confirmSubscription()">Confirm Payment</button>
            <button class="btn btn-danger" onclick="hidePopup()">Cancel</button>
        </div>
    </div>

    <script>
        function showPopup(planID, planName, planPrice) {
            $("#popup-title").text("Subscribe to " + planName);
            $("#popup-price").text("Price: ₹" + planPrice);
            $("#popup-overlay").fadeIn();
            sessionStorage.setItem("selectedPlanID", planID);
        }
        
        function hidePopup() {
            $("#popup-overlay").fadeOut();
        }

        function confirmSubscription() {
    var planID = sessionStorage.getItem("selectedPlanID");

    if (!planID) {
        alert("Error: No plan selected.");
        return;
    }

    $.post("update_subscription.php", { planID: planID })
    .done(function(response) {
        console.log("Server Response: ", response); // Debugging output
        alert(response); // Show response from server
        location.reload();
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        console.log("AJAX Error: ", textStatus, errorThrown); // Log AJAX error
        alert("Subscription update failed. Please try again.");
    });
}


        // Debugging tool: Detect extra margin
        $(document).ready(function() {
            var bodyMargin = $("body").css("margin-top");
            console.log("Body margin-top: " + bodyMargin);

            if (parseInt(bodyMargin) > 0) {
                $("#debug-space").show(); // Show red box if extra margin is present
            }
        });
        $(document).ready(function() {
    $("#popup-overlay").hide(); // Ensure popup is hidden on page load
});
    </script>
</body>
</html>

<?php include_once 'sub-views/footer2.php'; ?>
