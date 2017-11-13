<!DOCTYPE HTML>

<?php
require_once '../php/phpHeader.php';
$header = new PhpHeader();

require_once '../php/accountInfo.php';
require_once '../php/headerButtons.php';
require_once '../php/edit.php';

$edit = new Edit();
$edit->CheckPermissions();
?>

<html lang="pl">
<head>
    <meta charset = "utf-8" />
    <meta name = "viewport" content="width=device-width">
    <title>Fiszki</title>
    <meta name = "description" content = "" /> <!-- add some description -->
    <meta name = "keywords" content = "" />
    <meta name = "author" content = "Mateusz Śliwakowski">
    <link href = "../css/style.css" rel = "stylesheet" type = "text/css">
    <link href = "../css/diki.css" rel = "stylesheet" type = "text/css">

    <script src = "../js/wordController.js"></script>
    <script src = "../js/dikiSearchController.js"></script>
    <script src = "../js/editButtonsController.js"></script>
</head>

<body>
<header>
    <div class="container">
        <div id="searchbar">
            <a href = "../index.php"><img class="logo" src="../img/transp.png" width = "36" height="36"></a>
            <form method = "get" action = "../wyszukiwarka/index.php">
                <input id="search" placeholder="Szukaj fiszek..." type ="text" name = "q">
                <input id="icon" type ="image" src="../img/transp.png" width="32" height = "32">
            </form>
        </div>

        <?php
        DisplayHeaderButtons("dodaj");
        DisplayAccountInfo();
        ?>
    </div>
</header>

<div id = "modal_fade_id" class = "modal_fade">
    <div class = "delete_card">
        <h2>Czy na pewno chcesz usunąć listę?</h2>
        <hr>
        <a href = "../usun/index.php?q=<?php echo $edit->listProps->id; ?>"><button id = "delete_button_left">Tak</button></a>
        <button id = "delete_button_right" onclick = "PopupRefuse()">Nie</button>
    </div>
</div>

<section class = "vertical-expand">
    <div class = "edit_container">
        <?php
            if($edit->otherError)
            {
                ?>
                <div class = "error_card">
                    <h2>Coś poszło nie tak...</h2>
                    <hr>
                    <span>Wystąpił nieznany błąd.</span>
                </div>
                <?php
            }
            else if ($edit->noGetError)
            {
                ?>
                <div class = "error_card">
                    <h2>Coś poszło nie tak...</h2>
                    <hr>
                    <span>Błędny adres URL.</span>
                </div>
                <?php
            }
            else if ($edit->permissionError)
            {
                ?>
                <div class = "error_card">
                    <h2>Coś poszło nie tak...</h2>
                    <hr>
                    <span>Nie masz uprawnień do edycji tej listy.</span>
                </div>
                <?php
            }
            else
            {
                //no errors
                ?>
                <div class = "left_container">
                    <div class = "edit_card">
                        <h2><?php echo $edit->listProps->name?></h2>
                        <hr>
                        <?php
                            $edit->LoadCards();
                        ?>
                    </div>
                </div>

                <div class = "diki_container">
                    <div class = "diki">
                        <input type = "text" onkeypress="return EnterSearch(event);" id = "dikiSearch" placeholder = "Szukaj w słowniku...">
                        <input onclick = "DikiSearch()" id="dikiIcon" type ="image" src="../img/transp.png" width="32" height = "32">
                        <hr>
                        <div id = "dikiContent"> </div>
                    </div>

                    <div class = "buttons_container">
                        <div class = "button_edit">
                            <a href = "../przegladaj/index.php"><button class = "edit_button">Zapisz</button></a>
                        </div>
                        <div class = "button_edit">
                            <button class = "edit_button" onclick = "PopupDelete()">Usuń</button>
                        </div>
                        <div class = "button_edit">
                            <a href = "../test/quick.php?id=<?php echo $edit->listProps->id;?>"><button class = "edit_button">Szybki test</button></a>
                        </div>
                    </div>
                </div>
                <?php
            }
        ?>

        <div id = "dropdown-content">
            <a href = "../profil/index.php">Profil</a>
            <hr>
            <a href = "../php/logout.php">Wyloguj</a>
        </div>
    </div>
</section>

<footer>
    <div class = "container">
        <p> Fiszki by Mateusz Śliwakowski, Copyright &copy; 2017</p>
        <nav>
            <ul>
                <li> <a href = "../kontakt/index.php">Kontakt</a></li>
                <li> <a href = "../pomoc/index.php">Pomoc</a></li>
            </ul>
        </nav>
    </div>
</footer>
</body>
<script src = "../js/dropdownController.js"></script>
</html>
