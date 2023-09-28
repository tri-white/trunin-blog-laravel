<?php 
session_start();
include("classes/post_like.php");
include("classes/connect.php");

    if(isset($_SESSION['myblog_userid'])){
            $liker = new Like();
            $userid2= $_GET['userid'];
            $postid2=$_GET['postid'];
            $res = $liker->change_like($userid2,$postid2);

            $query = "UPDATE post set likes = (SELECT COUNT(*) from likes where postid='$postid2') where postid = '$postid2'";
            $db = new Database();
            $res = $db->write($query);
    }
    else{
        header("Location:login.php");
        die;
    }

    
    header("Location: post-card_details.php?postid=".$postid2);
    die;
?>