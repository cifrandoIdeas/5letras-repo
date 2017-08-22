<?php

include "lib.php";

$result=mysql_query("SELECT * FROM `cupones` WHERE `comprado` = -1");
$cambio=0;
  while($arr=mysql_fetch_assoc($result))
		  {
			if(strstr($arr['fecha_venc'],"-")!=FALSE)
				{
				$fecha=explode("-",$arr['fecha_venc']);
				if(mktime(0, 0, 0, $fecha[1],$fecha[2],$fecha[0]) < mktime(date("G") - 2, 0, 0,date("m"),date("d"),date("Y"))) $cambio=1;				
				}
			else
				{
				$fecha=(int)$arr['fecha_venc'];
				if($fecha < mktime(date("H") - 2, 0, 0, date("m"), date("d"),   date("Y"))) $cambio=1;
				}
			if($cambio)
			mysql_query("UPDATE `cupones` SET `comprado` = '0', fecha_venc = '', correo_usuario = '' WHERE `id_cupon` = '" . $arr['id_cupon'] . "'");			
		  }		  
?>