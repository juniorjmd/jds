$(document).ready(function(){

$('#cuerpoCartera').tabs();
$('#Linktabs-1').click(function(){
	    //carga_listar(datosAjax,list_res_Cartera);
		//inicioListar(tabla,funcion,php,ordenar,columna,igual,dato,columna2,columna3,nomAplicacion)
		 inicioListar('cartera',list_res_Cartera,null,'idCartera',null,null,null,null,null,'Cartera')
								});

$('#Linktabs-1').trigger('click');
$('#Linktabs-2').click(function(){
    var query="SELECT * FROM `cartera` ORDER BY `cartera`.`idCartera` ASC";
    var dateText=new Date();
var dia=dateText.getDate()
var mes=(dateText.getMonth()+1);
var anio=dateText.getFullYear();
var fecha =mes+"/"+dia+"/"+anio;
	$("#dataLabel").html(fecha) 
	var datos_json = "tabla=" + encodeURIComponent('cartera')+
	"&orden=" + encodeURIComponent('idCartera')		+
	"&respuesta=" + encodeURIComponent('cartera')		+
		"&nocache=" + Math.random();
		carga_crear_id(datos_json,llenaCarteraId);
$('#cancelarCartera').trigger('click');
									});

$("#valCartera").keyup(function (){
	dato=$(this).val()
	if (Trim(dato)!=""){
		if(isNaN(dato)){
				jAlert('el valor debe ser un numero');
				$("#valCartera").focus();
				$("#valCartera").val("");
				return
				}
				var abono=$("#abonoInicial").val()
				if(Trim(abono)==""){
					abono=0;
					}
					valorTotal=dato-abono;
					numeroCuotas=$("#numeroCuotas").val()
					if(Trim(numeroCuotas)==""){
						numeroCuotas=1;
						}
						valorCuotas=valorTotal/numeroCuotas
				
				$("#totalDeuda").html(valorTotal)
				$("#valCuota").html(valorCuotas.toFixed(2))
				}else{$("#totalDeuda").html(0)
				$("#valCuota").html(0)}
	
	});
$("#abonoInicial").keyup(function (){
	dato=$(this).val()
	if (Trim(dato)!=""){
		
		if(isNaN(dato)){
				jAlert('el valor debe ser un numero');
				$("#abonoInicial").val("")
				$("#abonoInicial").focus();
				return
				}else{
					VALOR_INI=parseInt(Trim($("#valCartera").val()))
					if(parseInt(dato)>VALOR_INI){
						jAlert("el abono inicial no puede ser mayor al valor del credito");
						$("#abonoInicial").focus();
						$("#abonoInicial").val(0);
						return
						}
					}
	}else{dato=0;}
			
	total=Trim($("#valCartera").val());
	if(total==""){valorTotal=valorCuotas=0}
	else{
		valorTotal=total-dato;
		cuotas=Trim($("#numeroCuotas").val())
		if(cuotas==""){	cuotas=1}
		valorCuotas=valorTotal/cuotas;
		}
	$("#totalDeuda").html(valorTotal)
				$("#valCuota").html(valorCuotas.toFixed(2))
				});
$("#numeroCuotas").keyup(function (){
	dato=$(this).val()
	if (Trim(dato)!=""){
		if(isNaN(dato)){
				jAlert('el valor debe ser un numero');
				$("#numeroCuotas").val("1");
				$("#numeroCuotas").focus();
				return
				}
			if(dato==0){jAlert('el valor debe ser un numero mayor a 0');
				$("#numeroCuotas").focus();
				return}
			}else{dato=1;}
			total=$("#valCartera").val();
			if(Trim(total)==""){valorTotal=valorCuotas=0}
			else{
				abono=$("#abonoInicial").val();
				if(Trim(abono)==""){abono=0;}
				valorTotal=total-abono;
				valorCuotas=valorTotal/dato
				}
				$("#totalDeuda").html(valorTotal)
				$("#valCuota").html(valorCuotas.toFixed(2))
	
	});
$("#abonoInicial").focus(function (){
	var dato=$("#valCartera").val();
	if (isNaN(dato)){
		$("#valCartera").val("");
		$("#valCartera").focus();
	}});
	
$("#numeroCuotas").focus(function (){
	var dato=$("#valCartera").val();
	if (isNaN(dato)){
		$("#valCartera").val("");
		$("#valCartera").focus()
	}
	
	});
  
$("input[id='busquedaPacienteRegistrado']").keyup(function (){
			var php = null;											
	var dato=$(this).val();
	if (Trim(dato)!=""){//"'%".$dato."%'"

		inicioListar('clientes',list_res_pacientes_2,php,null,'nombre',null,dato,'idCliente','apellido','Paciente');	
		
		
		}else{
			limpia_linea('tablasListaPaciente','indiceListaPaciente');
			llenaBusqueda()
			$(this).focus();}
	
	
	});

llenaBusquedaProveedor()
$("input[id='busquedaProveedorRegistrado']").keyup(function (){
	  var dato=$(this).val();
	if (Trim(dato)!=""){//"'%".$dato."%'"
inicioListar('proveedor',function (){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
	var encabezados =['idProveedor','razonSocial' ,'telefono','email'  ];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewProv','tablasListaProveedor','indiceListaProveedor','listarTablaProveedor',0,15,"codigoProveedor",false,false,false,false,false);
}else {limpia_linea('tablasListaProveedor','indiceListaProveedor');
	var texto="encuentra registrado ningun Proveedor en la base de datos";
		$('#tablasListaProveedor').html(texto);
	}
	},php,ordenar,'razonSocial',igual,dato,'idProveedor',columna3,'Proveedor')
	
	
	}else{
			limpia_linea('tablasListaProveedor','indiceListaProveedor');
	llenaBusquedaProveedor()
			$(this).focus();}
	});
$('#buscaProveedor').click(function(){llenaBusqueda()
									$.colorbox({overlayClose:false, inline:true, href:"#busquedaProveedor",width:"90%", height:"50%"});
								});

$('#buscaCliente').click(function(){
    llenaBusqueda()
    $.colorbox({overlayClose:false, inline:true, href:"#busquedaCliente",width:"90%", height:"50%"});
								});

$('#guardarCartera').click(function(){
			 var valCuota=Trim($('#valCuota').html())	
		 var totalDeuda=Trim($('#totalDeuda').html())
		   var codigoCliente=Trim($('#codigoCliente').val())
		 	var nombreYapellido=Trim($('#nombreYapellido').html())
		  var carteraDescripcion=Trim($('#carteraDescripcion').val())
		  var valCartera=Trim($('#valCartera').val())
		 var abonoInicial=Trim($('#abonoInicial').val())
		 var numeroCuotas=Trim($('#numeroCuotas').val())
		 var intervalos=Trim($('#intervalos').val())
			if(codigoCliente==""||Trim($("#errorCedula2").html()) !=""){$("#codigoCliente").focus();
			return;}
			
				if( valCartera==0){$("#valCartera").focus();
			return;}else{if(isNaN(valCartera)){
				jAlert('el valor de la cartera debe ser un numero');
				$("#valCartera").focus();
				return
				}}
				if(abonoInicial==""){abonoInicial=0;}else{if(isNaN(abonoInicial)){
				jAlert('el valor del abono debe ser un numero');
				$("#abonoInicial").focus();
				return
				}}
				if(numeroCuotas==""){numeroCuotas=1}else{if(isNaN(numeroCuotas)){
				jAlert('el valor del Numero Cuotas debe ser un numero');
				$("#numeroCuotas").focus();
				return
				}}
				if(intervalos==""){
			intervalos=1;
			}
			if(parseInt(abonoInicial)>parseInt(valCartera)){
				jAlert("el abono inicial no puede ser mayor al valor del credito");
				$("#abonoInicial").val(0)
				$("#abonoInicial").focus();
				return
			}
			
		 var datos_json= "labeIDcartera="+ encodeURIComponent(Trim($('#labeIDcartera').html()))+"&"+	
		  "dataLabel="+ encodeURIComponent(Trim($('#dataLabel').html())	)+"&"+
		   "codigoCliente="+ encodeURIComponent(Trim($('#codigoCliente').val()))+"&"+
		 	 "nombreYapellido="+ encodeURIComponent(Trim($('#nombreYapellido').html()))+"&"+	
		   "carteraDescripcion="+ encodeURIComponent(Trim($('#carteraDescripcion').val()))+"&"+
		  "valCartera="+ encodeURIComponent(Trim($('#valCartera').val()))+"&"+
		 "abonoInicial="+ encodeURIComponent(abonoInicial)+"&"+
		 "numeroCuotas="+ encodeURIComponent(numeroCuotas)+"&"+
		 "intervalos="+ encodeURIComponent(intervalos)+"&"+
		 "valCuota="+ encodeURIComponent(Trim($('#valCuota').html()))+"&"+	
		 "totalDeuda="+ encodeURIComponent(Trim($('#totalDeuda').html()))+"&"+	
		 	 "respuesta="+ encodeURIComponent("nuevaCartera")+"&nocache=" + Math.random();
			carga_insert(datos_json,respuestaNuevaCartera);	
									
								});


 
 	

$("#codigoProveedor").keydown(function(tecla){
		var r=tecla.keyCode;
			if(r==112){if($(id))
					{$('#buscaProveedor').trigger('click');}
				
			}
	});	
$('#cancelarCartera').click(function(){
	 $(".NewCartera").each(function(){
		$(this).val(" "); 
	});
		$("#valCartera").val(0);
	$("#numeroCuotas").val("1")
	$(".NewCarteralb").each(function(){
	$(this).html(" "); 
	});
});

$('#cancelarCredito').click(function(){ 
	$(".NewCredito").each(function(){$(this).val(" "); });
	$("#numeroCuotasCredito").val("1")
	$(".Newcreditolb").each(function(){	$(this).html(" ");});
	$("#valCredito").val(0);
});



$("#valCredito").keyup(function (){
	dato=$(this).val()
	if (Trim(dato)!=""){
		if(isNaN(dato)){
				jAlert('el valor debe ser un numero');
				$("#valCredito").val("");
				$("#valCredito").focus();
				return
				}
				var abono=$("#abonoInicialCredito").val()
				if(Trim(abono)==""){
					abono=0;
					}
					valorTotal=dato-abono;
					numeroCuotas=$("#numeroCuotasCredito").val()
					if(Trim(numeroCuotas)==""){
						numeroCuotas=1;
						}
						valorCuotas=valorTotal/numeroCuotas
				
				$("#totalDeudaCredito").html(valorTotal.toFixed(2))
				$("#valCuotaCredito").html(valorCuotas.toFixed(2))
				}else{$("#totalDeudaCredito").html(0)
				$("#valCuotaCredito").html(0)}
	});

$("#abonoInicialCredito").keyup(function (){
	dato=$(this).val()
	if (Trim(dato)!=""){
		if(isNaN(dato)){
				jAlert('el valor debe ser un numero');
				$("#abonoInicialCredito").val("");
				$("#abonoInicialCredito").focus();
				return
				}else{
					VALOR_INI=parseInt(Trim($("#valCredito").val()))
					if(parseInt(dato)>VALOR_INI){
						jAlert("el abono inicial no puede ser mayor al valor del credito");
						$("#abonoInicialCredito").val(0);
						$("#abonoInicialCredito").focus();
						return
						}
					}
				}else{dato=0;}
			total=Trim($("#valCredito").val());
			if(total==""){valorTotal=valorCuotas=0}
			else{
				valorTotal=total-dato;
				cuotas=Trim($("#numeroCuotasCredito").val())
				if(cuotas==""){
					cuotas=1
					}
					valorCuotas=valorTotal/cuotas;
				}
	$("#totalDeudaCredito").html(valorTotal.toFixed(2))
	$("#valCuotaCredito").html(valorCuotas.toFixed(2))
});

$("#numeroCuotasCredito").keyup(function (){
	dato=$(this).val()
	//alert(dato)
	if (Trim(dato)!=""){
		if(isNaN(dato)){
				jAlert('el valor debe ser un numero');
				$("#numeroCuotasCredito").val("1");
				$("#numeroCuotasCredito").focus();
				return
				}
			if(dato==0){jAlert('el valor debe ser un numero mayor a 0');
				$("#numeroCuotasCredito").focus();
				return}
			}else{dato=1;}
			total=$("#valCredito").val();
			if(Trim(total)==""){valorTotal=valorCuotas=0}
			else{
				abono=$("#abonoInicialCredito").val();
				if(Trim(abono)==""){abono=0;}
				valorTotal=total-abono;
				valorCuotas=valorTotal/dato
				}
			//	alert("estoy en cero "+dato+" "+valorTotal+" "+valorCuotas)
				$("#totalDeudaCredito").html(valorTotal.toFixed(2))
				$("#valCuotaCredito").html(valorCuotas.toFixed(2))
	});

$("#abonoInicialCredito").focus(function (){
	var dato=$("#valCredito").val();
	if (isNaN(dato)){
		$("#valCredito").focus()
	$("#valCredito").val("")
	}});
	
$("#numeroCuotasCredito").focus(function (){
	var dato=$("#valCredito").val();
	if (isNaN(dato)){
		$("#valCredito").val("")
	$("#valCredito").focus()
	}});

$('#guardarCredito').click(function(){
	var valCuota=Trim($('#valCuotaCredito').html())	
	var totalDeuda=Trim($('#totalDeudaCredito').html())
	var codigoCliente=Trim($('#codigoProveedor').val())
	var razonSocial=Trim($('#razonSocial').html())
	var carteraDescripcion=Trim($('#DescripcionCredito').val())
	var valCartera=Trim($('#valCredito').val())
	var abonoInicial=Trim($('#abonoInicialCredito').val())
	var numeroCuotas=Trim($('#numeroCuotasCredito').val())
	var intervalos=Trim($('#intervalosCredito').val())
	if(codigoCliente==""|| Trim($("#errorProveedor").html())!=""){$("#codigoProveedor").focus();
			return;}
			if( valCartera==0){$("#valCredito").focus();
			return;}else{if(isNaN(valCartera)){
				jAlert('el valor del credito debe ser un numero');
				$("#valCartera").focus();
				return
				}}
				if(abonoInicial==""){abonoInicial=0;}else{if(isNaN(abonoInicial)){
				jAlert('el valor del abono debe ser un numero');
				$("#abonoInicialCredito").focus();
				return
				}}
				if(numeroCuotas==""){numeroCuotas=1}else{if(isNaN(numeroCuotas)){
				jAlert('el valor del Numero Cuotas debe ser un numero');
				$("#numeroCuotasCredito").focus();
				return
				}}
				if(intervalos==""){
			intervalos=1;
			}
	if(parseInt(abonoInicial)>parseInt(valCartera)){
		jAlert("el abono inicial no puede ser mayor al valor del credito");
		 $("#abonoInicialCredito").val(0);
		 $("#abonoInicialCredito").focus();
		 return
		 }
					
		 var datos_json= "labeIDcartera="+ encodeURIComponent(Trim($('#labeIDcredito').html()))+"&"+	
		  "dataLabel="+ encodeURIComponent(Trim($('#dataLabel2').html())	)+"&"+
		   "codigoProveedor="+ encodeURIComponent(Trim($('#codigoProveedor').val()))+"&"+
		 	 "razonSocial="+ encodeURIComponent(Trim($('#razonSociallb').html()))+"&"+	
		   "DescripcionCredito="+ encodeURIComponent(Trim($('#DescripcionCredito').val()))+"&"+
		  "valCredito="+ encodeURIComponent(Trim($('#valCredito').val()))+"&"+
		 "abonoInicialCredito="+ encodeURIComponent(abonoInicial)+"&"+
		 "numeroCuotasCredito="+ encodeURIComponent(numeroCuotas)+"&"+
		 "intervalosCredito="+ encodeURIComponent(intervalos)+"&"+
		 "valCuotaCredito="+ encodeURIComponent(valCuota)+"&"+	
		 "totalDeudaCredito="+ encodeURIComponent(totalDeuda)+"&"+	
		 	 "respuesta="+ encodeURIComponent("nuevaCredito")+"&nocache=" + Math.random();
			carga_insert(datos_json,respuestaNuevaCredito);	
			});
});

