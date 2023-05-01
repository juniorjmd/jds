$(document).ready(function(){
		enableDisable("#origenValue");
		OcultaYMuestra("#liquidar","");
		OcultaYMuestra("#listadoEntradas","");
		OcultaYMuestra("#Mostrar");
		OcultaYMuestra("#listado");
		query ="SELECT * FROM "+$("#sucursalId").val()+"entradastemp where `usuario` = "+$("#usuarioId").val() ;
		var datos_json = "query=" + encodeURIComponent(query) +
		"&nocache=" + Math.random();
		
		$("#origenEntrada").change(function(){
                var op = $("#origenEntrada option:selected").html();
				if(Trim(op)=="Otros")
				{enableDisable("","#origenValue");
				$("#origenValue").val("");
				$("#origenValue").focus();
				OcultaYMuestra("","#origenValue");
				}
				else{enableDisable("#origenValue","");OcultaYMuestra("#origenValue");
				$("#origenValue").val($("#origenEntrada option:selected").html());}
        });
		
		
		carga_listar(datos_json,listResEntradas);
		
		query ="SELECT * FROM "+$("#sucursalId").val()+"entradas" ;
		var datos_json = "query=" + encodeURIComponent(query) +
		"&nocache=" + Math.random();
		
		carga_listar(datos_json,listResEntradas2);
		
		$("#mostrarLista").click(function(){
			mostrar=$("#mostarSW").val();
			if(mostrar=='1'){
			OcultaYMuestra("","#listadoEntradas");
			OcultaYMuestra("#insertarNuevo");
			$("#mostarSW").val('0')
			$("#layer").html('Crear')
			}else{
				OcultaYMuestra("#listadoEntradas");
				OcultaYMuestra("","#insertarNuevo");
				$("#mostarSW").val('1')
				$("#layer").html('Listar')
				}
              
        });
		
		
		query ="SELECT * FROM "+$("#sucursalId").val()+"inventario" ;
		var datos_json = "query=" + encodeURIComponent(query) +
		"&nocache=" + Math.random();
		var tabla=$("#sucursalId").val()+"inventario" ;
		//inicioListar(tabla,list_res_inv,php,ordenar)
		$("#busqueda").click(function(){inicioListado();});		   
		$("#entradaId").focus();			   
		$(".busca_edit").colorbox({overlayClose:false, inline:true, href:"#buscar_suc2"});
		id_input="input[id='entradaId']";
		procesa_leave(id_input,"codigo","articulo",respuestaBusquedaArticulo,$("#sucursalId").val());
		inicio_busqueda(3,'list_busqueda_aux','indice_busqueda_aux','tablaBusqGrupAux');
		$("#finalizarInsert").attr('disabled',true);
				
		$("#finalizarInsert").click(function(){	
			var finaliza=true;
        	$.colorbox({overlayClose:false, inline:true, href:"#loading",width:"100%", height:"100%"});
          	if(Trim($("#nombre").get(0).innerHTML)!="")
               {finaliza=insertaArticulo()} 										
				nombre=$("#codigoIngreso").get(0).id;
				dato=$('#hiddenCodigoIngreso').get(0).value; 
				datos_json=nombre+"="+encodeURIComponent(dato)+"&";
				datos_json =datos_json+"sucursalId="+ encodeURIComponent($("#sucursalId").val())+"&"
									+"nombreSuc="+encodeURIComponent($("#nombreSuc").val())+"&"
									+"destino="+encodeURIComponent($("#NomSuc").get(0).innerHTML)+"&"
									+"codOrigen="+encodeURIComponent($("#origenEntrada option:selected").val())+"&"
									+"origen="+encodeURIComponent($("#origenValue").get(0).value)+"&"
									+"respuesta="+ encodeURIComponent("entradaFinalizar")
									+"&nocache=" + Math.random();
				if(finaliza==true){carga_insert(datos_json,respuestaInsertEtrada2)}
				else{jQuery.colorbox.close();}	 	 
											 });  
		
		
		
		
	$("#entradaId").keydown(function(tecla){
	var r=tecla.keyCode;
	if(r==13){
		 var dato=Trim($("#entradaId").get(0).value);
		if (dato==""){
				$("#busqueda").trigger('click');
			}
			else{if(Trim($("#nombre").get(0).innerHTML)!=""){
				var x=$("#entradaId").val()
  				$("#entradaId").val(x.toUpperCase());
				$("#cantidad").focus();	
				}
				else{
					$("#grupo_busq_2").attr('value',dato);
					$("#busqueda").trigger('click');
					$("#grupo_busq_2").trigger('keyup');
					
					}
				
				}
		}
	});	
	
	$("#cantidad").keydown(function(tecla){
	var r=tecla.keyCode;
	if(r==13){
		 var dato=Trim($(this).get(0).value);
		if (dato==""){
			alert("el dato esta vacio");
			}
			else{if(Trim($("#nombre").get(0).innerHTML)!=""){
				$("#insertaArticulo").focus();	}
				else{$("#entradaId").focus();
					}
				}
		}
	});	
	

	$("input[id='grupo_busq_2']").keyup(function (e){
	var dato=$(this).val();
	help=e.keyCode;
	if(((parseInt(help)<37)||(parseInt(help)>40))&&(parseInt(help)!=13)&&(parseInt(help)!=27)&&(parseInt(help)!=18)&&(parseInt(help)!=16)){
	if (Trim(dato)!=""){//"'%".$dato."%'"
	var query="SELECT * FROM articulo WHERE `nombre` LIKE ";
	
	var datos_json = "query=" + encodeURIComponent(query)+		
			"&dato=" + encodeURIComponent(dato) +
			"&tabla2=" + encodeURIComponent('codigo') +
		"&nocache=" + Math.random();
		//alert(datos_json);
        limpia_linea('list_busqueda_aux','indice_busqueda_aux');
    	carga_listar(datos_json,resp_busq_aux);
		}else{
        inicioListado()
      	$(this).focus();}
	
							}					 
	});
	
$("#PresioVenta").keydown(function(tecla){
				var r=tecla.keyCode;
				if(r==13){
					$("#guardarPresio").trigger('click');
					}
				});		
$("#guardarPresio").click(function(){
		if($("#PresioVenta").val()==0){alert("El Precio de venta debe ser mayor a 0");}	
		else{OcultaYMuestra("#liquidar","");
		insertaArticulo();
		}
});	
$("#cerrarliquidar").click(function(){
	OcultaYMuestra("#liquidar","");
	});

 
		
$("#insertaArticulo").click(function(){
		if($("#PresioVenta").val()==0){
			/*$("#guardarPresio").unbind('click')
			$("#PresioVenta").unbind('keydow')*/
			OcultaYMuestra("","#liquidar");
			$("#PresioVenta").focus();
			}
		else{insertaArticulo()}
				});


});
 
