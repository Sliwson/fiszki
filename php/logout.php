<?php
    session_start();

    if(!isset($_SESSION["login_id"])) {
        $_SESSION["login_id"] = 0;
    }
    else {
        $_SESSION["login_id"] = 0;
    }
    header("Location:../index.php");
?>