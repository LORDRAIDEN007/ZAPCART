<?php 
include_once 'sub-views/header.php'; 
require 'helpers/init_conn_db.php';

if (!isset($_SESSION['shopOwnerID'])) {
    header("Location: login.php");
    exit();
}

$shopOwnerID = $_SESSION['shopOwnerID'];

// Fetch user's subscription plan
$query = "SELECT SubscriptionPlan FROM shopowners WHERE ShopOwnerID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $shopOwnerID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$subscriptionPlan = $user['SubscriptionPlan'] ?? 'Basic'; // Default to Basic if not found
?>
<style>
    main {
        background-image: url('assets/images/bg.jpeg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh; /* Full viewport height */
        margin: 0; /* Remove default margin */
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 20px;
    }

    .container {
        width: 90%;
        max-width: 800px;
        background: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-upgrade {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
        font-size: 16px;
    }

    .btn-upgrade:hover {
        background-color: #0056b3;
    }
</style>

<main>
    <div class="container">
        <?php if ($subscriptionPlan === 'Basic'): ?>
            <h2>Your current plan is <strong>Basic</strong></h2>
            <p>Upgrade to <strong>Standard</strong> or <strong>Premium</strong> to access AI recommendations.</p>
            <a href="subscriptions.php" class="btn-upgrade">Upgrade Now</a>
        <?php else: ?>
            <h2>AI Recommendations</h2>
            <div class="table-container">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Shop ID</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Shelf Location</th>
                            <th>Recommended Product ID</th>
                            <th>Recommended Product Name</th>
                            <th>Recommended Shelf Location</th>
                            <th>Recommendation For</th>
                            <th>Is Successful</th>
                            <th>Recommendation Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM airecommendations";
                        $stmt = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt, $sql);
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                            <tr>
                                <td>' . $row['RecommendationID'] . '</td>
                                <td>' . $row['ShopID'] . '</td>
                                <td>' . $row['ProductID'] . '</td>
                                <td>' . $row['ProductName'] . '</td>
                                <td>' . $row['ShelfLocation'] . '</td>
                                <td>' . $row['RecommendedProductID'] . '</td>
                                <td>' . $row['RecommendedProductName'] . '</td>
                                <td>' . $row['RecommendedShelfLocation'] . '</td>
                                <td>' . $row['RecommendationFor'] . '</td>
                                <td>' . ($row['IsSuccessful'] ? 'Yes' : 'No') . '</td>
                                <td>' . $row['RecommendationDate'] . '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include_once 'sub-views/footer2.php'; ?>
