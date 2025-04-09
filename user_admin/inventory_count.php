<?php require 'helpers/init_conn_db.php'; ?>
<?php
          // Fetch the count of inventory alerts
          $alertCountQuery = "SELECT COUNT(*) AS alert_count FROM InventoryAlerts";
          $alertCountResult = mysqli_query($conn, $alertCountQuery);
          $alertCount = mysqli_fetch_assoc($alertCountResult)['alert_count'];
          ?>
          <div class="count"><?php echo $alertCount; ?></div>