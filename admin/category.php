<?php include "header.php";

if($_SESSION['user_role']=='0'){
    header("Location: {$hostname}/admin/post.php");
}
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </thead>
                    <?php

                    require('config.php');

                    // $sql="SELECT * FROM category left JOIN 
                    // post ON category.post = post.post_id 
                    // WHERE category_id = 30";

                    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Provide a default value for $page
                    $limit = 5;
                    $offset = ($page - 1) * $limit; // Use $limit consistently

               

                    $sql = "SELECT c.category_id, c.category_name, COUNT(p.post_id) AS post_count FROM category c LEFT JOIN post p ON c.category_id = p.category GROUP BY c.category_id, c.category_name order by category_id desc  LIMIT $offset, $limit";
                    $result = mysqli_query($conn, $sql);
                    $count = $offset+1;
                    if(mysqli_num_rows($result)){
                        while ($row=mysqli_fetch_assoc($result)) {
                    ?>
                    <tbody>

                        <tr>
                            <td class='id'><?php echo $count; ?></td>
                            <td><?php echo $row['category_name']?></td>
                            <td><?php echo $row['post_count']?></td>
                            <td class='edit'><a href='update-category.php?id=<?php echo $row['category_id']?>'><i class='fa fa-edit'></i></a></td>
                            <td class='delete'><a href='delete-category.php?id=<?php echo $row['category_id']?>'><i class='fa fa-trash-o'></i></a></td>
                        </tr>
                       <?php
                       $count++;
                             }
                            }        
                       ?>
                    </tbody>
                </table>
                <?php
                $sql1="select * from category ";
                          $result1 = mysqli_query($conn, $sql1);
                          $total_records=mysqli_num_rows($result1);
                        
                        $total_pages=ceil($total_records/$limit);
                        echo "<ul class='pagination admin-pagination'>";
                        if($page > 1){
                            echo "<li><a href='category.php?page=" . ($page - 1) . "'>Prev</a></li>";
                        }
                        for ($i = 1; $i <= $total_pages; $i++) { 
                            $active = ($i == $page) ? "active" : "";
                            echo "<li class='" . $active . "'><a href='category.php?page=" . $i . "'>" . $i . "</a></li>";
                        }
                        if($total_pages > $page){
                            echo "<li><a href='category.php?page=" . ($page + 1) . "'>Next</a></li>";
                        }
                        echo '</ul>';
                          
                          ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
