<?php
session_start();
include("classes/connect.php");
$postid= $_GET['postid'];

$query = "DELETE FROM post where postid = '$postid'";
$db = new Database();
$res = $db->write($query);

$query = "DELETE FROM comment where postid = '$postid'";
$db = new Database();
$res = $db->write($query);

$query = "DELETE FROM likes where postid = '$postid'";
$db = new Database();
$res = $db->write($query);

header("Location:index.php");
die;
?>