 var T_find = new Object();
var contadorOPR = 0;
T_find.CargadorContenidos = function(){
    this.cargador_eventos();
}
T_find.CargadorContenidos.prototype = {
    cargador_eventos: function()	
    { 
            $('#div_tabla_reporte').hide();
    $('#enviarExcel').click(function(e){
        e.preventDefault();
         var datos = $("<div>").append( $('#tabla_reporte').eq(0).clone()).html() ;
                   
                 //datos.append('<style>table {border-collapse: collapse;} table, th, td { border: 1px solid black;}</style>')
                 var f = new Date(); 
                 var _nombre = 'Balance_general'+f.getDate()   + (f.getMonth() +1)   + f.getFullYear();
                  //$($(this).data('target')).find('table').tableExport({type:'excel',escape:'false'});
                $("#datos_a_enviar").val(datos);
                $("#nombre_reporte").val(_nombre)
                $("#exportarTabla").submit();
    })
    $(".hasDatepicker").datepicker("destroy");
    $('#ordenDePedidoEnviado').remove();
    $('*[data-url="notasPedidosDevoPorDetalle.php"]').unbind('click').click(function(){
        $('#datos_vistas').val('*[data-url="notasPedidosDevoPorDetalle.php"]');
        $('#datosVistas').submit()
    });  
     var fechaAux = new Date();
var anio = fechaAux.getFullYear();
var rango = String(anio-6)+ ":"+anio;
    $('#fechaInicial').datepicker({changeMonth: true,
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            changeYear: true,yearRange: rango,  
            dateFormat:'yy-mm-dd',
            dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],  maxDate:new Date() ,
            onSelect: function (selectedDate ) { 
                    var fechaActual = new Date();
                    var milisegundos=parseInt(35*24*60*60*1000); 
                    var days  = $('#numMaxMeses').val()//180 ;//dias equivalentes a 6 meses 
                    var day=parseInt(selectedDate.substring(3,5) ) ; 
                    var month=parseInt(selectedDate.substring(0,2));
                    var year=parseInt(selectedDate.substring(6,10));
                    fecha= new Date(year, month, day);
                    var tiempo=fecha.getTime();
                    //Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
                    milisegundos=parseInt(days*24*60*60*1000);
                    //Modificamos la fecha actual
                    fecha.setTime(tiempo+milisegundos); 
                    if(fecha>=fechaActual)
                        {  fecha = fechaActual;  }
                    
                    $('#fechaFinal').datepicker("option", "maxDate", fecha , "minDate", selectedDate)
             
                }         });	
    $('#fechaFinal').datepicker({changeMonth: true,
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            changeYear: true,yearRange: rango,dateFormat:'yy-mm-dd',            
            dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
            maxDate:new Date(), onSelect: function (selectedDate) {
                  $('#fechaInicial_pDD').datepicker("option", "maxDate", selectedDate )}     }); 
          $('.hasDatepicker').datepicker('setDate', new Date());
          
     $('#enviar_datos').click(function(e){
         e.preventDefault()
        var datosFrm =  $('#formularioBalance').serialize()
        $.ajax({
        url: 'view/action/action.php',  
        type: 'POST',
        
        dataType: "json",
        data: datosFrm	,
         error: function(xhr, ajaxOptions, thrownError) {
                alert(JSON.stringify(xhr.status));
                alert(JSON.stringify(ajaxOptions));  
                alert(JSON.stringify(thrownError));},
        beforeSend: function() {
            console.log(JSON.stringify(datosFrm));
                $('#div_tabla_reporte').hide();
                }, 
        statusCode: {
                404: function() { alert( "pagina no encontrada" ); },
                408: function() {alert( "Tiempo de espera agotado. la peticion no se realizo " ); } 
                         },
        success: function(objeto_json) {
           console.log(JSON.stringify(objeto_json))
           var tbActivo
           var tActivo  = objeto_json.saldo_total_activo
           var tbPasivo 
           var tPasivo   = objeto_json.saldo_total_pasivo 
           var tbPatrimonio 
           var tPatrimonio = objeto_json.saldo_total_patrimonio
            
           tbActivo = tbPasivo = tbPatrimonio = '';
           var datoAux = objeto_json.datos_activo
           for (i=0;i<objeto_json.filas_activo;i++){
              tbActivo += "<tr><td>"+datoAux[i].nombre_cuenta+"</td>"+
               "<td align='right' >"+datoAux[i].saldo+"</td></tr>";
           }
           
             datoAux = objeto_json.datos_pasivo
           for (i=0;i<objeto_json.filas_pasivo;i++){
              tbPasivo += "<tr><td>"+datoAux[i].nombre_cuenta+"</td>"+
               "<td align='right'>"+datoAux[i].saldo+"</td></tr>";
           }
           
             datoAux = objeto_json.datos_patrimonio
           for (i=0;i<objeto_json.filas_patrimonio;i++){
              tbPatrimonio += "<tr><td>"+datoAux[i].nombre_cuenta+"</td>"+
               "<td  align='right'>"+datoAux[i].saldo+"</td></tr>";
           }
           
           $('#tbActivo').html(tbActivo) 
           $('#tActivo').html(tActivo) 
           $('#tbPasivo').html(tbPasivo) 
           $('#tPasivo').html(tPasivo) 
           $('#tbPatrimonio').html(tbPatrimonio) 
           $('#tPatrimonio').html(tPatrimonio)         
           
            $('#div_tabla_reporte').show();
        }	
        });
     })     
          
    }
    }