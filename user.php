<?php

class User
{
    private $errors = [];

    public function signup($POST) {
        foreach ($POST as $key => $value){
            if($key == "firstname"){
                if(htmlspecialchars(trim($value)) == ""){
                    $this->errors[] = "Please enter a valid Firstname";
                }elseif(strlen($value) == 1){
                    $this->errors[] = "Firstname must be more than one character";
                }elseif (!preg_match("/^[a-zA-Z-']*$/", $value)) {
                    $this->errors[] = "Only letters are allowed in Firstname";
                }
            }
            if($key == "lastname"){
                if(htmlspecialchars(trim($value)) == ""){
                    $this->errors[] = "Please enter a valid Lastname";
                }elseif(strlen($value) == 1){
                    $this->errors[] = "Lastname must be more than one character";
                }
                elseif(!preg_match("/^[a-zA-Z-']*$/", $value)) {
                    $this->errors[] = "Only letters are allowed in Lastname";
                }
            }
            if($key == "email"){
                if(htmlspecialchars(trim($value)) == ""){
                    $this->errors[] = "Please enter a valid Email";
                } elseif(!filter_var($value, FILTER_VALIDATE_EMAIL))  {
                    $this->errors[] = "Invalid Email Address";
                }
            }
            if($key == "phone"){
                if(htmlspecialchars(trim($value)) == ""){
                    $this->errors[] = "Please enter a valid Phone Number";
                }elseif(!preg_match('/^\d+$/', $value)){
                    $this->errors[] = "Only numbers are allowed in Phone";
                }
            }
            if($key == "password"){
                if(htmlspecialchars(trim($value)) == ""){
                    $this->errors[] = "Please enter a valid Password";
                }elseif(strlen($value) < 6 ){
                    $this->errors[] = "Password must be atleast 6 characters long";
                }
            }
        }

        $DB = new Database();
        // check if email already exists on the Database
        $data = [];
        $data['email'] = $POST['email'];
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $result = $DB->read($query,$data);
        if($result){
            $this->errors[] = "This email is already in use";
        }

        // check if phone number already exists on the Database
        $data = [];
        $data['phone'] = $POST['phone'];
        $query = "SELECT * FROM users WHERE phone = :phone LIMIT 1";
        $result = $DB->read($query,$data);
        if($result){
            $this->errors[] = "This Phone Number is already in use";
        }

            // save to database 
            if(count($this->errors) == 0){

                $query = "INSERT INTO users (firstname,lastname,email,phone,password,date) VALUES (:firstname,:lastname,:email,:phone,:password,:date)";
                
                $data = [];
                $data['firstname'] = $POST['firstname'];
                $data['lastname'] = $POST['lastname'];
                $data['email'] = $POST['email'];
                $data['phone'] = $POST['phone'];
                $data['password'] = $POST['password'];
                $data['date'] = date("Y-m-d H:i:s");

                $result = $DB->write($query,$data);
                if(!$result){
                    $this->errors[] = "Your data could not be saved!";
                }
            }
            return $this->errors;
    }


}