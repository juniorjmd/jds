var formatNumber = {
 separador: ".", // separador para los miles
 sepDecimal: ',', // separador para los decimales
 formatear:function (num){
  num +='';
  var splitStr = num.split('.');
  var splitLeft = splitStr[0];
  var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '';
  var regx = /(\d+)(\d{3})/;
  while (regx.test(splitLeft)) {
  splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
  }
  return this.simbol + splitLeft  +splitRight;
 },
 new:function(num, simbol){
  this.simbol = simbol ||'';
  return this.formatear(num);
 }
};
function enviar_ventas_simple(){
	
		var valorTotal= parseFloat($("#cantidadVenta").val())* parseFloat($("#presioVenta").val());
		
			var datosAjax='codMesa='+encodeURIComponent($("#modulo").val())
				+'&IdVenta='+encodeURIComponent($("#IdVenta").val())
				+'&idProducto='+encodeURIComponent($("#idProducto").val())
				+'&nombreProducto='+encodeURIComponent($("#nombreProducto").val())
				+'&presioVenta='+encodeURIComponent($("#presioVenta").val())
				+'&porcent_iva='+encodeURIComponent($("#porcent_iva").val())
				+'&PsIVA='+encodeURIComponent($("#PsIVA").val())
				+'&IVA='+encodeURIComponent($("#IVA").val())
				+'&cantidadVendida='+encodeURIComponent($("#cantidadVenta").val())
                                +'&cantidadDescontar='+encodeURIComponent($("#cantidadVenta_descontar").val())
				+'&mesaActivada='+encodeURIComponent($("#PCname").val())
				+'&valorTotal='+encodeURIComponent(valorTotal)
				+"&nocache=" + Math.random()
			$.ajax({
            url: 'guardarVentas.php',  
            type: 'POST',
         	
            data: datosAjax,
			dataType: "json",
            beforeSend: function(){
				// console.log(JSON.stringify(datosAjax))
            }, 
			statusCode: {
    			404: function() {
				 alert( "pagina no encontrada" );
   				 },
				 408: function() {
				alert( "Tiempo de espera agotado. la peticion no se realizo " );
   				 } 
				 },
            //una vez finalizado correctamente
            success: function(responseText){
//			console.log(JSON.stringify(responseText))
			  $("#cerrarliquidar").trigger("click")
                          $("#cerrarTransformar").trigger("click")
			  if (responseText['estado'] == 2){
				   alert (responseText['mensaje'] )				  
			  }
			  else{ $('#frame_facturas').attr('src',"facturacion.php");}
			 },
            //si ha ocurrido un error fail(function( jqXHR, textStatus )
            error: function( jqXHR, textStatus ){
                message = $("no se pudo insertar el producto en este momento");
           $("#cerrarliquidar").trigger("click")            
           $("#cerrarTransformar").trigger("click")
			}
        })
	 }	
	 
function cookie(){
	$.cookie('usuario',null)
 $.cookie('nombre',null)
$.cookie('apellido',null)
	}

function asignarCambioGrid(idfila)
{	$(idfila).mouseover(function() {
		helpidTD=$(this).get(0).id;
		if(helpidTD=='600')
	{	helpidTD=630;
		}
		for(i=1;i<=7;i++){
			idhelp="#"+helpidTD+'d'+i;
			idhelp2=helpidTD+'d'+i;
			auxid="#classID"+i;
			$(auxid).val(document.getElementById(idhelp2).className);
			$(idhelp).removeClass('ui-widget-content');
			document.getElementById(idhelp2).className = 'ui-widget-content2';
			}
});
$(idfila).mouseout(function() {idTR=$(this).get(0).id;
	if(idTR=='600')
	{	helpidTD=630;
		}
	for(i=1;i<=7;i++){
		idhelp="#"+helpidTD+'d'+i;
		idhelp2=helpidTD+'d'+i;
		$(idhelp).removeClass('ui-widget-content2');
		auxid="#classID"+i;
		document.getElementById(idhelp2).className = $(auxid).val();
		}
});}

function CrearGrid(IdDiv){
var texto='<div id="CuerpoGrid"   style="width:100%; height:600px;overflow:auto"><table id="tablagrid" width="100%" border="0">            <tr  class="ui-widget-header" align="center"><td colspan="2" width="10,95%" >&nbsp;&nbsp;&nbsp;</td><td  height="27"  id="txtD1" ><span class="cabecera"></span><br/>Domingo</td><td  id="txtD2"><span class="cabecera" ></span><br/>Lunes</td>              <td id="txtD3"><span  class="cabecera"></span><br/>Martes</td>              <td id="txtD4" ><span class="cabecera"></span><br/>Miercoles</td>              <td id="txtD5" ><span class="cabecera"></span><br/>Jueves</td>              <td id="txtD6" ><span class="cabecera"></span><br/>Viernes</td>              <td  id="txtD7"><span class="cabecera"></span><br/>Sabado</td>            </tr> <tr   align="center"><td ></td> <td  ></td> <td id="flechaD1" class="flechaD"></td>   <td class="flechaD" id="flechaD2"  ></td>   <td id="flechaD3" class="flechaD"></td>   <td id="flechaD4" class="flechaD"></td>   <td  id="flechaD5" class="flechaD"></td>     <td id="flechaD6" class="flechaD"></td>   <td id="flechaD7" class="flechaD"></td></tr> </table> <table  width="100%" border="0"> '
var cont=0;
hora2=hora=5
ampm="am"
var seccionHora=00;
for (i=0;i<51;i++){muestra="";
rowspan=4;
if(i==0){seccionHora=30;rowspan=2;	cont=4}
if(i==22){rowspan=0;cont=4}
if(cont==4){
hora++
hora2++
seccionHora=0;
muestra='<div  id="'+hora2+'00'+'div"><tbody > <tr id="'+hora2+'00'+'" ><td rowspan="'+rowspan+'" class="ui-widget-header" >'+hora+'</td>';
cont=0
if(i==22){cont=3;ampm="pm";hora=0;}
if(i==0){cont=2; seccionHora=30; 
muestra='<div  id="'+hora2+'30'+'div"><tbody > <tr id="'+hora2+'00'+'" ><td rowspan="'+rowspan+'" class="ui-widget-header" >'+hora+'</td>';
}
}
else{muestra='<tr id="'+hora2+seccionHora.toString()+'" >'; //alert(hora+seccionHora.toString())
}
cont++;
texto=texto +muestra;
if(seccionHora==0){
auxseccionHora="00"}else{auxseccionHora=seccionHora}
for(r=0;r<=7;r++){
if (r==0){classId="class='ui-widget-header'";
 id=hora2+auxseccionHora.toString()+"d0"
 auxID=auxseccionHora+ampm;
 ancho=""
 }else{ancho="14%"
 auxID=""
 classId="class='ui-widget-content'";
 id=hora2+auxseccionHora.toString()+"d"+(r);}
if(i==22){classId="class='ui-widget-header'";
	texto=texto +"<td "+classId+" width='"+ancho+"'>"+auxID+'</td>';
	}else{ 
texto=texto +"<td id='"+id+"' "+classId+" width='"+ancho+"'> "+auxID+'<table  border="0" id="'+id+'_tabla"  width="100%"  ><tr  align="center" ><td ></td></tr>                <tr><td ><div class= "CitasRegistradas" align="center" id="'+id+'_TablaDiv" ></div ></td>                </tr>              </table>                <div class= "CitasRegistradas" align="center" id="'+id+'_indexDiv" ></div>  </td>';}
}
texto=texto+"</tr>"
idfila='#'+hora2+auxseccionHora;
seccionHora=seccionHora+15;
if(cont==4){texto=texto+"</tbody></div>";}
}
texto=texto+"</div><tr  class='ui-widget-header' align='center'>            <td  colspan='2'   >diferido</td>              <td  id='d1diferido' class= 'CitasRegistradas'></td> <td  id='d2diferido' class= 'CitasRegistradas'></td> <td  id='d3diferido' class= 'CitasRegistradas'></td> <td  id='d4diferido' class= 'CitasRegistradas'></td> <td  id='d5diferido' class= 'CitasRegistradas'></td> <td  id='d6diferido'class= 'CitasRegistradas'></td> <td class= 'CitasRegistradas'  id='d7diferido' ></td></tr><tr  class='ui-widget-header' align='center'>            <td  colspan='2'   >Cancelado</td>              <td  id='d1Cancelado'class= 'CitasRegistradas'></td> <td  id='d2Cancelado' class= 'CitasRegistradas'></td> <td class= 'CitasRegistradas' id='d3Cancelado' ></td> <td class= 'CitasRegistradas' id='d4Cancelado' ></td> <td class= 'CitasRegistradas' id='d5Cancelado' ></td> <td  class= 'CitasRegistradas' id='d6Cancelado' ></td> <td class= 'CitasRegistradas' id='d7Cancelado' ></td></tr> <tr  class='ui-widget-header' align='center'>            <td  colspan='2'   >&nbsp;</td>              <td  id='d1Cancelado'class= 'CitasRegistradas'>&nbsp;</td> <td  id='d2Cancelado' class= 'CitasRegistradas'>&nbsp;</td> <td class= 'CitasRegistradas' id='d3Cancelado' >&nbsp;</td> <td class= 'CitasRegistradas' id='d4Cancelado' >&nbsp;</td> <td class= 'CitasRegistradas' id='d5Cancelado' >&nbsp;</td> <td  class= 'CitasRegistradas' id='d6Cancelado' >&nbsp;</td> <td class= 'CitasRegistradas' id='d7Cancelado' >&nbsp;</td></tr></tabla></div> <input type='hidden' id='classID1' /><input type='hidden'id='classID2' /><input type='hidden' id='classID3' /><input type='hidden' id='classID4' /><input type='hidden' id='classID5' /><input type='hidden' id='classID6' /><input type='hidden' id='classID7' /><input type='hidden' id='dateInicial' /><input type='hidden' id='dateFinal' /></div>"
$(IdDiv).append(texto);
$('#CuerpoGrid').niceScroll({cursorborder:"",cursorcolor:"#a6c9e2"});	
hora=5;
cont=3;
for (i=0;i<51;i++){
cont++;
if(i==22){cont=4}
auxseccionHora=seccionHora.toString();
if(cont==4){seccionHora=0
	hora++;
	auxseccionHora="00"
	cont=0;
	if(i==0){cont=2;
		seccionHora=30;}	
	if(i==22){cont=3}}
idfila='#'+hora.toString()+auxseccionHora
//	alert(i+" es el valos de i y el valor de cont " +cont+"  "+hora.toString()+"  "+idfila+"  "+auxseccionHora)
seccionHora=seccionHora+15;
if(i!=22){
asignarCambioGrid(idfila)}}
}

