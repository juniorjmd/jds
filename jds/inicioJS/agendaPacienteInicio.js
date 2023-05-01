
$(document).ready(function(){
 $(document).keydown(function(tecla){
		var r=tecla.keyCode;
		if(r==27){
			$("#conterFecha").css('display', 'none');
					  $("#containerIquierda").css('width', '30px');
					  	  $("#muestraFecha").css('background','url(css/images/controls2.1.png) no-repeat top left');
						   $("#muestraFecha").css('left', '21px');
						   $('#pagCitas').dialog("close");
						   $('#pagEditCitas').dialog("close");
						   $('#pagEdicionPacientes').dialog("close");
						   $('#pagProcedimiento').dialog("close"); 
			}
			if(r==13){
				
			}
	});	
$("#conterFecha").css('display', 'none');
$("#muestraFecha").css('background-color', '#e6e9ea');
$("#muestraFecha").css('left', '21px');
$('#muestraFecha').hover( function(){
     $(this).css('background-position', 'bottom left');
},
function(){
     $(this).css('background-position', '');
});
$("#muestraFecha").click(function(){
					if($("#conterFecha").css('display')=='none'){
						
						$("#containerIquierda").css('width', '235px');
						
					  $("#conterFecha").css('display', 'block');
					   	  $(this).css('left', '241px');
					  $(this).css('background','url(css/images/controls2.png) no-repeat top left');
					  }
					  else{$("#conterFecha").css('display', 'none');
					  $("#containerIquierda").css('width', '30px');
					  	  $(this).css('background','url(css/images/controls2.1.png) no-repeat top left');
						   $(this).css('left', '21px');}
					   });	
CrearGrid("#GridAgendar");
$("#posicion").val("1");
$("#Guardado").val("nuevaCita");
$("#horaCita").change(function (){		 
			var IdGrid=$("#horaCita").val()
				$("#gridID").val(IdGrid)
	});	

$("#errorCedula2").click(function (){
		$("#Guardado").val("nuevaCitaYcliente");
						   
		$("#nombre2").css('display', 'inline');
		$("#apellido2").css('display', 'inline');
		$("#email2").css('display', 'inline');
		 $("#telefono2").css('display', 'inline');
		   });
$("input[id='cedula2']").keyup(function (){
	var dato=$(this).val();
	if (Trim(dato)!=""){
	var query="select * from pacientes where `idCliente`= "+dato+" ";
	var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
		carga_listar(datos_json,llenaCita);}else{
			var texto=" ";
			$("#errorCedula2").html(texto);
			$(this).focus();}
	});
	
$("input[id='cedula2']").css('disabled',true)
$("input[id='cedula2']").trigger('keyup')
$('#cuerpo').tabs();
$('#conterFecha').tabs();
$('#containerTablaDiferidos').tabs();
$('#tabs').tabs();
$('#listarTablaPaciente').tabs();
$('#containerTablar').tabs();
$('#Ttabs-1').tabs();
$('#listaEstados').tabs();
$('#fecha').datepicker({selectOtherMonths: true,
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
						 
						 
   onSelect: function(dateText, inst) {  
   var fecha = new Date(dateText);
   var dia=fecha.getDate()
	var mes=(fecha.getMonth()+1);
	var anio=fecha.getFullYear();

	asignaFechas(fecha)
		
   }});			 
					
		
$('#GridAgendar').niceScroll({cursorborder:"",cursorr:"#a6c9e2"});	
						  $("#posicion").val("2");
						  $("html").niceScroll({cursorborder:"",cursorr:"#a6c9e2"});			
						 var dateText=new Date();
					asignaFechas(dateText);


$('#pagCitas').dialog({
					autoOpen: false,
					width: 420,
						open: function( event, ui ) {
							$("input[id='cedula2']").attr('disabled',true)
					 },
					beforeClose: function(event, ui) {	
					dateInicial=new Date($("#dateInicial").val())
					dateFinal=new Date($("#dateFinal").val())
									 $("#estadoCita").removeAttr("disabled"); 
						$("#horaCita").removeAttr("disabled"); 
					$("#nombre2").css('display', 'none');
		$("#apellido2").css('display', 'none');
		$("#email2").css('display', 'none');
		 $("#telefono2").css('display', 'none');
					$("#estadoCita").val("sin confirmacion");
					$("#horaCita").val("0");
					$("#Guardado").val("nuevaCita");
					if($("#posicion").val()==1){$("#Linktabs-1").trigger("click");}
	 if($("#posicion").val()==2){verificaCita(dateInicial,dateFinal);}},
					buttons: {
					"Ok": function() {
						var cedula=	 Trim($("#cedula2").get(0).value);
			var nombre= Trim($("#nombre2").get(0).value)
		 var apellido =Trim($("#apellido2").get(0).value);
		 var email=Trim($("#email2").get(0).value);
		 var telefono=Trim($("#telefono2").get(0).value);
		 var observacion =Trim($("#observacion2").get(0).value);
		var fechaCita
		 var horaCita =Trim($('#horaCita').val());
		 var posicion=$("#posicion").val();
		 var  IdGrid
		 var fecha
		 if(posicion==1){
			  fecha=new Date($("#IngresoCitaId").val()); 
			  }else{ 
			 fecha =new Date(Trim($("#fechaCita").get(0).value));
	}
		var NumDias=fecha.getDay()+1;
						var dia=fecha.getDate()
						var mes=(fecha.getMonth()+1);
							var anio=fecha.getFullYear();
			
	fechaCita =mes+"/"+dia+"/"+anio
	   IdGrid= '#'+ horaCita+'d'+NumDias;
	   var estadoCita=Trim($('#estadoCita').val());
		  if (cedula=="")
		 {$("#cedula").focus();
		 	return;
		 }
		 if (nombre=="")
		 {$("#nombre").focus();
		  return;
		 }
		 
		 if (apellido=="")
		 {$("#apellido").focus();
		 	 return; }
		 
		  if (email=="")
		 {$("#email").val($("#cedula").val());
		 email=$("#email").val();
		 }
		 
		   if (horaCita=="0")
		 {$("#horaCita").focus();
		 return;  }
		if (observacion=="")
		 {observacion="No posee observaciones para esta cita";}
				 respueta=$("#Guardado").val();
		 $("#IngresoCitaId").val(fechaCita);
		  $("#IdGridIngreso").val(IdGrid);
		  RangoHora=IdGrid.substring(1,IdGrid.length-4);
		  if(posicion==1){
			   var query="select * from agenda where `fecha` ="
	var query2=" AND `ubicacionGrid`=";
	var query3="AND  (estadoCita <> 'diferido' AND estadoCita <> 'cancelada' ) BY `hora` DESC";
	var datos_json = "query="+ encodeURIComponent(query)+	
	"&query2="+ encodeURIComponent(query2)+	
		"&query3="+ encodeURIComponent(query3)+	
		"&dato1="+ encodeURIComponent(fechaCita)+	
		"&ubicacionGrid="+ encodeURIComponent(IdGrid)+	
		"&respuesta="+ encodeURIComponent("revisaNuevasCitas")+	
		"&nocache=" + Math.random();
		carga_listar(datos_json,respuestaDblclick2,"php/listadoInventario.php")
			 }else{var datos_json="cedula="+ encodeURIComponent(cedula)+"&"+
	"nombre="+ encodeURIComponent(nombre)+"&"+
		 "apellido="+encodeURIComponent(apellido)+"&"+
		"email="+ encodeURIComponent(email)+"&"+
		 "telefono="+ encodeURIComponent(telefono)+"&"+
		   "observacion="+encodeURIComponent(observacion) +"&"+
		    "fechaCita="+encodeURIComponent(fechaCita) +"&"+
			  "horaCita="+encodeURIComponent(horaCita) +"&"+
			  "estadoCita="+encodeURIComponent(estadoCita) +"&"+
			  "IdGrid="+encodeURIComponent(IdGrid) +"&"+
			  "RangoHora="+encodeURIComponent(RangoHora) +"&"+
		 "respuesta="+ encodeURIComponent(respueta)+"&nocache=" + Math.random();
			carga_insert(datos_json,respuestaNuevaCita1);	
			}
            	},
						"Cancel": function() {
							$(this).dialog("close");
						}
					}
				});




$('#pagProcedimiento').dialog({
					autoOpen: false,
					width: 400,
					open: function( event, ui ) {				 },
					beforeClose: function(event, ui) {	
					$(".procedimientoLB").each(function(){
								$(this).val("");
								$(this).html("");		  });
				 },
					
					buttons: {
						
						"Ok": function() {
							
				CitaProcedimiento=$("#CitaProcedimiento").html();
	
		PacienteCedulaProc= $("#PacienteCedulaProc").html();
		 
		Procnombre=$("#Procnombre").html();
		
		fechaCitaProc=$("#fechaCitaProc").html();
		
		 	if(Trim($("#procTXT").val())==""){
				procTXT="Procedimiento de rutina (cambio de ligas, de alambre. etc)"
				
				}else{procTXT=Trim($("#procTXT").val())}
		
	var datos_json="CitaProcedimiento="+ encodeURIComponent(CitaProcedimiento)+"&"+
	"PacienteCedulaProc="+ encodeURIComponent(PacienteCedulaProc)+"&"+
		"Procnombre="+encodeURIComponent(Procnombre)+"&"+
		"fechaCitaProc="+ encodeURIComponent(fechaCitaProc)+"&"+
		"procTXT="+ encodeURIComponent(procTXT)+"&"+
		 "respuesta="+ encodeURIComponent("nuevoProcedimiento")+"&nocache=" + Math.random();
		carga_insert(datos_json,respuestaNewProc);					
			
				},
						"Cancel": function() {$("#respuesta").val("none")
							$(this).dialog("close");
						}
					}
				});
});
				
