<?php

require('config.php');

if(empty($_FILES['new-image']['name'])){
    $target=$_POST['old-image'];
}else {
    $errors = array();

    $file_name = $_FILES['new-image']['name'];
    $file_size = $_FILES['new-image']['size'];
    $file_tmp = $_FILES['new-image']['tmp_name'];
    $file_type = $_FILES['new-image']['type'];
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

$post_id = (int)$_POST["post_id"]; // Cast to int to ensure it's an integer
$post_title = mysqli_real_escape_string($conn, $_POST["post_title"]);
$postdesc = mysqli_real_escape_string($conn, $_POST["postdesc"]);
$category = (int)$_POST["category"]; 
// echo $_POST["post_id"];
$sql = "update post set title='{$post_title}', description='{$postdesc}',
        category={$category}, post_img= '{$image_name}' where post_id = {$post_id}";
        $sql.="update category set post=post+1 where category_id = {$category}";
        
header("Location: {$hostname}/admin/post.php");

?>