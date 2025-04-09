<?php require 'helpers/init_conn_db.php'; ?>
<?php
          // Fetch the count of stock history entries
          $aiRecommendationsCountQuery = "SELECT COUNT(*) AS ai_recommendations_count FROM airecommendations";
    $aiRecommendationsCountResult = mysqli_query($conn, $aiRecommendationsCountQuery);
    $aiRecommendationsCount = mysqli_fetch_assoc($aiRecommendationsCountResult)['ai_recommendations_count'];
          ?>
          <div class="count"><?php echo $aiRecommendationsCount; ?></div>