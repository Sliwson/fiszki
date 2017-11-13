<?php
    require_once '../PHPMailer_5.2.0/class.phpmailer.php';

    function SendEmail($address, $subject, $msg)
    {
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
            
        $mail->setFrom("admin@fiszka.ct8.pl", "Mateusz Śliwakowski");
        $mail->addAddress($address);
            
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->IsHTML(true);
            
        $ret = $mail->Send();            
    }
?>