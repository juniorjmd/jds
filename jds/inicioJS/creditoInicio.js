$(document).ready(function(){
 
$('#Linktabs-2').click(function(){
var query="SELECT * FROM `credito` ORDER BY `credito`.`idCartera` ASC";
var dateText=new Date();
var dia=dateText.getDate()
var mes=(dateText.getMonth()+1);
var anio=dateText.getFullYear();
var fecha =mes+"/"+dia+"/"+anio;
	$("#dataLabel2").html(fecha) 
var datos_json = "tabla=" + encodeURIComponent('credito')+
	"&orden=" + encodeURIComponent('idCartera')		+
	"&respuesta=" + encodeURIComponent('cartera')		+
		"&nocache=" + Math.random();
		carga_crear_id(datos_json,function (){var respuesta_json = this.req.responseText;$("#labeIDcredito").html(respuesta_json);});	
								
$('#cancelarCredito').trigger('click');
$("#tabs-1").fadeOut( "slow", function() { 
    $("#tabs-2").css("display", "");  
    $("#tabs-2").removeClass('hidden');                 
    $('#Linktabs-1').removeClass('active');
    $('#Linktabs-2').addClass('active');});
              });

$('#Linktabs-1').click(function(){
    $("#tabs-2").fadeOut( "slow", function() { 
                    $("#tabs-1").css("display", ""); 
                    $('#Linktabs-2').removeClass('active');
                    $('#Linktabs-1').addClass('active');
                  });
    inicioListar('credito',list_res_Credito,null,'idCartera',null,null,null,null,null,'Credito');
            });
$('#Linktabs-1').trigger('click'); 
$('#buscaProveedor').click(function(){
    llenaBusqueda();
     $('#btn_busquedaProveedor').trigger('click');
 });
$('#cancelarCredito').click(function(){ 
	$(".NewCredito").each(function(){$(this).val(" "); });
	$("#numeroCuotasCredito").val("1");
	$(".NewCreditolb").each(function(){
            $(this).html(" ");});
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
				if(Trim(abono)=== ""){
					abono=0;
					}
					valorTotal=dato-abono;
					numeroCuotas=$("#numeroCuotasCredito").val()
					if(Trim(numeroCuotas)=== ""){
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
			if(total=== ""){valorTotal=valorCuotas=0}
			else{
				valorTotal=total-dato;
				cuotas=Trim($("#numeroCuotasCredito").val())
				if(cuotas=== ""){
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
			if(Trim(total)=== ""){valorTotal=valorCuotas=0}
			else{
				abono=$("#abonoInicialCredito").val();
				if(Trim(abono)=== ""){abono=0;}
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
	if(codigoCliente=== ""|| Trim($("#errorProveedor").html())!==""){$("#codigoProveedor").focus();
			return;}
			if( valCartera === 0){$("#valCredito").focus();
			return;}else{if(isNaN(valCartera)){
				jAlert('el valor del credito debe ser un numero');
				$("#valCartera").focus();
				return ;
				}}
				if(abonoInicial=== ""){abonoInicial=0;}else{if(isNaN(abonoInicial)){
				jAlert('el valor del abono debe ser un numero');
				$("#abonoInicialCredito").focus();
				return ;
				}}
				if(numeroCuotas=== ""){numeroCuotas=1}else{if(isNaN(numeroCuotas)){
				jAlert('el valor del Numero Cuotas debe ser un numero');
				$("#numeroCuotasCredito").focus();
				return ;
				}}
				if(intervalos=== ""){
			intervalos=1;
			}
	if(parseInt(abonoInicial)>parseInt(valCartera)){
		jAlert("el abono inicial no puede ser mayor al valor del credito");
		 $("#abonoInicialCredito").val(0);
		 $("#abonoInicialCredito").focus();
		 return ;
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
                 
                // console.log(datos_json);
			carga_insert(datos_json,respuestaNuevaCredito);	
			});
});

function llenaCarteraId(){
	var respuesta_json = this.req.responseText;
	$("#labeIDcartera").html(respuesta_json);
		}
		

	
 
function llenaBusquedaProveedor(){
	
	
		inicioListar('proveedores',function (){//evalua la respuesta recibida para listar los colores
var respuesta_json = this.req.responseText;
var objeto_json = eval("("+respuesta_json+")");
var num_filas = objeto_json.filas;
if (num_filas>0){
	var encabezados =['idCliente','razonSocial' ,'telefono','email'  ];
var cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewProv','tablasListaProveedor','indiceListaProveedor','listarTablaProveedor',0,15,"codigoProveedor",false,false,false,false,false);
}else { 
	var texto="encuentra registrado ningun Proveedor en la base de datos";
		$('#tablasListaproveedores').html(texto);
	}
	});
		}
		
function llenaBusqueda(){	
		inicioListar('proveedores',list_res_proveedores);
		}
		 
function respuestaNuevaCredito(){
var respuesta_json = this.req.responseText;
alert(respuesta_json)
	$('#Linktabs-2').trigger('click');
	
	}// JavaScript Document