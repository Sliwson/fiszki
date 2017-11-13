<?php
    require_once 'database.php';
    
    //returns 0 when confirmation successful, 1 when failed, 2 when user was already confirmed

    function ConfirmUser($token)
    {
        $result = preg_match("/[a-zA-Z0-9]{32}/", $token);
        
        if($result == false) return 1;
        
        $sql = "Select `Id`, `Confirmed` FROM `Accounts` WHERE `Emailtoken` = '".$token."';";
        $result = Query($sql);
        
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $id = $row["Id"];
            $wasConfirmed = $row["Confirmed"];
            
            if($wasConfirmed == 1) return 2;
            
            $sql = "UPDATE `Accounts` SET `Confirmed`='1' WHERE `Id`='".$id."';";
            $result = Query($sql);
            if($result == 1) return 0;
            else return 1;
        }
        else
        {
            return 1;
        }
    }
?>