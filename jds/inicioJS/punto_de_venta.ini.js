var id_grupo_producto = '';
var Global_preventa = 0;
var Global_PsIVA = 0;
var Global_IVA  = 0;
$(document).ready(function(){
//busqueda de datos por codigo
$('#id_producto').css('text-transform','uppercase').keydown(function(e){
		var tecla=e.keyCode;
		if(tecla==13){$("#enviarIdProducto").trigger("click");
		}
	});
		$("#enviarIdProducto").click(function(e){
			e.preventDefault();
 		    var cantAct;
			var valorEnviar;
			
			$("#cantidadVenta").val(0);
			valorEnviar = Trim($('#id_producto').val());
			//alert(valorEnviar)
			//inicio bloque obtencion de datos producto
		if(valorEnviar!=''){
			var datosAjax = {
		/*tabla: 'producto',
		inicio: '',
		where:true,
		igual:true,
		columna1:'idProducto',
		dato:valorEnviar,
		datosRequeridos:['idProducto','PsIVA','nombre','IVA','precioVenta','porcent_iva','stock','cantActual']
		*/
		proced : 'GET_PRODUC_BARCODE',
		datosProce:[valorEnviar]
		};		
		$.ajax({url: '../php/db_listar_nuevo.php',  
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
 			success: function(data) {
                           
				//console.log(JSON.stringify(data))
				var total = data['filas'];
				var datosTabla=data['datos'];
                                var auxDato ;
				if (total > 0 ){
                                    var tipo_producto = '';
                                    var padre = '';
				for(var i =0; i<datosTabla.length;i++){
					auxDato=datosTabla[i];
				tipo_producto = auxDato.tipo_producto;
                                if(tipo_producto == 'MT'){
                                    padre = $('#transformar')
                                }else{ 
                                    padre = $('#liquidar')
                                    }
                                      //  alert(JSON.stringify(auxDato))
					 $("#idProducto").val(auxDato.idProducto)
					 padre.find("#nomProducto").html(auxDato.nombre)
					  $("#nombreProducto").val(auxDato.nombre)
					 $("#presioVenta").val(auxDato.precioVenta)
					  $("#PsIVA").val(auxDato.PsIVA)
					  $("#IVA").val(auxDato.IVA)
                                          id_grupo_producto = auxDato.idGrupo;
//                                          $("#presioVenta").data('preventa',auxDato.precioVenta)
//                                          $("#presioVenta").data('PsIVA',auxDato.PsIVA)
//                                          $("#presioVenta").data('IVA',auxDato.IVA)
                                          
                                          Global_preventa = auxDato.precioVenta
                                          Global_PsIVA =  auxDato.PsIVA
                                          Global_IVA = auxDato.IVA
                                          
                                          
					  padre.find("#pVenta").html(formatNumber.new(  auxDato.precioVenta, "$"))
					 padre.find("#Ps_IVA").html(formatNumber.new( auxDato.PsIVA, "$") )
					 padre.find("#_IVA").html(formatNumber.new( auxDato.IVA, "$") )
					 $("#porcent_iva").val(auxDato.porcent_iva)
					 $("#cantActualArt").val(auxDato.cantActual)
					}
                                    console.log(tipo_producto);
                                        if (tipo_producto == 'MT'){
                                        listar_tipos_medidas();
                                        
                                }else{
                                            $("#liquidar").css("display","inline")
					}
                                        $('#id_producto').val('');
					}
                                        else{
						$('#id_producto').focus();
						alert('el codigo de producto no se encuentra registrado')
					}
				},error: function(a,e,b){
					 console.log("se genero un error"+JSON.stringify(a,e,b))
					}});//fin bloque obtencion de datos producto
}else{
$('#id_producto').focus();}					
});	
//busqueda de datos por codigo
$('#cantidadVenta').attr('readonly',true)
var nuevo_precio = 
 "<br><div class='input-group hidden' id='nuevo_precio' >"+
  "<input type='number' class='form-control' id='nuevo_precio_value' value='0'>"+
  "<span class='input-group-btn'>" +
  "<button class='btn btn-default' type='button' id='aceptar_nuevo_precio'> <span  class='glyphicon glyphicon-remove'  aria-hidden='true'  ></span> Go!</button></span> </div> <br>" ;
  
$('#liquidar').children().append(nuevo_precio);	
var nuevo_precio = 
 "<br><br><br><br><div class='input-group hidden' id='nuevo_precio_tf' >"+
  "<input type='number' class='form-control' id='nuevo_precio_value_tf' value='0'>"+
  "<span class='input-group-btn'>" +
  "<button class='btn btn-default' type='button' id='aceptar_nuevo_precio_tf'> <span  class='glyphicon glyphicon-remove'  aria-hidden='true'  ></span> Go!</button></span> </div> <br>" ;

$('#transformar').children().append(nuevo_precio);	

$('#cambiarPrecio').click(function(){
	$('#nuevo_precio').removeClass('hidden');
	$('#nuevo_precio_value').focus();
	$('#nuevo_precio_value').val(0);
}); 
 
//nuevo precio tranformacion

$('#cambiarPrecio_tf').click(function(){
	$('#nuevo_precio_tf').removeClass('hidden');
	$('#nuevo_precio_value_tf').focus();
	$('#nuevo_precio_value_tf').val(0);
}); 
$('#nuevo_precio_value').keypress(function(e){
		var tecla=e.which;
if (tecla==13){$('#aceptar_nuevo_precio').trigger('click')}});

/*
$('#aceptar_nuevo_precio').click(function(){
	var pNuevo = parseFloat($('#nuevo_precio_value').val() ); 
	if ( pNuevo > 0){
		 var iva 			= $( "input[id=IVA]" )  ;
		 var presioVenta 	= $( "input[id=presioVenta]" )  ;
		 var porcent_iva 	= $( "input[id=porcent_iva]" ) ;
		 var PsIVA 			= $( "input[id=PsIVA]" ) ; 
		 if (porcent_iva.val() > 0)
			{presioVenta.val( pNuevo);
			var valIva = parseInt('1.'+porcent_iva.val()); 
			PsIVA.val(parseFloat( pNuevo /valIva ).toFixed(2))
			iva.val(parseFloat(presioVenta.val())-parseFloat(PsIVA.val()))
		}else{
			 iva.val(0) 			  	  ;
			 presioVenta.val(pNuevo)  	  ;
			 PsIVA.val(pNuevo)  		  ; 
		}
 
          padre = $('#liquidar');
         padre.find( "#_IVA" ).html( iva.val()) ;
	 padre.find( "#pVenta" ).html(presioVenta.val())  ; 
	 padre.find( "#Ps_IVA" ).html(PsIVA.val()) ; 
		
	}
	$('#nuevo_precio').addClass('hidden');
});
*/
$('#aceptar_nuevo_precio').click(function(){
	var pNuevo = parseFloat($('#nuevo_precio_value').val() ); 
	if ( pNuevo > 0){
		 var iva 			= $( "input[id=IVA]" )  ;
		 var presioVenta 	= $( "input[id=presioVenta]" )  ;
		 var porcent_iva 	= $( "input[id=porcent_iva]" ) ;
		 var PsIVA 			= $( "input[id=PsIVA]" ) ; 
		 var new_presio_sin_iva = pNuevo;
		 var new_presio_iva = 0;
		 var new_presio_con_iva = pNuevo;
		 var aux_porc_iva = porcent_iva.val();
		 if (aux_porc_iva > 0)
			{  
		   aux_porc_iva = (aux_porc_iva / 100 ) + 1;
			   
			   new_presio_sin_iva =  new_presio_sin_iva / aux_porc_iva
			   new_presio_iva = new_presio_con_iva - new_presio_sin_iva
		} 
		
		
		iva.val(parseFloat(new_presio_iva ).toFixed(2))
        PsIVA.val(parseFloat(new_presio_sin_iva ).toFixed(2) )
        presioVenta.val(new_presio_con_iva)
 
          padre = $('#liquidar');
          padre.find( "#_IVA" ).html( parseFloat(new_presio_iva ).toFixed(2)) ;
	 padre.find( "#pVenta" ).html(presioVenta.val())  ; 
	 padre.find( "#Ps_IVA" ).html(parseFloat(new_presio_sin_iva ).toFixed(2)) ; 
		
	}
	$('#nuevo_precio').addClass('hidden');
});
/////////////////////////////////////////////////////////////////
$('#nuevo_precio_value_tf').keypress(function(e){
		var tecla=e.which;
if (tecla==13){$('#aceptar_nuevo_precio_tf').trigger('click')}});


$('#aceptar_nuevo_precio_tf').click(function(){
	var pNuevo = parseFloat($('#nuevo_precio_value_tf').val() ); 
	if ( pNuevo > 0){
	    
		 var iva 			= $( "input[id=IVA]" )  ;
		 var presioVenta 	= $( "input[id=presioVenta]" )  ;
		 var porcent_iva 	= $( "input[id=porcent_iva]" ) ;
		 var PsIVA 			= $( "input[id=PsIVA]" ) ; 
		 //alert(porcent_iva.val())
		 var new_presio_sin_iva = pNuevo;
		 var new_presio_iva = 0;
		 var new_presio_con_iva = pNuevo;
		 var aux_porc_iva = porcent_iva.val();
		 if (aux_porc_iva > 0)
			{  
		   aux_porc_iva = (aux_porc_iva / 100 ) + 1;
			   
			   new_presio_sin_iva =  new_presio_sin_iva / aux_porc_iva
			   new_presio_iva = new_presio_con_iva - new_presio_sin_iva
			    
		//	var valIva = parseInt('1.'+porcent_iva.val()); 
		//	PsIVA.val(parseFloat( pNuevo /valIva ).toFixed(2))
		//	iva.val(parseFloat(presioVenta.val())-parseFloat(PsIVA.val()))
		} 
		
		//presioVenta.val( );
		
        iva.val(parseFloat(new_presio_iva ).toFixed(2))
        PsIVA.val(parseFloat(new_presio_sin_iva ).toFixed(2) )
        presioVenta.val(new_presio_con_iva)
        
   var padre = $('#transformar');
	 padre.find( "#_IVA" ).html( parseFloat(new_presio_iva ).toFixed(2)) ;
	 padre.find( "#pVenta" ).html(presioVenta.val())  ; 
	 padre.find( "#Ps_IVA" ).html(parseFloat(new_presio_sin_iva ).toFixed(2)) ; 
          
	}
	$('#nuevo_precio_tf').addClass('hidden');
});
///////////////////////////////////////////////////////////////////

	 $(document).mousemove(function(event){
    //$('#cordinates').text(event.pageX + ", " + event.pageY);
	if(event.pageY <=45){
		if($('#mostrar_header').val()=='n'){$('#header').toggle(700, function() {});
		$('#mostrar_header').val('y')
		}
		}
  });
$('#tipoVentaDD a').click(function(e){
	var tVenta 
	e.preventDefault();
	tVenta =$(this).attr('id')
	switch (tVenta)
	{
	case  'v_efectivo':
		$('#tipoVenta').html('EFECTIVO')
	break;
	case 'v_credito' :
		$('#tipoVenta').html('CREDITO')
	break;
	case 'v_tarjeta' :
		$('#tipoVenta').html('ELECTRONICA')
	break;
	}
});
$('#header').mouseleave(function(){
$(this).toggle(700, function() {});
if($('#mostrar_header').val()=='y'){
$('#mostrar_header').val('n')}
});
//$('#header').unbind('mouseleave');
$('#lb_quitar_header').click(function(){
	if($('#mostrar_header').val()=='y'){
			$('#mostrar_header').val('n')}
	$('#header').toggle(700, function() {});
	$('#lb_quitar_header').css('display','none');
	$('#lb_mostrar_header').css('display','inline');
	});
$('#lb_mostrar_header').click(function(){
	if($('#mostrar_header').val()=='n'){
			$('#mostrar_header').val('y')}
	$('#header').toggle(700, function() {});
	$('#lb_mostrar_header').css('display','none');
	$('#lb_quitar_header').css('display','inline');
	});	
$("#frame1").niceScroll( {cursorcolor:"#8EACF2"});
	$("iframe").niceScroll( {cursorcolor:"#8EACF2"});
	////////modulo busqueda
	$('#id_producto').focus(function(){
		$(this).attr('readonly',false)
		$('#id_producto').val('')
	}).blur(function(){
		$(this).attr('readonly',true)
	})
	$(document).keydown(function(e){
		//alert(e.keyCode)
		var tecla=e.keyCode;
		if(tecla==118){
			$('#id_producto').parent().removeClass('hidden')			
			$('#id_producto').focus();
	}
		if(tecla==27){$("#cerrarBuscar").trigger("click");
		$("#cerrarConf").trigger("click");
	}
	if(tecla==113){$('#inicioBuscar').trigger("click");
	}
	if(tecla==115){$("#config").trigger("click");
	}
	});	
	$("#busqueda").keyup(function(){
	$('#frameBusqueda').attr('src',"busquedaFrame.php?id="+encodeURIComponent($(this).val())+"&nocache=" + Math.random());});
	$("#cerrarBuscar").click(function(){
		$('#id_producto').focus();
		$("#busquedaArticulo").css("display","none")
		});	
	$('#limpiar').click(function(){
	$("#busqueda").val('');	
	$('#busqueda').focus();
	$('#frameaux').attr('src',"busquedaFrame.php");
	})
	$('#inicioBuscar').click(function(){
		$("#limpiar").trigger("click");
			OcultaYMuestra("","#busquedaArticulo");
		$('#busqueda').focus();
			});	
	///////fin modulo		
	$('#abrirCajon').click(function(){
			$.ajax({
						url: 'abrirCaja.php',  
						type: 'POST',
						
						data: false,
						});
			});	
////////////////////////////////////////////////////////////////////////////////////				
			OcultaYMuestra("#Mostrar");
//////////////////////////////////////////////////		
$("#config").click(function(){OcultaYMuestra("","#configuracion");});
$("#cerrarConf").click(function(){OcultaYMuestra("#configuracion");});
/////////////////////////////////////////////77777
////////inicio//////
//String.fromCharCode(e.which)
 
$("#cuerpo_cliente :input").keyup(function(e){
		var tecla=e.which;
                 
				if (tecla==13){
					if($("#auxNombre").val()!=""){var llamado;
						if($("#llamado").val()=="actualizacion"){llamado="actualizar";}else{llamado="crear";}	
				var datosAjax='idCliente='+encodeURIComponent($("#id_tabla_cliente").val())
				+'&nit='+encodeURIComponent($("#mod_id_cliente").val())
				+'&nombre='+encodeURIComponent($("#auxNombre").val())
				+'&razonSocial='+encodeURIComponent($("#auxNombre").val())
				+'&telefono='+encodeURIComponent($("#auxTelefono").val())
				+'&email='+encodeURIComponent($("#auxEmail").val())
				+'&direccion'+encodeURIComponent($("#auxDireccion").val())
				+'&IdVenta='+encodeURIComponent($("#IdVenta").val())
				+'&procesoDB='+encodeURIComponent(llamado)
				+'&llamado='+encodeURIComponent("agregar")
				+"&nocache=" + Math.random();
				$.ajax({
						url: '../agregaPaciente.php',  
						type: 'POST',
						
						data: datosAjax	,
						 error: function(xhr, ajaxOptions, thrownError) {
							alert(xhr.status);
							alert(ajaxOptions);  
							alert(thrownError);},
						statusCode: {
							404: function() { alert( "pagina no encontrada" ); },
							408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
								 },
 						success: function(data) {
								$('#frame_facturas').attr('src', $('#frame_facturas').attr('src'));
								$("#llamado").val('');
								}	
					});
						}else{
					alert("el nombre no debe estar en blanco")
					$("#auxNombre").focus()
					}}});					
$("#mod_id_cliente").keyup(function(e){
		//alert(e.which)
		var tecla=e.which;
				if (tecla==13){
				$('#enterBtn').trigger('click');
				}
	});
$(document).keyup(function(e){
		//alert(e.which)
		var tecla=e.which;
				if (tecla==13){
				if($("#llamado").val()=="actualizacion"){
					
				}
				}
	});
$('#enterBtn').click(function(){
		if(Trim($("#mod_id_cliente").val())==""){}
				else{
				var llamado
				if($("#llamado").val()=="actualizacion"){llamado="actualizar";}else{llamado="revisar";}	
				var datosAjax='idCliente='+encodeURIComponent($("#mod_id_cliente").val())
				+'&IdVenta='+encodeURIComponent($("#IdVenta").val())
				+'&llamado='+encodeURIComponent(llamado)
				+"&nocache=" + Math.random()
				// alert(datosAjax);
				$.ajax({
						url: '../agregaPaciente.php',  
						type: 'POST',
						
						data: datosAjax,
						dataType: "json", 						
						 error: function(xhr, ajaxOptions, thrownError) {
							console.log('fail: '+xhr.status +thrownError);   },						 
 						success: function(data) { 
						//console.log('done'+ JSON.stringify(data ) ); 
								var datos=data["datos"];
								var filas=data["filas"];
								var error=data["error"];
								if(filas !=0){
								$("#llamado").val('');
								//alert(error)
								$('#frame_facturas').attr('src', $('#frame_facturas').attr('src'));
								}else{
								if(error!=""){
								 r = confirm(error);
							if(r==true){
								OcultaYMuestra("","#cuerpo_cliente");
								$("#auxNombre").focus()}
							}}}
			});	
		}
	});
	$("#cambiaCliente").click(function(){
		$("#llamado").val("actualizacion");
		OcultaYMuestra("#container","#mod_usuario");
		OcultaYMuestra("","#mod_insert_user");
		$("#mod_id_cliente").focus();
		});
////////////////la funcion que muestra los modulos de venta o de ingreso del cliente esta en listapedido//
////////////////////////////////////////////////77777
$("#cambiaCajero").click(function(){
		OcultaYMuestra("#container","#mod_Cajero");
		$('#auxUsuario').val('');
		$('#auxClave').val('');
		$('#auxUsuario').focus();
		});
$("#Ccambio_cajero").click(function(){
		OcultaYMuestra("#mod_Cajero","#container");
		});		
$('#auxUsuario').keyup(function(e){
		var tecla=e.keyCode;		
	if(tecla==13){
		$('#auxClave').focus();	
	}
	});
$('#auxClave').keyup(function(e){
		var tecla=e.keyCode;		
	if(tecla==13){
		$('#aceptar_cajero').trigger("click");
	}
	});
$("#aceptar_cajero").click(function(){
var datosAjax = 'user='+encodeURIComponent($('#auxUsuario').val())
				+'&pass='+encodeURIComponent($('#auxClave').val())
				+"&nocache=" + Math.random();
				// alert(datosAjax);
		$.ajax({
						url: '../cambioSesion.php',  
						type: 'POST',
						
						data: datosAjax,
						dataType: "json", 						
						 error: function(xhr, ajaxOptions, thrownError) {
							alert(xhr.status + ' '+thrownError);   },						 
 						success: function(data) { 
								var datos=data["datos"];
								var filas=data["result"];
								var error=data["error"];
								if(filas =='ok'){
								$('#N_cajero').html(data["nombre_cajero"])
								$('#mod_Cajero').append('<div class="alert alert-success" role="alert" id="respuestaOK"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <span class="sr-only">ok:</span>'+error+', CAJERO: '+data["nombre_cajero"]+'</div>')
									window.setTimeout("$('#respuestaOK').remove();OcultaYMuestra('#mod_Cajero','#container');",1500); 
								}else{
									
								$('#mod_Cajero').append('<div class="alert alert-danger" role="alert" id="respuestaOK"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <span class="sr-only">ok:</span>'+error+'</div>')
									window.setTimeout("$('#respuestaOK').remove()",1900); 
							}}});
		});

$('iframe').load(function(){ 
if($("#activaContainer").val()=='activo')
{
$('#mod_usuario').fadeOut()
$("#container").show()
}
else {$('#mod_id_cliente').focus();}
		});
$("body").append(		
"<div id='cierreResult' style='border-style: solid; padding:15 ; margin-right:-175;right:50%;top:10%; background-color:#FFFFFF; width: 350px;  display:none; font-weight: bold; position: absolute; ' >"+
"<style> #tblcierreResult td {font-size:11px; height:15px}</style>"+
" <table class='table' id='tblcierreResult'><tr><td align='right' style='width:50%'>   Fecha :  </td><td>  <span id='rsc_fecha'></span> | <span id='rsc_horas'></span><image src='../imagenes/ajax-loader.gif' id='img_c_0' class='img_c' width='20px' height='20px'></td></tr> "+
" <tr><td align='right'> Usuario :  </td><td><span id='rsc_user'></span> <image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_1' class='img_c'></td></tr>"+
" <tr><td align='right'> Saldo Inicial :  </td><td><span id='rsc_saldoInicial'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_2' class='img_c'></td></tr>"+
" <tr><td align='right'>  Total Venta :  </td><td>   <span id='rsc_totalVenta'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_3' class='img_c'></td></tr>"+
" <tr><td align='right'>Total Abonos_cartera :  </td><td>   <span id='rsc_total_abonos_cartera'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_4' class='img_c'></td></tr>"+
" <tr><td align='right'>   Total Nomina :  </td><td>   <span id='rsc_total_nomina'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_5' class='img_c'></td></tr>"+
" <tr><td align='right'> Total Compras :  </td><td>   <span id='rsc_TOTAL_COMPRAS'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_6' class='img_c'></td></tr>"+
" <tr><td align='right'> Total Efectivo :  </td><td>   <span id='rsc_totalEfectivo'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_8' class='img_c'></td></tr>"+
" <tr><td align='right'> Total pagos iva :  </td><td>   <span id='rsc_total_pagos_iva'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_9' class='img_c'></td></tr>"+
" <tr><td align='right'>Total Abonos Credito :  </td><td>   <span id='rsc_total_abonos_credito'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_10' class='img_c'></td></tr>"+
" <tr><td align='right'>   Total Retiro :  </td><td>   <span id='rsc_totalRetiro'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_11' class='img_c'></td></tr>"+
" <tr><td align='right'>    Total Gasto :  </td><td>   <span id='rsc_totalGasto'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_12' class='img_c'></td></tr> "+
" <tr><td align='right'>   Saldo Actual :  </td><td>   <span id='rsc_saldoActual'></span><image src='../imagenes/ajax-loader.gif' width='20px' height='20px' id='img_c_7' class='img_c'></td></tr>"+
" <tr><td align='right' colspan='2'>  <input type='button' id='btn_close_cierreCaja' value='ok'/></td></tr></table>"+
"</div>");
	
$("#btn_cierreCaja").click(function(){
	OcultaYMuestra( "#container","#cierreResult");
	$("#btn_close_cierreCaja").attr('disabled',true)
	$('#img_c_').css('display','block')	
	$.ajax({url: '../cierres/cierre_automatico.php',  
			type: 'POST',
			
			data: null,
			dataType: "json", 						
			error: function(xhr, ajaxOptions, thrownError) {
					//alert('estatus: '+xhr.status + ' || error '+thrownError+' || error ' );
					alert (JSON.stringify(xhr)); 					},						 
 			success: function(data) { 
				console.log(JSON.stringify(data)); 	
				var datos=data["datos"];
				var resultado=data["resultado"];
				var error=data["msq"];
				if(resultado =='ok'){
					$('#rsc_fecha').html(data["fecha"])
					$('#rsc_horas').html(data["horas"])
					$('#img_c_0').css('display','none')
					$('#rsc_user').html(data["user"])
					$('#img_c_1').css('display','none')
					$('#rsc_saldoInicial').html(data["saldoInicial"])
					$('#img_c_2').css('display','none')
					$('#rsc_totalVenta').html(data["totalVenta"])
					$('#img_c_3').css('display','none')
					$('#rsc_total_abonos_cartera').html(data["total_abonos_cartera"])
					$('#img_c_4').css('display','none')
					$('#rsc_total_nomina').html(data["total_nomina"])
					$('#img_c_5').css('display','none')
					$('#rsc_TOTAL_COMPRAS').html(data["TOTAL_COMPRAS"])
					$('#img_c_6').css('display','none')
					$('#rsc_saldoActual').html(data["saldoActual"])
					$('#img_c_7').css('display','none')
					$('#rsc_totalEfectivo').html(data["totalEfectivo"])
					$('#img_c_8').css('display','none')
					$('#rsc_total_pagos_iva').html(data["total_pagos_iva"])
					$('#img_c_9').css('display','none')
					$('#rsc_total_abonos_credito').html(data["total_abonos_credito"])
					$('#img_c_10').css('display','none')
					$('#rsc_totalRetiro').html(data["totalRetiro"])
					$('#img_c_11').css('display','none')
					$('#rsc_totalGasto').html(data["totalGasto"]) 
					$('#img_c_12').css('display','none')
					}else{
						$('#cierreResult').append('<div class="alert alert-danger" role="alert" id="respuestaOK"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> <span class="sr-only">ok:</span>'+error+'</div>')
									window.setTimeout("$('#respuestaOK').remove()",1900); 
							}
	$("#btn_close_cierreCaja").removeAttr('disabled')}});
});	
$("#btn_close_cierreCaja").click(function(){
	OcultaYMuestra( "#cierreResult","#container");
});	
//$('#cant_venta_tranformada')
$('#cantTranformada').keyup(function(){
   // alert('entro')
    var cantidad = $('#cantTranformada').val();
   if ($('#cantTranformada').val() == '') $('#cantTranformada').val(0)
         var cantidad = $('#cantTranformada').val();
    $('.medidas').each(function(){
        if($(this).prop("checked") == true){
         //  alert('entro otra vez')
            medida = $(this)
            
        }
    }) 
      
         var pulgadas  = medida.data('pulgadas') 
         var pies  = medida.data('pies') 
         var medida = medida.val();
         
        var  total_pies = parseFloat(pies).toFixed(2)* parseFloat(cantidad).toFixed(2)
        $('#cant_venta_tranformada').val(total_pies) 
//        Global_preventa  
//        Global_PsIVA  
//        Global_IVA
        var presio_venta_unidad = parseFloat(Global_preventa).toFixed(2) * parseFloat(pies).toFixed(2);
        var presio_siva_venta_unidad = parseFloat(Global_PsIVA).toFixed(2) * parseFloat(pies).toFixed(2);
                                            
                                            $("#presioVenta").val(presio_venta_unidad)
					  $("#PsIVA").val(presio_siva_venta_unidad)
					  
        
})
		});
                

