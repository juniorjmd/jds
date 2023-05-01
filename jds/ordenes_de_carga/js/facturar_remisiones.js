$(document).ready(function(){
/*
 * devolucion' data-orden_de_compra='{$id_orden_compra}' data-codigo_remision='{$row["id_remision"]}' 
 *   <input type="hidden" id="dev_id_orden_compra" name="dev_id_orden_compra" />
              <input type="hidden" id="dev_id_remision" name="dev_id_remision" />
              <input type="submit" id="enviar_devolucion"/>
 */ 
$('.devolucion').click(function(){
   var orden = $(this).data('orden_de_compra');
   var remision =  $(this).data('codigo_remision'); 
   $('#dev_id_orden_compra').val(orden)
   $('#dev_id_remision').val(remision)
   $('#enviar_devolucion').trigger('click')
      
})
 $('#facturar_orden_compra').click(function(){ 
     $('#tipo_venta').val('EFECTIVO').trigger('change');  
     $("#_porc_retefuente").val( $("#aux_porc_retefuente").val() )
     $('#_pago_retefuente').val('N').trigger('change')
  }); 
 $('#_pago_retefuente').change(function(){
     var prop = false;
     if($(this).val()=='N'){
         prop = true;
     }
     $("#_porc_retefuente").prop('readOnly',prop)
 })
$('#generar_facturacion').click(function(){
    var tipoVenta = $('#tipo_venta').val();
    if (tipoVenta == 'CREDITO'){ 
        
       // _abonoInicial
       // _numCuotas
       // _intervalo
        if($('#_intervalo').val()==''){alert('debe escoger el tipo de pago!!');return;}
        if($('#_numCuotas').val()=='' || $('#_numCuotas').val()==0){alert('debe ingresar el numero de cuotas!!');return;}        
        if($('#_abonoInicial').val()==''){$('#_abonoInicial').val(0)}
        
        
    }else if(tipoVenta == 'ELECTRONICA'){
        if($('#_num_vauche').val()==''){alert('debe ingresar numero del vauche');return;}
    }
 $('#enviar_orden_compra').trigger('click')
  }); 

$('#tipo_venta').change(function(){
     
         $('.venta_datafono').val('').fadeOut()
         $('.venta_credito').val('').fadeOut()
     
    if ($(this).val() == 'CREDITO'){
        $('.venta_credito').fadeIn()
    }else if($(this).val() == 'ELECTRONICA'){
        $('.venta_datafono').fadeIn()
    }
    
})
});