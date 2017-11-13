<?php
require_once 'quickTest.php';

if(isset($_GET["id"]))
{
    $id = $_GET["id"];
    if(is_numeric($id))
    {
        $check = new QuickTest($id);
        if($check->GetPermission()) {
            //load word pairs and code as json
            $sql = "SELECT `English`, `Polish` FROM `Words` WHERE `List_id` = '" . $id . "';";
            $result = Query($sql);

            if ($result->num_rows > 0) {
                $array = $result->fetch_all();
                $to_return = json_encode($array);
                echo $to_return;
            } else echo "1";
        }
        else echo "0";
    }
    else echo "0";
}
else echo "0";