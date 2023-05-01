$(document).ready(function(){
$("#EditarBoton").click(function (){
								  $("#activaEdicion").val("activo");
								  	$(".pacientesEdicion").each(function(){
								$(this).css('display', 'inline');				  
												  });
									$(".pacientesEdicionLb").each(function(){
								$(this).css('display', 'none');				  
												  });
									
									$("#cedulaEdicionLb").css('display', 'inline');
									$("#cedulaEdicion").css('display', 'none');	
									//$("#tuCampo").attr("disabled", "enable");
										$("#observacionEdicion").css('display','inline' );
									$("#observacionEdicion").removeAttr("disabled"); 
									$("#nombreEdicion").focus();
								   });
inicioPaciente()


$("input[id='cedulaEdicion']").keyup(function (){
											   
	var dato=$(this).val();
	if (Trim(dato)!=""){
	var query="select * from pacientes where `idCliente`= "+dato+" ";
	var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
		//alert (datos_json);
		carga_listar(datos_json,llenaEdicion);}else{
			
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
					 inicioPaciente();} },
					
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
			//alert(datos_json)
		
			carga_insert(datos_json,respuestaNuevoPaciente);					
			
				},
						"Cancel": function() {$("#respuesta").val("none")
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
								$(this).val('');	
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
			inicioPaciente()
			
			carga_borrarUpdate(datos_json,respuestaEdicionPaciente);	}else{
				$(this).dialog("close");}
			
				},
						"Cancel": function() {
							$("#activaEdicion").val("inactivo");
							$(this).dialog("close");
						}
					}
				});


$("input[id='busquedaPacienteRegistrado']").keyup(function (){
												
	var dato=$(this).val();
	if (Trim(dato)!=""){//"'%".$dato."%'"
	var query="SELECT * FROM pacientes WHERE `nombre` LIKE ";
	var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
		//alert (datos_json);"SELECT * FROM procedimientos WHERE `nombre` LIKE "
			var datos_json = "query=" + encodeURIComponent(query) +
			"&dato=" + encodeURIComponent(dato) +
			"&tabla2=" + encodeURIComponent('idCliente') +
			"&tabla3=" + encodeURIComponent("apellido") +
		"&nocache=" + Math.random();
		//alert(datos_json);
		limpia_linea('tablasListaPaciente','indiceListaPaciente');
		carga_listar(datos_json,list_res_pacientes);
		}else{
			inicioPaciente()
			$(this).focus();}
	
	});
					});	

  function inicioPaciente(){
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
	}
	
