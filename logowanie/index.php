<!DOCTYPE HTML>

<?php
    require_once '../php/phpHeader.php';
    $header = new PhpHeader();

    require_once '../php/login.php';

    if($_SESSION["login_id"] > 0)
        header("Location:../home/index.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST")
        HandleLogin();
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
                        <li class = "active">Logowanie</li>
                        <li><a href="../rejestracja/index.php">Rejestracja</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section class="vertical-expand">
            <div class = "container">
                <div class = "loginF">
                <h2>Logowanie</h2>
                <hr>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="loginform">
                    <label>Login:</label> <br>
                    <input autofocus class = "inputfield" type = "text" name = "login" maxlength = "32" required value = "<?php if(isset($_SESSION["prev_login"])) echo  $_SESSION["prev_login"] ?>"> <br>
                    <label>Hasło:</label> <br>
                    <input class = "inputfield" type = "password" name = "pass" required> <br>
                    <input id="button" type = "submit" value = "Zaloguj">
                </form>

                <?php
                    //handling errors
                    if($badData) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Błędny login lub hasło!</p></div>";
                    if($not_confirmed) echo "<div class = \"warningmedium\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Potwierdź adres email przed pierwszym logowaniem!</p></div>";

                echo "</div>";
                ?>
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
