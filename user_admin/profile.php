<?php
session_start();
if (!isset($_SESSION['shopOwnerID'])) {
    header("Location: login.php");
    exit();
}

require 'helpers/init_conn_db.php';

$shopOwnerID = $_SESSION['shopOwnerID'];

// Fetch user details from the database
$query = "SELECT * FROM shopowners WHERE ShopOwnerID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $shopOwnerID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Format subscription dates
$subscriptionStart = date("d M Y", strtotime($user['SubscriptionStartDate']));
$subscriptionEnd = $user['SubscriptionEndDate'] ? date("d M Y", strtotime($user['SubscriptionEndDate'])) : "N/A";

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - ZAPCART</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/44f557ccce.js"></script>
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }
        .profile-card {
            max-width: 500px;
            margin: 60px auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .profile-icon {
            font-size: 80px;
            color: #007bff;
            margin-bottom: 15px;
        }
        .profile-header h2 {
            margin-bottom: 5px;
            font-weight: bold;
        }
        .profile-header h5 {
            color: #6c757d;
        }
        .subscription-badge {
            font-size: 14px;
            padding: 8px 12px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .basic { background: #6c757d; color: white; }
        .standard { background: #007bff; color: white; }
        .premium { background: #28a745; color: white; }
        .profile-details p {
            text-align: left;
            font-size: 16px;
            margin: 8px 0;
        }
        .btn-group a {
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="profile-header">
            <i class="fa fa-user-circle profile-icon"></i>
            <h2><?php echo $user['OwnerName']; ?></h2>
            <h5><?php echo $user['ShopName']; ?></h5>
            <span class="subscription-badge <?php echo strtolower($user['SubscriptionPlan']); ?>">
                <?php echo $user['SubscriptionPlan']; ?> Plan
            </span>
        </div>
        <hr>
        <div class="profile-details">
            <p><strong><i class="fa fa-envelope"></i> Email:</strong> <?php echo $user['Email']; ?></p>
            <p><strong><i class="fa fa-phone"></i> Contact:</strong> <?php echo $user['ContactNumber'] ?? "Not Provided"; ?></p>
            <p><strong><i class="fa fa-map-marker"></i> Address:</strong> <?php echo $user['Address'] ?? "Not Provided"; ?></p>
            <p><strong><i class="fa fa-calendar"></i> Joined:</strong> <?php echo date("d M Y", strtotime($user['CreatedAt'])); ?></p>
            <p><strong><i class="fa fa-clock"></i> Subscription Start:</strong> <?php echo $subscriptionStart; ?></p>
            <p><strong><i class="fa fa-clock"></i> Subscription End:</strong> <?php echo $subscriptionEnd; ?></p>
        </div>
        <hr>
        <div class="btn-group">
            <a href="edit_profile.php" class="btn btn-primary"><i class="fa fa-edit"></i> Edit Profile</a>
            <a href="reset_password.php" class="btn btn-warning"><i class="fa fa-key"></i> Reset Password</a>
            <a href="dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>