  <?php require 'helpers/init_conn_db.php'; ?>
  <table class="table-sm table table-hover table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Product Name</th>
                  <th scope="col">Category</th>
                  <th scope="col">Price</th>
                  <th scope="col">Stock</th>
                  <th scope="col">Last Updated</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>              
                <?php
                  $sql = "SELECT * FROM Products where stock < 10";
                  $stmt = mysqli_stmt_init($conn);
                  mysqli_stmt_prepare($stmt, $sql);
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                      <tr>
                        <td scope="row">'.$row['ProductID'].'</td>
                        <td>'.$row['ProductName'].'</td>
                        <td>'.$row['Category'].'</td>
                        <td>'.$row['Price'].'</td>
                        <td>'.$row['Stock'].'</td>
                        <td>'.$row['LastUpdated'].'</td>
                        <th class="options">
                          <div class="dropdown">
                            <a class="text-reset text-decoration-none" href="#" 
                              id="dropdownMenuButton" data-toggle="dropdown" 
                                aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-ellipsis-v"></i>
                            </a>  
                            <div class="dropdown-menu">
                              <form class="px-4 py-3" action="../includes/admin/admin.inc.php" method="post">
                                <input type="hidden" name="product_id" value="'.$row['ProductID'].'">
                                <button type="submit" name="edit_but" class="btn btn-primary btn-sm">Edit</button>
                                <button type="submit" name="delete_but" class="btn btn-danger btn-sm">Delete</button>
                              </form>
                            </div>
                          </div>  
                        </th>                
                      </tr> ';
                  }
                ?>
              </tbody>
            </table>