function respuestaNuevaCita1(){
		var respuesta_json = this.req.responseText;
		var numeroLetras = respuesta_json.length;
	pat=/Duplicate entry/;

	if (numeroLetras==38)
	{	
	$('#pagCitas').dialog("close");
	var Identificador=$("#IdGridIngreso").val();
	var fecha = new Date($("#IngresoCitaId").val());
  	var milisegundos=parseInt(24*60*60*1000);
	var NumDias=fecha.getDay() ;
	var totalDia=parseInt(fecha.getTime());	
	var inicio=new Date();
	inicio.setTime((totalDia+((6-parseInt(NumDias))*milisegundos))-(6*milisegundos))
	 var final=new Date();
	 final.setTime((totalDia+((6-parseInt(NumDias))*milisegundos)))
	 			
		verificaCita(inicio,final)
		}
else{
	//alert(respuesta_json);

	if(pat.test(respuesta_json)){
	 pat=/key 3/;
	if(pat.test(respuesta_json)){
		var texto="el e-mail ya esta registrado";
		$('#errorEmail2').html(texto);
		$("#email2").keyup(function (){var texto="";
		$('#errorEmail2').html(texto);
	
	});
		$("#email2").focus();
		
		}else{
			
			var texto="la Cedula ya esta registrada";
		$('#errorCedula2').html(texto);
		$("#cedula2").keyup(function (){var texto="";
		$('#errorCedula2').html(texto);
	
	});
			$("#cedula2").focus();	
		}
	}}		

	}


function respuestaNuevoPaciente(){
		var respuesta_json = this.req.responseText;
		var numeroLetras = respuesta_json.length;
	pat=/Duplicate entry/;
	if (numeroLetras==38)
	{//$("#respuesta").val()=="nuevoRegistro"
		$("#respuesta").val("nuevoRegistro")	
	$('#pagSalidas').dialog("close");
		}
else{if(pat.test(respuesta_json)){
	 pat=/key 2/;
	if(pat.test(respuesta_json)){
		var texto="el e-mail ya esta registrado";
		$('#errorEmail').html(texto);
		$("#email").keyup(function (){var texto="";
		$('#errorEmail').html(texto);
	
	});
		$("#email").focus();
		
		}else{
			
			var texto="la Cedula ya esta registrada";
		$('#errorCedula').html(texto);
		$("#cedula").keyup(function (){var texto="";
		$('#errorCedula').html(texto);
	
	});
			$("#cedula").focus();	
		}
	}}		

	}



function respuestaNuevoProveedor(){
		var respuesta_json = this.req.responseText;
			//alert(respuesta_json)
        	var numeroLetras = respuesta_json.length;
	pat=/Duplicate entry/;
	if (numeroLetras==38)
	{//$("#respuesta").val()=="nuevoRegistro"
		$("#respuesta").val("nuevoRegistro")	
	$('#pagSalidas').dialog("close");
		}
else{if(pat.test(respuesta_json)){
	 pat=/key 2/;
	if(pat.test(respuesta_json)){
		var texto="el e-mail ya esta registrado";
		$('#errorEmail').html(texto);
		$("#email").keyup(function (){var texto="";
		$('#errorEmail').html(texto);
	
	});
		$("#email").focus();
		
		}else{
			
			var texto="la Cedula ya esta registrada";
		$('#errorCedula').html(texto);
		$("#cedula").keyup(function (){var texto="";
		$('#errorCedula').html(texto);
	
	});
			$("#cedula").focus();	
		}
	}}		

	}


function asignarNuevoPaciente(){

$("#nuevoPaciente").click(function (){
					$('#pagSalidas').dialog('open'); });
}

function list_res_proveedor(){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
//alert(respuesta_json)
var num_filas = objeto_json.filas;
if (num_filas>0){
	var texto="<span id='nuevoPaciente' class='nuevolink'>agregar un nuevo proveedor aqui.</span>";
	var encabezados =['idProveedor','razonSocial'  ,'telefono','email','direccion'  ];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewProv','tablasListaPaciente','indiceListaPaciente','listarTablaPaciente',2,15,"cedulaEdicion","pagEdicionPacientes",false,false,false,false,muestraCreditosProveedor);

	$('#tablasListaPaciente').append(texto);
$(".imagen1").each(function(){
	$(this).attr("width","18");
$(this).attr("height","19");
$(this).attr("src","imagenes/editar_grande.jpg");
});
$(".imagen2").each(function(){
$(this).attr("src","imagenes/ui-icons_lapiz.png");
$(this).attr("width","18");
$(this).attr("height","19");

});
}else {limpia_linea('tablasListaPaciente','indiceListaPaciente');
	var texto="Todavía no se encuentra registrado ningun paciente en la base de datos, para registrar haga click <span id='nuevoPaciente' class='menu_click'>aqui.</span>";
	$('#tablasListaPaciente').html(texto);
	}
	asignarNuevoPaciente();
	}

