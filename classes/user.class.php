<?php

require_once './classes/Misc.class.php';

class User extends Misc 
{


    public function validateMail($mail)
    {
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            return true;
        }else{
            return false;
        }

    }
    private function checkMailFree($mail)
    {
        $result = $this->_db->simpleSelect("users", "email", array("email", "=", $mail));
        
        return ($this->_db->haveRows($result) == true) ? false : true;  
    }

    private function checkPwd($user, $pwd)
    {
        $result = $this->_db->simpleSelect("users", "`username`, `password`", array("username` = '".$user."' AND `password", "=", $this->hashPwd($pwd)));
        return $this->_db->haveRows($result);
    }

    private function checkUsername($user)
    {

        $result = $this->_db->simpleSelect("users", "username", array("username", "=", $user));

        return ($this->_db->haveRows($result) == true) ? false : true; 
    }



    public function hashPwd($pwd)
    {
        $newPassword = md5(sha1($pwd."9iu".crc32($pwd))."10u3jhkl");
        return $newPassword;
    }

    public function getCurrentUser()
    {
        if(isset($_COOKIE['userLogged'])){
            $user_array = json_decode(urldecode($_COOKIE['userLogged']));
            if(isset($user_array->id)){
                return $user_array->id;
            }
        }else{
                return false;
        }   
    }
    public function getUserData($userid)
    {

        $sql = sprintf("SELECT U.* FROM users U
        WHERE U.id = '%s' ", $userid);
        $result = $this->_db->raw->query($sql); 
        if($row = $result->fetch_assoc()){
        $userData = array(
            "id" => $row['id'],
            "username" => $row['username'],
            "fullname" => $row['fullname'],
            "email" => $row['email'],
            "rank" => $row['rank'],
            "last_ip" => $row['last_ip'],
            "password" => $row['password'],
            );
            return $userData;
        }else{
            return $this->_db->raw->error;
        }
    }
    
    public function isAdmin($userid = NULL)
    {
        if($userid == NULL)
            $userid = $this->getCurrentUser();

        if($userid){

            if($this->getRank($userid) > 0){
                return true;
            }else{
                return false;
            }
        }
    }


    private function getRank($userid = NULL){
        if($userid == NULL)
            $userid = $this->getCurrentUser();

        $result = $this->_db->simpleSelect("users", "rank", array("id", "=", $userid));
        if($row = $result->fetch_assoc()){
            return $row['rank'];
        }else{
            die("User doesn't exist!");
        }       
    }

    private function getFullname($userid = NULL){
        if($userid == NULL)
            $userid = $this->getCurrentUser();

        $result = $this->_db->simpleSelect("users", "fullname", array("id", "=", $userid));
        if($row = $result->fetch_assoc()){
            return $row['fullname'];
        }else{
            die("User doesn't exist!");
        }       
    }
    private function getUserId($username)
    {
        $result = $this->_db->simpleSelect("users", "id", array("username", "=", $username));

        if($row = $result->fetch_assoc()){
            return $row['id'];
        }else{
            die("User doesn't exist!");
        }
    }

    public function isLogged()
    {
        if(isset($_COOKIE['userLogged'])){
            $user_array = json_decode(urldecode($_COOKIE['userLogged']));
            if(isset($user_array->username)){
                return true;
            }
        }else{
            return false;
        }
    }

    public function isExist($userid = NULL)
    {

        if($userid == NULL)
            $userid = $this->getCurrentUser();
        if($userid == 0)
            return true;

        return true;
    }
    public function remove($id_user)
    {

        $where_array = array("id", "=", $id_user);
        if($this->_db->deleteToDB("users", $where_array)){
            // User deleted sucefully ! 
            return true;
        }else{
            // Error
            die("Error deleting the user!");
        }

    }
    public function login($user, $pwd)
    {
        if(!$this->isLogged()){

            if($this->checkPwd($user, $pwd)){

                $login_array = array(
                    "id" => $this->getUserId($user),
                    "username" => $user,
                    "fullname" => $this->getFullname($this->getUserId($user)),
                    "pwd" => $this->hashPwd($pwd),
                    "rank" => $this->getRank($this->getUserId($user)) 
                );

                $login_array = urlencode(json_encode($login_array));
                $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
                setcookie("userLogged", $login_array, time()+72000, '/', $domain, false);
                return $login_array;
                
            }else{
                die("Wrong user/password combination !");
            }
        }else{
            die("You are already logged !! Please log out for login again");
        }
    }

    public function editUser($id, $username, $pwd, $fullname, $email, $rank)
    {
        # code...
    }
    public function logout($id = NULL)
    {
                $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
                setcookie("userLogged", "x", time()-3600, '/', $domain, false);
    }

    public function register($username, $pwd, $email, $fullname, $rank = 0)
    {
        if($this->checkMailFree($email))
        {
            if($this->validateMail($email)){

                if($this->checkUsername($username)){
                    $array_values = array(
                        "username" => $username,
                        "email" => $email,
                        "fullname" => $fullname,
                        "rank" => $rank,
                        "password" => $this->hashPwd($pwd),
                        "last_ip" => $_SERVER['REMOTE_ADDR'],
                    );
                    if($id_reg = $this->_db->insertToDB("users", $array_values)){
                        return $id_reg;
                    }else{
                        return false;
                        die("Error!");
                    }


                }else{
                    die("Username already used!");
                }
            }else{
                die("Invalid Email");
            }
        }else{
            die("Email already used!");
        }
    }
}