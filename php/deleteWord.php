<?php
    require_once 'phpHeader.php';
    $header = new PhpHeader();

require_once 'checkPermission.php';

if(isset($_GET["word_id"])  && isset($_GET["list_id"]))
{
    $word_id = TestInput($_GET["word_id"]);
    $list_id = TestInput($_GET["list_id"]);

    if(is_numeric($word_id) && is_numeric($list_id))
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
                    $sql = "DELETE FROM `Words` WHERE `Id` = '".$word_id."';";
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
