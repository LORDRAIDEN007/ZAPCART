<?php
if(isset($_POST['login_but'])) {
    require '../helpers/init_conn_db.php';
    
    $email_id = $_POST['user_id'];
    $password = $_POST['user_pass'];

    // Query to fetch shop owner details by email
    $sql = 'SELECT * FROM shopowners WHERE Email=? OR OwnerName=?';
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('Location: ../index.php?error=sqlerror');
        exit();
    }

    mysqli_stmt_bind_param($stmt,'ss',$email_id,$email_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['Password'])) {
            session_start();
            $_SESSION['shopOwnerID'] = $row['ShopOwnerID'];
            $_SESSION['shopName'] = $row['ShopName'];
            $_SESSION['ownerName'] = $row['OwnerName'];
            $_SESSION['shopEmail'] = $row['Email'];
            $_SESSION['subscriptionPlan'] = $row['SubscriptionPlan'];
            header('Location: ../dashboard.php?login=success');
            exit();
        } else {
            header('Location: ../index.php?error=wrongpwd');
            exit();
        }
    } else {
        header('Location: ../index.php?error=invalidcred');
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header('Location: dashboard.php');
    exit();
}
