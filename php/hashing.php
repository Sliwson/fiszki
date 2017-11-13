<?php
    //use this function to crypt passwords during user's registration. Each hash is 256 digits long. 
    //$rawPass is password in plain text. Returns hashed password, ready to be put in database.
    function HashPassword($rawPass)
    {
        $salt = mcrypt_create_iv(32);
        $hashedSalt = hash("sha512", $salt);
        $passToHash = $rawPass.$hashedSalt;
        $hashedPass = hash("sha512", $passToHash);
        return $hashedPass.$hashedSalt;
    }
    
    //use this function during login check. $userPass is submitted password in plain text, $databasePass is 256 digits long password from database.
    //returns 1 when passwords matches, 0 when not.
    function ComparePasswords($userPass, $databasePass)
    {
        $hashedSalt = substr($databasePass, -128);
        $hashedPass = substr($databasePass, 0, 128);
        $passToHash = $userPass.$hashedSalt;
        $hashedUserPass = hash("sha512", $passToHash);
        if($hashedUserPass == $hashedPass) return 1;
        else return 0;       
    }
?>