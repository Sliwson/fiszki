<?php
    require_once '../php/phpHeader.php';
    $header = new PhpHeader();

    require_once 'database.php';

    $nameUsed = false;
    $badFormat = false;
    $tooLong = false;
    $notLogged = false;

    function TestInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function HandleUpdate()
    {
        global $nameUsed, $badFormat, $tooLong, $notLogged, $header;

        $nameUsed = false;
        $badFormat = false;
        $tooLong = false;
        $notLogged = false;

        $name = EscapeString((TestInput($_POST["name"])));
        $type = TestInput($_POST["listType"]);

        if($name == "" || $name == null || $type == null)
        {
            $badFormat = true;
        }
        else
        {
            if(strlen($name) > 64)
            {
                $tooLong = true;
            }
            else {
                $result = 1;
                if ($result == 0)
                {
                    $badFormat = true;
                }
                else
                {
                    //input validated
                    if($type == "private")
                    {
                        if($_SESSION["login_id"] == 0)
                        {
                            $notLogged = true;
                        }
                        else
                        {
                            $sql = "SELECT `Id` FROM `Lists` WHERE `Name` = '".$name."' AND `OwnerId` = '".$_SESSION["login_id"]."';";
                            $result = Query($sql);

                            if($result->num_rows > 0)
                            {
                                $nameUsed = true;
                            }
                            else
                            {
                                //add and move to edition
                                $sql = "INSERT INTO `Lists` VALUES ('','".$name."','0','".$_SESSION["login_id"]."','".$header->editTokens->editToken."');";
                                Query($sql);

                                $sql = "SELECT `Id` FROM `Lists` WHERE `Name` = '".$name."' AND `Public` = '0' AND `OwnerId` = '".$_SESSION["login_id"]."';";
                                $result = Query($sql);

                                $id = 0;
                                if($result->num_rows > 0)
                                {
                                    $row = $result->fetch_assoc();
                                    $id = $row["Id"];
                                }

                                header("Location: ../edycja/index.php?list_id=".$id);
                            }
                        }
                    }
                    else if ($type == "public")
                    {
                        $sql = "SELECT `Id` FROM `Lists` WHERE `Name` = '".$name."' AND `OwnerId` = '0';";
                        $result = Query($sql);

                        if($result->num_rows > 0)
                        {
                            $nameUsed = true;
                        }

                        if($_SESSION["login_id"] > 0) {
                            $sql = "SELECT `Id` FROM `Lists` WHERE `Name` = '" . $name . "' AND `OwnerId` = '" . $_SESSION["login_id"] . "';";
                            $result = Query($sql);

                            if ($result->num_rows > 0) {
                                $nameUsed = true;
                            }
                        }

                        if($nameUsed == false)
                        {
                            //add and move to edition
                            $sql = "INSERT INTO `Lists` VALUES ('','".$name."','1','".$_SESSION["login_id"]."','".$header->editTokens->editToken."');";
                            Query($sql);

                            $sql = "SELECT `Id` FROM `Lists` WHERE `Name` = '".$name."' AND `Public` = '1' AND `OwnerId` = '".$_SESSION["login_id"]."';";
                            $result = Query($sql);

                            $id = 0;
                            if($result->num_rows > 0)
                            {
                                $row = $result->fetch_assoc();
                                $id = $row["Id"];
                            }
                            
                            header("Location: ../edycja/index.php?list_id=".$id);
                        }
                    }
                    else
                    {
                        $badFormat = true;
                    }
                }
            }
        }
    }
?>