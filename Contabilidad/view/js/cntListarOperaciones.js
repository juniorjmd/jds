 var T_find = new Object();

T_find.CargadorContenidos = function(){
    this.cargador_eventos();
}
T_find.CargadorContenidos.prototype = {
    cargador_eventos: function()	
    { 
      //$('#principal').html("se cargo todo")
       
       
      cargarTablas(); 
      $("#btn").click(function () {
       $("#printarea").printThis({pageTitle: "comprobante de operación" });
     });
       
    }

}
function cargarTablas(  idPadre ){   
    var idMod =  'vw_cnt_listar_operaciones';
    //vw_cnt_listar_operaciones_cont_Load_gif
     var datosAjax = {action:'LISTAR_DATOS_OPERACIONES',idPadre : idPadre,cabeceras:idMod};  
      $('#'+idMod+'_cont_Load_gif').show(function(){
                        $.ajax({
                        url: 'view/action/action.php',  
                        type: 'POST',
                        
			dataType: "json",
                        data: datosAjax	,
                         error: function(xhr, ajaxOptions, thrownError) {
                                console.log(JSON.stringify(xhr.status));
                                console.log(JSON.stringify(ajaxOptions));  
                                console.log(JSON.stringify(thrownError));},
                        beforeSend: function() {
				 console.log(JSON.stringify(datosAjax))
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
                             if (objeto_json['error'] ==''){
                                 msg = '';  
                              //  $('#tablaResultado').html(  ) 
                               for(i=0;i<objeto_json['digitosArrTamanio'];i++){
                                   
                               }
                              var cargadorLista= new cont_table.CargadorContenidos(objeto_json,objeto_json["cabeceras"],'normalNewPac','tablasLista'+idMod,'indiceLista'+idMod,'listarTabla'+idMod,
                              0,15,false,false,false,false,
                                function(){ //boton eliminar... 
                                    let padre = $(this).parent().parent() 
                                     $('.elmtPrint').html('')
                                     $('#numVolante').html(padre.find('#idAux').val())
                                     $('#descripcion').html(padre.find('#nombre').val())
                                     $('#fechaCreacion').html(padre.find('#fecha').val())
                                     $('#nombreUsuario').html(padre.find('#nombreCompleto').val())
                                     
                                     cargarListaTrn(padre.find('#cod_operacion').val())
                                     
                                   // eliminarMenu( padre.find('#id_grupo').val() , padre.find('#cod_grupo').val())
                                    //eliminarMenu(this.datoProcesar ); 
                                }); 
                                }else{
                                    msg = 'ERROR  '+error+' ';
                                    alert(msg);
                                }
                               $('#'+idMod+'_cont_Load_gif').hide()   
                        }	
                });})
}
function cargarListaTrn( id_operacion ){
    var datosAjax = {action:'LISTAR_TRANSACCIONES', ORIGEN_TRANSACCION : 'operaciones' , PARAMETRO_BUSQUEDA:id_operacion};  
    $.ajax({
        url: 'view/action/action.php',  
        type: 'POST',
        dataType: "json",
        data: datosAjax	,
         error: function(xhr, ajaxOptions, thrownError) {
                console.log(JSON.stringify(xhr.status));
                console.log(JSON.stringify(ajaxOptions));  
                console.log(JSON.stringify(thrownError));},
        beforeSend: function() {
              console.log(JSON.stringify(datosAjax))
                }, 
        statusCode: {
                404: function() { alert( "pagina no encontrada" ); },
                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                         },
        success: function(objeto_json) { 
            console.log(JSON.stringify(objeto_json))
            let tr_generador = '';
            objeto_json['datos'].forEach(element => { 
                console.log(element.nombre_cuenta)
                tr_generador += '<tr>';
                tr_generador += '<td>'+element.nro_subcuenta+'</td>';
                tr_generador += '<td>'+element.nombre_cuenta+'</td>';
                tr_generador += '<td>'+element.nombre_subcuenta+'</td>';
                tr_generador += '<td>'+element.varlor_debito+'</td>';
                tr_generador += '<td>'+element.varlor_credito+'</td>';
                tr_generador += '<td>'+element.cod_tercero+'</td>';
                tr_generador += '</tr>';                
            });
            $('#cuerpoTabla').html(tr_generador);
            $('#btnModal').trigger('click');
        }	
});
} 