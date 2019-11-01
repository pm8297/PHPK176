<?php
session_start();
if(isset($_SESSION['mail']) && isset($_SESSION['pass'])){
    session_destroy();
}
header('location: index.php');
?>