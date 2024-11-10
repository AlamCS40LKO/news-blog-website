<?php include "header.php"; 

require('config.php');


if(isset($_POST['submit'])){

    $cat_id = $_POST['cat_id'];
    $cat_name = $_POST['cat_name'];

$sql1 = "update category set category_name = '{$cat_name}' where category_id = {$cat_id}";

$result1 = mysqli_query($conn, $sql1) or die("Query Failed");

if($result1){
    header("Location: {$hostname}/admin/category.php");
}

}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="adin-heading"> Update Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                <?php
                 $cat_id = $_GET['id'];
                $sql = "select * from category where category_id = {$cat_id}";

                $result = mysqli_query($conn, $sql) or die("Query Failed");
                if (mysqli_num_rows($result)) {
                        while ($row=mysqli_fetch_assoc($result)) {
                
                ?>
                  <form action="<?php $_SERVER['PHP_SELF']?>" method ="POST">
                      <div class="form-group">
                          <input type="hidden" name="cat_id"  class="form-control" value="<?php echo $row['category_id']?>" placeholder="">
                      </div>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat_name" class="form-control" value="<?php echo $row['category_name']?>"  placeholder="" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>

                  <?php
                              
        }
    }
    
                  ?>
                </div>
              </div>
            </div>
          </div>
<?php include "footer.php"; ?>