/////////////7funciones
function listar_tipos_medidas(){
    var lista = '';
  //  alert(id_grupo_producto);
    	var datosAjax = {
		tabla: 'vw_medidas_relacionadas_grupos',
		inicio: '',    
		datosRequeridos:'',
                where:true ,
                columna1:'id_grupo',
                dato:id_grupo_producto,
                igual:true
		/*
		proced : 'GET_PRODUC_BARCODE',
		datosProce:[valorEnviar]*/
		};		
		$.ajax({url: '../php/db_listar_nuevo.php',  
			type: 'POST',
			data: datosAjax,
			dataType: "json",
			 beforeSend: function() {
				//console.log(JSON.stringify(datosAjax))
                                $('#cont_lista_medidas').html(lista)
				}, 
			statusCode: {
    			404: function() {
				 alert( "pagina no encontrada" );
   				 },
				 408: function() {
				alert( "Tiempo de espera agotado. la peticion no se realizo " );
   				 } 
				 },
 			success: function(data) { 
				//console.log(JSON.stringify(data))
				var total = data['filas'];
				var datosTabla=data['datos'];
				if (total > 0 ){ 
                                    var auxDato;
                                    var medidas;
                                    
                                    var div_contenedor = '<div id="cont_medidas_%numero%" class="contenedores_medidas" >'
                                    /*var str = "Visit Microsoft!";
                                    var res = str.replace("Microsoft", "W3Schools");
                                    aux_num_medidas++;
                                        if (aux_num_medidas == 15){
                                            aux_num_medidas =0;
                                            lista += '</td><td>'
                                        }*/
                                    var aux_num_medidas = 1;
                                    var contador_medidas = 1;
                                    lista=div_contenedor.replace('%numero%' , contador_medidas )+'<table>';
				for(var i =0; i<datosTabla.length;i++){
					auxDato=datosTabla[i] ; 
                                        medidas = 'edad'+auxDato.id;
                                        if(aux_num_medidas == 15 ){
                                            contador_medidas++;
                                            aux_num_medidas = 0;
                                           lista +='</table></div>'+div_contenedor.replace('%numero%' , contador_medidas )+'<table>'
                                        }
                                        lista += '<tr><td><input type="radio" class="medidas" id="'+medidas+'" data-codigo="'+auxDato.codigo+'" '+
                                                ' data-m1="'+auxDato.m1+'" data-m2="'+auxDato.m2+'" data-m3="'+auxDato.m3+'" data-pulgadas="'+auxDato.total_pulgadas+'" '+
                                                ' data-pies="'+auxDato.total_pies+'" data-medida="'+auxDato.medida+'" value="'+auxDato.medida+'">'+auxDato.medida+
                                                '</td></tr>';
                                        aux_num_medidas++;
					}
                                       //lista+='</td></tr></tabla>';
                                       if(aux_num_medidas <= 15 ){
                                           lista+='</table></div>';
                                        }
                                        
                                       
                                        $('#cont_lista_medidas').html(lista)
                                        add_evento_nav_lista_medidas();
                                        $('.medidas').unbind('click').click(function(){
                                            $('#aux_nombre_venta').val('')
                                             $('.medidas').prop( "checked",false )
                                             $(this).prop( "checked",true )
                                             var pulgadas  = $(this).data('pulgadas') 
                                             var pies  = $(this).data('pies') 
                                             var medida = $(this).val();
                                             $('#aux_nombre_venta').val(medida)
                                             if ($('#cantTranformada').val() == '') $('#cantTranformada').val(0)
                                             var cantidad = $('#cantTranformada').val();
                                             var pies_aux = parseFloat(pies).toFixed(2);
                                             var  total_pies = pies * parseFloat(cantidad).toFixed(2)//regresar
                                             var padre_aux = $(window.parent.document);//$(padre).find
                                             var presio_venta_unidad = parseFloat( Global_preventa ).toFixed(2) * pies_aux;
                                             var presio_siva_venta_unidad = parseFloat(Global_PsIVA).toFixed(2) * pies_aux;
                                             var total_iva = parseFloat(Global_IVA).toFixed(2) * pies_aux;
                                            
                                           presio_venta_unidad = parseFloat(presio_venta_unidad).toFixed(2)
                                            presio_siva_venta_unidad = parseFloat(presio_siva_venta_unidad).toFixed(2)
                                            total_iva = parseFloat(total_iva).toFixed(2)
                                            
                                            $("#presioVenta").val(presio_venta_unidad)
					    $("#PsIVA").val(presio_siva_venta_unidad)
					    $("#IVA").val(total_iva)
                                            ////////////////////////////////////////////////////
                                            //console.log( presio_venta_unidad + presio_siva_venta_unidad + total_iva)
                                             $("#transformar").find("#pVenta").html(presio_venta_unidad)
					    $("#transformar").find("#Ps_IVA").html(presio_siva_venta_unidad)
                                            $("#transformar").find("#_IVA").html(total_iva)
                                          
                                            $("#cant_venta_tranformada").val(total_pies)
                                            
                                        })
                                        $("#transformar").css("display","inline") 
					}
                                        else{ 
						alert('no existen medidas Generadas para realizar la venta')
					}
				 },error: function(a,e,b){
					 console.log("se genero un error"+JSON.stringify(a,e,b))
					}});//fin bloque obtencion de datos producto
}



function valida_numeros(e){
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8){
        return true;
    }
        
    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
///////////////////////