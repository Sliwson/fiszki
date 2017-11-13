<?php
require_once '../php/phpHeader.php';
$header = new PhpHeader();

require_once '../php/searchController.php';
$searchController = new SearchController($_GET["q"]);

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
            <form form method = "get" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input id="search" value = "<?php $searchController->ShowBarValue(); ?>" placeholder="Szukaj fiszek..." type ="text" name = "q">
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
        <?php $searchController->DisplaySearchResults(); ?>

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
