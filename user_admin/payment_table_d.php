<?php
// Include the database connection
require 'helpers/init_conn_db.php';

// Handle the "Mark Complete" action
if (isset($_POST['mark_complete'])) {
    $check_id = $_POST['check_id']; // Get the ID of the payment check
    
    // Update the status of the payment check to "Complete"
    $sql = "UPDATE paymentchecks SET status = 'Complete' WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind the check_id parameter
        mysqli_stmt_bind_param($stmt, "i", $check_id);
        
        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to the same page to refresh the table
            header("Location: " . 'http://localhost:8080/zapcart2.0/user_admin/dashboard.php');
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }
}
?>

<table class="table-sm table table-hover table-bordered">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Status</th>
            <th scope="col">Amount</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch all records from the paymentchecks table
        $sql = "SELECT * FROM paymentchecks ORDER BY id DESC;";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Loop through the results and display each payment check
        while ($row = mysqli_fetch_assoc($result)) {
            echo '
                <tr>
                    <td scope="row">'.$row['id'].'</td>
                    <td>'.$row['status'].'</td>
                    <td>'.$row['amount'].'</td>
                    <td>
                        <form action="'.$_SERVER['PHP_SELF'].'" method="post">
                            <input type="hidden" name="check_id" value="'.$row['id'].'">
                            <button type="submit" name="mark_complete" class="btn btn-success btn-sm">Mark Complete</button>
                        </form>
                    </td>
                </tr>';
        }
        ?>
    </tbody>
</table>
