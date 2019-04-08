<?php
if (!isset($_GET['id']))
    header("location: index.php");

include "scripts/lib.php";
$id_cupon = $dbh->real_escape_string(substr($_GET['id'], 1));

$query = "SELECT * FROM cupones,moteles WHERE cupones.id_motel = moteles.idmotel AND id_cupon = '" . $id_cupon . "'";

$res = $dbh->query($query);
$arr = $res->fetch_assoc();

if ($arr['comprado'] != "1" || $arr['checked_in'] == "1") {

//    header("location: index.php");
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>:: Cincoletras.mx :: Cupones</title>
        <style type="text/css">
            html{
                font-family: Arial;
                font-size: 11px;
                line-height: 14px;                   
            }
            a{
                font-size: 12px;
                display: block;
                float: left;
                width: 100%;
                text-decoration: none;
                margin: 20px 0;
            }
            div{
                float: left;             
            }
            #cupon{
                width: 600px;
                height: 382px;
                padding-top: 80px;
                position: relative;
            }
            #cupon div{
                position: relative;
                z-index: 100;
            }
            #img_cupon{
                position: absolute;
                top:0;
                left: 0;
                z-index: 0;
            }
            #first{
                margin-left: 22px;    
            }
            #first p{
                font-size: 14px;
            }
            #last{
                margin: 84px 0 0 13px;
                max-height: 80px;
            }
            .leftdivs{
                width: 280px;
            }
            #monto{
                font-weight: bold;
                margin: 21px 0 0 145px;
            }
            #codigo{
                font-weight: bold;
                margin: 15px 0 0 95px;                
            }
            #fecha{
                margin: 11px 0 0 75px;
            }
            .right{
                float: right;
            }
            img{
                border: none;
            }
            @media print {
                a {
                    display: none;
                }
            }               
        </style>    
    </head>
    <body>
        <a href="javascript:print()">
            <img src="images/print.jpg" />
            Imprimir este cupon
        </a>

        <div id="cupon">        
            <div class="leftdivs" id="first">
                <p>
                    <?php
                    echo $arr['nombre'];
                    ?>
                </p>
                <p>
                    Tipo: 
                    <?php
                    echo $arr['tipo'];
                    ?> 
                </p>
                <p id="monto">                
                    <?php
                    echo $arr['precio'];
                    ?>.00                
                </p>
                <p id="codigo">                
                    <?php
                    echo $arr['id_cupon'];
                    ?>               
                </p>   
                <p id="fecha">                
                    <?php
                    if (strpos($arr['fecha_venc'], "-") === false && trim($arr['fecha_venc']) != '' ) {
                        $arr['fecha_venc'] = date("Y-m-d", $arr['fecha_venc']);
                    }
                    if(strpos($arr['fecha_venc'], "-") !== false) {
                        $f = explode("-", $arr['fecha_venc']);
                        echo $f[2] . "/" . $f[1] . "/" . $f[0];
                    }
                    ?>                
                </p>             
            </div>
            <div class="leftdivs">
                <?php
                $urlToEncode = $arr['id_cupon'];
                generateQRwithGoogle($urlToEncode);

                function generateQRwithGoogle($chl, $widhtHeight = '150', $EC_level = 'L', $margin = '0') {
                    echo '<img src="http://chart.apis.google.com/chart?chs=' . $widhtHeight .
                    'x' . $widhtHeight . '&cht=qr&chld=' . $EC_level . '|' . $margin .
                    '&chl=' . $chl . '" alt="QR code" widhtHeight="' . $widhtHeight .
                    '" widhtHeight="' . $widhtHeight . '" class="right"/>';
                }
                ?>                        
            </div>
            <img src="images/cupon.jpg" id="img_cupon" class="right" />
            <div id="last">
                <p>                
                    <?php
                    echo $arr['condiciones_uso'];
                    ?>              
                </p>                 
            </div>

        </div>

    </body>
</html>