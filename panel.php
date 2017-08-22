<?php
session_start();
include "scripts/lib.php";
setlocale(LC_TIME, "es_MX");

if (isset($_GET['salir'])) {
    session_unset();
}

//usuarios
if (isset($_POST['user'])) {
    $usuario = mysql_real_escape_string($_POST['user']);

    if ($usuario != "admin147") {
        $result = mysql_query("SELECT * FROM moteles2 WHERE pass LIKE '$usuario'");
        if (!mysql_num_rows($result)) {
            header('Location: panel.php?mensaje=' . urlencode("Usuario no existe"));
        } else {
            $arr = mysql_fetch_assoc($result);
            $_SESSION['usuario'] = $usuario;
            $_SESSION['tipo'] = "user";
            $_SESSION['motel'] = $arr['id_motel'];
            $tipo = "user";
            $motel = $arr['id_motel'];
        }
    } else {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo'] = "admin";
        $tipo = "admin";
    }
} else {
    if (isset($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
        $tipo = $_SESSION['tipo'];
        if (isset($_SESSION['motel']))
            $motel = $_SESSION['motel'];
    }
}

$mensaje = "";

if (isset($_POST['condiciones'])) {
    $id_motel = $_POST['select_motel'];
    $sencillas = $_POST['num_sencilla'];
    $precio_sencillas = $_POST['precio_sencilla'];
    $jacuzzi = $_POST['num_jacuzzi'];
    $precio_jacuzzi = $_POST['precio_jacuzzi'];

    $premium = $_POST['num_premium'];
    $precio_premium = $_POST['precio_premium'];
    $dobles = $_POST['num_doble'];
    $precio_dobles = $_POST['precio_doble'];

    $condiciones = $_POST['condiciones'];
    $facturacion = $_POST['mes'] . "-" . $_POST['year'];

    if (is_numeric($sencillas)) {
        for ($x = 0; $x < $sencillas; $x++) {
            do {
                $id_cupon = randomString(5);
            } while (!mysql_query("INSERT INTO `cupones` (`id_cupon`, `id_motel`, `tipo`, `condiciones_uso`, `facturacion`, `precio`) 
							VALUES ('$id_cupon', '$id_motel', 'sencilla', '$condiciones','$facturacion','$precio_sencillas');"));
        }
    }

    if (is_numeric($jacuzzi)) {
        for ($x = 0; $x < $jacuzzi; $x++) {
            $id_cupon = randomString(5);
            mysql_query("INSERT INTO `cupones` (`id_cupon`, `id_motel`, `tipo`, `condiciones_uso`, `facturacion`, `precio`) 
							VALUES ('$id_cupon', '$id_motel', 'jacuzzi', '$condiciones','$facturacion','$precio_jacuzzi');");
        }
    }


    if (is_numeric($premium)) {
        for ($x = 0; $x < $premium; $x++) {
            do {
                $id_cupon = randomString(5);
            } while (!mysql_query("INSERT INTO `cupones` (`id_cupon`, `id_motel`, `tipo`, `condiciones_uso`, `facturacion`, `precio`) 
							VALUES ('$id_cupon', '$id_motel', 'premium', '$condiciones','$facturacion','$precio_premium');"));
        }
    }

    if (is_numeric($dobles)) {
        for ($x = 0; $x < $dobles; $x++) {
            $id_cupon = randomString(5);
            mysql_query("INSERT INTO `cupones` (`id_cupon`, `id_motel`, `tipo`, `condiciones_uso`, `facturacion`, `precio`) 
							VALUES ('$id_cupon', '$id_motel', 'doble', '$condiciones','$facturacion','$precio_dobles');");
        }
    }

    $mensaje = "Cupones creados";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Panel de control :: CincoLetras.Mx</title>

        <meta name="keywords" content="Moteles, Guadalajara, Hoteles, Hospedaje, renta de cuartos, Alojamiento, estancia, habitaciones, motelazo, motelaso" />
        <meta name="title" content=":: Cinco Letras :: La guia de moteles en Guadalajara"/>
        <meta name="description" content="La guia de moteles en Guadalajara. Encuentra los mejores moteles con los precios mas accesibles en Cinco Letras"/>

        <link rel="image_src" href="images/cincoletras_logo.jpg" />

        <link rel="stylesheet" href="css/reset.css" type="text/css" />
        <link rel="stylesheet" href="css/panel.css" type="text/css" />

        <style type="text/css">
<?php
if ($tipo == "user") {
    echo '.elemento a.eliminar{
                    display: none;
                    }';
}
?>
        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {

                $("#crear_cupones form").submit(function() {
                    var x = 0;
                    $(":input", this).each(function() {
                        if ((($(this).val() == "") || ($(this).val() == "-1")) && ($(this).attr("type") != "submit"))
                        {
                            alert("Debes llenar o seleccionar todos los campos" + $(this).attr("name"));
                            x = 1;
                            return false;
                        }
                    });

                    if (x == 1)
                        return false;
                });

                $("#crear").click(function() {
                    if (!$("#crear_cupones").is(":visible"))
                    {
                        $(".secciones_panel").hide();
                        $("#imprimir").hide();
                        $("#crear_cupones").fadeIn(500);
                    }
                });

                $("#editar").click(function() {
                    if (!$("#editar_cupones").is(":visible"))
                    {
                        $(".secciones_panel").hide();
                        $("#resultados").empty();
                        $("#editar_cupones").fadeIn(500);
                        $("#imprimir").fadeIn(500);
                    }
                });

                $("#filtros").submit(function() {
                    $.post("scripts/cupones.php", {
                        mes: $("#mes_f").val(),
                        year: $("#year_f").val(),
                        motel: $("#id_motel").val(),
                        tipo: $("#tipo").val(),
                        checked: $("#checked_in").val(),
                        comprado: $("#comprado").val(),
                        usuario: '<?php echo $tipo; ?>',
                        id_cupon: $("#id_cupon").val()
                    }, function(data) {
                        if (data == "0")
                            alert("Ha ocurrido un error");
                        else
                        {
                            if (data == "")
                                alert("No hay resultados");
                            $("#resultados").replaceWith('<div id="resultados">' + data + '</div>');
                            if ($("#cupones").height() > $("#contenido").height())
                                $("#contenido").height($("#cupones").height());
                        }
                    });
                    return false;
                });

                $(".check_in").live('click', function() {
                    $.post("scripts/cupones.php", {
                        mes: $("#mes_f").val(),
                        year: $("#year_f").val(),
                        motel: $("#id_motel").val(),
                        tipo: $("#tipo").val(),
                        checked: $("#checked_in").val(),
                        comprado: $("#comprado").val(),
                        id_cupon: $("#id_cupon").val(),
                        usuario: '<?php echo $tipo; ?>',
                        cupon: $(this).attr('title'),
                        accion: "check_in"}, function(data) {
                        if (data == "0")
                            alert("Hubo un error, intenta de nuevo");
                        else {
                            if (data == "")
                                alert("No hay resultados");
                            $("#resultados").replaceWith('<div id="resultados">' + data + '</div>');
                            if ($("#cupones").height() > $("#contenido").height())
                                $("#contenido").height($("#cupones").height());
                        }
                    });
                });

                $(".uncheck_in").live('click', function() {
                    $.post("scripts/cupones.php", {
                        mes: $("#mes_f").val(),
                        year: $("#year_f").val(),
                        motel: $("#id_motel").val(),
                        tipo: $("#tipo").val(),
                        checked: $("#checked_in").val(),
                        comprado: $("#comprado").val(),
                        id_cupon: $("#id_cupon").val(),
                        usuario: '<?php echo $tipo; ?>',
                        cupon: $(this).attr('title'),
                        accion: "uncheck_in"}, function(data) {
                        if (data == "0")
                            alert("Hubo un error, intenta de nuevo");
                        else {
                            if (data == "")
                                alert("No hay resultados");
                            $("#resultados").replaceWith('<div id="resultados">' + data + '</div>');
                            if ($("#cupones").height() > $("#contenido").height())
                                $("#contenido").height($("#cupones").height());
                        }
                    });
                });

                $(".eliminar").live('click', function() {
                    if (confirm("Esta seguro que desea eliminar este cupon?"))
                    {
                        $.post("scripts/cupones.php",
                                {
                                    mes: $("#mes_f").val(),
                                    year: $("#year_f").val(),
                                    motel: $("#id_motel").val(),
                                    tipo: $("#tipo").val(),
                                    checked: $("#checked_in").val(),
                                    comprado: $("#comprado").val(),
                                    id_cupon: $("#id_cupon").val(),
                                    usuario: '<?php echo $tipo; ?>',
                                    cupon: $(this).attr('title'),
                                    accion: "eliminar"
                                },
                        function(data) {
                            if (data == "0")
                                alert("Hubo un error, intenta de nuevo");
                            else
                            {
                                if (data == "")
                                    alert("No hay resultados");
                                $("#resultados").replaceWith('<div id="resultados">' + data + '</div>');
                                if ($("#cupones").height() > $("#contenido").height())
                                    $("#contenido").height($("#cupones").height());
                            }
                        });
                    }
                });

                $(".pagar").live('click', function() {
                    if (($(".correo_usuario_text", $(this).parent()).val() == "") || (!IsValidEmail($(".correo_usuario_text", $(this).parent()).val())))
                    {
                        alert("Debes ingresar un correo válido antes de pagar");
                        return false;
                    }
                    if (confirm("Este cupon se marcará como pagado, estas seguro?"))
                    {
                        $.post("scripts/cupones.php",
                                {
                                    mes: $("#mes_f").val(),
                                    year: $("#year_f").val(),
                                    motel: $("#id_motel").val(),
                                    tipo: $("#tipo").val(),
                                    checked: $("#checked_in").val(),
                                    comprado: $("#comprado").val(),
                                    id_cupon: $("#id_cupon").val(),
                                    usuario: '<?php echo $tipo; ?>',
                                    cupon: $(this).attr('title'),
                                    correo_user: $(".correo_usuario_text", $(this).parent()).val(),
                                    accion: "pagar"
                                },
                        function(data) {
                            if (data == "0")
                                alert("Hubo un error, intenta de nuevo");
                            else
                            {
                                if (data == "")
                                    alert("No hay resultados");
                                $("#resultados").replaceWith('<div id="resultados">' + data + '</div>');
                                if ($("#cupones").height() > $("#contenido").height())
                                    $("#contenido").height($("#cupones").height());
                            }
                        });
                    }
                });


                $(".descuento").live('click', function() {
                    if (confirm("Esta seguro que desea cambiar el descuento?"))
                    {
                        $.post("scripts/cupones.php",
                                {
                                    mes: $("#mes_f").val(),
                                    year: $("#year_f").val(),
                                    motel: $("#id_motel").val(),
                                    tipo: $("#tipo").val(),
                                    checked: $("#checked_in").val(),
                                    comprado: $("#comprado").val(),
                                    id_cupon: $("#id_cupon").val(),
                                    usuario: '<?php echo $tipo; ?>',
                                    cupon: $(this).attr('title'),
                                    descuento_cupon: $(".descuento_cupon", $(this).parent()).val(),
                                    accion: "descuento"
                                },
                        function(data) {
                            if (data == "0")
                                alert("Hubo un error, intenta de nuevo");
                            else
                            {
                                if (data == "")
                                    alert("No hay resultados");
                                $("#resultados").replaceWith('<div id="resultados">' + data + '</div>');
                                if ($("#cupones").height() > $("#contenido").height())
                                    $("#contenido").height($("#cupones").height());
                            }
                        });
                    }
                });

                $("#imprimir_btn").click(function(e) {
                    e.preventDefault();
                    if ($("#resultados").is(":empty"))
                        alert("No hay resultados a imprimir");
                    else
                    {
                        alert("Imprimiendo");
                        window.print();
                    }
                });

<?php
if ($mensaje != "") {
    echo 'alert("' . $mensaje . '");';
}
if ($tipo == "user") {
    echo '$("#editar").trigger("click");';
}
?>

            });

            function IsValidEmail(email)
            {
                var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                return filter.test(email);
            }
        </script>

    </head>

    <body>

        <div id="contenido">
            <div id="menu">
                <?php
                if (isset($usuario)) {
                    ?>
                    <ul>
                        <?php
                        if ($tipo == "admin") {
                            ?>
                            <li>
                                <a href="#5l" title="Crear" id="crear">
                                    Crear cupones
                                </a>
                            </li>
                        <?php }
                        ?>
                        <li>
                            <a href="#5l" title="Editar Cupones" id="editar">
                                Editar cupones
                            </a>
                        </li>
                        <li>
                            <a href="panel.php?salir=1" id="salir_btn">
                                Salir
                            </a>
                        </li>                        
                    </ul>
                <?php }
                ?>
            </div>

            <?php
            if (isset($usuario)) {
                ?>
                <div id="cupones">
                    <div id="crear_cupones" class="secciones_panel">
                        <h1>Crear cupones</h1>
                        <form method="post" action="panel.php">
                            <label>
                                Motel:
                            </label>

                            <select id="select_motel" name="select_motel" class="txt">
                                <option value="-1">Selecciona motel</option>
                                <?php
                                $result = mysql_query("SELECT * FROM `moteles`");
                                while ($arr = mysql_fetch_assoc($result)) {
                                    echo '<option value="' . $arr['idmotel'] . '">' . $arr['nombre'] . '</option>';
                                }
                                ?>
                            </select>

                            <label>
                                <span>Mes:</span>
                                <select id="mes" name="mes" class="txt">
                                    <option value="-1">Selecciona Mes...</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>                            
                                    <option value="09">Septiembre</option>                            
                                    <option value="10">Octubre</option>                            
                                    <option value="11">Noviembre</option>                            
                                    <option value="12">Dicimebre</option>                            
                                </select>
                            </label>                      

                            <label>
                                A&ntilde;o:
                            </label>
                            <select id="year" name="year" class="txt">
                                <option value="-1">Selecciona a&ntilde;o</option>
                                <?php
                                for ($x = 2011; $x <= 2020; $x++) {
                                    echo '<option value="' . $x . '">' . $x . '</option>';
                                }
                                ?>
                            </select>                    

                            <p>
                                Selecciona el n&uacute;mero de cupones por tipo:
                            </p>

                            <label>
                                <span>Habitaciones sencillas:</span>
                                <input type="text" name="num_sencilla" value="0" />
                            </label>   

                            <label>
                                <span>Precio:</span>
                                <input type="text" name="precio_sencilla" value="0" />
                            </label>                                                           

                            <label>
                                <span>Habitaciones con Jacuzzi:</span>
                                <input type="text" name="num_jacuzzi" value="0" />
                            </label>   

                            <label>
                                <span>Precio:</span>
                                <input type="text" name="precio_jacuzzi" value="0" />
                            </label>                                                           


                            <label>
                                <span>Habitaci&oacute;n Premium:</span>
                                <input type="text" name="num_premium" value="0" />
                            </label>                                        

                            <label>
                                <span>Precio:</span>
                                <input type="text" name="precio_premium" value="0" />
                            </label>   

                            <label>
                                <span>Habitaci&oacute;n Doble:</span>
                                <input type="text" name="num_doble" value="0" />
                            </label>                                        

                            <label>
                                <span>Precio:</span>
                                <input type="text" name="precio_doble" value="0" />
                            </label>                          

                            <label>
                                Condiciones de uso:
                            </label>
                            <textarea name="condiciones" class="txt"></textarea>

                            <input type="submit" value="Crear" />                       
                        </form>
                    </div>

                    <div id="editar_cupones" class="secciones_panel">
                        <h1>Editar cupones</h1>
                        <form id="filtros" name="filtros" method="post">

                            <label>
                                <span>
                                    ID cupon:
                                </span>
                                <input type="text" name="id_cupon" id="id_cupon" class="txt2" />                   
                            </label>                

                            <label>
                                <span>
                                    Motel:
                                </span>
                                <?php
                                if ($tipo == "admin") {
                                    ?>                                
                                    <select id="id_motel" name="id_motel" class="txt2">
                                        <option value="-1">Cualquiera</option>
                                        <?php
                                        $result = mysql_query("SELECT * FROM `moteles`");
                                        while ($arr = mysql_fetch_assoc($result)) {
                                            echo '<option value="' . $arr['idmotel'] . '">' . $arr['nombre'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <?php
                                } else {
                                    $result = mysql_query("SELECT * FROM `moteles` WHERE idmotel = $motel");
                                    while ($arr = mysql_fetch_assoc($result)) {
                                        echo '
                                            <span id="motel_user">' . $arr['nombre'] . '</span>
                                            <input type="hidden" id="id_motel" name="id_motel" value="' . $arr['idmotel'] . '"/>';
                                    }
                                }
                                ?>                                
                            </label>

                            <label>
                                <span>
                                    Tipo:
                                </span>
                                <select name="tipo" id="tipo" class="txt2">
                                    <option value="-1">Cualquiera</option>
                                    <option value="sencilla">Sencilla</option>
                                    <option value="jacuzzi">Con Jacuzzi</option>          
                                    <option value="premium">Premium</option>
                                    <option value="doble">Doble</option>                                                    
                                </select>
                            </label>

                            <label>
                                <span>
                                    Resgitrado:
                                </span>                    
                                <select name="checked_in" id="checked_in" class="txt2">
                                    <option value="-1">Cualquiera</option>
                                    <option value="0">No resgistrado</option>
                                    <option value="1">Registrado</option>                            
                                </select>
                            </label>

                            <label>
                                <span>
                                    En venta:
                                </span>                    
                                <select name="comprado" id="comprado" class="txt2">
                                    <option value="-1">Cualquiera</option>
                                    <option value="0">No vendido</option>
                                    <option value="2">Pendiente</option> 
                                    <option value="1">Vendido</option>                            
                                </select>
                            </label>  

                            <label>
                                <span>Mes:</span>
                                <select id="mes_f" name="mes_f" class="txt2">
                                    <option value="-1">Cualquiera</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>                            
                                    <option value="09">Septiembre</option>                            
                                    <option value="10">Octubre</option>                            
                                    <option value="11">Noviembre</option>                            
                                    <option value="12">Dicimebre</option>                            
                                </select>
                            </label>                      

                            <label>
                                A&ntilde;o:
                            </label>
                            <select id="year_f" name="year_f" class="txt2">
                                <option value="-1">Cualquiera</option>
                                <?php
                                for ($x = 2011; $x <= 2020; $x++) {
                                    echo '<option value="' . $x . '">' . $x . '</option>';
                                }
                                ?>
                            </select>                          

                            <input type="submit" value="filtrar"  />
                        </form>
                        <div id="imprimir">
                            <a href="panel.php" id="imprimir_btn">
                                Imprimir resultados
                            </a>
                        </div>
                        <div id="resultados"></div>
                    </div>        
                </div>
                <?php
            } else {
                ?>
                <form id="auth" action="panel.php" method="post">
                    <h1>
                        Panel :: Cincoletras.mx
                    </h1>            
                    <label>
                        Introduce tu clave de usuario:
                    </label>
                    <input type="password" name="user" value="" class="txt" />
                    <input type="submit" value="Ingresar" />
                </form>
                <?php
            }
            ?>
        </div>
    </body>
</html>