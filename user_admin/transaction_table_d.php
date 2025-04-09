<?php require 'helpers/init_conn_db.php'; ?>
<table class="table-sm table table-hover table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Cart ID</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Payment Method</th>
                <th scope="col">Transaction Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $transactionSql = "SELECT * FROM Transactions";
                $transactionStmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($transactionStmt, $transactionSql);
                mysqli_stmt_execute($transactionStmt);
                $transactionResult = mysqli_stmt_get_result($transactionStmt);

                while ($transactionRow = mysqli_fetch_assoc($transactionResult)) {
                  echo '
                    <tr>
                      <td scope="row">'.$transactionRow['TransactionID'].'</td>
                      <td>'.$transactionRow['CartID'].'</td>
                      <td>'.$transactionRow['TotalAmount'].'</td>
                      <td>'.$transactionRow['PaymentMethod'].'</td>
                      <td>'.$transactionRow['TransactionDate'].'</td>
                      <th class="options">
                        <div class="dropdown">
                          <a class="text-reset text-decoration-none" href="#" 
                             id="dropdownMenuButton" data-toggle="dropdown" 
                             aria-haspopup="true" aria-expanded="false">
                             <i class="fa fa-ellipsis-v"></i>
                          </a>  
                          <div class="dropdown-menu">
                            <form class="px-4 py-3" action="../includes/admin/admin.inc.php" method="post">
                              <input type="hidden" name="transaction_id" value="'.$transactionRow['TransactionID'].'">
                              <button type="submit" name="view_transaction" class="btn btn-info btn-sm">View Details</button>
                            </form>
                          </div>
                        </div>  
                      </th>                
                    </tr>';
                }
              ?>
            </tbody>
          </table>