<?php
    require_once 'phpHeader.php';
    $header = new PhpHeader();

    function DisplayHeaderButtons($active)
    {
        if($_SESSION["login_id"] > 0)
        {
            echo "<nav>";
                echo "<ul>";
                    if($active == "dodaj") echo"<li> <a class = \"active\" href = \"../dodaj/index.php\">Dodaj fiszki</a></li>";
                    else echo "<li> <a href = \"../dodaj/index.php\">Dodaj fiszki</a></li>";
                    if($active == "przegladaj") echo"<li> <a class = \"active\" href = \"../przegladaj/index.php\">Przeglądaj</a></li>";
                    else echo "<li> <a href = \"../przegladaj/index.php\">Przeglądaj</a></li>";
                echo "</ul>";
            echo "</nav>";
        }
        else
        {
            echo "<nav>";
                echo "<ul>";
                    if($active == "dodaj") echo"<li> <a class = \"active\" href = \"../dodaj/index.php\">Dodaj fiszki</a></li>";
                    else echo "<li> <a href = \"../dodaj/index.php\">Dodaj fiszki</a></li>";
                    if($active == "przegladaj") echo"<li> <a class = \"active\" href = \"../przegladaj/index.php\">Przeglądaj</a></li>";
                    else echo "<li> <a href = \"../przegladaj/index.php\">Przeglądaj</a></li>";
                echo"</ul>";
            echo"</nav>";
        }
    }
?>
