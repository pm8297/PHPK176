<?php  
    session_start();  
    if(isset($_SESSION['mail']) && isset($_SESSION['pass'])){
    define('SECURITY',true);
    include_once('../config/connect.php');
    $cat_id = $_GET['cat_id'];
    $sql = "DELETE FROM category WHERE cat_id=$cat_id";
    $query = mysqli_query($conn,$sql); 
    header('location: index.php?page_layout=category');
}else{
header('location: index.php');
}
?>