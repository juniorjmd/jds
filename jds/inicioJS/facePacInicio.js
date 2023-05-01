$(document).ready(function(){
$('#cuerpo').tabs();
 $(this).attr("title",$("#nombreData").val()+" "+$("#apellidoData").val());	
 var dato=$("#Identificacion").html();
$('#CuerpoFotos').niceScroll({cursorborder:"",cursorcolor:"#a6c9e2"});

$("#Linktabs-5").click(function (){
									buscarProcedimiento(dato,llenaDatosProce)		 
									 });
$("#Linktabs-6").click(function (){
		if (Trim(dato)!=""){
		var query="SELECT * FROM `galeria` WHERE galeria.idCliente = "+dato;
		var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
		carga_listar(datos_json,llenafotos,"php/muestraFoto.php");}
		});
$("#nuevaFoto").click(function (){
					window.location.replace("upload/SubeFoto.php");
						 });

$("#Linktabs-3").click(function (){
							buscarCitas(dato,llenaDatosCitas)		 
								 });
	
$("#Linktabs-4").click(function (){
var query="SELECT * FROM `cartera` WHERE `idCliente` ="+dato+"  ORDER BY `cartera`.`idCartera` ASC";
var datos_json = "query=" + encodeURIComponent(query) +
"&nocache=" + Math.random();
limpia_linea('tablasListaCartera','indiceListaCartera');
		carga_listar(datos_json,list_res_Cartera); 
									 });
									 
	$("#Linktabs-2").click(function (){
									buscarHistoria(dato,llenaDatosHistoria)		 
									 });
	});	

function llenafotos(){
		var respuesta_json = this.req.responseText;
		//alert(respuesta_json)
		$("#fotosPeque").html(respuesta_json);
		$(".PacienteImg").click(function (){
										window.location.replace("galeria.php");
									 });
	}
