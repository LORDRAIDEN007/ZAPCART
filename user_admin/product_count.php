<?php require 'helpers/init_conn_db.php'; ?>
<?php
    // Fetch the count of products
    $productCountQuery = "SELECT COUNT(*) AS product_count FROM Products";
    $productCountResult = mysqli_query($conn, $productCountQuery);
    $productCount = mysqli_fetch_assoc($productCountResult)['product_count'];
?>
<div class="count"><?php echo $productCount; ?></div>