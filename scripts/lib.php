<?php

$dbh = mysql_connect("localhost", "nektuzco_5letras", "CincoLetras5") or die('Error de conexión: ' . mysql_error());
mysql_select_db("nektuzco_cincoletras");

function randomString($length) {
    $string = md5(time());
    $highest_startpoint = 32 - $length;
    $randomString = substr($string, rand(0, $highest_startpoint), $length);
    return $randomString;
}

$temp = explode("index.php", @$_SERVER["REQUEST_URI"]);
$url = "http://" . @$_SERVER["SERVER_NAME"] . $temp[0];
?>