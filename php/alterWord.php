<?php
require_once 'phpHeader.php';
$header = new PhpHeader();

require_once 'checkPermission.php';

if(isset($_GET["en"]) && isset($_GET["pl"]) && isset($_GET["list_id"]) && isset($_GET["word_id"]))
{
    $english = EscapeString(TestInput($_GET["en"]));
    $polish = EscapeString(TestInput($_GET["pl"]));
    $list_id = TestInput($_GET["list_id"]);
    $word_id = TestInput($_GET["word_id"]);

    if(strlen($english) <= 256 && strlen($polish) <= 256 && is_numeric($list_id) && is_numeric($word_id))
    {
        //check permissions
        if(CheckPermission($list_id))
        {
            //check if the word id matches list id
            $sql = "SELECT `List_id` FROM `Words` WHERE `Id` = '".$word_id."';";
            $result = Query($sql);

            if ($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                $list_id_db = $row["List_id"];

                if($list_id == $list_id_db)
                {
                    $sql = "UPDATE `Words` SET `English`='".$english."', `Polish` = '".$polish."' WHERE `Id` = '".$word_id."';";
                    Query($sql);
                    echo "1";
                }
                else echo "0";
            }
            else echo "0";
        }
        else echo "0";
    }
    else echo "0";
}
else echo "0";