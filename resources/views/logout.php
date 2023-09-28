<?php 
session_start();
unset($_SESSION['myblog_userid']); 
header("Location: login.php");
die;
?>
