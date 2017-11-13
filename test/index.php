<?php
require_once '../php/phpHeader.php';
$header = new PhpHeader();

require_once "../php/headerButtons.php";
require_once "../php/accountInfo.php";
require_once "../php/quickTest.php";

$test = new QuickTest($_GET["id"]);
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
    <script src = "../js/learnController.js"></script>
</head>

<body onload = "LoadTestInfo(<?php echo $test->GetListId();?>)" >
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
        DisplayHeaderButtons("none");
        DisplayAccountInfo();
        ?>
    </div>
</header>

<section class = "vertical-expand">
    <div class = "container">
        <?php
            if($test->GetPermission())
            {
                //show test menu
                ?>
                    <div class = "left_container" id = "lc">
                        <div class = "edit_card">
                          <div class = "scroll">
                              <img id="loadingSpinnerCenter" src = "../img/Spinner.gif">

                              <div class="flip-container" id = "flip_cont">
                                  <div class="flipper" id = "flipper">
                                      <div class="front">
                                          <!-- front content -->
                                          <p id = "polish_text"></p>
                                          <input class = "test_input" id = "user_input" type = "text">
                                          <button class="check_button" id = "check_button_id" onclick = "CheckAndFlip()">Sprawdź</button>
                                      </div>
                                      <div class="back">
                                          <!-- back content -->
                                          <p id = "polish_text_back"></p>
                                          <p id = "answer_result"></p>
                                          <button class="check_button" id = "next_button" onclick = "NextCard()">Dalej</button>
                                      </div>
                                  </div>
                              </div>
                            </div>
                         </div>
                    </div>

                    <div class = "right_container" id = "rc">
                        <div class = "edit_card">
                            <h2>Informacje</h2>
                            <hr>
                            <div class = "scroll">
                              <p class = "infoParagraph">Próba nr: <span id = "try"></span></p>
                              <p class = "infoParagraph">Postęp: <span id = "progress"></span></p>
                              <p class = "infoParagraph">Poprawnie: <span id = "correct"></span></p>
                              <p class = "infoParagraph">Błędnie: <span id = "wrong"></span></p>
                              <p class = "infoParagraph">Skuteczność: <span id = "effectiveness"></span></p>
                            </div>
                        </div>
                    </div>

                    <div class = "error_card_hidden" id = "error_hidden">
                        <h2>Coś poszło nie tak...</h2>
                        <hr>
                        <span>Lista jest pusta!</span>
                    </div>
                <?php
            }
            else
            {
                //show error
                ?>
                <div class = "error_card">
                    <h2>Coś poszło nie tak...</h2>
                    <hr>
                    <span>Błędny adres URL.</span>
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
