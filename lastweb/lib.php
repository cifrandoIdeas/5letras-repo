<?php
function conn()
{
$dbh=mysql_connect ("localhost", "publigui_5letras", "CincoLetras5") or die ('Error de conexión: ' . mysql_error());
mysql_select_db ("publigui_cincoletras");
}
?>