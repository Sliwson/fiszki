<?php
require_once '../php/phpHeader.php';
$header = new PhpHeader();

require_once "../php/headerButtons.php";
require_once "../php/accountInfo.php";
require_once "../php/browse.php";

$browse = new Browse();
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
        DisplayHeaderButtons("przegladaj");
        DisplayAccountInfo();
        ?>
    </div>
</header>

<div id = "modal_fade_id" class = "modal_fade">
    <div class = "delete_card">
        <h2>Czy na pewno chcesz usunąć listę?</h2>
        <hr>
        <a id = "delete_id"><button id = "delete_button_left">Tak</button></a>
        <button id = "delete_button_right" onclick = "PopupRefuse()">Nie</button>
    </div>
</div>

<section class = "vertical-expand">
    <div class = "container">
        <div class = "half">
            <div class = "edit_card">
                <h2>Twoje listy</h2>
                <hr>
                <div class = "scroll">
                    <?php $browse->DisplayYourLists(); ?>
                </div>
            </div>
        </div>

        <div class = "half">
            <div class = "vertical_half">
                <div class = "edit_card">
                    <h2>Polecane</h2>
                    <hr>
                    <div class = "scroll">
                        <?php $browse->DisplayRecommenedLists(); ?>
                    </div>
                </div>
            </div>

            <div class = "vertical_half">
                <div class = "edit_card">
                    <h2>Ostatnio przeglądane</h2>
                    <hr>
                    <div class = "scroll">
                        <?php $browse->DisplayLastLists(); ?>
                    </div>
                </div>
            </div>
        </div>

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
