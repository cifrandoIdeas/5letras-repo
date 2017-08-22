<?php
include "header.php";

//conexion base de datos
conn();
$m=intval($_GET['m']);
$qry=mysql_query("select * from moteles where idmotel=".$m);
$mot=mysql_fetch_assoc($qry);
?>

<meta property="og:title" content="<?php echo utf8_encode($mot['nombre']); ?>" /> 
<meta property="og:description" content="<?php echo utf8_encode($mot['descripcion']);?>" /> 
<meta property="og:image" content="<?php echo 'http://'.$_SERVER['SERVER_NAME'] . '/fotos/main/' . $mot['idmotel']; ?>.jpg" />   
<meta property="og:type" content="hotel" />
    
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="script/jquery.lightbox-0.5.js"></script>


<script type="text/javascript">
$(function() {
	$('.galerias').lightBox();
});

//funcion de javascript para compartir galerias en facebook
function sharefb()
	{
	url=location.href;
	url=encodeURIComponent(url);
	window.open('http://www.facebook.com/sharer.php?u=' + url + '&t=<?php echo urlencode($mot['nombre'] . " :: Cinco Letras, La guía de moteles en Guadalajara");?>','Facebook','width=600,height=400');
	}
	
//js para comaprtir en twitter
function sharetwitter()
	{
	u=location.href;
	t='<?php echo "Cinco Letras, La guía de moteles en Guadalajara :: Motel " . $mot['nombre'];?>';
	window.open('http://twitter.com/share?url='+encodeURIComponent(u)+'&text='+encodeURIComponent(t),'Twitter','toolbar=0,status=0,width=626,height=436');
	return false;
	}

</script>

<?php
include "ganalytics.php";
?>

</head>

<body>
<center>

<table style="width:1000px;" cellpadding="0" cellspacing="0"><tr><td style="background-image:url(assets/logo.jpg); height:130px; vertical-align:middle; text-align:left">

<?php
include "menu.php";
?>

</td></tr>

<tr><td style="background-image:url(assets/fondoinf.jpg); background-repeat:no-repeat; background-position:top">
<center>
<table border="0" cellpadding="0" cellspacing="0" width="958"><tr>
  <td>
  
  <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="620" height="390" id="video" align="middle">
				<param name="movie" value="video.swf?nombre=<?php echo $mot['idmotel']; ?>" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="play" value="true" />
				<param name="loop" value="true" />
				<param name="wmode" value="transparent" />
				<param name="scale" value="showall" />
				<param name="menu" value="true" />
				<param name="devicefont" value="false" />
				<param name="salign" value="" />
				<param name="allowScriptAccess" value="sameDomain" />
				<!--[if !IE]>-->
				<object type="application/x-shockwave-flash" data="video.swf?nombre=<?php echo $mot['idmotel']; ?>" width="620" height="390">
					<param name="movie" value="video.swf?nombre=<?php echo $mot['idmotel']; ?>" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#ffffff" />
					<param name="play" value="true" />
					<param name="loop" value="true" />
					<param name="wmode" value="transparent" />
					<param name="scale" value="showall" />
					<param name="menu" value="true" />
					<param name="devicefont" value="false" />
					<param name="salign" value="" />
					<param name="allowScriptAccess" value="sameDomain" />
				<!--<![endif]-->
					<a href="http://www.adobe.com/go/getflash">
						<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
					</a>
				<!--[if !IE]>-->
				</object>
				<!--<![endif]-->
			</object>

<br /><br />
<div style="text-align:left">
<span class="titmot"><?php echo utf8_encode(strtoupper($mot['nombre'])); ?></span>
  
  <div id="social">
	<a href="javascript:sharefb()">
  		<img src="assets/fb.png" />
  	</a>
  
  	<a href="javascript:sharetwitter()">
  		<img src="assets/tw.png" />
	</a>
    
  </div>
  
  <hr width="621"  noshade="noshade" />
  <?php echo utf8_encode(nl2br($mot['descripcion'])); ?>
  
  </div>
  <br />

    
  <table style="width:621px">
  <tr>
  <?
	for($i="a";$i<="i";$i++){
		echo "<td class=\"mbanner thumbs\">\n";
		if(file_exists("fotos/thumbs/".$mot['idmotel'].$i.".jpg")){
			echo "	<a href=\"fotos/gde/".$mot['idmotel'].$i.".jpg\" id=\"".$mot['idmotel'].$i."\" class='galerias'>
						<img src=\"fotos/thumbs/".$mot['idmotel'].$i.".jpg\" />
					</a>\n";
/*			echo "<div id=\"".$i."\"><img src=\"fotos/gde/".$mot['idmotel'].$i.".jpg\" alt=\"".$mot['nombre']."\" />\n";
			echo "<script type=\"text/javascript\">\n";
			echo "$('#".$mot['idmotel'].$i."').fancyZoom();\n";
			echo "</script></div>\n";*/
			
		}
		echo "</td>";
		if($i=="c" || $i=="f")
			echo "</tr><tr>";
	}
	?>
    </tr>
      
  </table>
  </td>
  <td style="text-align:center">
  
  <table border="0" cellpadding="0" cellspacing="5"><tr><td class="mbanner mban2 banner"><a href="http://www.juevesdewings.com/" target="_blank"><img src="assets/bannerwings.jpg" /></a></td></tr>
  <tr><td class="mbanner mban2 banner"><img src="assets/banner_abajo.jpg" /></td></tr>
   <tr><td class="mbanner mapa">

<iframe width="308" height="379" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $mot['mapa']; ?>"></iframe>
   
   
   </td></tr>
  </table></td></tr></table></center>
</td></tr>
</table>

<?php
include "reel.php";
?>

</body>
</html>