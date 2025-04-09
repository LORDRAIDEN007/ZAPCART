<?php 
include_once 'sub-views/header.php'; 
require 'helpers/init_conn_db.php';
?>

<link rel="stylesheet" href="assets/css/admin.css">
<link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300&family=Poiret+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
<script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
<script>
    // Function to update inventory_table_d
    function updateInventoryTable() {
        $.ajax({
            url: "inventory_table_d.php",
            success: function (result) {
                $("#inventory_table_d").html(result);
            }
        });
    }

    // Function to update product_table_d
    function updateProductTable() {
        $.ajax({
            url: "product_table_d.php",
            success: function (result) {
                $("#product_table_d").html(result);
            }
        });
    }

    // Function to update transaction_table_d
    function updateTransactionTable() {
        $.ajax({
            url: "transaction_table_d.php",
            success: function (result) {
                $("#transaction_table_d").html(result);
            }
        });
    }

    // Function to update payment_table_d
    function updatePaymentTable() {
        $.ajax({
            url: "payment_table_d.php",
            success: function (result) {
                $("#payment_table_d").html(result);
            }
        });
    }

    // Function to update product_count
    function productcount() {
        $.ajax({
            url: "product_count.php",
            success: function (result) {
                $("#product_count").html(result);
            }
        });
    }

    // Function to update cart_count
    function cartcount() {
        $.ajax({
            url: "carts_count.php",
            success: function (result) {
                $("#carts_count").html(result);
            }
        });
    }

    // Function to update transactions_count
    function transactionscount() {
        $.ajax({
            url: "transactions_count.php",
            success: function (result) {
                $("#transactions_count").html(result);
            }
        });
    }

    // Function to update inventory_count
    function inventorycount() {
        $.ajax({
            url: "inventory_count.php",
            success: function (result) {
                $("#inventory_count").html(result);
            }
        });
    }

    // Function to update recommendation_count
    function recommendationcount() {
        $.ajax({
            url: "recommendations_count.php",
            success: function (result) {
                $("#recommendations_count").html(result);
            }
        });
    }

    // Call all functions when the page loads
    updateInventoryTable();
    updateProductTable();
    updateTransactionTable();
    updatePaymentTable();
    productcount();
    cartcount();
    transactionscount();
    inventorycount();
    recommendationcount();

    // Set intervals for periodic updates
    setInterval(updateInventoryTable, 1000); // Update inventory table every second
    setInterval(updateProductTable, 1000);   // Update product table every second
    setInterval(updateTransactionTable, 1000); // Update transaction table every second
    setInterval(updatePaymentTable, 1000);   // Update payment table every second
    setInterval(productcount, 1000); // Update product count every second
    setInterval(cartcount, 1000); // Update cart count every second
    setInterval(transactionscount, 1000); // Update transactions count every second
    setInterval(inventorycount, 1000); // Update inventory count every second
    setInterval(recommendationcount, 1000); // Update recommendation count every second










    // Function to update timeline
function updateTimeline() {
    $.ajax({
        url: "inventory_timeline.php",
        success: function (result) {
            $("#timeline-container").html(result);
        }
    });
}

// Add to your existing function calls
updateTimeline();

// Add to your setInterval calls
setInterval(updateTimeline, 1000);
</script>




