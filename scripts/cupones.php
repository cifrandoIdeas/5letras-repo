<?php

include "lib.php";
ini_set("include_path", '/home1/nektuzco/php:' . ini_get("include_path"));
require_once 'Mail.php';
setlocale(LC_TIME, "es_MX");

if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $cupon = $_POST['cupon'];

    if ($accion == "check_in") {
        if (!$dbh->query("UPDATE `cupones` SET `checked_in` = '1' WHERE `id_cupon` = '$cupon'"))
            echo 0;
    }

    if ($accion == "uncheck_in") {
        if (!$dbh->query("UPDATE `cupones` SET `comprado` = '0', `fecha_venc` = '', correo_usuario = '' WHERE `id_cupon` = '$cupon'"))
            echo 0;
    }

    if ($accion == "descuento") {
        $descuento = intval($_POST['descuento_cupon']);
        if ($descuento < 0 || $descuento > 100)
            echo 0;
        else
        if (!$dbh->query("UPDATE `cupones` SET `descuento` = '$descuento' WHERE `id_cupon` = '$cupon'"))
            echo 0;
    }

    if ($accion == "eliminar") {
        if (!$dbh->query("DELETE FROM `cupones` WHERE `id_cupon` = '$cupon'"))
            echo 0;
    }

    if ($accion == "pagar") {
        $correo_user = $_POST['correo_user'];
        if (trim($correo_user) == "")
            return 0;

        $fecha_venc = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y")));

        //compra guardada y fecha de vencimiento
        $dbh->query("UPDATE `cupones` SET `comprado` = '1', `fecha_venc` = '$fecha_venc', correo_usuario = '$correo_user' WHERE `id_cupon` = '$cupon'");

        //Envio del ticket al usuario
        $res = $dbh->query("SELECT * FROM cupones,moteles WHERE id_motel = idmotel AND id_cupon = '$cupon'");
        $arr = res->fetch_assoc();

        // email de destino
        $email = $arr['correo_usuario'];

        // asunto del email
        $subject = "Cinco Letras - Imprime tu ticket";

        // Cuerpo del mensaje
        $mensaje = "---------------------------------- <br />";
        $mensaje.= "CINCOLETRAS.MX :: TICKET " . $arr['nombre'] . "<br />";
        $mensaje.= "---------------------------------- <br />";
        $mensaje.= "Entra en esta dirección para imprimir tu ticket:<br />";
        $mensaje.= "http://" . $_SERVER["SERVER_NAME"] . "/cupon.php?id=c" . $cupon . "<br />";
        $mensaje.= "---------------------------------- <br /><br />";
        $mensaje.= "Gracias por adquirir uno de nuestros Tickets. Agradecemos tu preferencia.<br /><br />";
        $mensaje.= "---------------------------------- <br />";

        // headers del email
        $headers['MIME-Version'] = '1.0';
        $headers['Content-type'] = 'text/html; charset=iso-8859-1';

        // Cabeceras adicionales
        $headers['To'] = $email;
        $headers['From'] = 'contacto@cincoletras.mx';
        $headers['Subject'] = $subject;

        // Enviamos el mensaje
//		if(!@mail($email, $subject, $mensaje, $headers)) echo "0m";		
//		else echo "1m";

        $mail = & Mail::factory("smtp", array(
                    'host' => 'mail.cincoletras.mx',
                    'port' => '26',
                    'auth' => "PLAIN",
                    'socket_options' => array('ssl' => array('verify_peer_name' => false)),
                    'username' => 'contacto@cincoletras.mx',
                    'password' => 'Contacto5letras'));

        $mail->send($email, $headers, $mensaje);


        //echo "mail: " . $mail->getMessage();
    }
}

$mes = $_POST['mes'];
$year = $_POST['year'];
$motel = $_POST['motel'];
$tipo = $_POST['tipo'];
$checked = $_POST['checked'];
$comprado = $_POST['comprado'];
$id_cupon = $_POST['id_cupon'];
$usuario = $_POST['usuario'];

$sql = 'SELECT * FROM `cupones`';
$seek = "";

if ($motel != "-1")
    $seek.=" id_motel = $motel";

if ($tipo != "-1") {
    if ($seek != "")
        $seek.=" AND";
    $seek.=" tipo LIKE '$tipo'";
}