function muestraCreditosProveedor(){
	$.colorbox({overlayClose:false, inline:true, href:"#esperaPaciente",width:"100%", height:"100%"});

window.location.replace("listadoCreditosProveedor.php?this.datosParaEnvio['razonSocial']&85DvoRR="+this.datosParaEnvio['idProveedor']);
}

function list_res_pacientes(){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
//alert(respuesta_json)
var num_filas = objeto_json.filas;
if (num_filas>0){
	var texto="<span id='nuevoPaciente' class='nuevolink'>agregar un nuevo paciente aqui.</span>";
	var encabezados =['idCliente','nombre' ,'apellido'  ,'telefono','email'  ];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewPac','tablasListaPaciente','indiceListaPaciente','listarTablaPaciente',0,16,"cedulaEdicion","pagEdicionPacientes",false,false,enviaDatosPaciente,false);
	$('#tablasListaPaciente').append(texto);
}else {limpia_linea('tablasListaPaciente','indiceListaPaciente');
	var texto="Todavía no se encuentra registrado ningun paciente en la base de datos, para registrar haga click <span id='nuevoPaciente' class='menu_click'>aqui.</span>";
	
	$('#tablasListaPaciente').html(texto);
	}
	asignarNuevoPaciente();
	}

function enviaDatosPaciente(){
	$("#cedulaEdicion").val(this.datosParaEnvio['idCliente']);
	$("#cedulaEdicion").trigger('keyup');
	$("#pagEdicionPacientes").dialog('open');
	/*alert(this.datosParaEnvio['idCliente']+ "   "+this.datosParaEnvio['nombre']+ this.datosParaEnvio['apellido']+  this.datosParaEnvio['direccion']+  this.datosParaEnvio['email']+  this.datosParaEnvio['telefono']+  this.datosParaEnvio['telefonoCelular']+  this.datosParaEnvio['observaciones']+  this.datosParaEnvio['diferidoPor']+  this.datosParaEnvio['ciudad']+  this.datosParaEnvio['FechaNacimiento']+  this.datosParaEnvio['edad']+  this.datosParaEnvio['sexo']+  this.datosParaEnvio['estCivil']+  this.datosParaEnvio['ocupacion']+  this.datosParaEnvio['fechaIngreso']);*/
	$("#facePaciente").attr("href", "facebookPaciente.php?nombre="+this.datosParaEnvio['nombre']+"&apellido="+this.datosParaEnvio['apellido']+"&1DuU4oP="+this.datosParaEnvio['idCliente']);

	}
function marcaFechaCab(dateInicial,dateFinal){
	var i=0;
	var aux=6;
	var avance=30
	var cont=3
	var aux2=1;
	var milisegundos=parseInt(24*60*60*1000);
	
	

	$(".cabecera").each(function(){
			var dateInicial2= new Date();
			dateInicial2.setTime(parseInt(dateInicial.getTime())+(milisegundos*i));
			var dia=dateInicial2.getDate()
			var mes=(dateInicial2.getMonth()+1);
			var anio=dateInicial2.getFullYear();
			var fecha =mes+"/"+dia+"/"+anio;
			var Identificador
			for (ini=0;ini<51;ini++){
				if(avance!=0){
				Identificador ='#'+aux.toString()+avance.toString()+'d'+aux2;	}else
				{Identificador ='#'+aux.toString()+'00d'+aux2;	}
			//alert(Identificador)	
			$("#UbicacionEnLaGrid").val(Identificador);
		
			
			asignarCrearCita(Identificador, fecha);
			//alert("fue y vino")
			avance=avance+15
			if(ini==22){cont=4}
			if(cont==4){cont=0;avance=00
			
			aux++;}
			
			cont++;
			}
			aux=6;
			avance=30
			cont=3
			aux2++;
			//Identificador.substring(1,Identificador.indexOf("d"));
			//anio.substring(2);
			 switch(mes){
		case  1:
		Auxmes="ene";
		break;
			 case  2:
			Auxmes="feb";
		break;
			 case  3:
			Auxmes="mar";
		break;
			 case  4:
			Auxmes="abr";
		break;
			 case  5:
			Auxmes="may";
		break;
			 case  6:
			Auxmes="jun";
		break;
			 case  7:
			Auxmes="jul";
		break;
			 case  8:
			Auxmes="ago";
		break;
			 case  9:
			Auxmes="sep";
		break;
			 case  10:
			Auxmes="oct";
		break;
			 case  11:
			Auxmes="nov";
		break;
			 case  12:
			Auxmes="dic";
		break;
			 }
		
			var texto=dia+"/"+Auxmes+"/"+anio.toString().substring(2);
			$(this).html(texto);
			i++;
				});
		verificaCita(dateInicial,dateFinal);	
	
	}

		
function list_res_articulo(){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
//alert(respuesta_json)
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
	var texto="";
	/*function atencionPacientes(){}
function eliminaCita(){}
function editarCita(){}*/
var encabezados =['nombrePaciente','hora','telefono','estadoCita' ,'idCita'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalPac1','tablasLista','indiceLista','listarTablacolor',3,20,false,false,false,false,eliminaCita,false,editarCita,atencionPacientes,'idCita','obsevaciones');
	var texto="registrar nueva cita click aqui";

}else {limpia_linea('tablasLista','indiceLista');
	var texto="no tiene registrada ningura cita para esta fecha para registrar click aqui";
	}$('#noCitaHoy').html(texto);}
	
	
