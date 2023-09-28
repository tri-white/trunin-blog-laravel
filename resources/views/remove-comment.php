<?php
session_start();
include("classes/connect.php");
$commid= $_GET['commid'];

$query = "DELETE FROM comment where commid = '$commid'";
$db = new Database();
$res = $db->write($query);

header("Location:index.php");
die;
?>