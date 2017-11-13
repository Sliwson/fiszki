<?php
    session_start();

    require_once 'database.php';
    require_once 'hashing.php';

    $badData = 0;
    $not_confirmed = 0;

    function TestInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function HandleLogin()
    {
        global $badData, $not_confirmed;
        $badData = 0;
        $not_confirmed = 0;

        $_SESSION["prev_login"] = $login = TestInput($_POST["login"]);
        $password = TestInput($_POST["pass"]);

        if($login == "" || $login == null || $password == "" || $password == null)
        {
            $badData = 1;
        }
        else
        {
            $result = preg_match("/[a-zA-Z0-9]{1,32}/", $login);
            if($result == 0)
            {
                $badData = 1;
            }
            else
            {
                //get login id
                $sql = "SELECT `Id`, `Password`, `Confirmed` FROM `Accounts` WHERE `Login`='".$login."';";
                $result = Query($sql);

                if($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();

                    $id = $row["Id"];
                    $databasePass = $row["Password"];
                    $confirmed = $row["Confirmed"];

                    $result = ComparePasswords($password, $databasePass);

                    if($result == 1)
                    {
                        if($confirmed == 0)
                        {
                            $not_confirmed = 1;
                        }
                        else
                        {
                            //ok, set session variables
                            $_SESSION["login_id"] = $id;
                            $_SESSION["username"] = $login;

                            unset($_SESSION["prev_login"]);

                            header("Location: ../home/index.php");
                        }
                    }
                    else
                    {
                        $badData = 1;
                    }
                }
                else
                {
                    $badData = 1;
                }
            }
        }
    }
?>