function listaDatosInventario(funcion,respuesta,dato1,dato2,dato3){
	
	limpia_linea('tablasLista','indiceLista');
		var datos_json = "respuesta=" + encodeURIComponent(respuesta) +
		"&dato1=" + encodeURIComponent(dato1) +
		"&dato2=" + encodeURIComponent(dato2) +
		"&dato3=" + encodeURIComponent(dato3) +
		"&nocache=" + Math.random();
			
	//	alert (datos_json)
		carga_listar(datos_json,funcion,"php/listadoInventario.php");
}
function asignarCrearCita(Identificador, fecha){
$(Identificador).unbind('dblclick');
$(Identificador).dblclick(function (){
		var fechaComp= new Date(fecha)
		var fechaComp2= new Date()
		var dia=fechaComp2.getDate()
		var mes=(fechaComp2.getMonth()+1);
		var anio=fechaComp2.getFullYear();
		var fechaAux =mes+"/"+dia+"/"+anio;
		fechaComp2= new Date(fechaAux)
		fecha1=parseInt(fechaComp.getTime())
		fecha2=parseInt(fechaComp2.getTime())
		if(fecha2<=fecha1){
		   	$('#fechaCita').val(fecha);
			var p= Identificador.substring(1,Identificador.indexOf("d"));
			$('#horaCita').val(p); 
			$("#horaCita").attr("disabled", true);
			$('#IdGrid').val("#"+$(this).get(0).id); 
			var query="select * from agenda where `fecha` ="
	var query2=" AND `ubicacionGrid`=";
	var query3="AND  (estadoCita <> 'diferido' AND estadoCita <> 'cancelada' ) BY `hora` DESC";
	var datos_json = "query="+ encodeURIComponent(query)+	
	"&query2="+ encodeURIComponent(query2)+	
		"&query3="+ encodeURIComponent(query3)+	
		"&dato1="+ encodeURIComponent(fecha)+	
		"&ubicacionGrid="+ encodeURIComponent("#"+$(this).get(0).id)+	
		"&respuesta="+ encodeURIComponent("revisaNuevasCitas")+	
		"&nocache=" + Math.random();
		carga_listar(datos_json,respuestaDblclick,"php/listadoInventario.php")}
		else{jAlert("la fecha en la que intenta apartar ya paso ");}
			});	
	
	}

	function respuestaDblclick(){
		var respuesta_json = this.req.responseText;
		//alert(respuesta_json)
		var objeto_json = eval('('+respuesta_json+')');
		var num_filas = objeto_json.filas;
		num_filas = objeto_json.filas;
	
		if (num_filas>0){
			
			jConfirm("la fecha y la hora en la cual desea apartar ya se encuentra ocupada, \nsi desea continuar sera registrado como diferido de lo contrario pulse cancelar \npara escoger otra hora y/o fecha para la reserva", "Creacion Nueva cita", function(r) {
			if(r) {
				$("#estadoCita").val("diferido");
			 $("#estadoCita").attr("disabled", true);
			 $('#pagCitas').dialog('open'); 
			} else {
				$('#pagCitas').dialog('close'); 
			}
		});
			
		} 
				 else{$('#pagCitas').dialog('open'); }
				 
				 
				 }
				 
				 
	function respuestaDblclick2(){
		var respuesta_json = this.req.responseText;
		//alert(respuesta_json)
		var objeto_json = eval('('+respuesta_json+')');
		var num_filas = objeto_json.filas;
		num_filas = objeto_json.filas;
	
		if (num_filas>0){
				jConfirm("la fecha y la hora en la cual desea apartar ya se encuentra ocupada, \nsi desea continuar sera registrado como diferido de lo contrario pulse cancelar \npara escoger otra hora y/o fecha para la reserva", "Creacion Nueva cita", function(r) {
			if(r) {
				$("#estadoCita").val("diferido");
			 $("#estadoCita").attr("disabled", true);
			 
			 
			fecha=new Date($("#IngresoCitaId").val()); 
			var NumDias=fecha.getDay()+1;
			var dia=fecha.getDate()
			var mes=(fecha.getMonth()+1);
			var anio=fecha.getFullYear();
			
	fechaCita =mes+"/"+dia+"/"+anio
	
	var cedula=	 Trim($("#cedula2").get(0).value);
			var nombre= Trim($("#nombre2").get(0).value)
		 var apellido =Trim($("#apellido2").get(0).value);
		 var email=Trim($("#email2").get(0).value);
		 var telefono=Trim($("#telefono2").get(0).value);
		 var observacion =Trim($("#observacion2").get(0).value);
		 var horaCita =Trim($('#horaCita').val());
		 var IdGrid= '#'+ horaCita+'d'+NumDias;
	 var RangoHora=IdGrid.substring(1,IdGrid.length-4);
	 respueta=$("#Guardado").val();
			 var datos_json="cedula="+ encodeURIComponent(cedula)+"&"+
			"nombre="+ encodeURIComponent(nombre)+"&"+
			 "apellido="+encodeURIComponent(apellido)+"&"+
			"email="+ encodeURIComponent(email)+"&"+
			 "telefono="+ encodeURIComponent(telefono)+"&"+
		 	  "observacion="+encodeURIComponent(observacion) +"&"+
		 	   "fechaCita="+encodeURIComponent(fechaCita) +"&"+
			  "horaCita="+encodeURIComponent(horaCita) +"&"+
			  "estadoCita="+encodeURIComponent("diferido") +"&"+
			  "IdGrid="+encodeURIComponent(IdGrid) +"&"+
			  "RangoHora="+encodeURIComponent(RangoHora) +"&"+
		 "respuesta="+ encodeURIComponent(respueta)+"&nocache=" + Math.random();
		 
		
			carga_insert(datos_json,respuestaNuevaCita1);	
			} else {
				$('#pagCitas').dialog('close'); 
			}
		});
		} else{	;
			 $("#estadoCita").attr("disabled", true);
			fecha=new Date($("#IngresoCitaId").val()); 
			var NumDias=fecha.getDay()+1;
			var dia=fecha.getDate()
			var mes=(fecha.getMonth()+1);
			var anio=fecha.getFullYear();
			fechaCita =mes+"/"+dia+"/"+anio
			var cedula=	 Trim($("#cedula2").get(0).value);
			var nombre= Trim($("#nombre2").get(0).value)
			var apellido =Trim($("#apellido2").get(0).value);
			var email=Trim($("#email2").get(0).value);
		 	var telefono=Trim($("#telefono2").get(0).value);
		 var observacion =Trim($("#observacion2").get(0).value);
		 var horaCita =Trim($('#horaCita').val());
		 var IdGrid= '#'+ horaCita+'d'+NumDias;
	 var RangoHora=IdGrid.substring(1,IdGrid.length-4);
	 respueta=$("#Guardado").val();
			 var datos_json="cedula="+ encodeURIComponent(cedula)+"&"+
			"nombre="+ encodeURIComponent(nombre)+"&"+
			 "apellido="+encodeURIComponent(apellido)+"&"+
			"email="+ encodeURIComponent(email)+"&"+
			 "telefono="+ encodeURIComponent(telefono)+"&"+
		 	  "observacion="+encodeURIComponent(observacion) +"&"+
		 	   "fechaCita="+encodeURIComponent(fechaCita) +"&"+
			  "horaCita="+encodeURIComponent(horaCita) +"&"+
			  "estadoCita="+encodeURIComponent($("#estadoCita").val()) +"&"+
			  "IdGrid="+encodeURIComponent(IdGrid) +"&"+
			  "RangoHora="+encodeURIComponent(RangoHora) +"&"+
		 "respuesta="+ encodeURIComponent(respueta)+"&nocache=" + Math.random();
		 //alert($("#estadoCita").val())
		carga_insert(datos_json,respuestaNuevaCita1);
			
			
			}
				
				 
				 
				 }
	
	
function llenaCita(){
	var respuesta_json = this.req.responseText;
	//alert (respuesta_json);
		var objeto_json = eval('('+respuesta_json+')');
				nFila=0;
				var num_filas = objeto_json.filas;
				var texto;
if (num_filas>0){
	texto="";
	$("#nombre2").css('display', 'none');
		$("#apellido2").css('display', 'none');
		$("#email2").css('display', 'none');
		 $("#telefono2").css('display', 'none');
	
			$("#nombre2").val(objeto_json.datos[nFila]['nombre']);
		$("#apellido2").val(objeto_json.datos[nFila]['apellido']);
		$("#email2").val(objeto_json.datos[nFila]['email']);
		 $("#telefono2").val(objeto_json.datos[nFila]['telefono']);
	
		 $("#nombreLb").html(objeto_json.datos[nFila]['nombre']);
		$("#apellidoLb").html(objeto_json.datos[nFila]['apellido']);
		$("#emailLb").html(objeto_json.datos[nFila]['email']);
		 $("#telefonoLb").html(objeto_json.datos[nFila]['telefono']);
				 
}else{
					
			texto=$("#cedula2").val();
				fecha=$("#fechaCita").val();
				hora=$("#horaCita").val();
					$(".citas").each(function(){
								$(this).val("");				  
								$(this).html(""); });
					auxiliar=$("#estadoCita").val()
					$("#estadoCita").val(auxiliar);
					$("#Guardado").val("nuevaCita");
					$("#fechaCita").val(fecha);
				$("#horaCita").val(hora);	
			$("#cedula2").val(texto);
			texto="la cedula no se encuentra registrada, registro nuevo? click aqui";
					}
	$("#errorCedula2").html(texto);
	
	}
	
