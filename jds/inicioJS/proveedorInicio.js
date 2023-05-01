$(document).ready(function(){
$("#EditarBoton").click(function (){
								  $("#activaEdicion").val("activo");
								  	$(".proveedorEdicion").each(function(){
								$(this).css('display', 'inline');				  
												  });
									$(".proveedorEdicionLb").each(function(){
								$(this).css('display', 'none');				  
												  });
									
									$("#cedulaEdicionLb").css('display', 'inline');
									$("#cedulaEdicion").css('display', 'none');	
									//$("#tuCampo").attr("disabled", "enable");
										$("#observacionEdicion").css('display','inline' );
									$("#observacionEdicion").removeAttr("disabled"); 
									$("#nombreEdicion").focus();
								   });


inicioProveedor()


$("input[id='cedulaEdicion']").keyup(function (){
											   
	var dato=$(this).val();
	if (Trim(dato)!=""){
	var query="select * from proveedor where `idProveedor`= ";
	var datos_json = "query=" + encodeURIComponent(query)+
	"&igual=" + encodeURIComponent('true')+	
	"&dato=" + encodeURIComponent(dato)+		
		"&nocache=" + Math.random();
		carga_listar(datos_json,llenaEdicionProveedor);}else{
			
								  	$(".proveedorEdicionLb").each(function(){
								$(this).css('display', 'inline');
								$(this).html('');
								
												  });
									$(".proveedorEdicion").each(function(){
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
					 generaKeydowm(".proveedor");
					 },
					beforeClose: function(event, ui) {	
					$(".proveedor").each(function(){
								$(this).val("");				  
												  });
					if($("#respuesta").val()=="nuevoRegistro"){
					 inicioProveedor();} },
					
					buttons: {
						
						"Ok": function okBoton() {
				var cedula=	 Trim($("#cedula").get(0).value);
			var razonSocial= Trim($("#razonSocial").get(0).value)
		  var email=Trim($("#email").get(0).value);
		 var telefono=Trim($("#telefono").get(0).value);
		  var celular =Trim($("#celular").get(0).value);
		 var observacion =Trim($("#observacion").get(0).value);
		 
		  if (cedula=="")
		 {$("#cedula").focus();
		 	return;
		 }
		 if (razonSocial=="")
		 {$("#razonSocial").focus();
		  return;
		 }
		 if ((email=="")||(email=="No aplica"))
		  {  email=cedula;}
	var datos_json=$("#cedula").get(0).id+"="+ encodeURIComponent(cedula)+"&"+
	$("#razonSocial").get(0).id+"="+ encodeURIComponent(razonSocial)+"&"+
	$("#email").get(0).id+"="+ encodeURIComponent(email)+"&"+
		 $("#telefono").get(0).id+"="+ encodeURIComponent(telefono)+"&"+
		  $("#celular").get(0).id+"="+encodeURIComponent(celular)+"&"+
		   $("#observacion").get(0).id+"="+encodeURIComponent(observacion) +"&"+
		 "respuesta="+ encodeURIComponent("nuevoProveedor")+"&nocache=" + Math.random();
			$("#posicion").val("31");
				carga_insert(datos_json,respuestaNuevoProveedor);					
			
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
					 generaKeydowm(".proveedorEdicion");
					 $("#cedulaEdicion").trigger("keyup");
					 
					 },
					beforeClose: function(event, ui) {	
				
								  	$(".proveedorEdicionLb").each(function(){
								$(this).css('display', 'inline');
								$(this).html('');
								
												  });
									$(".proveedorEdicion").each(function(){
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
			var razonSocial= Trim($("#razonSocialEdicion").get(0).value)
		 var email=Trim($("#emailEdicion").get(0).value);
		 var telefono=Trim($("#telefonoEdicion").get(0).value);
		  var celular =Trim($("#celularEdicion").get(0).value);
		  var observacion =Trim($("#observacionEdicion").get(0).value);
		 
		  if (cedula=="")
		 {$("#cedulaEdicion").focus();
		 //alert("estoy aqui "+cedula)
		 	return;
		 }
		 if (razonSocial=="")
		 {$("#razonSocialEdicion").focus();//alert("estoy aqui "+nombre)
		  return;
		 }
		 
		  if ((email=="")||(email=="No aplica"))
		 { email=cedula;
		 }
	var datos_json=$("#cedula").get(0).id+"="+ encodeURIComponent(cedula)+"&"+
	$("#razonSocial").get(0).id+"="+ encodeURIComponent(razonSocial)+"&"+
	$("#email").get(0).id+"="+ encodeURIComponent(email)+"&"+
		 $("#telefono").get(0).id+"="+ encodeURIComponent(telefono)+"&"+
		  $("#celular").get(0).id+"="+encodeURIComponent(celular)+"&"+
		    $("#observacion").get(0).id+"="+encodeURIComponent(observacion) +"&"+
			  "columna="+encodeURIComponent("idProveedor") +"&"+
			    "tabla="+encodeURIComponent("proveedor") +"&"+
		 "respuesta="+ encodeURIComponent("edicionProveedor")+"&nocache=" + Math.random();
			$("#posicion").val("31");
			
			
		carga_borrarUpdate(datos_json,function(){var respuesta_json = this.req.responseText;jAlert(respuesta_json);$('#pagEdicionPacientes').dialog("close");inicioProveedor();
        }    );	}else{
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
	var query="SELECT * FROM proveedor WHERE `nombre` LIKE ";
	var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
			var datos_json = "query=" + encodeURIComponent(query) +
			"&dato=" + encodeURIComponent(dato) +
			"&tabla2=" + encodeURIComponent('idProveedor') +
			"&nocache=" + Math.random();
		//alert(datos_json);
		limpia_linea('tablasListaPaciente','indiceListaPaciente');
		carga_listar(datos_json,list_res_proveedor);
		}else{
			inicioProveedor()
			$(this).focus();}
	
	});
					});	

  function inicioProveedor(){
			$("#activaEdicion").val("inactivo");
					var posicion=$("#posicion").val();
			if (posicion=='31')	  
			{  query ="SELECT * FROM proveedor ORDER BY `identificador` DESC" ;}else
		 { query ="SELECT * FROM proveedor ORDER BY `razonSocial` ASC" ;
								 }
								// alert(query);
		  $("#posicion").val("3");
		var datos_json = "query=" + encodeURIComponent(query) +
		"&nocache=" + Math.random();
		limpia_linea('tablasListaPaciente','indiceListaPaciente');
		carga_listar(datos_json,list_res_proveedor);
	}
	
