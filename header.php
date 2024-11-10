<?php
// echo "<pre>";
// print_r( $_SERVER);
// echo "</pre>";

// give result = [PHP_SELF] => /php projects/news blog website/index.php

$page= basename( $_SERVER['PHP_SELF'] );
require('config.php');
switch($page){
    case "single.php":
        if(isset($_GET['id'])){
            $title = "select * from post where post_id = {$_GET['id']}";
            $title_result = mysqli_query($conn, $title);
            $row_title = mysqli_fetch_assoc($title_result);
            $page_title = $row_title['title'];
        }else {
            $page_title="Page Not Found";
        }
        break;
        case "category.php":
            if(isset($_GET['id'])){
                $title = "select * from category where category_id = {$_GET['id']}";
                $title_result = mysqli_query($conn, $title);
                $row_title = mysqli_fetch_assoc($title_result);
                $page_title = $row_title['category_name']." News";
            }else {
                $page_title="Page Not Found";
            }
            break;
            case "author.php":
                if(isset($_GET['aid'])){
                    $title = "select * from user where user_id = {$_GET['aid']}";
                    $title_result = mysqli_query($conn, $title);
                    $row_title = mysqli_fetch_assoc($title_result);
                    $page_title = $row_title['username'];
                }else {
                    $page_title="Page Not Found";
                }
                break;
                case "search.php":
                    if(isset($_GET['search']) or $_GET['']){
                      
                        $page_title = 'Search :-'.$_GET['search'];
                    }else {
                        $page_title="No Search Result Found";
                    }
                    break;
                    default:
                   $page_title ="News Home Page";
                    break;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
            <?php
                  include "config.php";

                  $sql = "SELECT * FROM settings";

                  $result = mysqli_query($conn, $sql) or die("Query Failed.");
                  if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)) {
                        if( $row['logo']==''){
                            echo '<a href="index.php"> <h1>'.$row[websitename].'</h1></a>';
                        }else {
                            echo '<a href="index.php" id="logo"><img src="admin/images/'.$row['logo'].'"></a>';
                        }
                ?>
                
                <?php
                }
            }
            ?>
            </div>
            <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                require('config.php');
                if(isset($_GET['id'])){
                $cat_id = $_GET['id'];
                }
                $sql = "select * from category where post>0" ;
                $result = mysqli_query($conn, $sql) or die("Category fetch Query Unsuccessfully!!!!!");
                if(mysqli_num_rows($result)>0){
                    $active = "";
                  ?>
                <ul class='menu'>
                <li><a href='<?php echo $hostname;?>'>Home</a></li>
                    <?php
                    while ($row=mysqli_fetch_assoc($result)) {    
                        if(isset($_GET['id'])){
                            $cat_id = $_GET['id'];
                            if($row['category_id']==$cat_id){
                                $active = "active";
                            }else {
                                $active = "";
                            }   
                            }
                                
                        
             echo"
                    <li><a class='$active' href='category.php?id={$row['category_id']}'>
                        {$row['category_name']}</a></li>
                ";

            }
            echo"
            <li><a href='{$hostname}/admin'>Login</a></li>
        ";
            echo "</ul>";
           
        }
        ?>
    </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->


