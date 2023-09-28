<?php
session_start();
include("classes/connect.php");
$profileid= $_GET['profileid'];

$query = "DELETE FROM users where userid = '$profileid'";
$db = new Database();
$res = $db->write($query);

$query = "DELETE FROM post where userid = '$profileid'";
$db = new Database();
$res = $db->write($query);

$query = "DELETE FROM comment where userid = '$profileid'";
$db = new Database();
$res = $db->write($query);

$query = "DELETE FROM likes where userid = '$profileid'";
$db = new Database();
$res = $db->write($query);

header("Location: index.php");
die;
?>