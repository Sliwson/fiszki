<?php
require_once 'phpHeader.php';
$header = new PhpHeader();

class LastListsController
{
    public function AddNewRecord($list_id)
    {
        global $header;

        if($_SESSION["login_id"] > 0)
        {
            //use id's
            $user_id = $_SESSION["login_id"];

            //delete previous records
            $sql = "DELETE FROM `Last_by_id` WHERE `List_id` = '".$list_id."' AND `User_id` = '".$user_id."';";
            Query($sql);

            //insert new record on top
            $sql = "INSERT INTO `Last_by_id` VALUES ('', '".$list_id."', '".$user_id."');";
            Query($sql);
        }
        else
        {
            //use tokens
            $token = $header->editTokens->editToken;

            $sql = "DELETE FROM `Last_by_token` WHERE `List_id` = '".$list_id."' AND `Token` = '".$token."';";
            Query($sql);

            //insert new record on top
            $sql = "INSERT INTO `Last_by_token` VALUES ('', '".$list_id."', '".$token."');";
            Query($sql);
        }
    }

    public function GetLastListIds()
    {
        global $header;

        //get array count from database
        $sql = "SELECT `Value` FROM `Page_properties` WHERE `Name` = 'displayLastCount';";
        $result = Query($sql);

        $count = 4; //default count

        if($result->num_rows > 0)
        {
            $count = $result->fetch_assoc()["Value"];
        }

        $result;

        if($_SESSION["login_id"])
        {
            $id = $_SESSION["login_id"];
            $sql = "SELECT `List_id` FROM `Last_by_id` WHERE `User_id` = '".$id."';";
            $result = Query($sql);
        }
        else
        {
            $token = $header->editTokens->editToken;
            $sql = "SELECT `List_id` FROM `Last_by_token` WHERE `Token` = '" . $token . "';";
            $result = Query($sql);
        }

        $array_return = array();

        if($result->num_rows > $count)
        {
            $array = $result->fetch_all();
            for($i = 0, $c = $result->num_rows - 1; $i < $count; $i++, $c--)
            {
                $array_return[$i] = $array[$c][0];
            }
        }
        else if ($result->num_rows > 0)
        {
            $array = $result->fetch_all();
            for($i = 0, $c = $result->num_rows - 1; $i < $result->num_rows; $i++, $c--)
            {
                $array_return[$i] = $array[$c][0];
            }
        }
        else $array_return = null;

        return $array_return;
    }
}