<?php 

require('config.php');

if(isset($_FILES['fileToUpload'])){
    $errors = array();

    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type = $_FILES['fileToUpload']['type'];
    $file_ext = strtolower(end(explode('.',$file_name)));
    $extensions = array("jpeg","jpg","png");

    if(in_array($file_ext,$extensions)===false){
        $errors[]="This file Extension not allowed, Please choose JPG or PNG file extension.";
    }

    if($file_size>2097152){
        $errors[]="File size must be 2MB or Less than.";
    }
    $new_name=time()."-".basename($file_name);
    $image_name = $new_name;
    $target = "upload/".$new_name;

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,$target);
    }else {
        print_r($errors);
        die;
    }
}

if(isset($_POST['submit'])){
    session_start();
    $title = mysqli_real_escape_string($conn, $_POST['post_title']);
    $desc =mysqli_real_escape_string($conn,  $_POST['postdesc']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $date = date("d M Y");
    $author=$_SESSION['user_id'];
    // $file = mysqli_real_escape_string($conn, $_POST['fileToUpload']);

    $sql = "insert into post(title, description, category, post_date, author, post_img) 
    value ('{$title}','{$desc}',{$category},'{$date}',{$author},'{$image_name}');";

    $sql.="update category set post=post+1 where category_id = {$category}";

    if(mysqli_multi_query($conn, $sql)){
        header("Location: {$hostname}/admin/post.php");

    }else{
        echo "<div class='alert alert-danger'>Query Failed.</div >";
    }
}



?>