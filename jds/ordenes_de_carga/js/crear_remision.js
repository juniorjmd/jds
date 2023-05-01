$(document).ready(function(){
 
 /////////////////////////////////////////////
 $("#codProduto").focus(function(){$(this).val('');  
        $("#Presio_producto").val('');
	$("#Presio_sin_iva_producto").val('');
	$("#total_remision").val('');
        $('#iva_producto').val('')  ;
        $('#InombreP').val('');	
        $('#codProduto').val('');
        $('#porcent_iva').val('');          
 }).keyup(function(e){
     $.colorbox.close();
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
                var url = $('#url_base_aplicacion').val()+'php/db_listar_nuevo.php'
                //alert(url)
		$.ajax({url: url ,  
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
                                                
                                         id_grupo_producto_activo = auxDato.idGrupo 
                                        Global_preventa = auxDato.precioVenta 
                                        Global_PsIVA =auxDato.PsIVA 
                                        Global_IVA = auxDato.IVA 
                                        Global_porcent_IVA = auxDato.porcent_iva 
					  
					}
                                        
                                        if(auxDato.tipo_producto  == 'MT')
                                        {
                                            $('#cantidad_producto').prop('readonly', true);

                                            listar_tipos_medidas_creadas();
                                        }else{
                                            $('#cantidad_producto').val(0)//.attr('readonly', true);
                                            $('#cantidad_producto').prop('readonly',false).focus();
                                             
                                            $('#cantidad_producto_real').val(0)
                                            $('#Presio_sin_iva_producto').val(Global_PsIVA)
                                            $('#iva_producto').val(Global_IVA)
                                            $('#Presio_producto').val(Global_preventa) 
                                        }
					}else{
						$("#codProduto").val('').focus();
						$('#InombreP').val('');	
						$('#nombreP').html('');
						$('#precio').val('');
                                                $('#cancelar_ing_transf').trigger('click')
					}
				},error: function(a,e,b){
					 console.log("se genero un error"+JSON.stringify(a,e,b))
					}});//fin bloque obtencion de datos producto

		
		
	}}
	});
 //////////////////////////////////
  $('#cerrar_remision').click(function(){
 $('#enviar_cierre_remision').trigger('click')
  });
 ///////////////////////////////////
 $('#limpiar_campos').click(function(){
  $('#cancelar_ing_transf').trigger('click')
 });
  $('#enviar_datos').click(function(){
      
      var exit = false; 
       if(exit){return;}
      $('#submit_envio_datos').trigger('click');
  })
  $('#buscarProducto').unbind('keyup').unbind('keydown').unbind('keypress')
  $('#buscarProducto').click(function(e){
e.preventDefault();
$.colorbox({overlayClose:false, inline:true, href:"#busquedaArticulo",width:"800px", height:"400px"});
								});
                                                             
$('#cantTranformada').keyup(function(){
   // alert('entro')
   
    var cont =  $(this) ;
    if (Trim($(this).val()) == '' )
    {$(this).val(0);
    return false;
        } 
   try{
    var nwCNT =  $(this).val().replace(',','.')
    
    var repetir = 0;
    for (i = 0 ; i< nwCNT.length;i++)
    {  if(nwCNT[i] == '.'){
         repetir++;   
    } 
    } 
    if (/^([0-9])*[.]?[0-9]*$/.test(nwCNT)){}else{
        $(this).val(0);
            alert('error : La cantidad digitada(tranf) no es un numero valido '  );
        return false;}
     var axnwCNT
        axnwCNT =  parseFloat(nwCNT) 
    if (Number.isNaN(axnwCNT) || repetir>1) 
     throw "exite un error en la cantidad (tranf)"  
 
   $(this).val(nwCNT) 
   
     
  
         var cantidad = $('#cantTranformada').val();
         
         var pulgadas  = 0 
         var pies  = 0
         var medida = 0
    $('.medidas').each(function(){
        if($(this).prop("checked") == true){
         //  alert('entro otra vez')
            medida = $(this)
            pulgadas  = medida.data('pulgadas') 
            pies  = medida.data('pies') 
            medida = medida.val();
        }
    }) 
      
         
        var  total_pies = parseFloat(pies).toFixed(2)* parseFloat(cantidad).toFixed(2)
        $('#cantidad_producto').val(cantidad)
        $('#cantidad_producto_real').val(total_pies) 
//        Global_preventa  
//        Global_PsIVA  
//        Global_IVA
        var presio_venta_unidad = parseFloat(Global_preventa).toFixed(2) * parseFloat(pies).toFixed(2);
        var presio_siva_venta_unidad = parseFloat(Global_PsIVA).toFixed(2) * parseFloat(pies).toFixed(2);
        var presio_iva_unidad = parseFloat(Global_IVA).toFixed(2) * parseFloat(pies).toFixed(2);
        
        $('#iva_producto').val(presio_iva_unidad)  
        $("#Presio_producto").val(presio_venta_unidad)
	$("#Presio_sin_iva_producto").val(presio_siva_venta_unidad)
        
	$("#total_remision").val(presio_venta_unidad * cantidad)
	}   
   catch(err){
       alert('error : ' + err );
       return false;
   } 				  
        
})
$('#cantidad_producto').keyup(function(){  
    
        var cont =  $(this) ;
    if (Trim($(this).val()) == '' )
    {$(this).val(0);
    return false;
        } 
   try{
    var nwCNT =  $(this).val().replace(',','.')
    
    var repetir = 0;
    for (i = 0 ; i< nwCNT.length;i++)
    {  if(nwCNT[i] == '.'){
         repetir++;   
    } 
    } 
    if (/^([0-9])*[.]?[0-9]*$/.test(nwCNT)){}else{
        $(this).val(0);
            alert('error : La cantidad digitada no es un numero valido '  );
        return false;}
    var axnwCNT
        axnwCNT =  parseFloat(nwCNT) 
    if (Number.isNaN(axnwCNT) || repetir>1) 
     throw "exite un error en la nueva cantidad " ; 
 
   $(this).val(nwCNT);
   $('#cantidad_producto_real').val($(this).val()) ;
   
   $('#Presio_sin_iva_producto').trigger('keyup')
   
    }   
   catch(err){
       alert('error : ' + err );
       return false;
   }     
})                              
$(".listaInv").click(function(){
elimina_articulo($(this).attr("id"),'rest_remision')
});
$('#Presio_sin_iva_producto').keyup(function(){
    $(this).val()
    var porcent_iva =  $('#porcent_iva').val()
    var cantidad_producto = $('#cantidad_producto').val()
     if (cantidad_producto == '')cantidad_producto =0;
    var iva_producto = (porcent_iva * $(this).val() )/100;    
    $('#iva_producto').val(iva_producto)
     $('#Presio_producto').val(parseFloat($(this).val()) + parseFloat(iva_producto))
     
    $('#total_remision').val($('#Presio_producto').val() * parseFloat(cantidad_producto))
    
});
OcultaYMuestra("#medidas","#creacion");
$('#ingreso_medidas').click(function(){ 
    if ($('#cantTranformada').val() == 0 || $('#cantTranformada').val() == ''){alert('la cantidad a vender no debe ser mayo a cero');return;}
    if ($('#aux_nombre_venta').val() == ''){alert('Debe seleccionar una medida de corte');return;}
    OcultaYMuestra("#medidas","#creacion");
}) 
$('#cancelar_ing_transf').click(function(){
    $('.remision').val('');
    OcultaYMuestra("#medidas","#creacion");
})
});