<?php 
include_once 'sub-views/header.php'; 
require 'helpers/init_conn_db.php';

if (!isset($_SESSION['shopOwnerID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['delete_but'])) {
    $cartId = $_POST['cart_id'];
    $sql = "DELETE FROM Carts WHERE CartID = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $cartId);
    mysqli_stmt_execute($stmt);
    header("Location: cart_list.php");
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
                <i class="fa fa-shopping-cart" aria-hidden="true"> Carts</i>
                <table class="table-sm table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">ShopID</th>
                            <th scope="col">Status</th>
                            <th scope="col">TotalAmount</th>
                            <th scope="col">Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM Carts";
                        $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                            <tr>
                                <td scope="row">' . $row['CartID'] . '</td>
                                <td>' . $row['ShopID'] . '</td>
                                <td>' . $row['Status'] . '</td>
                                <td>' . $row['TotalAmount'] . '</td>
                                <td>' . $row['CreatedAt'] . '</td>
                                <td class="options">
                                    <form action="cart_list.php" method="post">
                                        <input type="hidden" name="cart_id" value="' . $row['CartID'] . '">
                                        <button type="submit" name="delete_but" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
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
