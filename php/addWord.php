<?php
require_once 'phpHeader.php';
$header = new PhpHeader();

require_once 'checkPermission.php';

if(isset($_GET["en"]) && isset($_GET["pl"]) && isset($_GET["list_id"]))
{
    $english = EscapeString(TestInput($_GET["en"]));
    $polish = EscapeString(TestInput($_GET["pl"]));
    $list_id = TestInput($_GET["list_id"]);

    if(strlen($english) <= 256 && strlen($polish) <= 256 && is_numeric($list_id))
    {
        //check permissions
        if(CheckPermission($list_id))
        {
            $sql = "INSERT INTO `Words` VALUES ('','".$english."','".$polish."','".$list_id."');";
            $id = QueryReturnId($sql);
            echo $id;
        }
        else echo "0";
    }
    else echo "0";
}
else echo "0";