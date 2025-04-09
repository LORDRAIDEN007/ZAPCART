<?php require 'helpers/init_conn_db.php'; ?>
<?php
          // Fetch the count of carts
          $cartCountQuery = "SELECT COUNT(*) AS cart_count FROM Carts";
          $cartCountResult = mysqli_query($conn, $cartCountQuery);
          $cartCount = mysqli_fetch_assoc($cartCountResult)['cart_count'];
          ?>
          <div class="count"><?php echo $cartCount; ?></div>