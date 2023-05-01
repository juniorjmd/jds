$(document).ready(function(){
 
 ///////////////////////////////////////////// 
 //////////////////////////////////
  $('#cerrar_remision').click(function(){
 $('#enviar_cierre_remision').trigger('click')
  });
 ///////////////////////////////////
 $('#limpiar_campos').click(function(){
  $('#cancelar_ing_transf').trigger('click')
 });
  $('#enviar_devolucion').click(function(){
      var exit = true; 
      $('.inp_dev').each(function(){
          if($(this).val() > 0)
          {exit = false; 
               return false;
          }
      });
      
       if(exit){alert('No ha ingresado informaciòn para devolucion.'); return false;}
      $('#submit_envio_datos').trigger('click');
  })
  $('#buscarProducto').unbind('keyup').unbind('keydown').unbind('keypress')
  $('#buscarProducto').click(function(e){
e.preventDefault();
$.colorbox({overlayClose:false, inline:true, href:"#busquedaArticulo",width:"800px", height:"400px"});
    });
/* 
$('#cantidad_producto').keydown(function(){  
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
            alert('error : La cantidad digitada no es un numero valido '  );
        return false;}
    nwCNT =  parseFloat(nwCNT)
    
    
    
    
   if (Number.isNaN(nwCNT) || repetir>0)
     throw "exite un error en la nueva cantidad "  
 
   $(this).val(nwCNT)
   $('#cantidad_producto_real').val($(this).val()) 
   
    }   
   catch(err){
       alert('error : ' + err );
       return false;
   } 
   
})   
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
					  
        
})	
*/

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

$('.inp_dev').keyup(function(){
   // alert('entro') 
    var cont =  $(this) ;
    if (Trim($(this).val()) == '' )
    {$(this).val(0);
    return false;
        }
    var cantACT =  $(this).data('max') 
   cantACT = parseFloat(cantACT) 
   try{
    var nwCNT =  $(this).val().replace(',','.')
    
    var repetir = 0;
    for (i = 0 ; i< nwCNT.length;i++)
    {  if(nwCNT[i] == '.'){
         repetir++;   
    } 
    } 
    if (/^([0-9])*[.]?[0-9]*$/.test($(this).val())){}else{
        $(this).val(0);
            alert('error : La cantidad a enviar mayor a la cantidad actual'  );
        return false;}
    nwCNT =  parseFloat(nwCNT)
    
    
    if (cantACT < nwCNT )
    {cont.val('0'); 
        alert('error : La cantidad a enviar mayor a la cantidad actual'  );
        return false;}
    
   if (Number.isNaN(nwCNT) || repetir>1)
     throw "exite un error en la nueva cantidad "  
    }   
   catch(err){
       alert('error : ' + err );
       return false;
   } 
    
    
    }) 


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

 
   function NumCheck(e, field) {
  key = e.keyCode ? e.keyCode : e.which
  // backspace
  if (key == 8) return true
  // 0-9
  if (key > 47 && key < 58) {
    if (field.value == "") return true
    regexp = /.[0-9]{2}$/
    return !(regexp.test(field.value))
  }
  // .
  if (key == 46) {
    if (field.value == "") return false
    regexp = /^[0-9]+$/
    return regexp.test(field.value)
  }
  // other key
  return false
 
}        