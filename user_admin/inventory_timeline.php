<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "zapcart2db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch inventory alerts
$sql = "SELECT * FROM inventoryalerts ORDER BY AlertDate DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Alert Timeline</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            width: 4px;
            height: 100%;
            background-color: #007bff;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -10px;
            top: 15px;
            width: 12px;
            height: 12px;
            background: #007bff;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="timeline">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="timeline-item">
                        <strong><?= htmlspecialchars($row['ProductName']) ?></strong>
                        <p class="mb-1 text-muted">Alert: <?= htmlspecialchars($row['AlertMessage']) ?></p>
                        <small class="text-secondary">Date: <?= $row['AlertDate'] ?></small>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No alerts found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
