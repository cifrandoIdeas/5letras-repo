<?php
$dbh = new mysqli("localhost", "nektuzco_5letras", "CincoLetras5", "nektuzco_cincoletras");

$temp = explode("index.php", filter_input(INPUT_ENV, "REQUEST_URI"));
$url = "http://" . filter_input(INPUT_ENV, "SERVER_NAME") . $temp[0];

function randomString($length) {
    $string = md5(time());
    $highest_startpoint = 32 - $length;
    $randomString = substr($string, rand(0, $highest_startpoint), $length);
    return $randomString;
}

function compra_exitosa($dbh, $url, $cupon_recibido){
    $mensaje = "";
    
    //calcular fecha de vencimiento
    $fecha_venc = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));

    //Envio del ticket al usuario
    $res = $dbh->query("SELECT * FROM cupones,moteles WHERE id_motel = idmotel AND id_cupon = '$cupon_recibido'");
    $arr = $res->fetch_array();

    //compra guardada y fecha de vencimiento
    $dbh->query("UPDATE `cupones` SET `comprado` = '1', `fecha_venc` = '$fecha_venc' WHERE `id_cupon` = '$cupon_recibido'");
    echo 'msg="Su compra ha sido exitosa. Gracias por su preferencia. El cupón llegara a su correo.";';

    // email de destino
    $email = $arr['correo_usuario'];

    // asunto del email
    $subject = "Cinco Letras - Imprime tu ticket";

    // Cuerpo del mensaje
    $mensaje.= "---------------------------------- \n";
    $mensaje.= "CINCOLETRAS.MX :: TICKET " . $arr['nombre'] . "\n";
    $mensaje.= "---------------------------------- \n";
    $mensaje.= "Entra en esta dirección para imprimir tu ticket:\n";
    $mensaje.= $url . "cupon.php?id=c" . $cupon_recibido . "\n";
    $mensaje.= "---------------------------------- \n\n";
    $mensaje.= "Gracias por adquirir uno de nuestros Tickets. Agradecemos tu preferencia.\n\n";
    $mensaje.= "---------------------------------- \n";

    // headers del email
    $headers = "From: contacto@cincoletras.com \r\n";

    // Enviamos el mensaje
    mail($email, $subject, $mensaje, $headers);       
}