function asignaFechas(fecha)
{
		$(".flechaD").each(function(){
								$(this).html('');
										  });
	fechaCabecera=new Date(fecha);
	var NumDias=fechaCabecera.getDay()+1;
	
	$('#flechaD'+NumDias).html('<img src="imagenes/flecha_abierto.png"  height="8" />')
		//alert(fecha.getDay());
		milisegundos=parseInt(24*60*60*1000);
		var NumDias=fecha.getDay()
		var fechaInicial= new Date();
		var fechaFinal=new Date();
		var totalMilisegundos;
		var totalMilisegundosNeg;
var totalDia=parseInt(fecha.getTime());

		 switch(NumDias){
		
		
case  0:
		fechaInicial=fecha;
		totalMilisegundos=(milisegundos*6 )+totalDia;
		fechaFinal.setTime(totalMilisegundos)
	break;
		
				
case  6:
		fechaFinal=fecha;
		totalMilisegundos=totalDia-(milisegundos*6 );
		fechaInicial.setTime(totalMilisegundos)
		
		break;
		
default:
		totalMilisegundosNeg= totalDia -(milisegundos*NumDias);
		fechaInicial.setTime(totalMilisegundosNeg)
		numFinal=6-NumDias
		totalMilisegundos=(milisegundos*numFinal )+totalDia;
		fechaFinal.setTime(totalMilisegundos)
		break;
		


		 }
		
			 marcaFechaCab(fechaInicial,fechaFinal);
}


	function llenaEdicionProveedor(){
		//alert("estoy en keyup de cedulaEdicion")
	var respuesta_json = this.req.responseText;
	var objeto_json = eval('('+respuesta_json+')');
				nFila=0;
				var num_filas = objeto_json.filas;
				var texto;
if (num_filas>0){
	texto="";
	$("#razonSocialEdicion").css('display', 'none');
		$("#emailEdicion").css('display', 'none');
		 $("#telefonoEdicion").css('display', 'none');
				 $("#celularEdicion").css('display', 'none');
			   $("#cedulaEdicionLb").css('display', 'none');
			 
			$("#razonSocialEdicion").val(objeto_json.datos[nFila]['razonSocial']);
			$("#emailEdicion").val(objeto_json.datos[nFila]['email']);
		 $("#telefonoEdicion").val(objeto_json.datos[nFila]['telefono']);
		 $("#observacionEdicion").val(objeto_json.datos[nFila]['observaciones']);	
		  
			 $("#celularEdicion").val(objeto_json.datos[nFila]['telefonoCelular']);	
					 
		 $("#cedulaEdicionLb").html(objeto_json.datos[nFila]['idProveedor']);
		 $("#razonSocialEdicionLb").html(objeto_json.datos[nFila]['razonSocial']);
			$("#emailEdicionLb").html(objeto_json.datos[nFila]['email']);
		 $("#telefonoEdicionLb").html(objeto_json.datos[nFila]['telefono']);
			 $("#celularEdicionLb").html(objeto_json.datos[nFila]['telefonoCelular']);	
			 
			 
			 
}else{
					
			texto=$("#cedulaEdicion").val();
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
			$("#cedulaEdicion").val(texto);
			texto="la cedula no se encuentra registrada, registro nuevo? click aqui";
					}
	$("#errorCedulaEdicion").html(texto);
	
	}
	
	function llenaEdicion(){
		//alert("estoy en keyup de cedulaEdicion")
	var respuesta_json = this.req.responseText;
	//alert (respuesta_json);
		var objeto_json = eval('('+respuesta_json+')');
				nFila=0;
				var num_filas = objeto_json.filas;
				var texto;
if (num_filas>0){
	texto="";
	$("#nombreEdicion").css('display', 'none');
		$("#apellidoEdicion").css('display', 'none');
		$("#emailEdicion").css('display', 'none');
		 $("#telefonoEdicion").css('display', 'none');
		 $("#diferidoPorEdicion").css('display', 'none');
			 $("#celularEdicion").css('display', 'none');
			   $("#cedulaEdicionLb").css('display', 'none');
			 
			$("#nombreEdicion").val(objeto_json.datos[nFila]['nombre']);
		$("#apellidoEdicion").val(objeto_json.datos[nFila]['apellido']);
		$("#emailEdicion").val(objeto_json.datos[nFila]['email']);
		 $("#telefonoEdicion").val(objeto_json.datos[nFila]['telefono']);
		 $("#observacionEdicion").val(objeto_json.datos[nFila]['observaciones']);	
		  $("#diferidoPorEdicion").val(objeto_json.datos[nFila]['diferidoPor']);	
		 
			 $("#celularEdicion").val(objeto_json.datos[nFila]['telefonoCelular']);	
					 
		 $("#cedulaEdicionLb").html(objeto_json.datos[nFila]['idCliente']);
		 $("#nombreEdicionLb").html(objeto_json.datos[nFila]['nombre']);
		$("#apellidoEdicionLb").html(objeto_json.datos[nFila]['apellido']);
		$("#emailEdicionLb").html(objeto_json.datos[nFila]['email']);
		 $("#telefonoEdicionLb").html(objeto_json.datos[nFila]['telefono']);
			 $("#diferidoPorEdicionLb").html(objeto_json.datos[nFila]['diferidoPor']);	 
			 $("#celularEdicionLb").html(objeto_json.datos[nFila]['telefonoCelular']);	
			 
			 
			 
}else{
					
			texto=$("#cedulaEdicion").val();
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
			$("#cedulaEdicion").val(texto);
			texto="la cedula no se encuentra registrada, registro nuevo? click aqui";
					}
	$("#errorCedulaEdicion").html(texto);
	
	}
	
	function respuestaEdicionCitas(){
		var respuesta_json = this.req.responseText;
		//alert(respuesta_json)
		$('#pagEditCitas').dialog("close");
		
	if($("#posicion").val()==1){$("#Linktabs-1").trigger("click");}
	 if($("#posicion").val()==2){$("#Linktabs-2").trigger("click");}
		}
	
function respuestaEdicionPaciente(){
		var respuesta_json = this.req.responseText;
		//alert(respuesta_json)
		var numeroLetras = respuesta_json.length;
		//alert(numeroLetras);
	pat=/Duplicate entry/;
	if (numeroLetras==37)
	{	$('#pagEdicionPacientes').dialog("close");
		}
else{if(pat.test(respuesta_json)){
	 pat=/key 2/;
	if(pat.test(respuesta_json)){
		var texto="el e-mail ya esta registrado";
		$('#errorEmailEdicion').html(texto);
		$("#emailEdicion").keyup(function (){var texto="";
		$('#errorEmailEdicion').html(texto);
	
	});
		$("#emailEdicion").focus();
		
		}else{
			
			var texto="la Cedula ya esta registrada";
		$('#errorCedulaEdicion').html(texto);
			$("#cedulaEdicion").focus();	
		}
	}}		

	}
	
function generaKeydowms(idKeydowm,id){
	$(idKeydowm).keydown(function(tecla){
		var r=tecla.keyCode;
			if(r==13){if($(id))
					{$(id).focus();}
				
			}
	});	
}
function generaKeydowm(idKeydowm)
{//alert("llegue al keydowm")
i=0
	$(idKeydowm).each(function(){
							   
						idKey ="#"+$(idKeydowm).get(i).id
						   i++;
						if($(idKeydowm).get(i))
						{
							id="#"+$(idKeydowm).get(i).id}
						//else{alert("en el "+i)}
							   
		generaKeydowms(idKey,id)
	});
	
	}

