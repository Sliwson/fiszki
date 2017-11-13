<?php
require_once '../php/phpHeader.php';
$header = new PhpHeader();

require_once "../php/checkPermission.php";
require_once "../php/headerButtons.php";
require_once "../php/accountInfo.php";
require_once "../php/deletePermanent.php";

$error = 0;

if(isset($_GET["q"]))
{
    $list_id = TestInput($_GET["q"]);
    $error = DeletePermanent($list_id);
}
else
{
    $error = 1;
}
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
        DisplayHeaderButtons("none");
        DisplayAccountInfo();
        ?>
    </div>
</header>

<section class = "vertical-expand">
    <div class = "container">
        <div class = "stretch_card">
            <div class = "delete_error">
            <?php
                if($error == 1)
                {
                    ?>
                        <h2>Podczas usuwania wystąpił błąd.</h2>
                        <hr>
                        <p>W razie problemów skontaktuj sie z administratorem portalu, korzystając z zakładki <a href="../kontakt/index.php">Kontakt</a>.</p>
                    <?php
                }
                else
                {
                    ?>
                        <h2>Lista usunięta pomyślnie.</h2>
                        <hr>
                    <?php
                }
            ?>
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
