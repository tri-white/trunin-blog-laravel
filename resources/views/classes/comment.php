<?php
class Comment {
    private $error = "";
    public function get_data($commid){
        $DB=new Database();
        $query = "SELECT * FROM comment WHERE commid='$commid' limit 1";
        $res = $DB->read($query);
        if(!$res){
            return false;
        }
        return $res[0];
    }
    public function create_comment($userid, $data){
        if(empty($data['description'])){
            $this->error .= "Не вдалося додати пустий комментар!<br>";
            return $this->error;
        }
        $description= addslashes($data['description']);

        $commid= $this->create_commid();
        while (!$this->check_commid($commid)){
            $commid = $this->create_commid();
        }

        $likes = 0;
        $postid = $data['post_id'];
        $query = 
        "insert into comment 
        (commid, postid, userid, description, likes) 
        values ('$commid', '$postid', '$userid','$description', '$likes'); ";
        
        $DB = new Database();
        $res = $DB->write($query);

        if($res){
        }
        else{
            $this->error .= "Не вдалося додати комментар. <br>";
            return  $this->error;
        }
    
    }

    public function create_commid(){
        $length=19;
        $id = "";
        for($i=0;$i<$length;$i++){
            $id .= rand(0,9);
        }
        return $id;
    }
    public function check_commid($commid){
        $check = "select * from comment where commid = '$commid'";
        $DB = new Database();
        $res = $DB->read($check);
        if(!is_bool($res)){
            return false;
        }
        return true;
    }

    public function get_comments($postid){

            $query = "select * from comment where postid ='$postid' limit 2";

        $DB = new Database();
        $res = $DB->read($query);
        if(!$res){
            return false;
        }
        return $res;
    }
    public function get_comments_nolimit($postid){

        $query = "select * from comment where postid ='$postid'";

    $DB = new Database();
    $res = $DB->read($query);
    if(!$res){
        return false;
    }
    return $res;
}
}