if ($checked != "-1") {
    if ($seek != "")
        $seek.=" AND";
    $seek.=" checked_in = $checked";
}

if ($comprado != "-1") {
    if ($comprado == "2")
        $comprado = "-1";
    if ($seek != "")
        $seek.=" AND";
    $seek.=" comprado = $comprado";
}

if ($id_cupon != "") {
    if ($seek != "")
        $seek.=" AND";
    $seek.=" id_cupon = '$id_cupon'";
}

$facturacion = "";
if ($mes != "-1" || $year != "-1") {
    if ($mes != "-1")
        $facturacion = "$mes-";
    else
        $facturacion = "%-";
    if ($year != "-1")
        $facturacion.="$year";
    else
        $facturacion.="%";
    if ($seek != "")
        $seek.=" AND";
    $seek.=" facturacion LIKE '$facturacion'";
}

if ($seek != "") {
    $sql.=" WHERE" . $seek;
}
$cont = "";
$x = 0;
$resul = $dbh->query($sql);
if ($resul->num_rows) {
    $cont.='
		<div class="elemento line">
			<span class="col1">
				ID cupon
			</span>		
			<span class="col2">
				Motel
			</span>	
			<span class="col3">
				Tipo
			</span>	
			<span class="col4">
				Correo
			</span>	
			<span class="col5">
				Facturacion
			</span>				
			<span class="col6">
				En venta
			</span>		
			<span class="col7">
				Desc.
			</span>					
		</div>';
}
while ($arr = $resul->fetch_array()) {
    $class = "";
    if (($x % 2) == 0)
        $class = ' gray';
    $cont.='
		<div class="elemento' . $class . '">
		
			<span class="col1">
				' . $arr['id_cupon'] . '
			</span>
			<span class="col2">
				';

    $r = $dbh->query("SELECT * FROM `moteles` WHERE idmotel = " . $arr['id_motel']);
    $a = $r->fetch_assoc();
    $cont.= $a['nombre'];

    $cont.= '
			</span>
			<span class="col3">
				' . $arr['tipo'] . '
			</span>';
    if ($arr['comprado'] != "1" && $usuario == "admin")
        $cont.= '<input type="text" name="correo_usuario_text" value="' . $arr['correo_usuario'] . '" class="col4 correo_usuario_text" />';
    else
        $cont.= '
			<span class="col4">
				' . $arr['correo_usuario'] . '
			</span>';

    $cont.= '
			<span class="col5">';
    $fact = explode("-", $arr['facturacion']);
    $cont.= strftime("%b", mktime(0, 0, 0, $fact[0])) . "-" . $fact[1];

    $cont.='
			</span>			
			<span class="col6">';

    if ($arr['comprado'] == "0")
        $cont.= "No comprado";
    else if ($arr['comprado'] == "-1")
        $cont.= "Pendiente";
    else
        $cont.= "Comprado";

    $cont.= '</span>';

    if ($arr['comprado'] == "0") {
        $cont.= '<input type="text" name="descuento_cupon" value="' . $arr['descuento'] . '" class="col7 descuento_cupon" />
				<a href="#5l" title="' . $arr['id_cupon'] . '" class="descuento">
					%
				</a>';
    } else {
        $cont.='
			<span class="col7">
				' . $arr['descuento'] . '%	
			</span>';
    }

    if ($arr['comprado'] == "0") {
        $cont.= '
			<a href="#5l" title="' . $arr['id_cupon'] . '" class="eliminar">
				Eliminar
			</a>';
    }

    if ($arr['comprado'] != "1" && $usuario == "admin") {
        $cont.= '
			<a href="#5l" title="' . $arr['id_cupon'] . '" class="pagar">
				Pagar
			</a>';
    }

    if ($arr['checked_in'] == 0) {
        if ($arr['comprado'] == 1) {
            $cont.= '					
				<a href="#5l" title="' . $arr['id_cupon'] . '" class="check_in">
					Registrar
				</a>';
            if ($usuario == "admin")
                $cont.= '
					<a href="#5l" title="' . $arr['id_cupon'] . '" class="uncheck_in">
						Re-activar
					</a>';
        }
    }
    else {
        $cont.= '					
			<a href="#5l" title="' . $arr['id_cupon'] . '">
				Registrado
			</a>';
    }

    $cont.= '		
		</div>
	';
    $x++;
}

echo $cont;
?>