<style>
  main{
    background-image: url('assets/images/bg.jpeg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat
  }
  body {
    background-color: #efefef;
  }
  td {
    font-size: 18px !important;
  }
  p {
    font-size: 35px;
    font-weight: 100;
    font-family: 'product sans';  
  }

  .main-section {
    width: 100%;
    margin: 0 auto;
    text-align: center;
    padding: 0px 20px;
    display: flex;
    justify-content: space-evenly;
    flex-wrap: wrap;
  }

  .dashboard {
    width: 18%;
    display: inline-block;
    background-color: #34495E;
    color: #fff;
    margin-top: 50px;
    text-align: center;
    padding: 20px;
    border-radius: 8px;
    box-sizing: border-box;
    margin-bottom: 30px;
  }

  .icon-section i {
    font-size: 30px;
    padding: 10px;
    border: 1px solid #fff;
    border-radius: 50%;
    background-color: #34495E;
  }

  .icon-section p {
    margin: 0px;
    font-size: 20px;
    padding-bottom: 10px;
  }

  .detail-section {
    margin-top: 10px;
    background-color: #2F4254;
    padding: 5px 0px;
  }

  .dashboard .detail-section:hover {
    background-color: #5a5a5a;
    cursor: pointer;
  }

  .detail-section a {
    color: #fff;
    text-decoration: none;
  }

  .count {
    font-size: 25px;
    font-weight: bold;
    color: white;
    margin-top: 10px;
  }

  .dashboard-2 .icon-section,
  .dashboard-2 .icon-section i {
    background-color: #9CB4CC;
  }

  .dashboard-2 .detail-section {
    background-color: #149077;
  }

  .dashboard-1 .icon-section,
  .dashboard-1 .icon-section i {
    background-color: #2980B9;
  }

  .dashboard-1 .detail-section {
    background-color: #2573A6;
  }

  .dashboard-3 .icon-section,
  .dashboard-3 .icon-section i {
    background-color: #316B83;
  }

  .dashboard-3 .detail-section {
    background-color: #CF4436;
  }

  .dashboard-4 .icon-section,
  .dashboard-4 .icon-section i {
    background-color: #A569BD;
  }

  .dashboard-4 .detail-section {
    background-color: #8E44AD;
  }

  .dashboard-5 .icon-section,
  .dashboard-5 .icon-section i {
    background-color: #45B39D;
  }

  .dashboard-5 .detail-section {
    background-color: #16A085;
  }

  table {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
  }

  td, th {
    padding: 12px;
    font-size: 18px;
  }
  /* Make the outer container full-width */
.container {
  width: 150%;
  padding: 0 0px; /* Add padding for better spacing */
}

/* Center the content and set max-width */
.inner-container {
  display: flex;
  flex-wrap: wrap;
  max-width: 1400px;
  margin: 0 auto;
}

/* Adjust left and right sections */
.left-section {
  width: 70%;
}

.right-section {
  width: 30%;
  padding-left: 75px;
}

/* Make sure right section fills available height */
/* .right-section .card {
  height: 100%;
} */


</style>

<main >
  <?php if (isset($_SESSION['shopOwnerID'])) { ?>
    <div class="container">
      <div class="main-section">
        <!-- Dashboard Items -->
        <div class="dashboard dashboard-1">
          <div class="icon-section">
            <i class="fa fa-cogs" aria-hidden="true"></i><br>
            Products
          </div>
          <div id="product_count">

          </div>
          <div class="detail-section">
            <a href="product_list.php">Manage Products</a>
          </div>
        </div>  

        <div class="dashboard dashboard-2">
          <div class="icon-section">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i><br>
            Carts
          </div>
          <div id="carts_count"></div>
          <div class="detail-section">
            <a href="cart_list.php">View Carts</a>
          </div>
        </div>

        <div class="dashboard dashboard-3">
          <div class="icon-section">
            <i class="fa fa-credit-card" aria-hidden="true"></i><br>
            Transactions
          </div>
          <div id="transactions_count"></div>
          <div class="detail-section">
            <a href="transaction_list.php">View Transactions</a>
          </div>
        </div>     

        <div class="dashboard dashboard-4">
          <div class="icon-section">
            <i class="fa fa-bell" aria-hidden="true"></i><br>
            Inventory Alerts
          </div>
          <div id="inventory_count"></div>
          
          <div class="detail-section">
            <a href="inventory_alerts.php">View Alerts</a>
          </div>
        </div>  

        <div class="dashboard dashboard-5">
          <div class="icon-section">
            <i class="fa fa-lightbulb-o" aria-hidden="true"></i><br>
            ZAPCART AI
          </div>
          <div id="recommendations_count"></div>
          
          <div class="detail-section">
            <a href="airecommendations.php">Recommendations</a>
          </div>
        </div>
      </div>
    
      <div class="container">
      <div class="inner-container">
        <!-- Left Section -->
        <div class="left-section">
          <!-- Payment List Section -->
          <div class="card mt-4" id="payments">
            <div class="card-body">
              <p class="text-secondary" style="color: #007bff; font-size: 1.5rem;">Payment List</p>
              <div id="payment_table_d"></div>  
            </div>
          </div>

          <!-- Products List Section -->
          <div class="card mt-4" id="products">
            <div class="card-body">
              <p class="text-secondary" style="color: #007bff; font-size: 1.5rem;">Low Stock Product List</p>
              <div id="product_table_d"></div>  
            </div>
          </div>

          <!-- Inventory Alerts Table -->
          <!-- <div class="card mt-4" id="alerts">
            <div class="card-body">
              <p class="text-secondary" style="color: #007bff; font-size: 1.5rem;">Inventory Alerts</p>
              <div id="inventory_table_d"></div>
            </div>
          </div> -->

          <!-- Transactions Table -->
          <div class="card mt-4" id="transactions">
            <div class="card-body">
              <p class="text-secondary" style="color: #007bff; font-size: 1.5rem;">Transactions</p>
              <div id="transaction_table_d"></div>
            </div>
          </div>
        </div>

        <!-- Right Section -->
        <!-- Right Section -->
<div class="right-section">
    <div class="card mt-4" id="right-container">
        <div class="card-body">
            <p class="text-secondary" style="color: #007bff; font-size: 1.5rem;">Inventory Alerts Timeline</p>
            <div id="timeline-container"></div>
        </div>
    </div>
</div>
      </div>
    </div>

  <?php } ?>
</main>

<?php include 'sub-views/footer2.php'; ?>
