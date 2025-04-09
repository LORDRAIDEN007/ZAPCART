<?php require 'helpers/init_conn_db.php'; ?>
<?php
          // Fetch the count of transactions
          $transactionCountQuery = "SELECT COUNT(*) AS transaction_count FROM Transactions";
          $transactionCountResult = mysqli_query($conn, $transactionCountQuery);
          $transactionCount = mysqli_fetch_assoc($transactionCountResult)['transaction_count'];
          ?>
          <div class="count"><?php echo $transactionCount; ?></div>