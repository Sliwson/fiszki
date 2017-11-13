<?php

require_once 'deletePermanent.php';
if(isset($_GET["q"])) {
    $id = TestInput($_GET["q"]);
    DeletePermanent($id);
}

header("Location: ../przegladaj/index.php");