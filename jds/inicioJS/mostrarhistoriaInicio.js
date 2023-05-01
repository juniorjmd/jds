$(document).ready(function(){
		$("#usuario").val($.cookie('usuario'));
$("#Identificacion").html($.cookie('usuario'));



$('.ImprimeHistoria').click(function (){
$('div#areaDeImpresion').printArea();
});

$('.CrearHistoria').click(function (){
$(this).attr("href", 'CreaHistoria.php');
});

	   
var dato=$("#usuarioCookie").val();
var nombre=$("#nombreCookie").val();
var apellido=$("#apellidoCookie").val();
$("#cabecera_2").html(dato);
$("#cabecera_3").html(nombre+' '+apellido);



	if (Trim(dato)!=""){
		/*SELECT * FROM `historiaclinica` , `examendental` , `examfisicoestomatologico` , `anamnesis` , `pacientes` WHERE historiaclinica.idPaciente = '84455110' AND examendental.idPaciente = '84455110' AND examfisicoestomatologico.idPaciente = '84455110' AND anamnesis.idPaciente = '84455110' AND pacientes.idCliente = '84455110'*/
		
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
	$("#cabecera_1").html(objeto_json.datos[nFila]['fechaIngreso']);
	$("#cabecera_4").html(objeto_json.datos[nFila]['direccion']);
	$("#cabecera_5").html(objeto_json.datos[nFila]['telefono']);
	$("#cabecera_6").html(objeto_json.datos[nFila]['ciudad']);
	$("#cabecera_7").html(objeto_json.datos[nFila]['FechaNacimiento']);
	$("#cabecera_8").html(objeto_json.datos[nFila]['edad']);
	$("#cabecera_9").html(objeto_json.datos[nFila]['sexo']);
	$("#cabecera_10").html(objeto_json.datos[nFila]['estCivil']);
	$("#cabecera_11").html(objeto_json.datos[nFila]['ocupacion']);
	$("#cabecera_12").html(objeto_json.datos[nFila]['diferidoPor']);
	
	
	var i=0;
	var cabecerasCol3=['Supernumerarios' ,'Trauma' ,'Abrasion' ,'Habitos' ,'ManchasCambiosColor' ,'PatoligiaPulparAbcesos' ,'BolsasMovilidad' ,'Maloclusiones' ,'PlacaBlanda','Incluidos'  ,'Calculos','descExaDental'];	
	
	var cabecerasCol2=['HigieneOral' ,'SedaDenta' ,'CepilloDental' ,'A.T.M' ,'SenosMaxilares','Labios' ,'MusculosMasticadores' ,'Lengua' ,'Ganglios' ,'Paladar' ,'Oclusion','PisoBoca','Frenillos' ,'Carrillos'  ,'Mucosas','GlandulasSalivares'  ,'Encias','Maxilares'    ,'Amigdalas' ,'descExaFisEstomat'];
		
	var cabecerasCol1=['TraMedico','FiebReuma','IngesMed','Hepatitis','ReacAlerg','Hipertension','Hemorragias','Embarazo','Irradicaciones','EnfRenales','Sinusitis','EnfGastIntesti','EnfRespiratoria','OrgSen','Cardiopatia','Otros','Diabetes','descAnamnesis'];

$(".parte1").each(function(){
cabeza=cabecerasCol1[i];
	i++;
	$(this).html(objeto_json.datos[nFila][cabeza]);
					 
					 })


i=0;
$(".parte2").each(function(){
	 cabeza=cabecerasCol2[i];
	i++;
	
	$(this).html(objeto_json.datos[nFila][cabeza]);
					 });


i=0;
$(".parte3").each(function(){cabeza=cabecerasCol3[i];
	i++;
 $(this).html(objeto_json.datos[nFila][cabeza]);
					 })
}