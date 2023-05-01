$(document).ready(function(){
    $('#tabla_listado_compra').html('');
  $('button').click(function(e){
      e.preventDefault();
  });
  
  $('label').addClass('formulario-jds'); 
  $('input').addClass('formulario-jds');

  $('select').addClass('formulario-jds');
  
 $('form').keypress(function(e){   
    if(e == 13){
      return false;
    }
  });

  $('input').keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });
  $("#cancelAll").click(function(e){
		auxCan=elimina($("#id_de_Compra").val());
		if(!auxCan){e.preventDefault();}
		});
  $('#aceptar').click(function(e){
	e.preventDefault();
	var str="";
	var h=0;var datos_para_envio;
	datos_para_envio='id_de_Compra='+encodeURIComponent($("#id_de_Compra").val())
	+"&usuario=" + encodeURIComponent($("#usurio").val());
	
	 $(".venta").each(function() {
			if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;$(this).focus();
			 return false;
			}else{
				datos_para_envio=datos_para_envio+"&"+$(this).attr("name")+"="+encodeURIComponent(Trim($(this).val()));
				}
    });
	if(h==0){		
		datos_para_envio=datos_para_envio+"&nocache=" + Math.random();
		console.log(datos_para_envio)
		$.ajax({
				url: 'saveCompra.php',  
				type: 'POST',
				
				data: datos_para_envio,
				success: function(respuesta){
					//alert(respuesta)
					console.log(respuesta)
					if(respuesta==1)
                                            cargar_compra();
					$(".venta").val("");
					$("#nombreP").html("&nbsp;");
						}
					});
		}
});
 
$('#buscarProducto').click(function(e){
e.preventDefault();
});

$('#final').click(function(){
	var si=true;
	if( $("#fechaIngreso").val()==""  ){si=false; alert("DEBE ESCOGER UNA FECHA...."); return false}
	if($("#provedor").val()=="0"){si=false;alert("DEBE ESCOGER UN PROVEDOR....");  return false}
	if ((parseFloat($("#val_subtotal_compra").val()) >= parseFloat($('#base_retefuente').val())) && ($("#retefuente_aplica").val()=="S" || $("retefuente_aplica").val()=="s" ))
	{$("#retefuente_div").css("display","block"); 
		si=false; return false
	}
	if($("#tipo_de_compra").val()=="2"){ $("#credito").css("display","block"); 
		datos_para_envio='id_de_Compra='+encodeURIComponent($("#id_de_Compra").val());
		$.ajax({
				url: 'revisaTotalCompra.php',  
				type: 'POST',
				
				data: datos_para_envio,
				success: function(respuesta){
					//alert(respuesta)
				$("#costoParcial").val(respuesta);
				$("#valCuotah").val(respuesta);
				$("#TotalInicialh").val(respuesta);
				$("#valCuota").html(respuesta);
				$("#TotalInicial").html(respuesta);
				
				}
					});
	si=false; return false}
	if(si){
	$("#enviar").trigger('click');
	}});

$("#precio").keyup(function(){
	if ((/^([0-9])*[.]?[0-9]*$/.test($(this).val()))&&(/^([0-9])*[.]?[0-9]*$/.test($("#cantidad").val()))){
	var valor=$(this).val()*$("#cantidad").val();
	$("#Tventa").val(valor);}else{$("#Tventa").val("");}
	});
	
$("#abono").keyup(function(){
	if (/^([0-9])*[.]?[0-9]*$/.test($(this).val())){
	var valor=$("#costoParcial").val()-$(this).val();
	$("#TotalInicial").html(valor);
	$("#valCuota").html(valor);
	$("#TotalInicialh").val(valor);
	$("#valCuotah").val(valor);
	}else{
		$("#TotalInicial").html($("#costoParcial").val());
		$("#valCuota").html($("#costoParcial").val());
		$("#TotalInicialh").val($("#costoParcial").val());
		$("#valCuotah").val($("#costoParcial").val());}
	});

$("#numeroCuotas").keyup(function(){var valor
	if ((/^([1-9])*$/.test($(this).val()))  &&  (Trim($(this).val())!="")){
	valor=parseInt($("#TotalInicialh").val())/parseInt($(this).val());
	}
	else{
		valor=$("#costoParcial").val();
	}$("#valCuotah").val(valor);$("#valCuota").html(valor);
	});	
	
