<?php
require_once 'phpHeader.php';
$header = new PhpHeader();

require_once 'checkPermission.php';
require_once 'database.php';

function DeletePermanent($list_id)
{
    if(is_numeric($list_id))
    {
        if(CheckPermission($list_id))
        {
            //ok, delete list
            $sql = "DELETE FROM `Lists` WHERE `Id` = '".$list_id."';";

            if(Query($sql))
            {
                //remove all occurences

                $sql = "DELETE FROM `Words` WHERE `List_id` = '".$list_id."';";
                Query($sql);

                $sql = "DELETE FROM `Recommended` WHERE `List_id` = '".$list_id."';";
                Query($sql);

                $sql = "DELETE FROM `Last_by_token` WHERE `List_id` = '".$list_id."';";
                Query($sql);

                $sql = "DELETE FROM `Last_by_id` WHERE `List_id` = '".$list_id."';";
                Query($sql);
            }
            else return 1;
        }
        else return 1;
    }
    else return 1;
}