function insertaArticulo(){
var nombre= Trim($("#nombre").get(0).innerHTML)
		 var cantidad =Trim($("#cantidad").get(0).value);
		if ((nombre=="")){
		$("#entradaId").focus();
		return false;
		}
		if(cantidad==""){$("#cantidad").focus();
		return false;
		}
$.colorbox({overlayClose:false, inline:true, href:"#loading",width:"100%", height:"100%"});
var datos_json="entradaId="+encodeURIComponent($("#entradaId").get(0).value)+"&"
+"destino="+encodeURIComponent($("#NomSuc").get(0).innerHTML)+"&"
+"origen="+encodeURIComponent($("#origenValue").get(0).value)+"&"
+"codOrigen="+encodeURIComponent($("#origenEntrada option:selected").val())+"&"
+"nombre="+encodeURIComponent($("#nombre").get(0).innerHTML)+"&"
+"cantidad="+encodeURIComponent($("#cantidad").get(0).value)+"&"
+"sucursalId="+encodeURIComponent($("#sucursalId").val())+"&"
+"nombreSuc="+encodeURIComponent($("#nombreSuc").val())+"&"
+"PresioVenta="+encodeURIComponent($("#PresioVenta").val())+"&"
+"codigoIngreso="+encodeURIComponent($('#codigoIngreso').get(0).innerHTML)+"&"
+"respuesta="+ encodeURIComponent("entrada")+"&nocache=" + Math.random();
carga_insert(datos_json,respuestaInsertEtrada);

return true;		
}
function respuestaBusquedaArticulo()
{var respuesta_json = this.req.responseText;
//alert(respuesta_json)
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
var dato="";
var texto="  ";
presio=codigo='';
if (num_filas>0){
	dato=objeto_json.datos[0]['nombre'];
	presio=objeto_json.datos[0]['Pventa'];
	codigo=objeto_json.datos[0]['codigo'];
	}
else{
		texto="no existe nigun dato registrado bajo ese ID ";
		presio=0
$("#informe").html("");	
		}
$("#nombre").html(dato);
$("#informe").html(texto);	
$("#PresioVenta").val(presio);		

$("#nombreProductoPresio").html(dato);
$("#CodigoPresio").html(codigo);	
$("#PresioVenta").val(presio);		
	}	
	
