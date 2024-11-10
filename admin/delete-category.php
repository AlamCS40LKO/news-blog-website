<?php

require('config.php');
$cat_id=$_GET['id'];
$sql = "Delete from category where category_id = {$cat_id}";
$result=mysqli_query($conn,$sql) and header("Location: {$hostname}/admin/category.php");




?>