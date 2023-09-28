<?php
class Like {
    public function change_like($userid, $postid){
        $res = $this->check_like($userid, $postid);
        if($res == false){
            $query = "insert into likes (userid,postid) values ('$userid','$postid')";
            $db = new Database();
            $res = $db->write($query);
            return $res;
        }
        else{
            $query = "delete from likes where userid='$userid' and postid='$postid'";
            $db = new Database();
            $res = $db->write($query);
            return $res;
        }
    }
    public function check_like($userid,$postid){
        $query = "select * from likes where userid='$userid' and postid='$postid'";
        $db = new Database();
        $res = $db->read($query);
        if(is_bool($res)){
            return false;
        }
        return true;
    }
    
}