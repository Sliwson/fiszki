<?php
require_once 'database.php';

class EditTokens
{
    public $editToken;

    function __construct(){
        if(!isset($_COOKIE{"editToken"}))
        {
            setcookie("editToken", $this->GenerateNewToken(32), strtotime( '+30 days' ));
            $this->editToken = $_COOKIE["editToken"];
        }
        else
        {
            $this->editToken = $_COOKIE["editToken"];
        }
    }

    function GenerateNewToken($length)
    {
        $good = false;

        $characters = array_merge(range('a', 'z'),range(0,9),range('A','Z'));
        $elements = count($characters);
        $token = "";

        while(!$good) {
            $token = "";
            for($i = 0; $i < $length; $i++)
            {
                $token .= $characters[mt_rand(0, $elements - 1)];
            }

            //search for repetitions in database
            $sql = "SELECT `Id` FROM `Edit_tokens` WHERE `Token` = '".$token."';";
            $result = Query($sql);

            if($result->num_rows > 0)
            {
                $good = false;
            }
            else
            {
                $good = true;
                $sql = "INSERT INTO `Edit_tokens` VALUES ('', '".$token."');";
                Query($sql);
            }
        }

        return $token;
    }
}