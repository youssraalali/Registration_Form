<?php

class User{
    private $username;
    private $email;
    private $password;
    private $repassword;

    public function __construct($username, $email, $password, $repassword)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->repassword = $repassword;
    }

    public function changePass($pass)
    {
        $this->password = sha1($pass);
    }
    public function validEmail()
    {
        $emailError = "Invalid Email Format";
        $entered_email = $this->email;
        if (filter_var($entered_email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE)) {
            return true;
        } else {
            //authentication failed
            return $emailError;
        }
    }

    public function validPass()
    {

        //password criteria
        $pass = $this->password;
        $minLength = 8;
        $requiresUpper = true;
        $requiresNumber = true;
        $requiresSpecialChar = true;

        $error = [];
        //check the pass length
        if (strlen($pass) < $minLength) {
            $error[] = "Password should be at least $minLength characters long";
        }
        //check the required upperCase letter
        if ($requiresUpper && !preg_match('/[A-Z]/', $pass)) {
            $error[] = "Password should contain at least 1 uppercase letter";
        }
        //check the required number
        if ($requiresNumber && !preg_match('/\d/', $pass)) {
            $error[] = "Password should contain at least 1 number";
        }
        //check the required special char
        if ($requiresSpecialChar && !preg_match('/[^a-zA-Z0-9\s]/', $pass)) {
            $error[] = "Password should contain at least 1 special character";
        }
        return $error;
    }

    public function identicalPass()
    {
        $pass = $this->password;
        $repass = $this->repassword;
        $error = "";

        if ($pass !== $repass) {
            $error = "Passwords do not match";
        }
        return $error;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function existEmail($fileName, $searchEmail){
        $error = '';
        $handle = fopen($fileName, "r");
        while($line = fgets($handle)){
            $found = strstr($line, $searchEmail);
            if ($found) {
                $error = 'This email address is already in use';
            }
        }
        fclose($handle);
        return $error;
    }
}
class Old extends User {
    public $email;
    public $password;

    public function __construct($email, $password){
        $this->email = $email;
        $this->password = $password;
    }

    public function validEmail()
    {
        $emailError = "Invalid Email Format";
        $entered_email = $this->email;
        if (filter_var($entered_email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE)) {
            return true;
        } else {
            //authentication failed
            return $emailError;
        }
    }


    function isUserExist($fileName, $searchEmail, $searchPass) {
        $error = '';
        $handle = fopen($fileName, "r");
        while (($line = fgets($handle)) !== false) {
            $emailPosition = strpos($line, $searchEmail);
            $passPosition = strpos($line, $searchPass);
            if ($emailPosition !== false && $passPosition !== false && $emailPosition < $passPosition) {
                return $error;
            }
        }
        fclose($handle);
        return $error = "There was a problem logging in. Check your email and password";
    }


}