function verificaCita(dateInicial,dateFinal){
	$("#dateInicial").val(dateInicial);
	$("#dateFinal").val(dateFinal);
		var dia=dateInicial.getDate()
			var mes=(dateInicial.getMonth()+1);
			var anio=dateInicial.getFullYear();
			var fecha1 =mes+"/"+dia+"/"+anio;
			dia=dateFinal.getDate()
			 mes=(dateFinal.getMonth()+1);
			 anio=dateFinal.getFullYear();
			var fecha2 =mes+"/"+dia+"/"+anio;
	//alert(fecha1+fecha2);
	//$query= "SELECT * FROM ".$tabla." WHERE  `".$columna."`   '".$fecha1."' AND  '".$fecha2."'; ";

	//2012-07-12
	var query="select * from agenda where `fecha` BETWEEN"
	var query2=" AND ";
	var query3=" BY `hora` DESC";
	var datos_json = "query="+ encodeURIComponent(query)+	
	"&query2="+ encodeURIComponent(query2)+	
		"&query3="+ encodeURIComponent(query3)+	
		"&dato1="+ encodeURIComponent(fecha1)+	
		"&dato2="+ encodeURIComponent(fecha2)+	
		"&respuesta="+ encodeURIComponent("buscarCitas")+	
		"&nocache=" + Math.random();
		carga_listar(datos_json,CargaCitasGrid,"php/listadoInventario.php")
	}	
	

	
function CargaCitasGrid(){
	
	var respuesta_json = this.req.responseText;
//alert(respuesta_json)	
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;

$(".CitasRegistradas").each(function(){$(this).html(""); });
for(r=1;r<=7;r++){
	
	seccionHora=30;
	hora=5;
cont=3;
for (i=0;i<51;i++){
cont++;
	if(i==22){cont=4}
	auxseccionHora=seccionHora.toString();
	if(cont==4){seccionHora=0
		hora++;
		auxseccionHora="00"
		cont=0;
		if(i==0){cont=2;
			seccionHora=30;auxseccionHora="30"}	
	if(i==22){cont=3}}

idfila='#'+hora.toString()+auxseccionHora+'d'+r
	$(idfila).css('background', '#fcfdfd');
	$(idfila).attr("title","")
seccionHora=seccionHora+15;
}
	
	
	
	
	
	
	}

if (num_filas>0){
	//alert(respuesta_json)	

for(iniGrid=0;iniGrid<num_filas;iniGrid++)
{
ubicacionGrid=objeto_json.datos[iniGrid]["ubicacionGrid"];	

estadoCita=objeto_json.datos[iniGrid]["estadoCita"];	
p= estadoCita.substring(1);
var tablaDivAux=p+"_TablaDiv";
var dato=objeto_json.datos[iniGrid]["nombrePaciente"];
if($('#tipoUsuario').val()=='2')
{	var cedula=objeto_json.datos[iniGrid]['IdCliente']
	if(cedula==$('#IdUsuario').val()){
		var dato=objeto_json.datos[iniGrid]["nombrePaciente"];}
		else{var dato="";}
}
else{}

var IdKeydowm;
descripcionCita=objeto_json.datos[iniGrid]["obsevaciones"];
idCitaVar=objeto_json.datos[iniGrid]["idCita"]
switch(estadoCita){
		case  "sin confirmacion":
		$(ubicacionGrid).css('background', '#FAAC36');
			IdKeydowm=ubicacionGrid.substring(1)+"_TablaDiv";
			$(ubicacionGrid+"_TablaDiv").html(dato+'<input type="hidden" id="'+IdKeydowm+'_hidden"  />');
	IdKeydowm='#'+IdKeydowm;
			break;
			
		case  "confirmada":
		$(ubicacionGrid).css('background', '#2F7ED7');
		IdKeydowm=ubicacionGrid.substring(1)+"_TablaDiv";
		$(ubicacionGrid+"_TablaDiv").html(dato);
		$(ubicacionGrid+"_indexDiv").html('<input type="hidden" id="'+IdKeydowm+'_hidden"  />')
		IdKeydowm='#'+IdKeydowm;
		
		break;
		case  "cancelada":
		
		var idCita=objeto_json.datos[iniGrid]["idCita"];
		IdKeydowm=idCita+"Cancelado";
		textAuxiliar='<span id="'+IdKeydowm+'">'+dato+'<br /></span><input type="hidden" id="'+IdKeydowm+'_hidden"  />'
		$("#"+ubicacionGrid.substring(ubicacionGrid.indexOf("d"))+"Cancelado").append(textAuxiliar);
		IdKeydowm="#"+idCita+"Cancelado";
		$(IdKeydowm).css('color', '#ffffff');
		break;
		case "asistido":
		//color==#5c9ccc
		IdKeydowm=ubicacionGrid.substring(1)+"_TablaDiv";
		$(ubicacionGrid).css('background', '#5c9ccc');
		$(ubicacionGrid+"_TablaDiv").html(dato+'<input type="hidden" id="'+IdKeydowm+'_hidden"  />');
	IdKeydowm='#'+IdKeydowm;
		break;
		case "no asistido":
		
		break;
		case  "diferido":
		var idCita=objeto_json.datos[iniGrid]["idCita"];
		IdKeydowm=idCita+"diferido";
		textAuxiliar='<span id="'+IdKeydowm+'">'+dato+'<br /></span><input type="hidden" id="'+IdKeydowm+'_hidden"  />'
		$("#"+ubicacionGrid.substring(ubicacionGrid.indexOf("d"))+"diferido").append(textAuxiliar);
		IdKeydowm="#"+idCita+"diferido";
		$(IdKeydowm).css('color', '#ffffff');
		break;}
		$(IdKeydowm+'_hidden').val(idCitaVar);
		//alert($(IdKeydowm+'_hidden').val()+" y el valor es  "+idCitaVar)
		$(IdKeydowm).attr("title",descripcionCita)

$(IdKeydowm).tipsy({gravity: 'w',opacity: 1});

$(IdKeydowm).click(function(){
							$("#idCita").val($("#"+$(this).get(0).id+'_hidden').val())
							titulo="Registro 00"+$("#idCita").val()
							$("#pagEditCitas").dialog({title:titulo});
							$("#pagEditCitas").dialog('open')
							
							});
	
}}}


function buscarProcedimiento(dato,funcion){
	if (Trim(dato)!=""){/*
		var query="select * from historialprocedimientos where `idPaciente`= "+dato+" ";
	var datos_json = "query=" + encodeURIComponent(query)+		
		"&nocache=" + Math.random();
	//alert (datos_json);*/
		var datosAjax = {
		tabla: 'historialprocedimientos',
		inicio: '',
		where:true,
		igual:true,
		columna1:'idPaciente',
		dato:dato,
		datosRequeridos:''
		/*
		proced : 'GET_PRODUC_BARCODE',
		datosProce:[valorEnviar]*/
		};
		carga_listar(datosAjax,funcion);	}}
		
		
