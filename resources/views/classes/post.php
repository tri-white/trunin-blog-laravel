<?php
class Post {
    private $error = "";
    public function get_categories(){
        $DB= new Database();
        $query = "SHOW COLUMNS FROM post WHERE Field = 'category'";
        $res = $DB->read($query);
        $enum = $res[0]['Type'];
        preg_match("/^enum\(\'(.*)\'\)$/", $enum, $matches);
        $res = explode("','", $matches[1]);
        return $res;
    }
    public function get_data($postid){
        $DB=new Database();
        $query = "SELECT * FROM post WHERE postid='$postid' limit 1";
        $res = $DB->read($query);
        if(!$res){
            return false;
        }
        return $res[0];
    }
    public function create_post($data, $userid, $files){
        if(empty($data['post-description']) && empty($files['file']['name'])){
            $this->error .= "Не вдалося додати пост без контенту!<br>";
            return $this->error;
        }

        if(!empty($files['post-image']['name'])){
            $folder = "uploads/".$userid."/";
            if(!file_exists($folder)){
                mkdir($folder,0777,true);
            }
            $img_class = new Image();
            $filename = $folder.$img_class->generate_filename(15).".jpg";
            move_uploaded_file($files['post-image']['tmp_name'],$filename);
            $photo = $filename;
        }
        else{
            $photo = "";
        }
        $description= addslashes($data['post-description']);
        $category = $data['post-category'];

        preg_match_all('/#(\w+)/', $description, $matches);
        $tags = implode(' ', $matches[1]);

        $postid= $this->create_postid();
        while (!$this->check_postid($postid)){
            $postid = $this->create_postid();
        }

        $query = 
        "insert into post 
        (postid, userid, description, photo, category, tags) 
        values ('$postid', '$userid','$description', '$photo', '$category','$tags'); ";
        
        $DB = new Database();
        $res = $DB->write($query);

        if($res){
        }
        else{
            $this->error .= "Не вдалося додати пост. <br>";
            return  $this->error;
        }
    
    }

    public function create_postid(){
        $length=19;
        $id = "";
        for($i=0;$i<$length;$i++){
            $id .= rand(0,9);
        }
        return $id;
    }
    public function check_postid($postid){
        $check = "select * from post where postid = '$postid'";
        $DB = new Database();
        $res = $DB->read($check);
        if(!is_bool($res)){
            return false;
        }
        return true;
    }

    public function get_posts($key, $cat, $sort){
        if($sort == "like-desc"||$sort=="date-desc"||$sort=="comm-desc"){
            $direction = 'DESC';
        }
        else{
            $direction = 'ASC';
        }

        if($sort=="like-desc" || $sort=="like-asc"){
            $field = "likes";
        }
        else if($sort=="date-desc" || $sort=="date-asc"){
            $field="date";
        }
        else{
            $field="comments";
        }

        if($cat == "all"){
            $query = "select * from post where description LIKE '%$key%' order by $field $direction";
        }
        else if($cat == "no"){
            $query = "select * from post where description LIKE '%$key%' and category ='' order by $field $direction";
        }
        else{
            $query = "select * from post where description LIKE '%$key%' and category = '$cat' order by $field $direction";
        }

        $DB = new Database();
        $res = $DB->read($query);
        if(!$res){
            return false;
        }
        return $res;
    }
}