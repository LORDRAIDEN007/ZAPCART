<?php require 'helpers/init_conn_db.php'; ?>
<table class="table-sm table table-hover table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Alert Message</th>
                <th scope="col">Alert Date</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $alertSql = "SELECT * FROM InventoryAlerts";
                $alertStmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($alertStmt, $alertSql);
                mysqli_stmt_execute($alertStmt);
                $alertResult = mysqli_stmt_get_result($alertStmt);

                while ($alertRow = mysqli_fetch_assoc($alertResult)) {
                  echo '
                    <tr>
                      <td scope="row">'.$alertRow['AlertID'].'</td>
                      <td>'.$alertRow['ProductName'].'</td>
                      <td>'.$alertRow['AlertMessage'].'</td>
                      <td>'.$alertRow['AlertDate'].'</td>
                      <th class="options">
                        <div class="dropdown">
                          <a class="text-reset text-decoration-none" href="#" 
                             id="dropdownMenuButton" data-toggle="dropdown" 
                             aria-haspopup="true" aria-expanded="false">
                             <i class="fa fa-ellipsis-v"></i>
                          </a>  
                          <div class="dropdown-menu">
                            <form class="px-4 py-3" action="../includes/admin/admin.inc.php" method="post">
                              <input type="hidden" name="alert_id" value="'.$alertRow['AlertID'].'">
                              <button type="submit" name="resolve_alert" class="btn btn-success btn-sm">Resolve</button>
                            </form>
                          </div>
                        </div>  
                      </th>                
                    </tr>';
                }
              ?>
            </tbody>
          </table>