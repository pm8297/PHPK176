<?php
session_start();
define('SECURITY',true);
include_once('../config/connect.php');
if(isset($_SESSION['mail']) && isset($_SESSION['pass'])){
    include_once('admin.php');
}else{
    include_once('login.php');
}
?>