 var T_find = new Object();
var countRegistros = 0;
T_find.CargadorContenidos = function(){
    this.cargador_eventos();
}
T_find.CargadorContenidos.prototype = {
    cargador_eventos: function()	
    { 
      //$('#principal').html("se cargo todo")
      $("#formularioOperaciones").find("input").click(function(event){
             event.preventDefault();
        });
        
      $('#crearRegistro').click(function(){
          countRegistros++;
          var debito = $('#debito').val();
          var credito = $('#credito').val();
          var numCuenta = $('#codCuenta').val();
          var nomCuenta = $('#nombreSubCuenta').val();
          if(debito == '' ){debito = 0; }
          if(credito == '' ){credito = 0;}
          if(numCuenta == '' || nomCuenta == ''){alert('Debe seleccionar una cuenta valida');return;}          
          if(debito == 0 && credito == 0  ){alert('Debe existir un monto Debito o Credito para generar el registro');return;}
          ////////////////////////////////////////////
          var elmTabla=document.getElementById("tbTablaTransacciones");
	var elmTR=document.createElement("tr"); 
	var elmTD=document.createElement("td");
	elmTD.innerHTML=numCuenta + "<input type='hidden' value='"+numCuenta+"' name='reg["+countRegistros+"][numCuenta]' >";
	elmTR.appendChild(elmTD); 
	var elmTD=document.createElement("td");
	elmTD.innerHTML=nomCuenta;
	elmTR.appendChild(elmTD);
	var elmTD=document.createElement("td"); 
	elmTD.innerHTML=debito+ "<input type='hidden' value='"+debito+"' name='reg["+countRegistros+"][debito]' >";
	elmTR.appendChild(elmTD);
        
	var elmTD=document.createElement("td"); 
	elmTD.innerHTML=credito+ "<input type='hidden' value='"+credito+"' name='reg["+countRegistros+"][credito]' >";
	elmTR.appendChild(elmTD);
        
        var elmTD=document.createElement("td"); 
	elmTD.innerHTML='<button class="dltRegistro" > - </button>';
        
	elmTR.appendChild(elmTD); 
	elmTabla.appendChild(elmTR);
        $('#debito').val('');
        $('#credito').val('');
        $('#codCuenta').val('');
        $('#nombreSubCuenta').val('');
        $('.dltRegistro').unbind('click').click(function(){
            $(this).parent().parent().remove();
        })
    })
      $('#btnCancelar').click(function(){ 
        $('#tablaDeDatos').find(" [type='text']").val('')
        $('#tbTablaTransacciones').html('')
        $('#PadreId').val('')
        $('#PadreId').val('')
        $(" [type='text']").val('')
      }); 
      $('#enviar_datos').click(function(e){
          e.preventDefault
      var nitBusqueda   = $('#nitBusqueda').val(); 
      var nomPersona   = $('#pagadoA').val(); 
      var nombreOperacion   = $('#nombreOperacion').val(); 
      if (countRegistros==0){alert('no existen transacciones agregadas!'); return ;}
      if(nitBusqueda == '' || nomPersona == ''){alert('Debe seleccionar una persona valida');return;}    
      if(nombreOperacion == ''){alert('Debe ingresar el nombre de la operacion a realizar');return;}    
            
      $.ajax({
        url: 'view/action/action.php',  
        type: 'POST',
        async: true,
        dataType: "json",
        data: $('#formularioOperaciones').serialize()	,
         error: function(xhr, ajaxOptions, thrownError) {
                console.log(JSON.stringify(xhr.status));
                console.log(JSON.stringify(ajaxOptions));  
                console.log(JSON.stringify(thrownError));},
        beforeSend: function() {
            console.log(JSON.stringify($('#formularioOperaciones').serialize()));
                $('#tablaResultado').hide()
                }, 
        statusCode: {
                404: function() { alert( "pagina no encontrada" ); },
                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                         },
        success: function(objeto_json) {
             console.log(JSON.stringify(objeto_json))
          $('#tablaResultado').show()
               var msg = '';  
             var error=objeto_json["error"]; 
             switch(error){
                 case  'ok': 
                     $('#btnCancelar').trigger('click');
                     alert('Los datos fueron ingresados con exito!!!!')
                 break;
                 case  'not ok': 
                      msg = 'ERROR  no se pudo ingresar la información en la base de datos. ';
                    alert(msg);
                 break;
             default  :
                 msg = ' !'+error+' ';
                    alert(msg);
                break; 
             }
            

        }	
    });
  })
        
    }

} 
 