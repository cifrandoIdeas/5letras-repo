<table><tr height="10"></tr><td bgcolor="#0b5b67" height="8" width="1000"></td><tr height="240"><td style="background-color:#191919; text-align:center;">
<center><br /><span class="titmot">+ MOTELES</span> EN GUADALAJARA
<script type="text/javascript">
/***********************************************
* Scrollable Menu Links- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* Visit http://www.dynamicDrive.com for hundreds of DHTML scripts
* This notice must stay intact for legal use
***********************************************/

//configure path for left and right arrows
var goleftimage='assets/flechaizq.jpg'
var gorightimage='assets/flechader.jpg'
//configure menu width (in px):
var menuwidth=721
//configure menu height (in px):
var menuheight=125
//Specify scroll buttons directions ("normal" or "reverse"):
var scrolldir="reverse"
//configure scroll speed (1-10), where larger is faster
var scrollspeed=7

//specify menu content
var menucontents=
<?php
if(strpos($_SERVER['PHP_SELF'],"infomotel")===FALSE)
	{
	if(!$dbh) conn();
	}
		echo "'<nobr>";
		$qry=mysql_query("select * from moteles order by rand()");

		while($moteles=mysql_fetch_array($qry)){
		echo "<a href=\"infomotel.php?m=".$moteles['idmotel']."\"><img src=\"fotos/mnu/".$moteles['idmotel'].".jpg\" style=\"border-width:medium; border-color:#CCC\"></a> ";
		}
		echo "</nobr>'";
		mysql_close();
		?>

////NO NEED TO EDIT BELOW THIS LINE////////////
var iedom=document.all||document.getElementById
var leftdircode='onMouseover="moveleft()" onMouseout="clearTimeout(lefttime)"'
var rightdircode='onMouseover="moveright()" onMouseout="clearTimeout(righttime)"'
if (scrolldir=="reverse"){
var tempswap=leftdircode
leftdircode=rightdircode
rightdircode=tempswap
}
if (iedom)
document.write('<span id="temp" style="visibility:hidden;position:absolute;top:-100;left:-5000">'+menucontents+'</span>')
var actualwidth=''
var cross_scroll, ns_scroll
var loadedyes=0
function fillup(){
if (iedom){
cross_scroll=document.getElementById? document.getElementById("test2") : document.all.test2
cross_scroll.innerHTML=menucontents
actualwidth=document.all? cross_scroll.offsetWidth : document.getElementById("temp").offsetWidth
}
else if (document.layers){
ns_scroll=document.ns_scrollmenu.document.ns_scrollmenu2
ns_scroll.document.write(menucontents)
ns_scroll.document.close()
actualwidth=ns_scroll.document.width
}
loadedyes=1
}
window.onload=fillup

function moveleft(){
if (loadedyes){
if (iedom&&parseInt(cross_scroll.style.left)>(menuwidth-actualwidth)){
cross_scroll.style.left=parseInt(cross_scroll.style.left)-scrollspeed+"px"
}
else if (document.layers&&ns_scroll.left>(menuwidth-actualwidth))
ns_scroll.left-=scrollspeed
}
lefttime=setTimeout("moveleft()",50)
}

function moveright(){
if (loadedyes){
if (iedom&&parseInt(cross_scroll.style.left)<0)
cross_scroll.style.left=parseInt(cross_scroll.style.left)+scrollspeed+"px"
else if (document.layers&&ns_scroll.left<0)
ns_scroll.left+=scrollspeed
}
righttime=setTimeout("moveright()",50)
}
if (iedom||document.layers){
	with (document){
		write('<table border="0" cellspacing="0" cellpadding="2">')
		write('<tr><td valign="middle" width="32" align="left"><a href="#" '+leftdircode+'><img src="'+goleftimage+'"border=0></a> </td>')
		write('<td width="'+menuwidth+'px" valign="bottom" >')
	if (iedom){
	write('<div style="position:relative;width:'+menuwidth+'px;height:'+menuheight+'px;overflow:hidden;">')
	write('<div id="test2" style="position:absolute;left:0;top:0">')
	write('</div></div>')
}
else if (document.layers){
	write('<ilayer width='+menuwidth+' height='+menuheight+' name="ns_scrollmenu">')
	write('<layer name="ns_scrollmenu2" left=0 top=0></layer></ilayer>')
}
	write('</td>')
	write('<td valign="middle" width="32"> <a href="#" '+rightdircode+'>')
	write('<img src="'+gorightimage+'"border=0></a>')
	write('</td></tr></table>')
}
}
</script>
</center>
<br />
<img src="assets/menuinf.jpg" usemap="#Map" style="border:none" />
</td></tr></table>

</center>

<map name="Map" id="Map">
  <area shape="rect" coords="39,9,130,36" href="masnuevo.php" alt="Lo m&aacute;s nuevo" />
  <area shape="rect" coords="208,13,279,34" href="masvisto.php" alt="Lo m&aacute;s visto" />
  <area shape="rect" coords="370,12,437,35" href="promociones.php" alt="Promo" />
  <area shape="rect" coords="674,13,743,33" href="contacto.php" alt="Contacto" />
</map>