function buscarPaciente(dato,funcion){
	if (Trim(dato)!=""){
	 
			var datosAjax = {
		tabla: 'pacientes',
		inicio: '',
		where:true,
		igual:true,
		columna1:'idCliente',
		dato:dato,
		datosRequeridos:''
		/*
		proced : 'GET_PRODUC_BARCODE',
		datosProce:[valorEnviar]*/
		};
		carga_listar(datosAjax,funcion);	}}
		
		function buscarCitas(dato,funcion){
	if (Trim(dato)!=""){
		var datosAjax = {
		tabla: 'agenda',
		inicio: '',
		where:true,
		igual:true,
		columna1:'idCliente',
		dato:dato,
		datosRequeridos:''
		/*
		proced : 'GET_PRODUC_BARCODE',
		datosProce:[valorEnviar]*/
		};
		carga_listar(datosAjax,funcion);	}}
		
		function buscarHistoria(dato,funcion){
	if (Trim(dato)!=""){
		var datosAjax = {
		tabla: 'historiaclinica',
		inicio: '',
		where:true,
		igual:true,
		columna1:'idPaciente',
		dato:dato,
		datosRequeridos:''
		/*
		proced : 'GET_PRODUC_BARCODE',
		datosProce:[valorEnviar]*/
		};
		carga_listar(datosAjax,funcion);	}}
		
		
		function buscarCartera(dato,funcion){
	if (Trim(dato)!=""){
	 
inicioListar('cartera',funcion,null,null,'idCuenta',true,dato,null,null,'sL')

		}}
		
		function buscarCredito(dato,funcion){
		if (Trim(dato)!=""){ 
		
inicioListar('credito',funcion,null,null,'idCuenta',true,dato,null,null,'sL')
		 	}}
		
function llenaDatosPaciente(){
	/*"Identificacion" "Direccion" "Telefono" "Ciudad" "fechaNacimiento""Edad""Sexo""EstadoCivil""Ocupacion"
	$("#nombre").html(objeto_json.datos[0]['IdCliente']);
	*/ 
	
	}
	
	function llenaDatosHistoria(){
	var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
	dato1=objeto_json.datos[0]['descAnamnesis']
	dato2=objeto_json.datos[0]['descExaFisEstomat']
	dato3=objeto_json.datos[0]['descExaDental']
	if(Trim(dato1)==""){if($('#tipoUsuario').val()=='1'){
		dato1="<div  id='cuepito1'>no se ha llenado la descripcion, para llenar haga click <span id='editarDatoH1' class='nuevolink'>aqui</span></div>"}else{dato1="<div  id='cuepito1'>no se ha llenado la descripcion </div>"}}
if(Trim(dato3)==""){if($('#tipoUsuario').val()=='1'){
		dato3="<div  id='cuepito3'>no se ha llenado la descripcion, para llenar haga click <span id='editarDatoH3' class='nuevolink'>aqui</span></div>"}else{dato3="<div  id='cuepito3'>no se ha llenado la descripcion </div>"}}
		
if(Trim(dato2)==""){if($('#tipoUsuario').val()=='1'){
		dato2="<div  id='cuepito2'>no se ha llenado la descripcion, para llenar haga click <span id='editarDatoH2' class='nuevolink'>aqui</span></div>"}else{dato2="<div  id='cuepito2'>no se ha llenado la descripcion </div>"}}
		
		var texto="<h3>Anamnesis</h3><div width='100%' id='divAnamnesis'>"+dato1+"<div align='center' id='AuxEdit1'><br /><textarea id='textAreaAnamnesis' cols='40'></textarea> <br /><input type='button' id='editarAnamnesis' value='aceptar' /><input type='button' id='CancelAnamnesis' value='cancelar' /></div></div><h3>Examen Fisico Estomatologico</h3><div  id='divExaFisEstomat' width='100%'>"+dato2+" <div align='center' id='AuxEdit2'><br /><textarea id='textAreaExaFisEstomat' cols='40'></textarea> <br /><input type='button' id='editarExaFisEstomat' value='aceptar' /><input type='button' id='CancelExaFisEstomat' value='cancelar' /></div> </div><h3>Examen Dental</h3><div  id='divExaDental' width='100%'>"+dato3+"<div align='center' id='AuxEdit3'><br /><textarea id='textAreaExaDental' cols='40'></textarea> <br /><input type='button' id='editarExaDental' value='aceptar' /><input type='button' id='CancelExaDental' value='cancelar' /></div></div><br/>";
	$('#historia').html(texto);
	$("#AuxEdit2").css('display', 'none');
	
		$("#AuxEdit1").css('display', 'none');
	
		$("#AuxEdit3").css('display', 'none');
	
	$("#editarAnamnesis").click(function (){ if(Trim($("#textAreaAnamnesis").val())!="")
											  {observacion =$("#textAreaAnamnesis").val()
												 cedula=$("#Identificacion").html()
												 var datos_json="cedula="+ encodeURIComponent(cedula)+"&"+
												 "columnaEditar="+ encodeURIComponent("descAnamnesis")+"&"+
												 "observacion="+encodeURIComponent(observacion) +"&"+
												 "columna="+encodeURIComponent("idPaciente") +"&"+
												 "tabla="+encodeURIComponent("historiaclinica") +"&"+
												 "respuesta="+ encodeURIComponent("edicionHistoria_1")+"&nocache=" + Math.random();
				carga_borrarUpdate(datos_json,respuestaEdicionHistoria_1);
				}
											  
											   });
	$("#CancelAnamnesis").click(function (){ $("#AuxEdit1").css('display', 'none');	
	$("#cuepito1").css('display','inline');		
	$("#textAreaAnamnesis").val("");});
	$("#editarExaFisEstomat").click(function (){
											  
											  if(Trim($("#textAreaExaFisEstomat").val())!="")
											  {//descExaFisEstomat
												  observacion =$("#textAreaExaFisEstomat").val()
												 cedula=$("#Identificacion").html()
												 var datos_json="cedula="+ encodeURIComponent(cedula)+"&"+
												 "columnaEditar="+ encodeURIComponent("descExaFisEstomat")+"&"+
												 "observacion="+encodeURIComponent(observacion) +"&"+
												 "columna="+encodeURIComponent("idPaciente") +"&"+
												 "tabla="+encodeURIComponent("historiaclinica") +"&"+
												 "respuesta="+ encodeURIComponent("edicionHistoria_1")+"&nocache=" + Math.random();
				carga_borrarUpdate(datos_json,respuestaEdicionHistoria_1);
												   
												  }
											  
											  });
	$("#CancelExaFisEstomat").click(function (){ $("#AuxEdit2").css('display', 'none');	
																	$("#cuepito2").css('display','inline');		
																	$("#textAreaExaFisEstomat").val("");});
	$("#editarExaDental").click(function (){ 
											  
											  if(Trim($("#textAreaExaDental").val())!="")
											  {//descExaDental
												   observacion =$("#textAreaExaDental").val()
												  cedula=$("#Identificacion").html()
												 var datos_json="cedula="+ encodeURIComponent(cedula)+"&"+
												 "columnaEditar="+ encodeURIComponent("descExaDental")+"&"+
												 "observacion="+encodeURIComponent(observacion) +"&"+
												 "columna="+encodeURIComponent("idPaciente") +"&"+
												 "tabla="+encodeURIComponent("historiaclinica") +"&"+
												 "respuesta="+ encodeURIComponent("edicionHistoria_1")+"&nocache=" + Math.random();
				carga_borrarUpdate(datos_json,respuestaEdicionHistoria_1);
												  }
											  
											  });
	$("#CancelExaDental").click(function (){
								$("#AuxEdit3").css('display', 'none');
								$("#cuepito3").css('display','inline');		  
								$("#textAreaExaDental").val("");});
	
	$("#editarDatoH1").click(function (){
								$("#AuxEdit1").css('display', 'inline');
								$("#cuepito1").css('display', 'none');	
									   });
	
	$("#editarDatoH2").click(function (){
						$("#AuxEdit2").css('display', 'inline');
						$("#cuepito2").css('display', 'none');			
		   });
	
	
	
	$("#editarDatoH3").click(function (){
					$("#AuxEdit3").css('display', 'inline');
					$("#cuepito3").css('display', 'none');			
		   				  	
	  });
/*<div align='justify' id='div'>
<textarea id="textArea" cols="100"></textarea> <br /><input type="button" id="editar" value="aceptar" /><input type="button" id="Cancel" value="cancelar" /></div>*/
}
	}
	
	
	function llenaDatosCitas(){
	var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){var texto="";
	var encabezados = ['idCita','fecha','hora','estadoCita','obsevaciones'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalCita','tablasListaCitas','indiceListaCitas','listarTablaCitas',0,15,"idCita","pagCitas",false,false,false,false);
}else {limpia_linea('tablasListaProc','indiceListaCitas');
	texto="no existe ningun cita hasta la fecha";
	$('#tablasListaProc').html(texto);
	}
	}
	
	
	function llenaDatosProce(){
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");

var num_filas = objeto_json.filas;
if (num_filas>0){
	var encabezados = ['codProc','fecha','codCita','procedimiento'];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normaProc','tablasListaProc','indiceListaProc','listarTablaProc',0,15,"codProc","pagProc",false,false,false,false);
}else {limpia_linea('tablasListaProc','indiceListaCitas');
	texto="no existe ningun procedimiento hasta la fecha";
	$('#tablasListaProc').html(texto);
	}
	
	}
	
	
	
	
