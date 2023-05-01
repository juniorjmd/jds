
$(document).ready(function(){
 cookie();
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
$("#EditarCita").click(
    function (){
	   $("#activaEdicionCita").val("activo");
	   if($("#estadoCitaEdit").val()!="asistido"&&$("#estadoCitaEdit").val()!="cancelada")
            {$("#estadoCitaEdit").removeAttr("disabled"); }
	   $("#observacionEditLb").removeAttr("disabled");
	   $("#estadoCitaEdit").focus();
       });
       
$("#EditarBoton").click(
    function (){
	    $("#activaEdicion").val("activo");
	 	$(".pacientesEdicion").each(function(){
		$(this).css('display', 'inline');				  
	});
	$(".pacientesEdicionLb").each(function(){
		$(this).css('display', 'none');				  
	});
	$("#cedulaEdicionLb").css('display', 'inline');
	$("#cedulaEdicion").css('display', 'none');	
	$("#observacionEdicion").css('display','inline' );
	$("#observacionEdicion").removeAttr("disabled"); 
	$("#nombreEdicion").focus();
	});

$("input[id='cedula2']").keyup(
function (){
	var dato=$(this).val();
	if (Trim(dato)!=""){
    	var query="select * from pacientes where `idCliente`= "+dato+" ";
    	var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
    	carga_listar(datos_json,llenaCita);}
    else{
		var texto=" ";
		$("#errorCedula2").html(texto);
		$(this).focus();}
	});

$("input[id='busquedaPacienteRegistrado']").keyup(
function (){									
	var dato=$(this).val();
	if (Trim(dato)!="")
    {//"'%".$dato."%'"
	   var query="SELECT * FROM pacientes WHERE `nombre` LIKE ";
	   var datos_json = "query=" + encodeURIComponent(query)+		
		"&dato=" + encodeURIComponent(dato) +
		"&tabla2=" + encodeURIComponent('idCliente') +
		"&tabla3=" + encodeURIComponent("apellido") +
		"&nocache=" + Math.random();
		//alert(datos_json);
		limpia_linea('tablasListaPaciente','indiceListaPaciente');
		carga_listar(datos_json,list_res_pacientes);
	}else{
		$("#Linktabs-3").trigger("click");
		$(this).focus();}
	});

$("input[id='cedulaEdicion']").keyup(function (){
											   
	var dato=$(this).val();
	if (Trim(dato)!=""){
        var query="select * from pacientes where `idCliente`= "+dato+" ";
	    var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
		carga_listar(datos_json,llenaEdicion);}
    else{
        $(".pacientesEdicionLb").each(function(){
		$(this).css('display', 'inline');
		$(this).html('');
		});
	$(".pacientesEdicion").each(function(){
		$(this).css('display', 'none');	
		$(this).val('');	
	 });
									
	$("#cedulaEdicionLb").css('display','none' );
	$("#cedulaEdicion").css('display','inline' );	
	$("#observacionEdicion").css('display','inline' );
	$("#observacionEdicion").attr("disabled", true);
									//$("#observacionEdicion").removeAttr("disabled"); 
			var texto=" ";
			$("#errorCedulaEdicion").html(texto);
			$(this).focus();}
	
	});

var dateText=new Date();
var dia=dateText.getDate()
var mes=(dateText.getMonth()+1);
var anio=dateText.getFullYear();
$("#IngresoCitaId").val(dateText)
var fecha =dia+"/"+mes+"/"+anio;
	$("#dataLabel").html(fecha)  ;
	
dateText1=mes+"/"+dia+"/"+anio;
$("#fechaDeIngresoCita").val(dateText1);

listaDatosInventario(list_res_articulo,"fecha",dateText1)
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
			$("#fechaCitaHidden").val(dateText)
  var posicion= $("#posicion").get(0).value;
  switch(posicion){
		case  '2':
		asignaFechas(fecha)
		break;
   		case  '1':
		listaDatosInventario(list_res_articulo,"fecha",dateText)
	var fecha2=dia+"/"+mes+"/"+anio;
	$("#dataLabel").html(fecha2);
		$("#IngresoCitaId").val(dateText)
		$("#fechaDeIngresoCita").val(dateText);
			break;
		case  '3':
	//	alert("estamos en la seccion de pacientes");
			break;
  }
   }});			 
					
		
$('#GridAgendar').niceScroll({cursorborder:"",cursorr:"#a6c9e2"});	
					
