$(document).ready(function(){
		$("#anamnesisId").accordion({ header: "h3", 
								
									active: 1 });				   
						   
						   $("#ExamenFisicoId").accordion({ header: "h3", 
									
									active: 1 });	
						   
						     $("#ExamenDentalId").accordion({ header: "h3", 
									
									active: 1 });	
							 
							 $('#cuerpo').tabs();
						   
							 $('#TablaCuerpo').tabs();
							 
							 
			//href="javascript:window.history.back(); "		
			
			
							 
							 $("#usuario").val($.cookie('usuario'));
$("#Identificacion").html($.cookie('usuario'));
var dato=$.cookie('usuario');
var nombre=$.cookie('nombre')
var apellido=$.cookie('apellido')

cedula=$.cookie('usuario');


$('#guardarHistoria').click(function (){
			 var datos_json="";
			 var i=0;
	for (cab=1;cab<=13;cab++){
		nombre="cabecera_"+cab;
	dato=$("#"+nombre).val();
datos_json=datos_json+nombre+"="+ encodeURIComponent(dato)+"&";	
	}

alert(datos_json);
$(".parte1").each(function(){
i++;
dato=$(this).val();
datos_json=datos_json+"parte_1_"+i+"="+ encodeURIComponent(dato)+"&";});
i=0;
$(".parte2").each(function(){
	i++;
	dato=$(this).val();
	datos_json=datos_json+"parte_2_"+i+"="+ encodeURIComponent(dato)+"&";
});
i=0;
$(".parte3").each(function(){i++;
	dato=$(this).val();
	datos_json=datos_json+"parte_3_"+i+"="+ encodeURIComponent(dato)+"&";
 }); 
									 datos_json= datos_json+"cedula="+ encodeURIComponent(cedula)+"&"+
									 			 "columna1="+encodeURIComponent("idPaciente") +"&"+
												 "tabla1="+encodeURIComponent("historiaclinica") +"&"+ 
												 "columna2="+encodeURIComponent("idPaciente") +"&"+
												 "tabla2="+encodeURIComponent("anamnesis") +"&"+ 
												 "columna3="+encodeURIComponent("idPaciente") +"&"+
												 "tabla3="+encodeURIComponent("examendental") +"&"+ 
												 "columna4="+encodeURIComponent("idPaciente") +"&"+
												 "tabla4="+encodeURIComponent("examfisicoestomatologico") +"&"+
												 "columna5="+encodeURIComponent("idCliente") +"&"+
												 "tabla5="+encodeURIComponent("pacientes") +"&"+
												 "respuesta="+ encodeURIComponent("edicionHistoria_2")+"&nocache=" + Math.random();
				carga_borrarUpdate(datos_json,respuestaEdicionHistoria_2);
						});



$("#cabecera_2").html(dato);
$("#cabecera_1").datepicker({selectOtherMonths: true,
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"]});
$("#cabecera_8").datepicker({selectOtherMonths: true,
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"]});
$("#cabecera_3").val(nombre);
$("#cabecera_4").val(apellido);
if (Trim(dato)!=""){
var query="SELECT * FROM `historiaclinica` , `examendental` , `examfisicoestomatologico` , `anamnesis` , `pacientes` WHERE historiaclinica.idPaciente = "+dato+" AND examendental.idPaciente = "+dato+" AND examfisicoestomatologico.idPaciente ="+dato+" AND anamnesis.idPaciente = "+dato+" AND pacientes.idCliente = "+dato;
		var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
		//alert (datos_json);
		carga_listar(datos_json,llenaHistoriaAuxiliar);	}
		
		
		

});	


function llenaHistoriaAuxiliar(){
		var respuesta_json = this.req.responseText;
		var objeto_json = eval('('+respuesta_json+')');
				nFila=0;
				var num_filas = objeto_json.filas;
$("#cabecera_1").val(objeto_json.datos[nFila]['fechaIngreso']);
			$("#cabecera_6").val(objeto_json.datos[nFila]['direccion']);
	$("#cabecera_5").val(objeto_json.datos[nFila]['telefono']);
	$("#cabecera_7").val(objeto_json.datos[nFila]['ciudad']);
	$("#cabecera_8").val(objeto_json.datos[nFila]['FechaNacimiento']);
	$("#cabecera_9").val(objeto_json.datos[nFila]['edad']);
	$("#cabecera_10").val(objeto_json.datos[nFila]['sexo']);
	$("#cabecera_11").val(objeto_json.datos[nFila]['estCivil']);
	$("#cabecera_12").val(objeto_json.datos[nFila]['ocupacion']);
	$("#cabecera_13").val(objeto_json.datos[nFila]['diferidoPor']);
		var i=0;
	var cabecerasCol3=['Supernumerarios' ,'Trauma' ,'Abrasion' ,'ManchasCambiosColor' ,'Habitos' ,'PatoligiaPulparAbcesos' ,'Maloclusiones','BolsasMovilidad' ,'PlacaBlanda','Calculos','Incluidos'   ,'descExaDental'];	
	
	var cabecerasCol2=['HigieneOral' ,'SedaDenta' ,'CepilloDental' ,'A.T.M' ,'SenosMaxilares','Labios' ,'MusculosMasticadores' ,'Lengua' ,'Ganglios' ,'Paladar' ,'Oclusion','PisoBoca','Frenillos' ,'Carrillos'  ,'Mucosas','GlandulasSalivares'  ,'Encias','Maxilares'    ,'Amigdalas' ,'descExaFisEstomat'];
		
	var cabecerasCol1=['TraMedico','FiebReuma','IngesMed','Hepatitis','ReacAlerg','Hipertension','Hemorragias','Embarazo','Irradicaciones','EnfRenales','Sinusitis','EnfGastIntesti','EnfRespiratoria','OrgSen','Cardiopatia','Otros','Diabetes','descAnamnesis'];

$(".parte1").each(function(){
cabeza=cabecerasCol1[i];
	i++;
	$(this).val(objeto_json.datos[nFila][cabeza]);
})
i=0;
$(".parte2").each(function(){
	 cabeza=cabecerasCol2[i];
	i++;
	$(this).val(objeto_json.datos[nFila][cabeza]);
});
i=0;
$(".parte3").each(function(){
	cabeza=cabecerasCol3[i];
	i++;
	//alert(objeto_json.datos[nFila][cabeza])
 $(this).val(objeto_json.datos[nFila][cabeza]);
 });
	
}


function respuestaEdicionHistoria_2(){
		var respuesta_json = this.req.responseText;
		alert(respuesta_json)
		$("#HistoriaRegresa").trigger("click")
		
		}
						   
				