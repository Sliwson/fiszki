<!DOCTYPE HTML>

<?php
require_once '../php/phpHeader.php';
$header = new PhpHeader();

require_once '../php/accountInfo.php';
require_once '../php/headerButtons.php';
require_once '../php/createListFilter.php';

if ($_SERVER["REQUEST_METHOD"] == "POST")
    HandleUpdate();
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

<section class = "vertical-expand">
    <div class = "container">
        <div class = "addForm">
        <h2>Utwórz nową listę:</h2>
            <hr>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h3>Nazwa:</h3>
            <input required maxlength="64" id = "name" type = "text" name = "name"> <br>
            <h3>Typ listy:</h3>
            <div class = "radioContainer">
                <input id = "radio2" type = "radio" name = "listType" value = "public" checked>
                <label for = "radio2"><span class = "radio">Publiczna</span></label> <br>
            </div>
            <div class = "radioContainer">
                <input id = "radio1" type = "radio" name = "listType" value = "private">
                <label for = "radio1"><span class = "radio">Prywatna</span></label> <br>
            </div>

            <input id="createButton" type = "submit" value = "Utwórz!">
        </form>

            <?php
            //handling errors
            if($notLogged) echo "<div class = \"warningadd\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Musisz być zalogowany aby utworzyć listę prywatną!</p></div>";
            if($tooLong) echo "<div class = \"warningadd\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Nazwa może się skłdać maksymalnie z 64 znaków!</p></div>";
            if($badFormat) echo "<div class = \"warningadd\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Nazwa nie może zawierać znaków specjalnych!</p></div>";
            if($nameUsed) echo "<div class = \"warningadd\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Nazwa już w użyciu!</p></div>";
            ?>

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
