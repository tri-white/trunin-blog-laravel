<?php
class Signup{
    private $error ="";

    
    public function correct($data){
        $login = $data['login'];
        $pass1 = $data['password'];
        $pass2 = $data['password2'];
        $query = "SELECT login FROM users WHERE login = '$login'";
        $DB = new Database();
        $res = $DB->read($query);
        if(!empty($res)){
            $this->error.="Користувач з даним логіном вже існує!<br>";
            return false;
        }

        if($pass1 != $pass2){
            $this->error.="Паролі не співпадають!<br>";
            return false;
        }

        if(strlen($login)<8){
            $this->error.="Логін має бути довжиною щонайменше 8 символів!<br>";
            return false;
        }
        if(strpos($login, ' ')!=false)
        {
            $this->error.="Логін не може містити пропуски!<br>";
            return false;
        }
        return true;
    }
    public function evaluate($data){
        foreach($data as $key => $value){
            if(empty($value)){
                $this->error .= "поле ".$key ." пусте!<br>";
            }
        }

        if($this->error!=""){
            return $this->error;
        }

        $corr = $this->correct($data);
        if(!$corr){
            return $this->error;
        }
        
        $this->create_user($data);

        
    }
    public function create_userid(){
        $length=19;
        $id = "";
        for($i=0;$i<$length;$i++){
            $id .= rand(0,9);
        }
        return $id;
    }
    public function create_user($data){
        $login = $data['login'];
        $password = $data['password'];
        $userid = $this->create_userid();
        while (!$this->check_userid($userid)){
            $userid = $this->create_userid();
        }

        $query = "insert into users (userid, login, password) 
        values ('$userid', '$login', '$password')";
        $DB = new Database();
        $DB->write($query);
    }
    public function check_userid($userid){
        $check = "select * from users where userid = '$userid'";
        $DB = new Database();
        $res = $DB->read($check);
        if(!is_bool($res)){
            return false;
        }
        return true;
    }
    
}