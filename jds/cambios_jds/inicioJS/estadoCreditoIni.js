$(document).ready(function(){
$('#cabecera').tabs();
$("#nuevoAbono").css('display', 'none');
$("#liquidar").css('display', 'none');
$("#IdCuenta").html($("#IdCuentaHD").val());
buscarCredito($("#IdCuentaHD").val(),llenaCartera)

$("#abonar").click(function(){
$("#valorAbono").val("")
var dateText=new Date();
var dia=dateText.getDate()
var mes=(dateText.getMonth()+1);
var anio=dateText.getFullYear();
var fecha =mes+"/"+dia+"/"+anio;
	$("#fecha").html(fecha) 
 		var datos_json = "tabla=" + encodeURIComponent('abonoscredito')+
	"&orden=" + encodeURIComponent('idAbono')		+
	"&respuesta=" + encodeURIComponent('cartera')		+
		"&nocache=" + Math.random();
		carga_crear_id(datos_json,function (){var respuesta_json = this.req.responseText;
	$("#idAbono").html(respuesta_json);
		});
	$("#idCuenta").html($("#IdCuentaHD").val()) 						
	$("#idClienteAbono").html($("#idCliente").html()) 	
	$("#deudaTotal").html($("#TotalActual").html()) 	
	$("#nuevoAbono").css('display', 'inline');
	})
		
$("#abonar2").click(function(){
$("#valorAbonoliquidar").html($("#TotalActual").html())
var dateText=new Date();
var dia=dateText.getDate()
var mes=(dateText.getMonth()+1);
var anio=dateText.getFullYear();
var fecha =mes+"/"+dia+"/"+anio;
	$("#fechaliquidar").html(fecha) 
	var datos_json = "tabla=" + encodeURIComponent('abonoscredito')+
	"&orden=" + encodeURIComponent('idAbono')		+
	"&respuesta=" + encodeURIComponent('cartera')		+
		"&nocache=" + Math.random();
		carga_crear_id(datos_json,function (){var respuesta_json = this.req.responseText;
	$("#idAbonoliquidar").html(respuesta_json);
		});		

	$("#idCuentaliquidar").html($("#IdCuentaHD").val()) 						
	$("#idClienteAbonoliquidar").html($("#idCliente").html()) 	
	$("#deudaTotalliquidar").html($("#TotalActual").html()) 	
	$("#liquidar").css('display', 'inline');
	})

abonoscredito()
$("#cerrarliquidar").click(function(){
							$("#liquidar").css('display', 'none');	 
								 });	
$("#cerrarBoton").click(function(){
							$("#nuevoAbono").css('display', 'none');	 
								 });	
$(document).keydown(function(tecla){
		var r=tecla.keyCode;
		if(r==27){
				$("#nuevoAbono").css('display', 'none');
				$("#liquidar").css('display', 'none');
			}
			if(r==13){
				
			}
	});	



$("#valorAbono").keydown(function(tecla){
		var r=tecla.keyCode;
	if(r==13){
				if(Trim($(this).val())!=""){
			if(isNaN($(this).val())){
			jAlert("el valor debe ser un numero ");
			$(this).focus();	
				}else{
					$("#guardarAbono").trigger('click')
					}
			}else{jAlert("el valor debe ser un numero ");}
			}
	});	
$("#valorAbono").keyup(function (){
		if(Trim($(this).val())!=""){
			if(isNaN($(this).val())){
			jAlert("el valor debe ser un numero ");
		
			$(this).focus();
			$(this).val('')	
				}
			
			}
	
	});
        $("#vauche_abono").prop('disabled',true)
 $("#tipo_pago_abono").change(function(){     
      $("#vauche_abono").prop('disabled',true)
      if(Trim($("#tipo_pago_abono").val())=="BANCOS" )
          $("#vauche_abono").prop('disabled',false)
     
 })
 
$("#guardarAbono").click(function(){ 
			if(Trim($("#valorAbono").val())!=""){
                         
                     if(Trim($("#tipo_pago_abono").val())=="BANCOS" && Trim($("#vauche_abono").val())==""){
                         jAlert("Debe ingresar el Número del vauche en un pago por transferencia")
				$("#vauche_abono").focus()
                                return;
                               }  
                         
		  num1=parseInt($("#valorAbono").val())
		   num2=parseInt($("#deudaTotal").html())
		
		if(num2<num1){jAlert("el valor que esta insertado esta por ensima de la deuda corrija por favor")
				$("#valorAbono").focus()
			}else{
				if(num1!=0){
				fecha=$("#fecha").html()
			id=$("#idAbono").html()
			cuenta=$("#idCuenta").html() 						
    		cliente=$("#idClienteAbono").html() 	
                var vauche_abono =$("#vauche_abono").val() 
                var tipo_pago_abono =$("#tipo_pago_abono").val() 
				 var datos_json="idAbono="+ encodeURIComponent(id)+"&"+ 
				 "vauche_abono="+ encodeURIComponent(vauche_abono)+"&"+ 
				 "valorAbono="+ encodeURIComponent(num1)+"&"+
				 "tipo_pago_abono="+ encodeURIComponent(tipo_pago_abono)+"&"+
				 "cliente="+ encodeURIComponent(cliente)+"&"+
				 "cuenta="+ encodeURIComponent(cuenta)+"&"+
				 "fecha="+ encodeURIComponent(fecha)+"&"+
				"respuesta="+ encodeURIComponent('nuevoAbonoCredito')+"&nocache=" + Math.random();
			carga_insert(datos_json,function (){var respuesta_json = this.req.responseText;alert(respuesta_json);
		abonoscredito();$("#nuevoAbono").css('display', 'none');$("#TotalActual").html(num2-num1);
		});	}else{jAlert("el valor no puede ser cero '0'");	$("#valorAbono").focus();}
			}
			
			
			}else{$("#valorAbono").focus()}
	});	


$("#guardarliquidar").click(function(){ 
 num2=parseInt($("#deudaTotal").html())
			num1=$("#valorAbonoliquidar").html()
			if(num1!=0){
		fecha=$("#fechaliquidar").html()
			id=$("#idAbonoliquidar").html()
			cuenta=$("#idCuentaliquidar").html() 						
    		cliente=$("#idClienteAbonoliquidar").html() 	
				 var datos_json="idAbono="+ encodeURIComponent(id)+"&"+
				 "valorAbono="+ encodeURIComponent(num1)+"&"+
				 "cliente="+ encodeURIComponent(cliente)+"&"+
				 "cuenta="+ encodeURIComponent(cuenta)+"&"+
				 "fecha="+ encodeURIComponent(fecha)+"&"+
				"respuesta="+ encodeURIComponent('nuevoAbonoCredito')+"&nocache=" + Math.random();
				carga_insert(datos_json,function (){var respuesta_json = this.req.responseText;alert(respuesta_json);
		abonoscredito();$("#liquidar").css('display', 'none');$("#TotalActual").html(0);
		});	}else{$("#liquidar").css('display', 'none');jAlert("esta deuda ya fue pagada")}
	});	



});

