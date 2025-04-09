<?php
include 'sub-views/header.php';
require 'helpers/init_conn_db.php';

// Check if admin is logged in
if (!isset($_SESSION['shopOwnerID'])) {
    header("Location: login.php");
    exit();
}

// Check if a product ID is provided
if (!isset($_GET['product_id'])) {
    header("Location: product_list.php");
    exit();
}

$productId = $_GET['product_id'];

// Fetch the product details
$sql = "SELECT * FROM Products WHERE ProductID = ?";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "Error: " . mysqli_error($conn);
    exit();
}
mysqli_stmt_bind_param($stmt, 'i', $productId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

// Handle update form submission
if (isset($_POST['update_product'])) {
    $productName = $_POST['product_name'];
    $productCategory = $_POST['product_category'];
    $productPrice = $_POST['product_price'];
    $productStock = $_POST['product_stock'];
    $productWeight = $_POST['product_weight'];
    $productCalories = $_POST['product_calories'];
    $productShelfLocation = $_POST['product_shelf_location'];
    $rfidTag = $_POST['rfid_tag'];

    $updateSql = "UPDATE Products 
              SET ProductName = ?, Category = ?, Price = ?, Stock = ?, Weight = ?, Calories = ?, ShelfLocation = ?, RFIDTag = ? 
              WHERE ProductID = ?";
$updateStmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($updateStmt, $updateSql)) {
    mysqli_stmt_bind_param($updateStmt, 'ssdiidssi', $productName, $productCategory, $productPrice, $productStock, $productWeight, $productCalories, $productShelfLocation, $rfidTag, $productId);
    mysqli_stmt_execute($updateStmt);
    header("Location: product_list.php");
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
    exit();
}

}
?>

<!-- <link rel="stylesheet" href="assets/css/admin.css"> -->
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300&family=Poiret+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
<style>
    /* General Styles */
/* General Styles */
body {
    font-family: 'Assistant', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

main {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: calc(100vh - 100px); /* Adjusted height to prevent overlapping */
    background: url('assets/images/bg.jpeg') no-repeat center center/cover;
    padding: 20px 0;
}

.container {
    width: 100%;
    max-width: 600px;
    margin-top: 60px; /* Added margin to avoid overlap with header */
    margin-bottom: 40px; /* Added margin to avoid overlap with footer */
}

.card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    backdrop-filter: blur(10px);
}

.card h3 {
    font-family: 'Cinzel', serif;
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Form Styles */
.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: 600;
    display: block;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: 0.3s;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0px 0px 8px rgba(0, 123, 255, 0.3);
}

/* Buttons */
.btn {
    display: inline-block;
    width: 100%;
    padding: 10px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    text-align: center;
    text-decoration: none;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    color: white;
    margin-top: 10px;
}

.btn-secondary:hover {
    background-color: #545b62;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        max-width: 90%;
    }
}

</style>

<main>
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h3>Edit Product</h3>
                <form action="edit_product.php?product_id=<?= $productId ?>" method="post">
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" name="product_name" value="<?= htmlspecialchars($product['ProductName']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="productCategory">Category</label>
                        <input type="text" class="form-control" name="product_category" value="<?= htmlspecialchars($product['Category']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="productPrice">Price</label>
                        <input type="number" step="0.01" class="form-control" name="product_price" value="<?= htmlspecialchars($product['Price']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="productStock">Stock</label>
                        <input type="number" class="form-control" name="product_stock" value="<?= htmlspecialchars($product['Stock']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="productWeight">Weight</label>
                        <input type="number" step="0.01" class="form-control" name="product_weight" value="<?= htmlspecialchars($product['Weight']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="productCalories">Calories</label>
                        <input type="number" class="form-control" name="product_calories" value="<?= htmlspecialchars($product['Calories']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="productShelfLocation">Shelf Location</label>
                        <input type="text" class="form-control" name="product_shelf_location" value="<?= htmlspecialchars($product['ShelfLocation']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="rfidTag">RFID Tag</label>
                        <input type="text" class="form-control" name="rfid_tag" value="<?= htmlspecialchars($product['RFIDTag']) ?>" required>
                    </div>
                    <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
                    <a href="product_list.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include_once 'sub-views/footer2.php'; ?>