$("#Linktabs-1").click(function (){
								 $("#posicion").val("1");
								 var dateText=new Date();
var dia=dateText.getDate()
var mes=(dateText.getMonth()+1);
var anio=dateText.getFullYear();

dateText1=mes+"/"+dia+"/"+anio;
$("#IngresoCitaId").val(dateText1)
var fecha =dia+"/"+mes+"/"+anio;
$("#fechaCitaHidden").val(fecha);
	$("#dataLabel").html(fecha);
listaDatosInventario(list_res_articulo,"fecha",dateText1)
								// alert($("#posicion").get(0).value);								 
								 });



$("#Linktabs-2").click(function (){								 
						  $("#posicion").val("2");
						  $("html").niceScroll({cursorborder:"",cursorr:"#a6c9e2"});			
						  //alert($("#posicion").get(0).value);
					 var dateText=new Date();
					asignaFechas(dateText);

								 });
			 
$("#Linktabs-3").click(function (){
					//alert($("#posicion").val())
					$("#activaEdicion").val("inactivo");
					var posicion=$("#posicion").val();
			if (posicion=='31')	  
			{  query ="SELECT * FROM pacientes ORDER BY `identificador` DESC" ;}else
		 { query ="SELECT * FROM pacientes ORDER BY `nombre` ASC" ;
								 }
								// alert(query);
		  $("#posicion").val("3");
		var datos_json = "query=" + encodeURIComponent(query) +
		"&nocache=" + Math.random();
		limpia_linea('tablasListaPaciente','indiceListaPaciente');
		carga_listar(datos_json,list_res_pacientes);
								 
								 });



$('#pagSalidas').dialog({
					autoOpen: false,
					width: 400,
					open: function( event, ui ) {
					 generaKeydowm(".pacientes");
					 },
					beforeClose: function(event, ui) {	
					$(".pacientes").each(function(){
								$(this).val("");				  
												  });
					if($("#respuesta").val()=="nuevoRegistro"){
					$("#Linktabs-3").trigger("click"); } },
					
					buttons: {
						
						"Ok": function okBoton() {
				var cedula=	 Trim($("#cedula").get(0).value);
			var nombre= Trim($("#nombre").get(0).value)
		 var apellido =Trim($("#apellido").get(0).value);
		 var email=Trim($("#email").get(0).value);
		 var telefono=Trim($("#telefono").get(0).value);
		  var celular =Trim($("#celular").get(0).value);
		  var diferidoPor =Trim($("#diferidoPor").get(0).value);
		  var observacion =Trim($("#observacion").get(0).value);
		 
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
		 if ((email=="")||(email=="No aplica"))
		  {  email=cedula;}
	var datos_json=$("#cedula").get(0).id+"="+ encodeURIComponent(cedula)+"&"+
	$("#nombre").get(0).id+"="+ encodeURIComponent(nombre)+"&"+
		 $("#apellido").get(0).id+"="+encodeURIComponent(apellido)+"&"+
		$("#email").get(0).id+"="+ encodeURIComponent(email)+"&"+
		 $("#telefono").get(0).id+"="+ encodeURIComponent(telefono)+"&"+
		  $("#celular").get(0).id+"="+encodeURIComponent(celular)+"&"+
		    $("#diferidoPor").get(0).id+"="+encodeURIComponent(diferidoPor)+"&"+
		    $("#observacion").get(0).id+"="+encodeURIComponent(observacion) +"&"+
		 "respuesta="+ encodeURIComponent("nuevoPaciente")+"&nocache=" + Math.random();
			$("#posicion").val("31");
			
		
			carga_insert(datos_json,respuestaNuevoPaciente);					
			
				},
						"Cancel": function() {$("#respuesta").val("none")
							$(this).dialog("close");
						}
					}
				});


$('#pagCitas').dialog({
					autoOpen: false,
					width: 420,
						open: function( event, ui ) {
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
					$(".citas").each(function(){
								$(this).val("");				  
								$(this).html(""); });
					$("#estadoCita").val("sin confirmacion");
					$("#horaCita").val("0");
					$("#Guardado").val("nuevaCita");
					if($("#posicion").val()==1){var dateText1=$("#fechaDeIngresoCita").val();
					listaDatosInventario(list_res_articulo,"fecha",dateText1);}
					if($("#posicion").val()==2){verificaCita(dateInicial,dateFinal);}
					},
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
			 fecha =new Date(Trim($("#fechaCita").val()));
		
	}
		var NumDias=fecha.getDay()+1;
						var dia=fecha.getDate()
						var mes=(fecha.getMonth()+1);
							var anio=fecha.getFullYear();
			
	fechaCita =mes+"/"+dia+"/"+anio
	   IdGrid= '#'+ horaCita+'d'+NumDias;
		 // alert(IdGrid+"  "+fechaCita+"  "+fecha)
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
		
		// alert(datos_json)
			carga_insert(datos_json,respuestaNuevaCita1);	
			}
		  		  
		
				},
						"Cancel": function() {
							$(this).dialog("close");
						}
					}
				});




