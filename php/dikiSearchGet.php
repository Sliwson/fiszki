<?php

if(isset($_GET["q"]))
{
    $str = $_GET["q"];
    $str = str_replace(" ", "+", $str);
    $url="https://www.diki.pl/slownik-angielskiego?q=".$str;
    $lines_array=file($url);
    $lines_string=implode('',$lines_array);
    echo $lines_string;
}
else echo "0";