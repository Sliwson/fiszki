<?php
    session_start();

    require_once 'database.php';
    require_once 'hashing.php';
    require_once 'mailer.php';

    class RegistrationErrors
    {
        public $pass_wrong = false;
        public $login_used = false;
        public $email_used = false;
        public $login_required = false;
        public $pass_required = false;
        public $pass_rep_required = false;
        public $email_required = false;
        public $login_pattern = false;
        public $email_pattern = false;
        public $pass_short = false;
        
        public function Reset()
        {
            $this->pass_wrong = false;
            $this->login_used = false;
            $this->email_used = false;
            $this->login_required = false;
            $this->pass_required = false;
            $this->pass_rep_required = false;
            $this->email_required = false;
            $this->login_pattern = false;
            $this->email_pattern = false;
            $this->pass_short = false;
        }
    }

    $regErrors = new RegistrationErrors();

    function TestInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function HandleRegistration() {
        global $regErrors;
        
        $regErrors->Reset();
        
        $_SESSION["prev_login"] = $login = TestInput($_POST["login"]);
        $password = TestInput($_POST["pass"]);
        $password_repeat = TestInput($_POST["pass_repeat"]);
        $_SESSION["prev_email"] = $email = TestInput($_POST["email"]);       
        
        //check if field are empty
        if($login == "" || $login == null) $regErrors->login_required = true;
        
        if($password == "" || $password == null) $regErrors->pass_required = true;
        
        if($password_repeat == "" || $password_repeat == null) $regErrors->pass_rep_required = true;
        
        if($email == "" || $email == null) $regErrors->email_required = true;
        
        
        if($regErrors->login_required == false && $regErrors->pass_required == false && $regErrors->pass_rep_required == false && $regErrors->email_required == false)
        {
            //check patterns
            $result = preg_match("/[a-zA-Z0-9]{1,32}/", $login);
            if($result == 0) $regErrors->login_pattern = true;
            else
            {
                //check login availible
                $sql = "SELECT `Id` FROM `Accounts` WHERE `Login`='" . $login . "';";
                $result = Query($sql);

                if ($result->num_rows > 0) {
                    $regErrors->login_used = true;
                }
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 64) {
                $regErrors->email_pattern = true;
            }
            else
            {
                //check email used
                $sql = "SELECT `Id` FROM `Accounts` WHERE `Email`='" . $email . "';";
                $result = Query($sql);

                if ($result->num_rows > 0) {
                    $regErrors->email_used = true;
                }
            }

            if($password != $password_repeat)
                $regErrors->pass_wrong = true;

            if(strlen($password) < 6 || strlen($password_repeat) < 6)
                $regErrors->pass_short = true;


            if($regErrors->login_pattern == false && $regErrors->email_pattern == false && $regErrors->pass_wrong == false && $regErrors->pass_short == false) {
                if ($regErrors->pass_wrong == false && $regErrors->login_used == false && $regErrors->email_used == false) {
                    //generate mail token
                    $unique = false;
                    while(!$unique) {
                        $token = mcrypt_create_iv(32);
                        $token = hash("md5", $token);

                        $sql = "SELECT `Id` FROM `Accounts` WHERE `Token`='".$token."';";
                        if(Query($sql)->num_rows == 0) $unique = true;
                    }

                    //insert data into database
                    $hashed_pass = HashPassword($password);
                    $sql = "INSERT INTO `Accounts` VALUES ('','" . $login . "','" . $hashed_pass . "','" . $email . "','img/test.png','false','" . $token . "');";
                    $result = Query($sql);

                    SendConfirmationEmail($email, $token);

                    header('Location: success.php');

                    //unset session variables
                    unset($_SESSION["prev_email"]);
                    unset($_SESSION["prev_login"]);
                }
            }
        }
    }

    function SendConfirmationEmail($address, $token)
    {
        $subject = "Fiszka - potwierdź adres email";
        
        $msg = "Witamy w portalu fiszka.ct8.pl! <br><br>".
               "Aby dokończyć proces rejestracji przejdź do strony: <br>".
               "https://fiszka.ct8.pl/rejestracja/confirm.php?token=".$token."<br><br>Pozdrawiam,<br>Mateusz Śliwakowski";
        SendEmail($address, $subject, $msg);
    }
?>