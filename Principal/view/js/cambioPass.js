 var T_find = new Object();

T_find.CargadorContenidos = function(url){
    this.cargador_eventos(url);
}
T_find.CargadorContenidos.prototype = {
    cargador_eventos: function(url)	
    { 
    
           
      $('#btnIngresar').click(function(){
        var p_ant = $('#password_ant').val();
         var p_nw_1 = $('#password_nw_1').val();
         var p_nw_2 = $('#password_nw_2').val();
         if(p_ant==''){alert('Las contraseñas anterior no debe estar en blanco.');}
         else{
            if(p_nw_1==''){alert('La nueva contraseña no debe estar en blanco.');}
            else{
                if(p_nw_2 != p_nw_1 ){alert('Las contraseñas ingresadas no coinciden.');
                    $('#password_nw_1').focus();}
                else{
                    var datosAjax = {action:'CAMBIAR_PASSWORD',passActual:p_ant,passNew:p_nw_1};                    
                        $.ajax({
                        url: 'view/action/action.php',  
                        type: 'POST',
                        
		                dataType: "json",
                        data: datosAjax	,
                         error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status);
                                alert(ajaxOptions);  
                                alert(thrownError);},
                        beforeSend: function() {
				// alert(JSON.stringify(datosAjax))
				}, 
                        statusCode: {
                                404: function() { alert( "pagina no encontrada" ); }, 
                                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                                         },
                        success: function(data) { 
						//aler(data)
                            var siga = true;
                                var msg = '';  
                                var datosTabla = data['datos']; 
                                var error=data["error"]; 
                                if (data['error'] === 'ok'){
                                    msg = 'LA CONTRASEÑA HA SIDO MODIFICADA CON EXITO';    
                                    
                                }else{
                                    msg = 'ERROR <p>'+error+'</p>';
                                    siga = false;
                                }
                                alert(msg );
                                if (typeof(url) !== "undefined" && siga ){
                                    irUrl(url);
                                }
                        }	
                });
      }}}});
    }

}