function llenaEditarCita(){
	
	var respuesta_json = this.req.responseText;
	//alert (respuesta_json);
		var objeto_json = eval('('+respuesta_json+')');
				nFila=0;
				var num_filas = objeto_json.filas;
				var texto;
if (num_filas>0){
	texto="";
	
	
	$("#LbEditCedula").html(objeto_json.datos[nFila]['IdCliente']);
   $("#LbEditfechaCita").html(objeto_json.datos[nFila]['fecha']); 
	$("#LbEditnombre").html(objeto_json.datos[nFila]['nombrePaciente']);
 	 $("#LbEdittelefono").html(objeto_json.datos[nFila]['telefono']);		
	  $("#EdithoraCita").val(objeto_json.datos[nFila]['hora']);
	$("#estadoCitaEdit").val(objeto_json.datos[nFila]['estadoCita']);
	$("#observacionEditLb").val(objeto_json.datos[nFila]['obsevaciones']);
		
		$("#rangoHora").val(objeto_json.datos[nFila]['rangoCita']);
			$("#pocisionGrid").val(objeto_json.datos[nFila]['ubicacionGrid']);	
			$("#EdithoraCitaAxu").val(objeto_json.datos[nFila]['hora']);
			$("#estadoCitaEditAux").val(objeto_json.datos[nFila]['estadoCita']);
}
	}
	
	
	
	
	
function list_res_Diferidos(){//evalua la respuesta recibida para listar los colores
var texto="";
	var respuesta_json = this.req.responseText;
//alert(respuesta_json)
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
	
var encabezados =['nombrePaciente','hora','telefono','estadoCita','idCita' ];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalDiferidos','DiferidostablasLista','DiferidosindiceLista','listarTablaDiferidos',0,13,false,false,false,false,cambiaDiferido,false,false,false,'idCita');

}else {limpia_linea('DiferidostablasLista','DiferidosindiceLista');
	var texto="no tiene registrada ningun diferido para esta fecha";
	}$('#noDiferidosHoy').html(texto);
	}	
	
function cambiaDiferido(){
	//alert(this.datoProcesar+	$("#rangoHora").val()+	$("#pocisionGrid").val()	+$("#EdithoraCitaAxu").val()+	$("#estadoCitaEditAux").val())
	
	var datos_json="idCita="+ encodeURIComponent(this.datoProcesar)+"&"+
						"rangoHora="+encodeURIComponent($("#rangoHora").val()) +"&"+
			  "pocisionGrid="+encodeURIComponent($("#pocisionGrid").val()) +"&"+
			    "horaCita="+encodeURIComponent($("#EdithoraCitaAxu").val()) +"&"+
			    "estadoCita="+encodeURIComponent($("#estadoCitaEditAux").val()) +"&"+
			 "columna="+encodeURIComponent("idCita") +"&"+
			    "tabla="+encodeURIComponent("agenda") +"&"+
		 "respuesta="+ encodeURIComponent("CambioDiferido")+"&nocache=" + Math.random();
			
			
			carga_borrarUpdate(datos_json,respuestacambiaDiferido)
	
	}	
	
function respuestacambiaDiferido(){
	if($("#posicion").val()==1){$("#Linktabs-1").trigger("click");}
	 if($("#posicion").val()==2){$("#Linktabs-2").trigger("click");}
	 
	}
	
function atencionPacientes(){//alert("estoy en atencionPacientes y el dato es "+this.datoProcesar)
//'SELECT * FROM `agenda` WHERE `idCita` = '+ this.datoProcesar
var datos_json="query="+ encodeURIComponent('SELECT * FROM `agenda` WHERE `idCita` = '+this.datoProcesar)+"&"+
				"&nocache=" + Math.random();
					carga_listar(datos_json,RespuestaAtencionPacientes)

}

function eliminaCita(){
var datos_json="dato="+ encodeURIComponent(this.datoProcesar)+"&"+
			 "columna="+encodeURIComponent("idCita") +"&"+
			    "tabla="+encodeURIComponent("agenda") +"&"+
		 "respuesta="+ encodeURIComponent("EliminaCita")+"&nocache=" + Math.random();
		 
		 jConfirm("esta a punto de eliminar completamente una cita \ndespues de esta operacion sera imposible recuperar estos datos, desea continuar?  ", "Eliminacion cita", function(r) {
			if(r) {
				carga_borrarUpdate(datos_json,respuestaEliminaCita)
			}} );
					


}
function editarCita(){//alert("estoy en editarCita y el dato es "+this.datoProcesar)

$("#idCita").val(this.datoProcesar)
							titulo="Registro 00"+$("#idCita").val()
							$("#pagEditCitas").dialog({title:titulo});
							$("#pagEditCitas").dialog('open')

}

function RespuestaAtencionPacientes(){
	var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
//alert(respuesta_json)
var num_filas = objeto_json.filas;
if (num_filas>0){
	$("#CitaProcedimiento").html(objeto_json.datos[0]['idCita']);
	
		 $("#PacienteCedulaProc").html(objeto_json.datos[0]['IdCliente']);
		 
		$("#Procnombre").html(objeto_json.datos[0]['nombrePaciente']);
		
		$("#fechaCitaProc").html(objeto_json.datos[0]['fecha']);
			$('#pagProcedimiento').dialog('open');
	}
	}

function respuestaEliminaCita(){
	var respuesta_json = this.req.responseText;
	var objeto_json = eval("("+respuesta_json+")");
	$("#Linktabs-1").trigger("click");
	var num_filas = objeto_json.Alert;
	jAlert(num_filas)
	}
	
function respuestaNewProc(){
	var respuesta_json = this.req.responseText;
	
	jAlert(respuesta_json);
	$("#Linktabs-1").trigger("click");
	$('#pagProcedimiento').dialog('close')
	}
	
	function respuestaEdicionHistoria_1(){
		var respuesta_json = this.req.responseText;
	//	jAlert(respuesta_json)
	$("#Linktabs-2").trigger("click");
		}



function CargaCookieCartera(){
	$.cookie('cuentaId',this.datoProcesar)
	window.location.replace("estadoCuenta.php");
		}	
  
function CargaCookieCredito(){
	$.cookie('cuentaId',this.datoProcesar)
	window.location.replace("estadoCredito.php");
		}	
		
function CargaPagCredito(){
	$("#datoHidden").val(this.datoProcesar);
	$("#pagina_inicial").val('nuevoCredito.php')
	$("#enviar").trigger('click');
		}
function CargaPagCartera(){//llama la pagina estadoCuenta.php
	$("#datoHidden").val(this.datoProcesar);
	$("#pagina_inicial").val('nuevaCuenta.php')
	$("#enviar").trigger('click');
		}		
