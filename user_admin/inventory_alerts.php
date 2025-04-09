<?php 
include_once 'sub-views/header.php'; 
require 'helpers/init_conn_db.php';

if (!isset($_SESSION['shopOwnerID'])) {
    header("Location: login.php");
    exit();
}

?>
<style>
    
    main {
    background-image: url('assets/images/bg.jpeg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh; /* Full viewport height */
    margin: 0; /* Remove default margin */
    display: flex; /* Optional: Center content inside the main */
    align-items: center; /* Optional: Center content vertically */
    justify-content: center; /* Optional: Center content horizontally */
    margin-top: -55px;
  }
  </style>
<link rel="stylesheet" href="assets/css/admin.css">
<main >
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <i class="fa fa-bell" aria-hidden="true"> Inventory Alerts</i>
                <table class="table-sm table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Shop ID</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Alert Message</th>
                            <th scope="col">Alert Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM InventoryAlerts";
                        $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                            <tr>
                                <td scope="row">' . $row['AlertID'] . '</td>
                                <td>' . $row['ShopID'] . '</td>
                                <td>' . $row['ProductID'] . '</td>
                                <td>' . $row['ProductName'] . '</td>
                                <td>' . $row['AlertMessage'] . '</td>
                                <td>' . $row['AlertDate'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include_once 'sub-views/footer2.php'; ?>
