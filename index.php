<?
include 'scripts/lib.php';

if (filter_input(INPUT_GET,'seccion')== false){
    $seccion = "home";
} else {
    $seccion = filter_input(INPUT_GET,'seccion');
}

if ($seccion != "home"){
    $goto = 1;
}

if (file_exists("secciones/" . $seccion . ".xml")) {
    $xml = simplexml_load_file("secciones/" . $seccion . ".xml");
}

setlocale(LC_TIME, "es_MX");

//$mensaje="";
//if (filter_input(INPUT_POST,'nombre')) {
//
//    $nombre = filter_input(INPUT_POST,'nombre');
//
//    $mail = filter_input(INPUT_POST,'email');
//
//    $comentarios = filter_input(INPUT_POST,'mensaje');
//
//
//
//    // email de destino
//
//    $email = "rp_cincoletras@hotmail.com";
//
//
//
//    // asunto del email
//
//    $subject = "Cinco Letras - Seccion Contacto";
//
//
//
//    // Cuerpo del mensaje            
//    $mensaje.= "---------------------------------- \n";
//
//    $mensaje.= "            Contacto               \n";
//
//    $mensaje.= "---------------------------------- \n";
//
//    $mensaje.= "NOMBRE:   " . $nombre . "\n";
//
//    $mensaje.= "EMAIL:    " . $mail . "\n";
//
//    $mensaje.= "FECHA:    " . date("d/m/Y") . "\n";
//
//    $mensaje.= "HORA:     " . date("h:i:s a") . "\n\n";
//
//    $mensaje.= "---------------------------------- \n\n";
//
//    $mensaje.= $comentarios . "\n\n";
//
//    $mensaje.= "---------------------------------- \n";
//
//
//
//    // headers del email
//
//    $headers = "From: " . $mail . " \r\n";
//
//
//
//    // Enviamos el mensaje
//
//    mail($email, $subject, $mensaje, $headers);
//
//    $mensaje = "Comentario enviado";
//}
?>
<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>:: Cinco Letras :: La guia de moteles en Guadalajara</title>

        <meta name="keywords" content="Motel, Moteles, Guadalajara, Zapopan, Tlaquepaque, Tonala, Tlajomulco, motelazo, motelaso, Hotel, Hoteles, Hospedaje, renta de cuartos, Alojamiento, estancia, habitaciones" />

        <meta name="description" content="La guia de moteles en Guadalajara. Encuentra los mejores moteles con los precios mas accesibles en Cinco Letras"/>

        <link rel="image_src" href="images/cincoletras_logo.jpg" />

        <?

        if ($seccion == "motel" && filter_input(INPUT_GET,'id')) {

            $result = $dbh->query("SELECT * FROM `moteles`,`moteles2` WHERE id_motel=idmotel AND idmotel = " . $dbh->real_escape_string(filter_input(INPUT_GET,'id')));

            if ($result == false){
                $seccion = "home";
            }

            else {

                $arr = $result->fetch_array();

                echo '<meta property="og:title" content="' . $arr['nombre'] . ' :: Adquiere tus tickets y disfruta" />';

                echo '<meta property="og:description" content="' . $arr['descripcion'] . '" />'; 

                echo '<meta property="og:image" content="' . $url . 'fotos/main/' . $arr['idmotel'] . '.jpg" />';   

                echo '<meta property="og:type" content="hotel" />';
            }
        }
        ?>

        <link rel="stylesheet" href="css/reset.css" type="text/css" />

        <link rel="stylesheet" href="css/5letras.css" type="text/css" />

        <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />

        <!-- Google Tag Manager -->

        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':

        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],

        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=

        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);

        })(window,document,'script','dataLayer','GTM-T8RBSLD');</script>

        <!-- End Google Tag Manager -->        

    </head>

    <body>
        <!-- Google Tag Manager (noscript) -->

        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T8RBSLD"

        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

        <!-- End Google Tag Manager (noscript) -->    
        <div id="header" class="div_principales">  

            <div class="content">  

                <div id="logo" class="left">

                    <a href="#5l">

                        <img src="images/5letras_logo.jpg" />

                    </a>

                </div>



                <div id="banner_p" class="left">

                    <a href="#" class="active">

                        <img src="images/header1.jpg" />

                    </a>

                    <a href="#">

                        <img src="images/header2.jpg" />

                    </a>                                               

                </div>



                <ul id="menup" class="left"> 

                    <li>

                        <a href="index.php?seccion=home" title="Home" class="<?
                        if ($seccion == "home"){
                            echo "active";
                        }
                        else{
                            echo "menu_btns";
                        }
                        ?>">

                            TOP 10

                        </a>

                    </li>

                    <li>

                        <a href="index.php?seccion=directorio" title="Directorio" class="<?
                        if ($seccion == "directorio"){
                            echo "active";
                        }
                        else{
                            echo "menu_btns";
                        }
                        ?>">

                            + Moteles

                        </a>

                    </li>

                    <li>

                        <a href="index.php?seccion=promociones" title="Promociones" class="<?
                        if ($seccion == "promociones"){
                            echo "active";
                        }
                        else{
                            echo "menu_btns";
                        }
                        ?>">

                            Promociones

                        </a>

                    </li>  

                    <li>

                        <a href="index.php?seccion=contacto" title="Contacto" class="<?
                        if ($seccion == "contacto"){
                            echo "active";
                        }
                        else{
                            echo "menu_btns";
                        }
                        ?>">

                            Contacto

                        </a>

                    </li> 

                </ul>



            </div>  

        </div>



        <div id="contenido" class="div_principales">

            <div class="content">

                <div id="banners">

                    <div id="siguenos">

                        <span>S&iacute;guenos</span>

                        <div>
                            <a href="https://www.facebook.com/pages/CincoLetrasMx/190217297676307?ref=hl">

                                <img src="images/face_page.jpg" />

                            </a>

                            <a href="https://twitter.com/#!/CINCOLETRASMX">

                                <img src="images/twitter_page.jpg" />

                            </a>

                            <a href="https://plus.google.com/104979540209105512314" rel="publisher">
                                <img src="images/googleround.png" />
                            </a>

                            <a href="https://www.youtube.com/channel/UCBjJalKOrn7Xe6m-G7MsqxA">

                                <img src="images/youtube.png" />

                            </a>

                            <a href="https://instagram.com/cincoletrasmx/">

                                <img src="images/instagram.png" />

                            </a>

                            <a href="https://www.pinterest.com/cincoletrasmx/" rel="publisher">
                                <img src="images/pinterest.png" />
                            </a>                            

                        </div>                                             

                    </div>

                    <a href="#5l">

                        <img src="images/banner1.jpg" />

                    </a>

                    <a href="#5l">

                        <img src="images/banner2.jpg" />

                    </a>

                    <a href="#5l">

                        <img src="images/banner3.jpg" />

                    </a>                                

                </div>            

                <div id="secciones" class="<? echo $seccion; ?>">

                    <a href="index.php?seccion=promociones" id="comofunciona">

                        <img src="images/comofunciona.jpg" />

                    </a>

                    <?
                    if ($xml){
                        echo $xml->seccion[0];
                    }

                    switch ($seccion) {

                        case "home":

                            $moteles = implode(",", array(19, 11, 49, 20, 4, 34, 40, 6, 46, 25));

                            $result = $dbh->query("SELECT idmotel, id_cupon, tipo, condiciones_uso, facturacion, nombre, precio, comprado, descripcion, descuento

							FROM `moteles` LEFT OUTER JOIN (

                                                            SELECT * 

                                                            FROM cupones

                                                            WHERE comprado =0

                                                            )t2 

                                                        ON idmotel = id_motel

							WHERE idmotel IN ($moteles)

							GROUP BY `idmotel` ORDER BY RAND()");

                            while ($arr = $result->fetch_array()) {

                                echo '<div class="cupon left">';

                                echo '<a href="index.php?seccion=motel&amp;id=' . $arr['idmotel'] . '">';

                                echo '<img src="fotos/main/' . $arr['idmotel'] . '.jpg" />';

                                echo '</a>';

				echo '<h3>' . $arr['nombre'] . '</h3>';							

				echo '<p>';

                                $desc_arr = explode(utf8_decode("DIRECCIÓN."), $arr['descripcion']);

                                echo utf8_encode($desc_arr[1]) . '</p>';

                                if ($arr['comprado'] == "0"){
                                    echo '<div class="condiciones">';

                                    echo nl2br($arr['condiciones_uso']);

                                    echo '</div> ';

                                    echo '<span>';

                                    echo 'Ticket: Habitaci&oacute;n ' . $arr['tipo'];

                                    echo '</span>';

                                    echo '<div class="botones">';

                                    echo '<a href="#5l" title="Mas informacion" class="btn_info">';

                                    echo '<img src="images/btn_masinfo.jpg" alt="Mostrar mas informacion" />';

                                    echo '</a>';

                                    echo '<a href="#act" title="Comprar" class="btn_comprar" id="c' . $arr['id_cupon'] . '">';

                                    echo '<img src="images/btn_comprar.jpg" alt="Comprar producto" />';

                                    echo '</a>';								

                                    echo '</div>';

                                    echo '<div class="share">';

                                    echo '<p>';

                                    echo 'Compartir';

                                    echo '</p>';

                                    echo '<a href="javascript:sharefb(\'' . $arr['idmotel'] . '\',\'' . $arr['nombre'] . '\')" title="Compartir en facebook">';

                                    echo '<img src="images/btn_face_cupon.jpg" alt="Compartir contenido en facebook" />';

                                    echo '</a>';

                                    echo '<a href="javascript:sharetwitter(\'' . $arr['idmotel'] . '\',\'' . $arr['nombre'] . '\')" title="Compartir en twitter">';

                                    echo '<img src="images/btn_twitter_cupon.jpg" alt="Compartir contenido en twitter" />';

                                    echo '</a>';								

                                    echo '</div>';

                                    echo '<div class="precio">';

                                    echo '<span>';

                                    echo '$' . ceil($arr['precio'] - (($arr['descuento'] * $arr['precio']) / 100));

                                    echo '</span>';

                                    echo '</div>';
                                }
                                echo '</div>';
                            }

                            break;
                        case "promociones":

                            $result = $dbh->query("SELECT id_motel, id_cupon, tipo, condiciones_uso, facturacion, nombre, precio, descuento

							FROM `cupones` , `moteles`

							WHERE `comprado` =0

							AND id_motel = idmotel

							AND activo = 1

							GROUP BY `id_motel` , `tipo` ORDER BY RAND()");

                            while ($arr = $result->fetch_array()) {

                                echo '

							<div class="cupon left">

                                                                <a href="index.php?seccion=motel&amp;id=' . $arr['id_motel'] . '">

                                                                    <img src="fotos/main/' . $arr['id_motel'] . '.jpg" />

                                                                </a>

								<h3>' . $arr['nombre'] . '</h3>							

								

								<p>		

									' . substr($arr['condiciones_uso'], 0, 100) . '

								</p>

								<div class="condiciones">

									' . nl2br($arr['condiciones_uso']) . '

								</div>

                                                                <span>

                                                                    Ticket: Habitaci&oacute;n ' . $arr['tipo'] . '

                                                                </span>                                                                

								<div class="botones">

									<a href="#5l" title="Mas informacion" class="btn_info">

                                                                            <img src="images/btn_masinfo.jpg" alt="Mostrar mas informacion" />

									</a>

									<a href="#act" title="Comprar" class="btn_comprar" id="c' . $arr['id_cupon'] . '">

										<img src="images/btn_comprar.jpg" alt="Comprar producto" />

									</a>								

								</div>

								<div class="share">

                                                                    <p>

                                                                    Compartir

                                                                    </p>

                                                                    <a href="javascript:sharefb(\'' . $arr['id_motel'] . '\',\'' . $arr['nombre'] . '\')" title="Compartir en facebook">

                                                                        <img src="images/btn_face_cupon.jpg" alt="Compartir contenido en facebook" />									</a>

                                                                   <a href="javascript:sharetwitter(\'' . $arr['id_motel'] . '\',\'' . $arr['nombre'] . '\')" title="Compartir en twitter">

                                                                        <img src="images/btn_twitter_cupon.jpg" alt="Compartir contenido en twitter" />                                                                             

                                                                        </a>							

								</div>

								<div class="precio">

									<span>

										$' . ($arr['precio'] - (($arr['descuento'] * $arr['precio']) / 100)) . '

									</span>

								</div>

							</div>

							';
                            }

                            break;



                        case "directorio":

                            echo '<div id="directorio_content">';

                            $result = $dbh->query("SELECT * FROM `moteles` WHERE activo = 1 ORDER BY RAND()");

                            while ($arr = $result->fetch_array()) {

                                echo '

								<div class="left">

									<a href="index.php?seccion=motel&amp;id=' . $arr['idmotel'] . '">

										<img src="fotos/main/' . $arr['idmotel'] . '.jpg" />

										<span>

											' . $arr['nombre'] . '

										</span>

									</a>

									<p>';

                                $desc_arr = explode(utf8_decode("DIRECCIÓN."), $arr['descripcion']);

                                echo utf8_encode($desc_arr[1]) . '

									</p>								

								</div>

								';
                            }

                            echo '</div>';

                            break;



                        case "motel":

                            $temp1 = explode("&", $arr['video']);

                            $temp2 = explode("?", $temp1[0]);

                            $temp3 = explode("=", $temp2[1]);

                            $video = "http://www.youtube.com/embed/" . $temp3[1];

                            echo '

                                                            <div class="left" id="desc_motel">

                                                                <iframe width="425" height="318" src="' . $video . '?wmode=opaque" frameborder="0" allowfullscreen>

                                                                </iframe>

                                                                <div id="share_motel">

                                                                    <h2>' . $arr['nombre'] . '</h2>

                                                                    <a href="javascript:sharetwitter(\'' . $arr['idmotel'] . '\',\'' . $arr['nombre'] . '\')" title="Compartir en twitter">

                                                                        <img src="images/btn_twitter_cupon.jpg" alt="Compartir contenido en twitter" />

                                                                    </a>                                                                        

                                                                    <a href="javascript:sharefb(\'' . $arr['idmotel'] . '\',\'' . $arr['nombre'] . '\')" title="Compartir en facebook">

                                                                        <img src="images/btn_face_cupon.jpg" alt="Compartir contenido en facebook" /> 

                                                                    </a>     

                                                                </div>                                                                

                                                                <p>

                                                                        ' . utf8_encode(nl2br($arr['descripcion'])) . '

                                                                </p>

                                                            </div>

                                                            <div class="left" id="mapa_motel">';

                            if (isset($arr['idmotel'])){
                                $result2 = $dbh->query("SELECT id_cupon, tipo, condiciones_uso, facturacion, precio, descuento

                                                                            FROM `cupones`

                                                                            WHERE `comprado` = 0

                                                                            AND id_motel = " . $arr['idmotel'] . "

                                                                            GROUP BY `tipo`");
                            }

                            while ($arr2 = $result2->fetch_array()) {

                                echo '

                                                                            <div class="cupon left">								

                                                                                    <p>		

                                                                                        <span>

                                                                                            Ticket: Habitaci&oacute;n ' . $arr2['tipo'] . '

                                                                                        </span>

                                                                                        ' . substr($arr2['condiciones_uso'], 0, 100) . '

                                                                                    </p>

                                                                                    <div class="condiciones">

                                                                                            ' . $arr2['condiciones_uso'] . '

                                                                                    </div>

                                                                                    <div class="botones">

                                                                                            <a href="#5l" title="Mas informacion" class="btn_info">

                                                                                                    <img src="images/btn_masinfo.jpg" alt="Mostrar mas informacion">

                                                                                            </a>

                                                                                            <a href="#act" title="Comprar" class="btn_comprar" id="c' . $arr2['id_cupon'] . '">

                                                                                                    <img src="images/btn_comprar.jpg" alt="Comprar producto">

                                                                                            </a>								

                                                                                    </div>

                                                                                    <div class="share">

                                                                                            <p>

                                                                                            Compartir

                                                                                            </p>

                                                                                            <a href="javascript:sharefb(\'' . $arr['idmotel'] . '\',\'' . $arr['nombre'] . '\')" title="Compartir en facebook">

                                                                                                    <img src="images/btn_face_cupon.jpg" alt="Compartir contenido en facebook" />

                                                                                            </a>

                                                                                            <a href="javascript:sharetwitter(\'' . $arr['idmotel'] . '\',\'' . $arr['nombre'] . '\')" title="Compartir en twitter">

                                                                                                    <img src="images/btn_twitter_cupon.jpg" alt="Compartir contenido en twitter" />

                                                                                            </a>								

                                                                                    </div>

                                                                                    <div class="precio">

                                                                                            <span>

                                                                                             $' . ($arr2['precio'] - (($arr2['descuento'] * $arr2['precio']) / 100)) . '

                                                                                            </span>

                                                                                    </div>

                                                                            </div>

                                                                            ';
                            }



                            echo '

                                                                    <div class="gray_box">

                                                                            <h3>Mapa</h3>

                                                                            <div>

                                                                                    <iframe width="232" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'
                            . $arr['mapa'] . '">

                                                                                    </iframe>

                                                                            </div>

                                                                    </div>								

                                                            ';



                            echo '

                                                            </div>

                                                            <div class="gray_box galerias_div">

                                                                    <h3>Galeria</h3>

                                                                    <div>';

                            for ($x = 'a'; $x <= 'i'; $x++) {

                                echo '

                                                                    <a href="fotos/gde/' . $arr['idmotel'] . $x . '.jpg" id="f' . $arr['idmotel'] . $x . '" class="galerias">

                                                                            <img src="fotos/thumbs/' . $arr['idmotel'] . $x . '.jpg" />

                                                                    </a>';
                            }



                            echo '

                                                                    </div>

                                                            </div>									

                                                    ';

                            break;

                        case 'contacto':
                        default:
                            echo '

						<form id="fcontacto" method="post" action="index.php?seccion=contacto">

							<input type="text" name="nombre" class="text" value="Nombre" id="nombre_c" />

							<input type="text" name="email" class="text" value="Email" id="email_c" />

							<textarea class="text" name="mensaje" id="mensaje_c">Escribe tu mensaje</textarea>

							<input type="image" src="images/btn_enviar_contacto.jpg" id="btn_enviarc" />

						</form>

						<div id="links">

							<a href="#5l">

								<span>contacto@cincoletras.mx</span>

							</a>

							<a href="http://www.facebook.com/cincoletrasmx">

								<span>www.facebook.com/cincoletrasmx</span>

							</a>

							<a href="http://www.twitter.com/cincoletras">

								<span>www.twitter.com/cincoletras</span>

							</a>							

						</div>

						';

                            break;                        
                    }
                    ?>                            

                </div>

            </div>    

        </div>



        <div id="footer" class="div_principales">

            <div class="content">

                <p> &#169; Copyright CincoLetras.mx 2011 todos los derechos reservados 

                    <a href="#5l" class="btn_terminos right" title="Mas informacion">
                        Términos y condiciones de uso
                    </a>
                </p>

            </div>

        </div>    



        <div class="popup" id="correo_mail">

            <p class="right">Introduce tu correo correctamente. Tu ticket te llegar&aacute; a esta direcci&oacute;n:
                <span>
                    ABSOLUTA DISCRECI&Oacute;N EN TU ESTADO DE CUENTA
                </span>
            </p>


<!--        <select id="tipo_pago" class="right">

            <option value="0">Escoge tu tipo de pago </option>

            <option value="paypal">Tajeta de crédito </option>

            <option value="dineromail">Transferencias - 7Eleven - Oxxo </option>

        </select>     -->    



            <!--        ******************************PAY PAL******************************-->

            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="forma_paypal">

                <input type="hidden" name="business" value="rp_cincoletras@hotmail.com"> 

                <input type="hidden" name="cmd" value="_xclick">            

                <input type="hidden" name="amount" value="0000">   

                <input type="hidden" name="item_name" value="###">

                <input type="hidden" name="item_number" value="c000"> 

                <input type="hidden" name="quantity" value="1"> 

                <input type="hidden" name="currency_code" value="MXN"> 

                <input type="hidden" name="lc" value="MXN">

                <input type="hidden" name="no_shipping" value="1"> 

                <input type="hidden" name="return" value=""> 

                <input type="hidden" name="cancel_return" value=""> 

                <input type="hidden" name="image_url" value="http://cincoletras.mx/images/5letras_paypal_logo.jpg">



                <label class="right">

                    <span>Email:</span>

                    <input placeholder="Tu correo" type="text" name="buyer_email" class="txt" id="mail_compra2" />

                </label>

                <input class="right boton" type="image" src="//www.paypalobjects.com/webstatic/es_MX/mktg/logos-buttons/redesign/btn_10.png" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">
                <img src="images/paypal.png" alt="paypal" />
                <img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">

            </form>          

<!--            <div id="boton-mercado-pago" style="display: none">
                <a href="">
                    Pagar
                </a>
                <img src="images/mercado-pago.png" alt="Mercado Pago" />
            </div>-->

        </div>



        <div class="popup" id="ventana_mensaje">

            <p class="right" id="mensaje">5 letras</p>

            <a href="#5l" class="simplemodal-close">

                <img src="images/btn_aceptar.jpg" class="right boton" />

            </a>

        </div>    



        <div class="popup" id="condiciones_uso">

            <div class="right">

                <p>

                    ¿Como funcionan los tickets?

                </p>

                <p>

                    Es importante que antes de comprar tu ticket te asegures de leer las condiciones de uso, ya que, cada establecimiento maneja sus propias políticas y condiciones con respecto de los tickets. Las condiciones de uso del ticket aparecen al darle click en el botón que dice; "Más información". 

                </p>

                <p>            

                    Al pagar tu ticket deberás ingresar tu e-mail y una vez que nuestro sistema registre tu pago el ticket se enviará vía, mail. Este ticket deberás imprimirlo y presentarlo en el establecimiento correspondiente.

                </p>

                <p>            

                    RECUERDA:<br /><br />

                    Una vez que compraste tu ticket este tiene una vigencia de 30 días y se canjea directamente en el establecimiento correspondiente (funciona como un pase de entrada). <br /><br />          

                    Pagar tu Ticket en CincoLetras.Mx con tu Tarjeta de Crédito y  habrás  realizado una compra segura en internet, gracias a la protección que nos ofrece PayPay, Inc. <br /><br />         

                    Para más información de como comprar con seguridad <a style="display:inline;" href="https://www.paypal.com/mx/webapps/mpp/security/buy-index" target="_blank">clic aquí</a>.

                </p>          

                <p>            

                    ¿Cuanto tiempo tarda en acreditarse el dinero en la cuenta de <span style="font-weight:bold">PayPal</span>  una vez que

                    realizaste tu pago?

                </p>

                <p>            

                    - Una vez que realizaste tu <span style="font-weight:bold">Pago con tarjeta de crédito o debito</span>  es instantáneo. (absoluta discreción en tu estado de

                    cuenta)                                    

                </p>

            </div>

            <a href="#5l" class="simplemodal-close">

                <img src="images/btn_aceptar.jpg" class="right boton" />

            </a>

        </div>      



        <!--SCRIPTS-->

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

        <script type="text/javascript" src="scripts/jquery.lightbox-0.5.js"></script>

        <script type="text/javascript" src="scripts/jquery.scrollTo-1.4.2-min.js"></script>

        <script type="text/javascript" src="scripts/jquery.simplemodal.1.4.1.min.js"></script>

        <script type="text/javascript">

            var goto = 0;

            var msg = 0;

<?
if (isset($goto)){
    echo "goto=1;";
}
echo "var curl='" . $url . "';";

if (filter_input(INPUT_GET,'c')){
    $cupon_recibido = substr(filter_input(INPUT_GET,'c'), 1);
}

$y = filter_input(INPUT_GET,'d');
if($y){
    switch($y){
        case "o":
            compra_exitosa($dbh,$url,$cupon_recibido);
            break;
        case "e":
            echo "msg='La compra se ha cancelado';";
            $dbh->query("UPDATE `cupones` SET `comprado` = '0' WHERE `id_cupon` = '$cupon_recibido'");            
            break;
        case "p":
            echo "msg='Gracias por su preferencia. Su compra está en proceso. Cuando realize su pago por favor entre en la sección de contacto, denos su numero de cupón y orden de pago y recibirá su cupón en su correo. Recuerda realizar tu pago dentro de los siguientes 2 días, después de estos días tu cupón será puesto de nuevo a la venta y deberás realizar tu compra de nuevo.';";
            break;        
    }
}
?>

        </script>

        <script type="text/javascript" src="scripts/cincoletras.js"></script>    

        <script type="text/javascript">

            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments);
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m);
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-59908591-1', 'auto');
            ga('send', 'pageview');

        </script>

        <!--        Facebook piel code-->
        <script>(function() {
                var _fbq = window._fbq || (window._fbq = []);
                if (!_fbq.loaded) {
                    var fbds = document.createElement('script');
                    fbds.async = true;
                    fbds.src = '//connect.facebook.net/en_US/fbds.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(fbds, s);
                    _fbq.loaded = true;
                }
                _fbq.push(['addPixelId', '870816666298429']);
            })();
            window._fbq = window._fbq || [];
            window._fbq.push(['track', 'PixelInitialized', {}]);
        </script>
        <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=870816666298429&amp;ev=PixelInitialized" /></noscript>

    </body>

</html>