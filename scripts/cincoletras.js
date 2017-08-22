// JavaScript Document

var cupon;
var precio;
var motel;

$(document).ready(function(){
	$('.galerias').lightBox();
	
	$("a").click(function(e){
		if($(this).attr("href").search("#5l")!=-1)			
			e.preventDefault();				  
		});	
	
	$("#fcontacto").submit(function(e){
		var x=0;
		$(":input",this).each(function(){
			if((($(this).val()=="")||($(this).val()=="Nombre")||($(this).val()=="Email")||($(this).val()=="Escribe tu mensaje"))&&($(this).attr("type")!="image"))
				{
                                $("#mensaje").html("<span style='display: block;font-size: 16px;margin: 70px 0 0 30px;'> Debes llenar todos los campos </span>");
                                ventana("#ventana_mensaje");                                     
				x=1;
				return false;
				}
			if($(this).attr("name")=="email")
				{
				if(!IsValidEmail($(this).val()))
					{
                    $("#mensaje").html("<span style='display: block;font-size: 16px;margin: 70px 0 0 30px;'> Debes ingresar un correo valido </span>");
                    ventana("#ventana_mensaje");                                            	
					x=1;
					return false;
					}
				}
			});
		
		if(x==1) return false;								 
		});	
	
	if(goto==1) $.scrollTo("#comofunciona",0);
	
	$(".btn_comprar").click(function(e){
		e.preventDefault();	
		ventana("#correo_mail");
                cupon=$(this).attr("id");
                precio=$(".precio span",$(this).parent().parent()).text().replace(/^\s+|\s+$/g,"").substr(1) + ".00";
                motel=$("h3",$(this).parent().parent()).text();                
                $('input[name="ok_url"]').val(curl +"index.php?seccion=home&d=o&c=" + cupon);
                $('input[name="error_url"]').val(curl + "index.php?seccion=home&d=e&c=" + cupon);
                $('input[name="pending_url"]').val(curl + "index.php?seccion=home&d=p&c=" + cupon);
                $('input[name="item_name_1"]').val("Ticket CincoLetras.mx :: Motel "+ motel + " - Cupon " + cupon);
                $('input[name="item_code_1"]').val(cupon);
                $('input[name="item_ammount_1"]').val(precio);
				
                $('input[name="return"]').val(curl +"index.php?seccion=home&d=o&c=" + cupon);
                $('input[name="cancel_return"]').val(curl + "index.php?seccion=home&d=e&c=" + cupon);
                $('input[name="item_name"]').val("Ticket CincoLetras.mx :: Motel "+ motel + " - Cupon " + cupon);
                $('input[name="item_number"]').val(cupon);
                $('input[name="amount"]').val(precio); 	
                
                //Aqui se mandara el codigo para mercado pago
                
		});

	$("#tipo_pago").change(function(){
		if($(this).val()=="0") $("#forma_dineromail, #forma_paypal").hide();
		if($(this).val()=="paypal") 
			{
			$("#forma_dineromail").hide();
			$("#forma_paypal").show();
			}
		if($(this).val()=="dineromail") 
			{
			$("#forma_dineromail").show();
			$("#forma_paypal").hide();
			}
		});
	
	$("#tipo_pago").click(function(){
		$(this).change();						   
		});

	$("#nombre_c").focus(function(){
		if($(this).val()=="Nombre") $(this).val("");
		});
	
	$("#email_c").focus(function(){
		if($(this).val()=="Email") $(this).val("");
		});
	
	$("#mensaje_c").focus(function(){
		if($(this).val()=="Escribe tu mensaje") $(this).val("");
		});
	
	$(".btn_info").click(function(e){
		e.preventDefault();	
		$("#mensaje").html($(".condiciones").html());
		ventana("#ventana_mensaje");
		});
         
	$("#comofunciona").click(function(e){
		e.preventDefault();	
		ventana("#condiciones_uso");
		});         
        
        
        if($("#banner_p a").length > 1)
            setInterval("banners()",5000);
        
        $("#forma_dineromail").submit(function(){        
            if(!IsValidEmail($("#mail_compra").val()))
                    {                    
                    alert("Debes ingresar un correo valido ");                    
                    return false;
                    }
             else
                    {
                    $.post("scripts/email_comprador.php",
                        {
                        email : $("#mail_compra").val(), 
                        cupon : cupon
                        },function(data){
                            if(data=="0")
                                {
                                alert("Algo ha salido mal, vuelve a intentarlo");
                                window.location.reload();
                                }
                            else
                                {
                                document.forms["forma_dineromail"].submit();
                                }
                            });
                    }
             return false;
            });
        
        $("#forma_paypal").submit(function(){        
            if(!IsValidEmail($("#mail_compra2").val()))
                    {                    
                    alert("Debes ingresar un correo valido ");                    
                    return false;
                    }
             else
                    {
                    $.post("scripts/email_comprador.php",
                        {
                        email : $("#mail_compra2").val(), 
                        cupon : cupon
                        },function(data){
                            if(data=="0")
                                {
                                alert("Algo ha salido mal, vuelve a intentarlo");
                                window.location.reload();
                                }
                            else
                                {
                                document.forms["forma_paypal"].submit();
                                }
                            });
                    }
             return false;
            });		
		
        if(msg!=0)
           {             
            $("#mensaje").text(msg);
            ventana("#ventana_mensaje");               
           }
        
	});//jquery

function ventana(selector)
{
$(selector).modal({
	overlayClose:true,
	onOpen: function (dialog) {
		dialog.overlay.fadeIn('slow', function () {
			dialog.data.hide();
			dialog.container.fadeIn('slow', function () {
				dialog.data.fadeIn(400);
				});
			});
	}});		
}

//funcion para loop de banners
function banners()
{
active=$("#banner_p a.active");
next=active.next();
if(next.length == 0) next=$("#banner_p a").first();
active.fadeOut(1000);
next.fadeIn(1000);
active.removeClass("active");
next.addClass("active");
}

//funcion de javascript para compartir galerias en facebook
function sharefb(u,t)
	{
        url= curl + "index.php?seccion=motel&id=" + u;
        title=t + " :: Cinco Letras, La guía de moteles en Guadalajara";
	window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(url) + '&t=' + encodeURIComponent(title),'Facebook','width=600,height=400');
	}
	
//js para comaprtir en twitter
function sharetwitter(u,t)
	{
        url= curl + "index.php?seccion=motel&id=" + u;
        title="Cinco Letras, La guía de moteles en Guadalajara :: Motel " + t;
	window.open('http://twitter.com/share?url='+encodeURIComponent(url)+'&text='+encodeURIComponent(title),'Twitter','toolbar=0,status=0,width=626,height=436');
	return false;
	}

function IsValidEmail(email)
	{
	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	return filter.test(email);
	}