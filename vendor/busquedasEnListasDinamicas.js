function busquedasDinamicas(datos){
$('.btn_enviar_busqueda_dinamica_'+datos.idMod+'_20170510').click(function(){ 
    
   /*$('#'+datos.idMod+'_cont_Load_gif').html('<span style="float: left; color: gray;font-size: 13px "  >Cargando&nbsp;</span>'
          + '<div class="loadingDiv" id="esperaMarcas" style="height:20px; width:100px;  " >'
          + '<div id="blockG_1" class="facebook_blockG"></div><div id="blockG_2" class="facebook_blockG">'
          + '</div><div id="blockG_3" class="facebook_blockG"> </div></div>');*/
     var padre = $(this).parent().parent().parent().parent().parent();
    var ejecutar = true;
    //SAP_rfc_clientes_cont_Load_gif
   
    if (padre.find('#busqueda_dinamica_'+datos.idMod+'_20170510').val() == ''){
        alert ('el Dato a buscar no debe estar en blanco');
        return;}
    if (ejecutar){ 
     var datosAjax = {action:datos.action,cabeceras:datos.idMod,item:padre.find('#busqueda_dinamica_'+datos.idMod+'_20170510').val(),columnas :padre.find('#col_busqueda_dinamica_'+datos.idMod+'_20170510').val(),concordancia:padre.find('#tip_concordancia_20170510').val()};       
     if (typeof  datos.datosEnvios !== "undefined" && datos.datosEnvios.length > 0){
         var auxArray = new Array()
         for (i=0; i< datos.datosEnvios.length ; i++ )
         {
            auxArray = datos.datosEnvios[i];
            datosAjax[auxArray.idEnvio] = $(auxArray.clave).val()  
         }
     }     
        
        var load_id = '#'+datos.idMod+'_cont_Load_gif';         
        $(load_id).show(function(){
        $.ajax({
                        url: datos.url,  
                        type: 'POST',
                        async: false,
			dataType: "json",
                        data: datosAjax	,
                         error: function(xhr, ajaxOptions, thrownError) {
                                alert(JSON.stringify(xhr.status));
                                alert(JSON.stringify(ajaxOptions));  
                                alert(JSON.stringify(thrownError));},
                        beforeSend: function() {   
                            //alert(JSON.stringify(datosAjax));
                            	}, 
                        statusCode: {
                                404: function() { alert( "pagina no encontrada" ); },
                                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                                         },
                        success: function(objeto_json) { 
                            console.log(JSON.stringify(objeto_json))
                             var msg = '';  
                             var error=objeto_json["error"]; 
                             if (objeto_json['error'] ==''){ 
                             var cargadorLista= new cont_table.CargadorContenidos(objeto_json,objeto_json["cabeceras"],'normalNewPac'+datos.idMod,'tablasLista'+datos.idMod,'indiceLista'+datos.idMod,'listarTabla'+datos.idMod,datos.tipoTabla,15,false,false,false,false,
                               datos.funcion1,false,datos.funcion2,datos.funcion3,false,false);
                                   // $('.imagen1').attr('src','')
                                   // $('.imagen2').attr('src','')
                                }else{
                                    msg = 'ERROR  '+error+' ';
                                    alert(msg);
                                }
                                 
                        }	
                });
        $( load_id ).hide();     
        });
            
             }  
                }) 
            
}

