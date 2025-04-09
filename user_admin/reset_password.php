<?php
session_start();
require 'helpers/init_conn_db.php';

if (!isset($_SESSION['shopOwnerID'])) {
    header("Location: login.php");
    exit();
}

$shopOwnerID = $_SESSION['shopOwnerID'];
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $error = "New passwords do not match.";
    } elseif (strlen($new_password) < 6) {
        $error = "Password must be at least 6 characters long.";
    } else {
        // Fetch current password hash from the database
        $query = "SELECT Password FROM shopowners WHERE ShopOwnerID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $shopOwnerID);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($old_password, $user['Password'])) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password in database
            $update_query = "UPDATE shopowners SET Password = ? WHERE ShopOwnerID = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $hashed_password, $shopOwnerID);
            $update_stmt->execute();
            $update_stmt->close();

            $success = "Password updated successfully!";
        } else {
            $error = "Old password is incorrect.";
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - ZAPCART</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body">
                <h4 class="card-title text-center">Reset Password</h4>
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"> <?php echo $error; ?> </div>
                <?php elseif (!empty($success)): ?>
                    <div class="alert alert-success"> <?php echo $success; ?> </div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Old Password</label>
                        <input type="password" name="old_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block">Reset Password</button>
                </form>
                <a href="profile.php" class="d-block text-center mt-3">Back to Profile</a>
            </div>
        </div>
    </div>
</body>
</html>
