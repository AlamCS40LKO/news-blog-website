<?php

require('config.php');

$user_id = $_GET['id'];

$sql = "Delete from user where user_id = '{$user_id}'";

if(mysqli_query($conn, $sql)){
    header("Location: {$hostname}/admin/users.php");

}

mysqli_connect($conn);
?>