function llenaCarteraId(){
	var respuesta_json = this.req.responseText;
	$("#labeIDcartera").html(respuesta_json);
		}
		
function llenaCarteraCliente(){
	var respuesta_json = this.req.responseText;
	//alert (respuesta_json);
		var objeto_json = eval('('+respuesta_json+')');
				nFila=0;
				var num_filas = objeto_json.filas;
				var texto;
	if (num_filas>0){
		texto="";
		$("#nombreYapellido").html(objeto_json.datos[nFila]['nombre']);   
	}else
   		{texto="la cedula no registrada";
		 $("#nombreYapellido").html("");}
	$("#errorCliente").html(texto);
	}	
	

	

function llenaBusquedaProveedor(){ 
		
	inicioListar('proveedores',
	function (objeto_json){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
	var encabezados =['idCliente','razonSocial' ,'telefono','email'  ];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewProv','tablasListaProveedor','indiceListaProveedor','listarTablaProveedor',0,15,"codigoProveedor",false,false,false,false,false);
}else {limpia_linea('tablasListaProveedor','indiceListaProveedor');
	var texto="encuentra registrado ningun Proveedor en la base de datos";
		$('#tablasListaProveedor').html(texto);
	}
	}
	,null,'razonSocial',null,null,null,null,null,'Proveedor')
		}
		
function llenaBusqueda(){ 
		/*limpia_linea('tablasListaPaciente','indiceListaPaciente');
		var datosAjax = {
		tabla: 'clientes',
		inicio: '',
		where:false,
		igual:false,
		columna1:'',
		datosRequeridos:'',
		orderBy : 'nombress',
		tipoOrder: 'ASC'
		 
		};
		carga_listar(datosAjax,list_res_pacientes_2);
		inicioListar(tabla,funcion,php,ordenar,columna,igual,dato,columna2,columna3,nomAplicacion){
		
		*/
		inicioListar('clientes',list_res_pacientes_2);
	//		inicioListar('proveedores',llenaCarteraCliente,null,null,'idCliente',1,dato,'nit',null,'sL')

		}
		
function respuestaNuevaCartera(){
var respuesta_json = this.req.responseText;
alert(respuesta_json)
	$('#Linktabs-2').trigger('click');
	
	}
function respuestaNuevaCredito(){
var respuesta_json = this.req.responseText;
alert(respuesta_json)
	$('#Linktabs-4').trigger('click');
	
	}