$("#cantidad").keyup(function(){
    /*
     *  if (!/^([0-9])*[.]?[0-9]*$/.test(numero))
     * 
     */ 
	if ((/^([0-9])*[.]?[0-9]*$/.test($(this).val()))&&(/^([0-9])*[.]?[0-9]*$/.test($("#precio").val()))){
	var valor=$(this).val()*$("#precio").val();
	$("#Tventa").val(valor);}else{$("#Tventa").val("");}
	});
$("#precio").change(function(){
	$(this).trigger("keyup");
	
	
	});
$("#cantidad").change(function(){
	$(this).trigger("keyup");
	});
	//class='boton_cancel' data-container
$('.boton_cancel').click(function(e){
	e.preventDefault;
	var id_container = $(this).data('container');
	$(id_container).css('display','none');
})
$('#cierraRetefuente').click(function(e){
	e.preventDefault;
	$('#retefuente_div').css('display','none');
	si=true;
	if($("#tipo_de_compra").val()=="2"){ $("#credito").css("display","block"); 
		datos_para_envio='id_de_Compra='+encodeURIComponent($("#id_de_Compra").val());
		$.ajax({
				url: 'revisaTotalCompra.php',  
				type: 'POST',
				
				data: datos_para_envio,
				success: function(respuesta){
					//alert(respuesta)
				$("#costoParcial").val(respuesta);
				$("#valCuotah").val(respuesta);
				$("#TotalInicialh").val(respuesta);
				$("#valCuota").html(respuesta);
				$("#TotalInicial").html(respuesta);
				
				}
					});
	si=false; return false}
	if(si){
	$("#enviar").trigger('click');
	}
})
//$("#codProduto").blur(function(){$("#precio").focus()})
$("#rfporcent").change(function(){
   
 $("#rftotalRetenido").val((parseFloat($('#rfventaNeta').val() || 0)*parseFloat($("#rfporcent").val() || 0))/100)
 $("#v_rftotalRetenido").val(parseFloat($("#rftotalRetenido").val() || 0).toLocaleString())
});
$("#codProduto").focus(function(){$(this).val('');$('#cantidad').val('');$('#nombreP').html('&nbsp;');$('#precio').val('');}).keyup(function(e){
	var tecla=e.keyCode;
		if(tecla==13){
			e.preventDefault();
	if (Trim($(this).val())!=""){
	var valor=$(this).val();
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
		datosProce:[valor]
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
 			success: function(data) {
				console.log(JSON.stringify(data))
				var total = data['filas'];
				datosTabla=data['datos'];
				if (total > 0 ){
				for(var i =0; i<datosTabla.length;i++){
					auxDato=datosTabla[i]; 
					 $('#InombreP').val(auxDato.nombre);	
						$('#nombreP').html(auxDato.nombre);
						$('#precio').val(auxDato.precioCompra );
						$('#codProduto').val(auxDato.idProducto);
					  
					}
					 $('#cantidad').focus();
					}else{
						$("#codProduto").val('').focus();
						$('#InombreP').val('');	
						$('#nombreP').html('&nbsp;');
						$('#precio').val('');
						$("#precio").trigger("keyup");
					}
				},error: function(a,e,b){
					 console.log("se genero un error"+JSON.stringify(a,e,b))
					}});//fin bloque obtencion de datos producto

		
		
	}}
    
	});
$("#codProduto").focus();

cargar_compra();
});			 
function cargar_compra()
{
    $('#tabla_listado_compra').html('');
    let idCompra = $('#id_de_Compra').val()
    let datos='dato='+encodeURIComponent(idCompra)
             +"&tabla="+encodeURIComponent("listacompra")
	     +"&col="+encodeURIComponent('idCompra');
         // mostrarDetalleFactura.php?tabla=listacompra
        // &dato=<?PHP echo $compraID;?>&col=idCompra" id="frame1" ></iframe>-->
	$.ajax({
			url: 'mostrarDetalleFactura.php',  
			type: 'GET',
			
			data: datos,
			success: function(responseText){
			//alert(responseText)
                        $('#tabla_listado_compra').html(responseText);
			}
		});
	}
	 
function elimina(dato){
	r = confirm("REALMENTE DESEA CANCELAR LA COMPRA\n\rEsto borrara completamente la compra del sistema y reversara los productos ingresados.");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent("listacompra")
		  +"&columna="+encodeURIComponent('idCompra');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			//alert(responseText)
			}
		});
	}
	return r;
	}
	 
  