function tabla(){
//$("#listadoMercancia").html("");
	var elmTabla=document.getElementById("listadoMercancia");
	var elmTR=document.createElement("tr");
	dato=$("#entradaId").get(0).value;
	var elmTD=document.createElement("td");
	elmTD.innerHTML=dato;
	elmTR.appendChild(elmTD);
	 dato=$("#nombre").get(0).innerHTML;
	var elmTD=document.createElement("td");
	elmTD.innerHTML=dato;
	elmTR.appendChild(elmTD);
	var elmTD=document.createElement("td");
		  dato=$("#cantidad").get(0).value;
	elmTD.innerHTML=dato;
	elmTR.appendChild(elmTD);
	elmTabla.appendChild(elmTR);}
	
	
	function resp_busq_aux(){
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
var destino = "entradaId";
var encabezados =['codigo','nombre','cantidad'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'aux','list_busqueda_aux','indice_busqueda_aux','tablaBusqGrupAux',0,25,destino);
}else {limpia_linea('list_busqueda_aux','indice_busqueda_aux');
	var texto="el dato no esta registrado en la base de datos";
	$('#list_busqueda_aux').html(texto);}}//si no hay ningun dato registrado bajo ese nombre o codigo	



function carga_id(){
	var query ="SELECT * FROM `"+$("#sucursalId").val()+"entradas`";
var respuesta="entradas";
datos_json= "respuesta=" + encodeURIComponent(respuesta) +
"&query=" + encodeURIComponent(query) +
"&nocache=" + Math.random();
carga_crear_id(datos_json,resp_id);

}

function resp_id(){
	var respuesta_json = this.req.responseText;
	$('#codigoIngreso').html(respuesta_json);
	$('#hiddenCodigoIngreso').attr('value',respuesta_json);

}

	
function respuestaInsertEtrada()
{
	var respuesta_json = Trim(this.req.responseText);
	var numeroLetras = respuesta_json.length;
jQuery.colorbox.close();
if ((numeroLetras>=38)&&(numeroLetras<=40))
 {tabla();
 var salva=$('#origenValue').val();
 var salva2=$('#NomSuc').html();
$("#finalizarInsert").removeAttr("disabled");
$("input[type=text]").each(function(){
 $(this).attr('value',' ');});
$("span").each(function(){
$(this).html(" ");});	
$('#origenValue').val(salva);
$('#NomSuc').html(salva2);
enableDisable("#origenValue");
enableDisable("#origenEntrada");
$("#entradaId").focus();
carga_id();}
  else{alert(respuesta_json);}

}


	
function respuestaInsertEtrada2()
{
	var respuesta_json = this.req.responseText;
	var respuestaJson=Trim(respuesta_json);
	var numeroLetras = respuestaJson.length;
	//jQuery.colorbox.close();
	if ((numeroLetras>=38)&&(numeroLetras<=40))
 { var disabled=true;
  location.reload();
 	}
  else{alert(respuesta_json);
  jQuery.colorbox.close();}

}

function inicioListado(){
	var query="SELECT * FROM articulo";
	var datos_json = "query=" + encodeURIComponent(query)+		
			"&nocache=" + Math.random();
		//alert(datos_json);
        limpia_linea('list_busqueda_aux','indice_busqueda_aux');
   	carga_listar(datos_json,resp_busq_aux);}

function listResEntradas(){
	var respuesta_json = this.req.responseText;
	//alert(respuesta_json)
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
var objetoJson = eval("("+respuesta_json+")");

$("#origenEntrada").val(objetoJson.datos[0]["codOrigen"]);
$("#origenValue").val(objetoJson.datos[0]["origen"]);
$("#NomSuc").html(objetoJson.datos[0]["destino"]);
$('#codigoIngreso').html(objetoJson.datos[0]["codEntrada"]);
$('#hiddenCodigoIngreso').attr('value',objetoJson.datos[0]["codEntrada"]);

enableDisable("#origenValue");
enableDisable("#origenEntrada");
$("#finalizarInsert").removeAttr("disabled");
var encabezados =['codProducto' ,'nombreProducto' ,'cantidad'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normal','indiceListaEntradas','tablasListaEntradas','listadoMercancia',0,25,false,false,false,false,false);
	
}else {limpia_linea('tablasListaEntradas','indiceListaEntradas');
carga_id();
	}
	}  


function listResEntradas2(){
	var respuesta_json = this.req.responseText;
	//alert(respuesta_json)
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
$("#finalizarInsert").removeAttr("disabled");
var encabezados =['origen' ,'destino' ,'codEntrada' ,'fecha' ,'totalArticulos'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normal','indiceListaEntradas2','tablasListaEntradas2','listarTablaEntradas2',0,25,false,false,false,false,false);
	
}else {limpia_linea('tablasListaEntradas2','indiceListaEntradas2');
	}
	}  




function listResMostrar(){
	var respuesta_json = this.req.responseText;
	//alert(respuesta_json)
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
$("#finalizarInsert").removeAttr("disabled");
var encabezados =['codEntrada' ,'fecha' ,'totalArticulos'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normal','indiceListaEntradas','tablasListaEntradas','listadoMercancia',0,25,false,false,false,false,false);
	
}else {limpia_linea('tablasListaEntradas','indiceListaEntradas');
	}
	
	
	}  
