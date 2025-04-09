<?php
include_once 'sub-views/header.php';
require 'helpers/init_conn_db.php';


if (!isset($_SESSION['shopOwnerID'])) {
    header("Location: login.php");
    exit();
}

// Handle add product action
if (isset($_POST['add_product'])) {
    $productName = $_POST['product_name'];
    $productCategory = $_POST['product_category'];
    $productPrice = $_POST['product_price'];
    $productStock = $_POST['product_stock'];
    $productWeight = $_POST['product_weight'];
    $productCalories = $_POST['product_calories'];
    $productShelfLocation = $_POST['product_shelf_location'];
    $rfidTag = $_POST['rfid_tag'];
    $lastUpdated = date('Y-m-d H:i:s');

    $sql = "INSERT INTO Products (ProductName, Category, Price, Stock,Weight,Calories,ShelfLocation, RFIDTag, LastUpdated) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'ssdiidsss', $productName, $productCategory, $productPrice, $productStock, $productWeight, $productCalories, $productShelfLocation, $rfidTag, $lastUpdated);
        mysqli_stmt_execute($stmt);
        header("Location: product_list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Handle delete action
if (isset($_POST['delete_but'])) {
    $productId = $_POST['product_id'];
    $sql = "DELETE FROM Products WHERE ProductID = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $productId);
    mysqli_stmt_execute($stmt);
    header("Location: product_list.php");
    exit();
}

// Handle edit action
if (isset($_POST['edit_but'])) {
    $productId = $_POST['product_id'];
    header("Location: edit_product.php?product_id=" . $productId);
    exit();
}
?>

<link rel="stylesheet" href="assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300&family=Poiret+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
<style>
    main {
        background-image: url('assets/images/bg.jpeg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -55px;
    }
</style>

<main>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Product Management</h2>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProductModal">Add Product</button>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <i class="fa fa-cogs" aria-hidden="true"> Products</i>
                <table class="table-sm table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Calories</th>
                            <th scope="col">ShelfLocation</th>
                            <th scope="col">RFID Tag</th>
                            <th scope="col">Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM Products";
                        $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                            <tr>
                                <td scope="row">' . $row['ProductID'] . '</td>
                                <td>' . $row['ProductName'] . '</td>
                                <td>' . $row['Category'] . '</td>
                                <td>' . $row['Price'] . '</td>
                                <td>' . $row['Stock'] . '</td>
                                <td>' . $row['Weight'] . '</td>
                                <td>' . $row['Calories'] . '</td>
                                <td>' . $row['ShelfLocation'] . '</td>
                                <td>' . $row['RFIDTag'] . '</td>
                                <td>' . $row['LastUpdated'] . '</td>
                                <td class="options">
                                    <div class="dropdown">
                                        <a class="text-reset text-decoration-none" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu">
                                            <form class="px-4 py-3" action="product_list.php" method="post">
                                                <input type="hidden" name="product_id" value="' . $row['ProductID'] . '">
                                                <button type="submit" name="edit_but" class="btn btn-primary btn-sm">Edit</button>
                                                <button type="submit" name="delete_but" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </div>  
                                </td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="product_list.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="productName">Product Name</label>
                            <input type="text" class="form-control" name="product_name" required>
                        </div>
                        <div class="form-group">
                            <label for="productCategory">Category</label>
                            <input type="text" class="form-control" name="product_category" required>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Price</label>
                            <input type="number" step="0.01" class="form-control" name="product_price" required>
                        </div>
                        <div class="form-group">
                            <label for="productStock">Stock</label>
                            <input type="number" class="form-control" name="product_stock" required>
                        </div>
                        <div class="form-group">
                            <label for="productWeight">Weight</label>
                            <input type="number" class="form-control" name="product_weight" required>
                        </div>
                        <div class="form-group">
                            <label for="productCalories">Calories</label>
                            <input type="number" class="form-control" name="product_calories" required>
                        </div>
                        <div class="form-group">
                            <label for="productShelfLocation">Shelf Location</label>
                            <input type="text" class="form-control" name="product_shelf_location" required>
                        </div>

                        <div class="form-group">
                            <label for="rfidTag">RFID Tag</label>
                            <input type="text" class="form-control" name="rfid_tag" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include_once 'sub-views/footer2.php'; ?>
