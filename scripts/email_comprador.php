<?php

include "lib.php";

$id_cupon = mysql_real_escape_string(substr($_POST['cupon'], 1));
$email = mysql_real_escape_string($_POST['email']);

if ($dbh->query("UPDATE `cupones` SET `correo_usuario` = '$email',`comprado` = '-1', `fecha_venc` = '" . date("U") . "' WHERE `id_cupon` = '$id_cupon'"))
    echo "1";
else
    echo "0";
?>
