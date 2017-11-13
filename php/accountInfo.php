<?php
    require_once 'phpHeader.php';
    $header = new PhpHeader();

    function DisplayAccountInfo()
    {
        if($_SESSION["login_id"] > 0)
        {
            if(!isset($_SESSION["username"]))
            {
                $_SESSION["username"] = "null";
            }

            //display account header
            echo "<div id = \"dropdown-check\"></div>";
            echo "<div id = \"account\">";
            echo "<img id = \"avatar\" src=\"../img/default-avatar.png\" width = \"40\" height = \"40\">";
            echo "<p>".$_SESSION["username"]."</p>";
            echo "<img id = \"expand\" src = \"../img/transp.png\" width = \"40\" height = \"40\">";
            echo "</div>";
        }
        else
        {
            //display registration header
            echo"<nav id = \"navright\">";
            echo"<ul>";
            echo"<li><a href=\"../logowanie/index.php\">Logowanie</a></li>";
            echo"<li><a href=\"../rejestracja/index.php\">Rejestracja</a></li>";
            echo "<img id = \"expand\" src = \"../img/transp.png\" width = \"0\" height = \"0\">";
            echo "<div id = \"dropdown-check\"></div>";
            echo"</ul>";
            echo"</nav>";
        }
    }
?>
