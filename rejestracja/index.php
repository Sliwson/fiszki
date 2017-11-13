<!DOCTYPE HTML>

<?php
    require_once '../php/phpHeader.php';
    $header = new PhpHeader();

    if($_SESSION["login_id"] > 0)
        header("Location:../home/index.php");

    require_once '../php/register.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST")
      HandleRegistration();
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
                        <li> <a href = "index.php" class = "active">Rejestracja</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section class="vertical-expand">
            <div class = "container">
                <div class = "loginF">
                <h2>Rejestracja</h2>
                    <hr>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="loginform">
                    <label>Login:</label> <br>
                    <input autofocus class = "inputfield" type = "text" name = "login" maxlength = "32" pattern="[a-zA-Z_0-9]+" title = "Login nie może zawierać znaków specjalnych!" required value = "<?php if(isset($_SESSION["prev_login"])) echo  $_SESSION["prev_login"] ?>"> <br>
                    <label>Hasło:</label> <br>
                    <input class = "inputfield" minlength = "6" type = "password" name = "pass" required> <br>
                    <label>Powtórz hasło:</label> <br>
                    <input class = "inputfield" minlength = "6" type = "password" name = "pass_repeat" required> <br>
                    <label>E-mail:</label> <br>
                    <input class = "inputfield" maxlength = "64" type = "email" name = "email" required value = "<?php if(isset($_SESSION["prev_email"])) echo  $_SESSION["prev_email"] ?>"> <br>
                    <p> Klikając przycisk zarejestruj akceptujesz Regulamin oraz potwierdzasz zapoznanie się z Zasadami dotyczącymi danych.</p>
                    <input id="button" type = "submit" value = "Zarejestruj">
                </form>

                <?php
                    //handling errors
                    if($regErrors->login_required) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Pole 'Login' nie może pozostać puste!</p></div>";
                    if($regErrors->pass_required) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Pole 'Hasło' nie może pozostać puste!</p></div>";
                    if($regErrors->pass_rep_required) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Pole 'Powtórz hasło' nie może pozostać puste!</p></div>";
                    if($regErrors->email_required) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Pole 'E-mail' nie może pozostać puste!</p></div>";
                    if($regErrors->pass_short) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Hasło powinno składać się z 6 lub więcej znaków!!</p></div>";
                    if($regErrors->login_pattern) echo "<div class = \"warningbig\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Pole 'Login' nie może zawierać więcej niż 32 znaki oraz nie powinno zawierać znaków specjalnych!</p></div>";
                    if($regErrors->email_pattern) echo "<div class = \"warningmedium\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Wprowadź poprawny adres email! (Nie dłuższy niż 64 znaki)</p></div>";
                    if($regErrors->pass_wrong) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Hasła nie zgadzają się!</p></div>";
                    if($regErrors->login_used) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Login zajęty!</p></div>";
                    if($regErrors->email_used) echo "<div class = \"warning\"> <img class = \"warnimg\" src = \"../img/warn_white.png\" width = \"20px\" height = \"20px\"> <p>Email zajęty!</p></div>";
                ?>
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
