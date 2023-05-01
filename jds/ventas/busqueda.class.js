function generarListado(inicio){
	if (!inicio){inicio='0';}
	$('.explListado').attr('disabled',true);
	$( "#divCargaListado" ).css('opacity','0,1');
	var datosAjax = {tabla: 'pacientes',
		inicio: inicio,
		tamanioBloque:'20'};	
		//alert(JSON.stringify(datosAjax))	
		$.ajax({url: 'php/db_listar.php',  
			type: 'POST',
			data: datosAjax,
			dataType: "json",
			 beforeSend: function() {	$( "#progressbarPacientes" ).css('display','');
			}, 
			statusCode: {
    			404: function() {
				 alert( "pagina no encontrada" );
   				 },
				 408: function() {
				alert( "Tiempo de espera agotado. la peticion no se realizo " );
   				 } 
				 },
 			success: function(data) {
				datosTabla=data['datos'];
				$("#containerTabla").html('');
				var encabezado =[{aliniacion:'left',cabeza:'NOMBRE COMPLETO',columnasTabla:['nombre','apellido'],separador:'  '},{aliniacion:'right',cabeza:'ID CLIENTE',columnasTabla:['idCliente'],separador:''},{aliniacion:'right',cabeza:'MAIL',columnasTabla:['email'],separador:''}]
//alert(JSON.stringify(encabezado))
var cargadorLista= new listadoTabla.CargadorContenidos(datosTabla,encabezado,'idCliente',false,"nuevaT",'containerTabla',funcionPaciente);
//alert(data['siguiente']+'  '+data['anterior']+'  '+data['ultimo'])
	$('#siguiente').val(data['siguiente']);
	$('#anterior').val(data['anterior']);
	$('#ultimo').val(data['ultimo']);
	$('.explListado').removeAttr('disabled',true);
	$( "#divCargaListado" ).css('opacity','1');
	$( "#progressbarPacientes" ).css('display','none');
				},error: function(a,e,b){
					 alert("se genero un error")
					}});
	}