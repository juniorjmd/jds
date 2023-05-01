$(document).ready(function(){
$.datepicker.setDefaults({ selectOtherMonths: true,
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],changeYear: true,
            
            dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"]}); 
  $('#fecha_de_cargue').datepicker({changeMonth: true,
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun','Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            changeYear: true,yearRange: '2014:2017',            
            dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
            minDate:new Date(), onSelect: function (selectedDate ) { 
                    var fechaActual = new Date();
                    var milisegundos=parseInt(35*24*60*60*1000); 
                    var days  = $('#numMaxMeses').val()//180 ;//dias equivalentes a 6 meses 
                    var day=parseInt(selectedDate.substring(3,5) ) ; 
                    var month=parseInt(selectedDate.substring(0,2));
                    var year=parseInt(selectedDate.substring(6,10));
                    var fecha= new Date(year, month, day);
                    var tiempo=fecha.getTime();
                    //Calculamos los milisegundos sobre la fecha que hay que sumar o restar...
                    milisegundos=parseInt(days*24*60*60*1000);
                    //Modificamos la fecha actual
                    fecha.setTime(tiempo+milisegundos); 
                    if(fecha>=fechaActual){fecha = fechaActual;}                    
                   // $('#fechaFinal_pd').datepicker("option", "maxDate", fecha , "minDate", selectedDate)
                }});
            
  $('#enviar_datos').click(function(){
      
      var exit = false; 
       if(exit){return;}
      $('#submit_envio_datos').trigger('click');
  }) 
  $('.crear_remision').click(function(){
      $('#orden_compra_remision').val($(this).data('orden_compra'))
      $("#crear_remision").trigger('click');                  
      
  })
  
  $('.facturar_remision').click(function(){
      $('#orden_compra_remision_factura').val($(this).data('orden_compra'))
      $("#faturar_remision").trigger('click');                  
      
  })
});