$(document).ready(function(){

	var dato=$("#IdUsuario").val();
    var nombre=$("#nombreData").val();
    var apellido=$("#apellidoData").val();					   
if (Trim(dato)!=""){
var query="SELECT * FROM `galeria` WHERE galeria.idCliente = "+dato;
		var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
		//alert (datos_json);
		carga_listar(datos_json,llenafotos);	}
		



});
function ws_basic(c,a,b){this.go=function(d){b.find("ul").stop(true).animate({left:(d?-d+"00%":(/Safari/.test(navigator.userAgent)?"0%":0))},c.duration,"easeInOutExpo");return d}};

function llenafotos(){
			
			var respuesta_json = this.req.responseText;
		var objeto_json = eval('('+respuesta_json+')');
		var num_filas = objeto_json.filas;
		if(num_filas>0){
var text='<ul>';
var textFotos="";
for(nFila=0;nFila<num_filas;nFila++){
text=text+'<li><img src="'+objeto_json.datos[nFila]['rutaFoto']+'" alt="'+objeto_json.datos[nFila]['titulo']+'" title="'+objeto_json.datos[nFila]['titulo']+'" id="wows1_'+nFila+'"/></li>';
textFotos=textFotos+'<a href="#" title="'+objeto_json.datos[nFila]['titulo']+'"><img src="'+objeto_json.datos[nFila]['rutaMuestra']+'" alt="" /></a>';
}
text=text+'</ul>';	

				
$("#fotosGrandes").html(text);
$("#fotosPequeñas").html(textFotos);
if(num_filas==1){
jQuery("#wowslider-container1").wowSlider({effect:"basic",prev:"",next:"",duration:20*100,delay:41*100,width:640,height:480,autoPlay:false,stopOnHover:true,loop:false,bullets:0,caption:true,captionEffect:"move",controls:true,logo:"engine1/loading.gif",onBeforeStep:0,images:0});}
else{jQuery("#wowslider-container1").wowSlider({effect:"basic",prev:"",next:"",duration:20*100,delay:41*100,width:640,height:480,autoPlay:false,stopOnHover:true,loop:false,bullets:0,caption:true,captionEffect:"move",controls:true,logo:"engine1/loading.gif",onBeforeStep:0,images:0});
}
			}
			
			
	}