$('#pagEditCitas').dialog({
					autoOpen: false,
					width: 420,
						open: function( event, ui ) {
				//	alert($("#idCita").val())
					  $("#EdithoraCita").attr("disabled",true);
					
	$("#estadoCitaEdit").attr("disabled",true);
	$("#observacionEditLb").attr("disabled",true);
					var query="select * from agenda where `idCita`= "+$("#idCita").val()+" ";
	var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
		//alert (datos_json);
		carga_listar(datos_json,llenaEditarCita);
					
					 },
					beforeClose: function(event, ui) {	 $("#activaEdicionCita").val("inactivo");
					
					
					},
					buttons: {
						"Ok": function() {
					
					estadoCitaEdit=$("#estadoCitaEdit").val();
					observacionEditLb=$("#observacionEditLb").val();
					LbEditfechaCita=$("#LbEditfechaCita").html(); 
					rangoCita=$("#rangoHora").val();
					if ($("#activaEdicionCita").val()=="activo"){
					
						if(estadoCitaEdit=="cancelada"){
							jConfirm("Acaba de cancelar una cita existente,\n Desea cargar un diferido de esta fecha en su lugar?  ", "Creacion Nueva cita", function(r) {
			if(r) {
				$.colorbox({overlayClose:false, inline:true, href:"#buscar_suc2",width:"50%", height:"50%"});
				var query="select * from agenda where `fecha` ="
	var query2=" AND `estadoCita`=";
	var query3=" BY `hora` DESC";
	var datos_json = "query="+ encodeURIComponent(query)+	
	"&query2="+ encodeURIComponent(query2)+	
		"&query3="+ encodeURIComponent(query3)+	
		"&fecha="+ encodeURIComponent(LbEditfechaCita)+	
		"&estadoCita="+ encodeURIComponent("diferido")+	
		"&respuesta="+ encodeURIComponent("diferidos")+	
		"&nocache=" + Math.random();
		//alert(datos_json)
		carga_listar(datos_json,list_res_Diferidos,"php/listadoInventario.php")
				
			}} );
							
							
							}
				var datos_json="idCita="+ encodeURIComponent($("#idCita").val())+"&"+
				 $("#estadoCitaEdit").get(0).id+"="+encodeURIComponent(estadoCitaEdit) +"&"+
			   $("#observacionEditLb").get(0).id+"="+encodeURIComponent(observacionEditLb) +"&"+
			   "columna="+encodeURIComponent("idCita") +"&"+
			    "tabla="+encodeURIComponent("agenda") +"&"+
		 "respuesta="+ encodeURIComponent("edicionCita")+"&nocache=" + Math.random();
			
			
			carga_borrarUpdate(datos_json,respuestaEdicionCitas);	}else{
				$(this).dialog("close");}
						
			
				},
						"Cancel": function() {
							$(this).dialog("close");
						}
					}
				});



