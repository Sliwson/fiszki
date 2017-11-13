<?php
    require_once '../php/phpHeader.php';
    $header = new PhpHeader();

    if($_SESSION["login_id"] > 0)
        header("Location:../home/index.php");
?>

<!DOCTYPE HTML>

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
                        <li> <a href='index.php' class = "active">Rejestracja </a></li>
                    </ul>
                </nav>
            </div>
        </header>

         <section class = "vertical-expand">
            <div class = "container">
                <div class = "stretch_card">
                <div id = "success">
                    <h2>Rejestracja przebiegła pomyślnie!</h2>
                    <hr>
                    <p> W twojej skrzynce mailowej powinien pojawić się email, który pozwoli dokończyć proces rejestracji. Nie zapomnij sprawdzić folderu spam! W razie problemów skontaktuj sie z administratorem portalu, korzystając z zakładki <a href="../kontakt/index.php">Kontakt</a>.</p>
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
