<?php include "header.php"; ?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <?php
                    require('config.php');
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                         $limit = 5;
                         $offset = ($page - 1) * $limit;

                    
                    if($_SESSION['user_role']=='1'){
                        $sql="select post.post_id, post.title, post.description, post.post_date,
                        category.category_name,category.category_id, user.username from post  
                        left join category on post.category = category.category_id
                        left join user on post.author = user.user_id
                        order by post.post_id desc limit {$offset},{$limit}";
                    }
                    elseif($_SESSION['user_role']=='0'){
                        $sql="select post.post_id, post.title, post.description, post.post_date,
                        category.category_name, user.username from post  
                        left join category on post.category = category.category_id
                        left join user on post.author = user.user_id
                        where post.author = {$_SESSION['user_id']}
                        order by post.post_id desc limit {$offset},{$limit}";
                    }
                      
                      $result=mysqli_query($conn, $sql) or die("Query failed");
                      if(mysqli_num_rows($result)>0){
                        $count=$offset+1;
                        while($row=mysqli_fetch_assoc($result)) {
                           
                      ?>
                      <tbody>

                          <tr>
                              <td class='id'><?php echo $count; ?></td>
                              <td><?php echo $row['title']?></td>
                              <td><?php echo $row['category_name']?></td>
                              <td><?php echo $row['post_date']?></td>
                              <td><?php echo $row['username']?></td>
                          
                              <td class='edit'><a href='update-post.php?id=<?php echo $row['post_id'];?>'><i class='fa fa-edit'></i></a></td>
                              <td class='delete'><a href='delete-post.php?id=<?php echo $row['post_id'];?>&cid=<?php echo $row['category_id'];?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                       <?php
                         $count++;
                         }
                      
                        ?>
                      </tbody>
                  </table>
                  <?php } 
                          $sql1="select * from post";
                          $result1 = mysqli_query($conn, $sql1);
                          $total_records=mysqli_num_rows($result1);
                        
                        $total_pages=ceil($total_records/$limit);
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){
                            echo "<li><a href='post.php?page=" . ($page - 1) . "'>Prev</a></li>";
                        }
                        for ($i = 1; $i <= $total_pages; $i++) { 
                            $active = ($i == $page) ? "active" : "";
                            echo "<li class='" . $active . "'><a href='post.php?page=" . $i . "'>" . $i . "</a></li>";
                        }
                        if($total_pages > $page){
                            echo "<li><a href='post.php?page=" . ($page + 1) . "'>Next</a></li>";
                        }
                        echo '</ul>';
                      ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
