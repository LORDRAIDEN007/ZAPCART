<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/44f557ccce.js"></script>
    <title>ZAPCART</title>          
    <link rel="icon" href="assets/images/brand.png" type="image/x-icon">          
</head>
<style>
    @font-face {
        font-family: 'product sans';
        src: url('assets/css/Product Sans Bold.ttf');
    }

    button.btn-outline-light:hover {
        color: cornflowerblue !important;
    }

    .navbar-custom {
        background-color: #3a3a3a;
        font-family: 'product sans', cursive;
    }

    h4 {
        font-size: 23px !important;
    }

    .table .thead-dark th {
        background-color: #316b83;
    }
</style>
<body>
    <nav class="navbar navbar-custom navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand text-light" href="dashboard.php"><h4>ZAPCART - Admin</h4></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <?php if(isset($_SESSION['shopOwnerID'])) { ?>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">
                            <h5 class="ml-2">Dashboard</h5>
                        </a>
                    </li>
                </ul>
                
                <!-- User Dropdown -->
                <div class="navbar-right dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 25px;">
                        <i class="ml-1 fa fa-user text-light"></i> 
                        <?php echo $_SESSION['ownerName']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="profile.php"><i class="fa fa-user-circle"></i> Profile</a>
                        <a class="dropdown-item" href="subscriptions.php"><i class="fa fa-credit-card"></i> Subscription Plans</a>
                        <a class="dropdown-item" href="help.php"><i class="fa fa-question-circle"></i> Help</a>
                        <div class="dropdown-divider"></div>
                        <form action="includes/logout.inc.php" method="POST" class="dropdown-item">
                            <button class="btn btn-outline-danger btn-block" type="submit"><i class="fa fa-sign-out"></i> Logout</button>
                        </form> 
                    </div>
                </div>
            <?php } ?>
        </div>
    </nav>

    <!-- Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Ensure Dropdown Works -->
    <script>
        $(document).ready(function () {
            $('.dropdown-toggle').dropdown();
        });
    </script>
</body>
</html>
