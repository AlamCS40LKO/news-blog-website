<?php include "header.php";

if($_SESSION['user_role']=='0'){
    header("Location: {$hostname}/admin/post.php");
}
    
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php
                         require('config.php');

                         $page = isset($_GET['page']) ? $_GET['page'] : 1; // Provide a default value for $page
                         $limit = 5;
                         $offset = ($page - 1) * $limit; // Use $limit consistently
                         $sql = "SELECT * FROM user ORDER BY user_id DESC LIMIT {$offset}, {$limit}";
                                            
                         $result=mysqli_query($conn,$sql) or die("In Table Something Went Wrong");
                         
                         if (mysqli_num_rows($result)>0) {
                             $count=$offset+1;
                            while ($row=mysqli_fetch_assoc($result)) {?>
                          <tr>
                              <td class='id'><?php echo $count;?></td>
                              <td><?php echo $row['first_name'],' ',$row['last_name'];?></td>
                              <td><?php echo $row['username'];?></td>
                              <td><?php 
                              if( $row['role']==1){
                                echo "admin";
                              }else {
                                echo "Normal";
                              }
                              ?></td>
                              <td class='edit'><a href='update-user.php?id=<?php echo $row['user_id'];?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-user.php?id=<?php echo $row['user_id'];?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php 
                           $count++;
                          }
                           ?>
                          </tbody>
                  </table>
                          <?php } 
                          
                          $sql1="select * from user";
                          $result1 = mysqli_query($conn, $sql1);
                          $total_records=mysqli_num_rows($result1);
                        
                        $total_pages=ceil($total_records/$limit);
                        echo "<ul class='pagination admin-pagination'>";
                        if($page>1){
                            echo "<li><a href='users.php?page=" . ($page - 1) . "'>Prev</a></li>";
                        }
                        for ($i=1; $i <=$total_pages; $i++) { 
                            if($i==$page){
                                $active = "active";
                            }
                            else {
                                $active="";
                            }
                            echo "<li class='".$active."'><a href='users.php?page=".$i."'>".$i."</a></li>";
                        }
                        if($total_pages>$page){
                            echo "<li><a href='users.php?page=" . ($page + 1) . "'>Nxt</a></li>";
                        }
                        echo '</ul>';
                          
                          ?>
                     
                 
                      <!-- <li class="active"><a>1</a></li> -->
                  
              </div>
          </div>
      </div>
  </div>
