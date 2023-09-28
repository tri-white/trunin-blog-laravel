<?php

class User{
    public function get_data($userid){
        $DB=new Database();
        $query = "SELECT * FROM users WHERE userid='$userid' limit 1";
        $res = $DB->read($query);
        if(!$res){
            return false;
        }
        return $res[0];
    }
    public function change_image($userid, $imagepath){
        $query = "UPDATE users SET photo = '$imagepath' where userid = '$userid'";
        $DB = new Database();
        $res = $DB->write($query);
        if($res==false){
            return false;
        }
        else{
            return true;
        }
    }
    public function get_posts($userid, $offset){
        $query = "select * from post where userid = $userid order by date DESC";
        $DB = new Database();
        $res = $DB->read($query);
        if(empty($res)){
            return false;
        }
        return $res;
    }
}