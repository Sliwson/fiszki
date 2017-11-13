<!DOCTYPE HTML>

<?php
    require_once '../php/phpHeader.php';
    $header = new PhpHeader();

    if($_SESSION["login_id"] > 0)
        header("Location:../home/index.php");

    require_once '../php/confirmReg.php';

    $messageToShow = 0;
    // 1 - wyświetl "Ups, coś poszło nie tak!"
    // 2 - email potwierdzony
    // 3 - email już potiwerdzony

    if(!isset($_GET["token"]))
    {
        $messageToShow = 1;
    }
    else
    {
        $result = ConfirmUser($_GET["token"]);
        if($result == 1) $messageToShow = 1;
        else if($result == 2) $messageToShow = 3;
        else $messageToShow = 2;
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
                <nav>
                    <ul>
                        <li> <a href = "../dodaj/index.php">Dodaj fiszki</a></li>
                        <li> <a href = "../przegladaj/index.php">Przeglądaj</a></li>
                    </ul>
                </nav>

                <nav id = "navright">
                    <ul>
                        <li><a href="../logowanie/index.php">Logowanie</a></li>
                        <li> <a href="index.php" class = "active">Rejestracja </a></li>
                    </ul>
                </nav>
            </div>
        </header>

         <section class = "vertical-expand">
            <div class = "container">
                <div class = "stretch_card">
                    <div id = "success">
                    <?php
                        if($messageToShow == 1)
                        {
                            echo "<h2>Ups, coś poszło nie tak!</h2>";
                            echo "<hr>";
                            echo "<p>W razie problemów skontaktuj sie z administratorem portalu, korzystając z zakładki <a href=\"../kontakt/index.php\">Kontakt</a>.</p>";
                        }
                        else if ($messageToShow == 2)
                        {
                            echo "<h2>Email został potwierdzony!</h2>";
                            echo "<hr>";
                            echo "<p>Gratulacje! Teraz możesz się zalogować, korzystając z zakładki <a href=\"../logowanie/index.php\">Logowanie</a>.</p>";
                        }
                        else if ($messageToShow == 3)
                        {
                            echo "<h2>Twój email jest już potwierdzony!</h2>";
                            echo "<hr>";
                            echo "<p>Możesz się zalogować, korzystając z zakładki <a href=\"../logowanie/index.php\">Logowanie</a>.</p>";
                        }
                    ?>
                    </div>
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
</html>