$('#pagEdicionPacientes').dialog({
					autoOpen: false,
					width: 400,
						open: function( event, ui ) {
					 generaKeydowm(".pacientesEdicion");
					 $("#cedulaEdicion").trigger("keyup");
					 
					 },
					beforeClose: function(event, ui) {	
				
								  	$(".pacientesEdicionLb").each(function(){
								$(this).css('display', 'inline');
								$(this).html('');
								
												  });
									$(".pacientesEdicion").each(function(){
								$(this).css('display', 'none');	
								$(this).val('display', 'none');	
												  });
									
									$("#cedulaEdicionLb").css('display','none' );
									$("#cedulaEdicion").css('display','inline' );	
									$("#observacionEdicion").css('display','inline' );
									$("#observacionEdicion").attr("disabled", true);
									//$("#observacionEdicion").removeAttr("disabled"); 
					if ($("#activaEdicion").val()=="activo")
					{$("#Linktabs-3").trigger("click");}
					$("#activaEdicion").val("inactivo"); 
					},
					buttons: {
						"Ok": function pagEdicionPacientes() {
							if($("#activaEdicion").val()=="activo"){
					var cedula=	 Trim($("#cedulaEdicion").get(0).value);
			var nombre= Trim($("#nombreEdicion").get(0).value)
		 var apellido =Trim($("#apellidoEdicion").get(0).value);
		 var email=Trim($("#emailEdicion").get(0).value);
		 var telefono=Trim($("#telefonoEdicion").get(0).value);
		  var celular =Trim($("#celularEdicion").get(0).value);
		  var diferidoPor =Trim($("#diferidoPorEdicion").get(0).value);
		  var observacion =Trim($("#observacionEdicion").get(0).value);
		 
		  if (cedula=="")
		 {$("#cedula").focus();
		 //alert("estoy aqui "+cedula)
		 	return;
		 }
		 if (nombre=="")
		 {$("#nombre").focus();//alert("estoy aqui "+nombre)
		  return;
		 }
		 
		 if (apellido=="")
		 {$("#apellido").focus();//alert("estoy aqui en apellido "+apellido)
		 	 return; }
		 
		  if ((email=="")||(email=="No aplica"))
		 { email=cedula;
		 }
	var datos_json=$("#cedula").get(0).id+"="+ encodeURIComponent(cedula)+"&"+
	$("#nombre").get(0).id+"="+ encodeURIComponent(nombre)+"&"+
		 $("#apellido").get(0).id+"="+encodeURIComponent(apellido)+"&"+
		$("#email").get(0).id+"="+ encodeURIComponent(email)+"&"+
		 $("#telefono").get(0).id+"="+ encodeURIComponent(telefono)+"&"+
		  $("#celular").get(0).id+"="+encodeURIComponent(celular)+"&"+
		    $("#diferidoPor").get(0).id+"="+encodeURIComponent(diferidoPor)+"&"+
		    $("#observacion").get(0).id+"="+encodeURIComponent(observacion) +"&"+
			  "columna="+encodeURIComponent("idCliente") +"&"+
			    "tabla="+encodeURIComponent("pacientes") +"&"+
		 "respuesta="+ encodeURIComponent("edicionPaciente")+"&nocache=" + Math.random();
			$("#posicion").val("31");
			//alert(datos_json)
			
			carga_borrarUpdate(datos_json,respuestaEdicionPaciente);	}else{
				$(this).dialog("close");}
			
				},
						"Cancel": function() {
							$("#activaEdicion").val("inactivo");
							$(this).dialog("close");
						}
					}
				});

$('#noCitaHoy').click(function (){
							  var dateText=new Date($("#IngresoCitaId").val());
var dia=dateText.getDate()
var mes=(dateText.getMonth()+1);
var anio=dateText.getFullYear();

var fecha =dia+"/"+mes+"/"+anio;
							$('#pagCitas').dialog('open'); 
							$('#fechaCita').val(fecha); 
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


/////////////////lo nuevo busqueda de pacientes////////////////////////////
$('#buscaPacienteCita').click(function(){llenaBusqueda()
									$.colorbox({overlayClose:false, inline:true, href:"#busquedaCliente",width:"90%", height:"50%"});
								});


$("input[id='busquedaPacCitasRegistrado']").keyup(function (){
														
	var dato=$(this).val();
	if (Trim(dato)!=""){//"'%".$dato."%'"
	var query="SELECT * FROM pacientes WHERE `nombre` LIKE ";
	var datos_json = "query=" + encodeURIComponent(query)+		
			"&dato=" + encodeURIComponent(dato) +
			"&tabla2=" + encodeURIComponent('idCliente') +
			"&tabla3=" + encodeURIComponent("apellido") +
		"&nocache=" + Math.random();
		limpia_linea('tablasListaPacCitas','indiceListaPacCitas');
		carga_listar(datos_json,list_res_pacientes_2);
		}else{
			limpia_linea('tablasListaPacCitas','indiceListaPacCitas');
			llenaBusqueda()
			$(this).focus();}
	
	
	});




});
				
		
function llenaBusqueda(){
	query ="SELECT * FROM pacientes ORDER BY `nombre` ASC" ;
		var datos_json = "query=" + encodeURIComponent(query) +
		"&nocache=" + Math.random();
		limpia_linea('tablasListaPacCitas','indiceListaPacCitas');
		carga_listar(datos_json,list_res_pacientes_2);
		}

	
	function list_res_pacientes_2(){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
//alert(respuesta_json)
var num_filas = objeto_json.filas;
if (num_filas>0){
	var encabezados =['idCliente','nombre' ,'apellido'  ,'telefono','email'  ];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalPacCitas','tablasListaPacCitas','indiceListaPacCitas','listarTablaPacCitas',0,15,"cedula2",false,false,false,false,false);
}else {limpia_linea('tablasListaPacCitas','indiceListaPacCitas');
	var texto="encuentra registrado ningun paciente en la base de datos";
		$('#tablasListaPaciente').html(texto);
	}
	
	asignarNuevoPaciente();
	
	}