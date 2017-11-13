<?php
session_start();
require_once 'editTokens.php';
require_once 'headerButtons.php';
require_once 'accountInfo.php';

class PhpHeader
{
    public $editTokens;

    public function __construct()
    {
        $this->editTokens = new EditTokens();

        if(!isset($_SESSION["login_id"]))
            $_SESSION["login_id"] = 0;
    }
}
