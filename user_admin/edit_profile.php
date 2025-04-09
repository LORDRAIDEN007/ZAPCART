<?php
session_start();
if (!isset($_SESSION['shopOwnerID'])) {
    header("Location: login.php");
    exit();
}

require 'helpers/init_conn_db.php';
$shopOwnerID = $_SESSION['shopOwnerID'];

// Fetch current user details
$query = "SELECT * FROM shopowners WHERE ShopOwnerID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $shopOwnerID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ownerName = $_POST['OwnerName'];
    $shopName = $_POST['ShopName'];
    $email = $_POST['Email'];
    $contactNumber = $_POST['ContactNumber'];
    $address = $_POST['Address'];

    $updateQuery = "UPDATE shopowners SET OwnerName=?, ShopName=?, Email=?, ContactNumber=?, Address=? WHERE ShopOwnerID=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssssss", $ownerName, $shopName, $email, $contactNumber, $address, $shopOwnerID);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully.";
        header("Location: edit_profile.php");
        exit();
    } else {
        $error_message = "Error updating profile. Please try again.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - ZAPCART</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/44f557ccce.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
        }
        .card {
            border-radius: 10px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-weight: bold;
            color: #333;
        }
        .btn-custom {
            background: #007bff;
            color: white;
            font-weight: bold;
        }
        .btn-custom:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <h2 class="text-center">Edit Profile</h2>
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success"> <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?> </div>
        <?php elseif (isset($error_message)): ?>
            <div class="alert alert-danger"> <?php echo $error_message; ?> </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Owner Name</label>
                <input type="text" name="OwnerName" class="form-control" value="<?php echo htmlspecialchars($user['OwnerName']); ?>" required>
            </div>
            <div class="form-group">
                <label>Shop Name</label>
                <input type="text" name="ShopName" class="form-control" value="<?php echo htmlspecialchars($user['ShopName']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="Email" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="ContactNumber" class="form-control" value="<?php echo htmlspecialchars($user['ContactNumber']); ?>">
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="Address" class="form-control"><?php echo htmlspecialchars($user['Address']); ?></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-custom btn-block"><i class="fa fa-save"></i> Save Changes</button>
                <a href="subscriptions.php" class="btn btn-warning btn-block"><i class="fa fa-credit-card"></i> Manage Subscription</a>
                <a href="profile.php" class="btn btn-secondary btn-block"><i class="fa fa-arrow-left"></i> Back to Profile</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>
