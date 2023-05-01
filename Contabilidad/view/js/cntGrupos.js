 var T_find = new Object();

T_find.CargadorContenidos = function(){
    this.cargador_eventos();
}
T_find.CargadorContenidos.prototype = {
    cargador_eventos: function()	
    { 
      //$('#principal').html("se cargo todo")
      
      $('.mcv_btnIngresar').addClass('button') 
      $('.Ecof_btnIngresar').addClass('button_eco') 
      $('#PadreId').change(function(){
          var data = $(this).val()
           $('#cod_grupo').val('')
                                       $('#Nombre').val('')  
                                       $('#Descripcion').val('')   
                                       
                                       $('#digito').val('') 
            cargarTablas(data);
          
      })
      $('#btnCancelar').click(function(){
        cargarTablas();
        cargarPadres() 
        $('#tablaDeDatos').find(" [type='text']").val('')
        $('#PadreId').val('')
      }); 
      $('#btnIngresar').click(function(){
      var ejecutar = true;
      if ($('#Nombre').val()==""){alert('Debe agregar un nombre de menú!');ejecutar =false; return ;}
     // if ($('#Descripcion').val()==""){alert('Debe agregar una descripción!');ejecutar =false; return ;}
      if (ejecutar){ 
          var data = $('#PadreId').val();
          /*$('#PadreId').change(function(){
          var data = $(this).val()
           $('#cod_grupo').val('')
                                       $('#Nombre').val('')  
                                       $('#Descripcion').val('')   
                                       
                                       $('#digito').val('') */
      var datosAjax = {action:'GUARDAR_DATOS_GRUPOS_CNT',
          digito : $('#digito').val() , 
          nombre : $('#Nombre').val()   ,  
          Descripcion : $('#Descripcion').val() ,   
          claseid : $('#PadreId').val(),  
          cod_grupo : $('#cod_grupo').val() };        
      $.ajax({
        url: 'view/action/action.php',  
        type: 'POST',
        
        dataType: "json",
        data: datosAjax	,
         error: function(xhr, ajaxOptions, thrownError) {
                alert(JSON.stringify(xhr.status));
                alert(JSON.stringify(ajaxOptions));  
                alert(JSON.stringify(thrownError));},
        beforeSend: function() {
          //  console.log(JSON.stringify(datosAjax));
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
    });}
  })
      
      cargarTablas();
      cargarPadres();
       
    }

}
function cargarTablas(  idPadre ){   
    var idMod =  'vw_cnt_grupos';
     var datosAjax = {action:'GET_LISTADO_GRUPOS_CNT',idPadre : idPadre,cabeceras:idMod};  
      $('#'+idMod+'_cont_Load_gif').show(function(){
                        $.ajax({
                        url: 'view/action/action.php',  
                        type: 'POST',
                        
			dataType: "json",
                        data: datosAjax	,
                         error: function(xhr, ajaxOptions, thrownError) {
                                alert(JSON.stringify(xhr.status));
                                alert(JSON.stringify(ajaxOptions));  
                                alert(JSON.stringify(thrownError));},
                        beforeSend: function() {
				 //alert(JSON.stringify(datosAjax))
                                $('#tablaResultado').hide()
				}, 
                        statusCode: {
                                404: function() { alert( "pagina no encontrada" ); },
                                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                                         },
                        success: function(objeto_json) {
                           // console.log(JSON.stringify(objeto_json))
                          $('#tablaResultado').show()
                               var msg = '';  
                             var error=objeto_json["error"]; 
                             if (objeto_json['error'] ==''){
                                 msg = '';  
                              //  $('#tablaResultado').html(  ) 
                               for(i=0;i<objeto_json['digitosArrTamanio'];i++){
                                   
                               }
                              var cargadorLista= new cont_table.CargadorContenidos(objeto_json,objeto_json["cabeceras"],'normalNewPac','tablasLista'+idMod,'indiceLista'+idMod,'listarTabla'+idMod,2,15,false,false,false,false,
                                function(){ //boton eliminar... 
                                     padre = $(this).parent().parent() 
                                    eliminarMenu( padre.find('#id_grupo').val() , padre.find('#cod_grupo').val())
                                    //eliminarMenu(this.datoProcesar ); 
                                },false,
                                    function(){ //boton editar... 
                                       var padre ;
                                       padre = $(this).parent().parent()
                                       padre.find('#padre').val();  
                                       $('#cod_grupo').val(padre.find('#id_grupo').val())
                                       $('#Nombre').val(padre.find('#nombre_grupo').val()) 
                                       $('#PadreId').val(padre.find('#cod_clase').val())
                                       $('#Descripcion').val(padre.find('#Descripcion').val())   
                                       
                                       $('#digito').val(padre.find('#digito').val())   
                                        
                                    }                                    
                                    ,false,false,false);
                                   // $('.imagen1').attr('src','')
                                   // $('.imagen2').attr('src','')
                                }else{
                                    msg = 'ERROR  '+error+' ';
                                    alert(msg);
                                }
                               $('#'+idMod+'_cont_Load_gif').hide()   
                        }	
                });})
}
function eliminarMenu( idMenu , codGrupo){//    cod_grupo   id_grupo
    var datosAjax = {action:'VERIFICAR_Y_ELIMINAR_GRUPO_CNT',id_grupo : idMenu , cod_grupo:codGrupo};  
    $.ajax({
        url: 'view/action/action.php',  
        type: 'POST',
        
        dataType: "json",
        data: datosAjax	,
         error: function(xhr, ajaxOptions, thrownError) {
                alert(JSON.stringify(xhr.status));
                alert(JSON.stringify(ajaxOptions));  
                alert(JSON.stringify(thrownError));},
        beforeSend: function() {
                 //console.log(JSON.stringify(datosAjax))
                }, 
        statusCode: {
                404: function() { alert( "pagina no encontrada" ); },
                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                         },
        success: function(objeto_json) {
            var data = $('#PadreId').val();
         //   alert(JSON.stringify(objeto_json))
               var msg = '';  
             var error=objeto_json["error"];
             switch(error){
                 case 'ok' :
                         msg = 'Grupo contable eliminado con exito!';
                         cargarPadres();
                             $('#PadreId').val(data);
                         cargarTablas(data);
                     break;
                 case '_table':
                        msg = 'ERROR  error al enviar el nombre de la tabla ';
                     break;
                     case '_dato':
                          msg = 'ERROR  error al enviar el identificador en la tabla del registro ';
                     break;
                     case '_COLUMNA':
                          msg = 'ERROR  error al envia el nombre de la columna identificadora del registro. ';
                     break;
                     default:
                         msg = 'ERROR  '+error+' ';
                     break;
             }  
             alert(msg);


        }	
});
}
function cargarPadres(  idPadre ){ 
     var idMod =  'vw_cnt_grupos';
     var datosAjax = {action:'GET_LISTADO_CLASES_CNT',idPadre : idPadre,cabeceras:idMod};      
     //console.log(JSON.stringify(datosAjax));
                        $.ajax({
                        url: 'view/action/action.php',  
                        type: 'POST',
                        
			dataType: "json",
                        data: datosAjax	,
                         error: function(xhr, ajaxOptions, thrownError) {
                                alert(JSON.stringify(xhr.status));
                                alert(JSON.stringify(ajaxOptions));  
                                alert(JSON.stringify(thrownError));},
                        beforeSend: function() {
				//alert(JSON.stringify(datosAjax))
                                
                                      
				}, 
                        statusCode: {
                                404: function() { alert( "pagina no encontrada" ); },
                                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                                         },
                        success: function(objeto_json) {
                         //   alert(JSON.stringify(objeto_json))
                               var msg = '';  
                             var error=objeto_json["error"]; 
                             if (objeto_json['error'] ==''){
                                 msg = '';  
                                 var datosTabla = objeto_json['datos'];
                                 var auxOptio = '';
                                 var auxDato;
                                 $('#PadreId').html('<option value="">SELECCIONE UNA CLASE</option>')
                                 for(var i=0; i<datosTabla.length;i++){
                                    auxDato=datosTabla[i];  
                                    auxOptio=$('<option>');//cod_clase, nombre_clase
                                    auxOptio.attr('value',auxDato.cod_clase)
                                    auxOptio.html(" "+auxDato.nombre_clase+"  ")
                                    $('#PadreId').append(auxOptio)
                                 }
                             
                            }else{
                                    msg = 'ERROR  '+error+' ';
                                    alert(msg);
                                }
                                 
                        }	
                });
}