function list_res_abonos(){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
log('datos recibidos : '+JSON.stringify(respuesta_json))
var num_filas = objeto_json.filas;
if (num_filas>0){
	var encabezados =['idAbono','idCliente' ,'idFactura','valorAbono' ,'fecha' ];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewAbono','tablasListaAbono','indiceListaAbono','listarTablaAbono',0,15,false,false,false,false,false,false);
}else {limpia_linea('tablasListaAbono','indiceListaAbono');
	var texto="encuentra registrado ningun Abono en la base de datos";
		$('#tablasListaAbono').html(texto);
	}
	}


function llenaCartera(){
	var respuesta_json = this.req.responseText;
	//alert(respuesta_json)
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
  $("#idCliente").html(objeto_json.datos[0]['idCliente'])
   $("#fechaIngreso").html(objeto_json.datos[0]['fechaIngreso'])
    $("#descripcion").html(objeto_json.datos[0]['descripcion'])
      $("#nombre").html(objeto_json.datos[0]['nombre'])
  $("#valorInicial").html(objeto_json.datos[0]['valorInicial'])
   $("#abonoInicial" ).html(objeto_json.datos[0]['abonoInicial'])
    $("#numCuotas").html(objeto_json.datos[0]['numCuotas'])
  $("#intervalo").html(objeto_json.datos[0]['intervalo'])
      $("#valorCuota").html(objeto_json.datos[0]['valorCuota'])
     $("#TotalActual").html(objeto_json.datos[0]['TotalActual'])
     $("#TotalInicial").html(objeto_json.datos[0]['TotalInicial'])//listadoCreditosProveedor.php?tabla1=proveedores&idCliente=001&tabla2=credito&dir=estadoCredito.php
	 $("#atras").attr('href',"listadoCreditosProveedor.php?tabla1=proveedores&idCliente="+objeto_json.datos[0]['idCliente']+"&tabla2=credito&dir=estadoCredito.php");
	}

function abonoscredito(){
	/*var query="SELECT * FROM `abonoscredito` WHERE `idFactura` =";
		dato=$("#IdCuenta").html();						
		var datos_json = "query=" + encodeURIComponent(query)+		
		"&igual=" + encodeURIComponent(true)+	
		"&dato=" + encodeURIComponent(dato)+	
		"&nocache=" + Math.random();
		limpia_linea('tablasListaAbono','indiceListaAbono');
		carga_listar(datos_json,list_res_abonos); 	
*/
inicioListar('abonoscredito',list_res_abonos,null,null,'idFactura',true,$("#IdCuenta").html(),null,null,'Abono')
		
	}
