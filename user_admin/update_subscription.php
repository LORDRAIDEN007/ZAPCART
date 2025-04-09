<?php
require 'helpers/init_conn_db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['planID'])) {
    $shopOwnerID = $_SESSION['shopOwnerID']; // Ensure user is logged in
    $planID = intval($_POST['planID']); // Sanitize input

    if (!$shopOwnerID) {
        echo "Error: User not logged in.";
        exit;
    }

    // Fetch plan details from subscriptionplans table
    $query = "SELECT PlanName, DurationInDays FROM subscriptionplans WHERE PlanID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $planID);
    $stmt->execute();
    $result = $stmt->get_result();
    $plan = $result->fetch_assoc();

    if (!$plan) {
        echo "Error: Invalid plan selection.";
        exit;
    }

    // Calculate new subscription start and end dates
    $startDate = date('Y-m-d H:i:s'); // Current timestamp
    $endDate = date('Y-m-d H:i:s', strtotime("+{$plan['DurationInDays']} days"));

    // Update the shop owner's subscription details
    $updateQuery = "UPDATE shopowners SET SubscriptionPlan = ?, SubscriptionStartDate = ?, SubscriptionEndDate = ? WHERE ShopOwnerID = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("sssi", $plan['PlanName'], $startDate, $endDate, $shopOwnerID);

    if ($updateStmt->execute()) {
        echo "Subscription updated successfully!";
    } else {
        echo "Database update failed.";
    }
} else {
    echo "Invalid request.";
}
?>
