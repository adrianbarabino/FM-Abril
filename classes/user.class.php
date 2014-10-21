<?php

require_once(__DIR__.'/Misc.class.php');

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

    public function getAll()
    {


        $result = $this->_db->advancedSelect("users U", array("U.*"));
        $allUsers = array();
        while ($row = $result->fetch_assoc()) {
        $userData = array(
            "id" => $row['id'],
            "username" => $row['username'],
            "fullname" => $row['fullname'],
            "email" => $row['email'],
            "rank" => $row['rank'],
            "last_ip" => $row['last_ip'],
            "password" => $row['password'],
            );     
            array_push($allUsers, $userData);
        }
        return $allUsers;

    }
    public function getUserData($userid)
    {

        $result = $this->_db->advancedSelect("users U", array("U.*"), array(array("U.id", "=", $userid)));

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

            if($this->getRank($userid) > 1){
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

    public function getFullname($userid = NULL){
        if($userid == NULL)
            $userid = $this->getCurrentUser();

        $result = $this->_db->simpleSelect("users", "fullname", array("id", "=", $userid));
        if($row = $result->fetch_assoc()){
            return $row['fullname'];
        }else{
            die("User doesn't exist!");
        }       
    }
    private function updateIp($userid = NULL, $last_ip = NULL)
    {

        if($userid == NULL)
            $userid = $this->getCurrentUser();

        if($last_ip == NULL)
            $last_ip = $_SERVER['REMOTE_ADDR'];



        $array_values = array(
            "last_ip" => $last_ip
            );

        $where_array = array("id", "=", $userid);
        if($this->_db->updateToDB("users", $array_values, $where_array)){
            // User update sucefully ! 
            return true;
        }else{
            // Error
            die("Error updating the Last IP!");
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

    public function isExist($userId)
    {

        $result = $this->_db->simpleSelect("users U", "U.id", array("id", "=", $userId));
        return $this->_db->haveRows($result);
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

                $login_array_cookie = urlencode(json_encode($login_array));
                $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
                setcookie("userLogged", $login_array_cookie, time()+72000, '/', $domain, false);
                $this->updateIp($login_array['id']);
                return $login_array;
                
            }else{
                return "ERROR: Wrong user/password combination !";
            }
        }else{
            return "ERROR: You are already logged !! Please log out for login again";
        }
    }

    public function editUser($id, $username, $email, $fullname, $rank, $last_ip = NULL, $password = NULL)
    {

        $id_user = intval($id);
        $userData = $this->getUserData($id_user);
        if($last_ip == NULL)
            $last_ip = $userData['last_ip'];

        if($password == NULL)
        {
            $password = $userData['password'];            
        }else{

            $password = $this->hashPwd($password);
        }


        $array_values = array(
            "id" => $id,
            "username" => $username,
            "email" => $email,
            "fullname" => $fullname,
            "rank" => $rank,
            "last_ip" => $last_ip,
            "password" => $password
            );

        $where_array = array("id", "=", $id);
        if($this->_db->updateToDB("users", $array_values, $where_array)){
            // User update sucefully ! 
            return true;
        }else{
            // Error
            die("Error updating the User!");
        }
    }
    public function logout($id = NULL)
    {
                $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
                setcookie("userLogged", "x", time()-3600, '/', $domain, false);
    }

    public function register($username, $pwd, $email, $fullname, $rank = 0, $login = false)
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
                        
                        if($login){
                            $this->login($username, $password);
                        }
                        return $id_reg;

                    }else{
                        return false;
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