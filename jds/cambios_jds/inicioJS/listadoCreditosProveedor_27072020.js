$(document).ready(function(){
	if($('form').attr("action")=='estadoCredito.php')
	{$('#regresa').attr("href",'provedores.php');	}
	else{$('#regresa').attr("href",'clientes.php');}
	listadoCreditosProv($("#IdProveedor").html(),$('#tabla2').val())
	
	});

function listadoCreditosProv(dato,tabla){
	var query="SELECT * FROM `"+tabla+"` WHERE `idCliente` = ";
	var datos_json = "query=" + encodeURIComponent(query) +
		"&dato=" + encodeURIComponent(dato) +
		"&igual=" + encodeURIComponent("true") +
		"&nocache=" + Math.random();
		//alert(datos_json)
		//carga_listar(datos_json,list_res_prov); 
		///////////////////////777
		
		var datosAjax = {
		tabla: tabla,
		inicio: '',
		where:true,
		igual:true,
		columna1:'idCliente',
		dato:dato,
		datosRequeridos:''
		/*
		proced : 'GET_PRODUC_BARCODE',
		datosProce:[valorEnviar]*/
		};		
		$.ajax({url: 'php/db_listar_nuevo.php',  
			type: 'POST',
			data: datosAjax,
			dataType: "json",
			 beforeSend: function() {
				console.log(JSON.stringify(datosAjax))
				}, 
			statusCode: {
    			404: function() {
				 alert( "pagina no encontrada" );
   				 },
				 408: function() {
				alert( "Tiempo de espera agotado. la peticion no se realizo " );
   				 } 
				 },
 			success:function(data){ list_res_prov(data)} ,error: function(a,e,b){
					 console.log("se genero un error"+JSON.stringify(a,e,b))
					}});//fin bloque obtencion de datos producto

		
		//////////////////////
		
		
		
		}

	function list_res_prov(objeto_json){//evalua la respuesta recibida para listar los colores
	/*{
				console.log(JSON.stringify(data))
				var total = data['filas'];
				datosTabla=data['datos'];
				if (total > 0 ){
				for(var i =0; i<datosTabla.length;i++){
					auxDato=datosTabla[i];
				
					 $("#idProducto").val(auxDato.idProducto)
					 $("#nomProducto").html(auxDato.nombre)
					 $("#nombreProducto").val(auxDato.nombre)
					 $("#presioVenta").val(auxDato.precioVenta)
					 $("#PsIVA").val(auxDato.PsIVA)
					 $("#IVA").val(auxDato.IVA)
					  $("#pVenta").html(formatNumber.new(  auxDato.precioVenta, "$"))
					 $("#Ps_IVA").html(formatNumber.new( auxDato.PsIVA, "$") )
					 $("#_IVA").html(formatNumber.new( auxDato.IVA, "$") )
					 $("#porcent_iva").val(auxDato.porcent_iva)
					 $("#cantActualArt").val(auxDato.cantActual)
					}
					$("#liquidar").css("display","inline")
					$('#id_producto').val('');
					}else{
						$('#id_producto').focus();
						alert('el codigo de producto no se encuentra registrado')
					}
				}*/
				console.log('datos :'+JSON.stringify(objeto_json))
				
				
var num_filas = objeto_json['filas'];
limpia_linea('tablasListaProveedor','indiceListaProveedor');
if (num_filas>0){
var encabezados =['idCuenta','descripcion' ,'fechaIngreso','valorInicial' ,'abonoInicial' ,'numCuotas','valorCuota','TotalActual'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewProveedor','tablasListaProveedor','indiceListaProveedor','listarTablaProveedor',0,17,false,false,false,false,CargaPagCredito,false);
}else {limpia_linea('tablasListaProveedor','indiceListaProveedor');
	var texto="no se encuentra registrada ningun Cartera en la base de datos";
		$('#tablasListaProveedor').html(texto);
	}
	}
 
 
 