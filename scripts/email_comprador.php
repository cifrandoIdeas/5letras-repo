<?php

include "lib.php";

$id_cupon = $dbh->real_escape_string(substr($_POST['cupon'], 1));
$email = $dbh->real_escape_string($_POST['email']);

if ($dbh->query("UPDATE `cupones` SET `correo_usuario` = '$email',`comprado` = '-1', `fecha_venc` = '" . date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"))) . "' WHERE `id_cupon` = '$id_cupon'"))
    echo "1";
else
    echo "0";
?>
