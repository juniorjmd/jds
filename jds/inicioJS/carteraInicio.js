$(document).ready(function(){

//$('#cuerpoCartera').tabs();
$('#Linktabs-1').click(function(){
	    //carga_listar(datosAjax,list_res_Cartera);
		//inicioListar(tabla,funcion,php,ordenar,columna,igual,dato,columna2,columna3,nomAplicacion)
               //$('#Linktabs-2').addClass("intro"); 
               
        
$("#tabs-2").fadeOut( "slow", function() { 
                    $("#tabs-1").css("display", ""); 
                    $('#Linktabs-2').removeClass('active');
                    $('#Linktabs-1').addClass('active');
                  });		 
    inicioListar('cartera',list_res_Cartera,null,'idCartera',null,null,null,null,null,'Cartera')
								});

$('#Linktabs-1').trigger('click');
$('#Linktabs-2').click(function(){
    $("#tabs-1").fadeOut( "slow", function() { 
                    $('#Linktabs-1').removeClass('active');
                    $('#Linktabs-2').addClass('active');
                    $("#tabs-2").removeClass('hidden'); 
                    $("#tabs-2").css("display", ""); 
                  });	
                  
                  
    let query="SELECT * FROM `cartera` ORDER BY `cartera`.`idCartera` ASC";
    let dateText=new Date();
let dia=dateText.getDate()
let mes=(dateText.getMonth()+1);
let anio=dateText.getFullYear();
let fecha =mes+"/"+dia+"/"+anio;
	$("#dataLabel").html(fecha) 
	let datos_json = "tabla=" + encodeURIComponent('cartera')+
	"&orden=" + encodeURIComponent('idCartera')		+
	"&respuesta=" + encodeURIComponent('cartera')		+
		"&nocache=" + Math.random();
		carga_crear_id(datos_json,llenaCarteraId);
$('#cancelarCartera').trigger('click');
            });

$("#valCartera").keyup(function (){
	dato=$(this).val()
	if (Trim(dato)!== ""){
		if(isNaN(dato)){
				alert('el valor debe ser un numero');
				$("#valCartera").focus();
				$("#valCartera").val("0");
                                $("#totalDeuda").html(0);
				$("#valCuota").html(0);
				return;
				}
				let abono=$("#abonoInicial").val();
				if(Trim(abono)=== ""){
					abono=0;
					}
					valorTotal=dato-abono;
					numeroCuotas=$("#numeroCuotas").val()
					if(Trim(numeroCuotas)=== ""){
						numeroCuotas=1;
						}
						valorCuotas=valorTotal/numeroCuotas
				
				$("#totalDeuda").html(valorTotal)
				$("#valCuota").html(valorCuotas.toFixed(2))
				}else{$("#totalDeuda").html(0)
				$("#valCuota").html(0)}
	
	});
$("#abonoInicial").keyup(function (){
	let dato=$(this).val();
	if (Trim(dato)!== ""){
		
		if(isNaN(dato)){
				alert('el valor debe ser un numero');
				$("#abonoInicial").val("")
				$("#abonoInicial").focus();
				return;
				}else{
					VALOR_INI=parseInt(Trim($("#valCartera").val()))
					if(parseInt(dato)>VALOR_INI){
						alert("el abono inicial no puede ser mayor al valor del credito");
						$("#abonoInicial").focus();
						$("#abonoInicial").val(0);
						return;
						}
					}
	}else{dato=0;}
			
	total=Trim($("#valCartera").val());
	if(total=== ""){valorTotal=valorCuotas=0}
	else{
		valorTotal=total-dato;
		cuotas=Trim($("#numeroCuotas").val())
		if(cuotas=== ""){	cuotas=1}
		valorCuotas=valorTotal/cuotas;
		}
	$("#totalDeuda").html(valorTotal)
				$("#valCuota").html(valorCuotas.toFixed(2))
				});
$("#numeroCuotas").keyup(function (){
	dato=$(this).val()
	if (Trim(dato)!=""){
		if(isNaN(dato)){
				alert('el valor debe ser un numero');
				$("#numeroCuotas").val("1");
				$("#numeroCuotas").focus();
				return;
				}
			if(dato==0){alert('el valor debe ser un numero mayor a 0');
				$("#numeroCuotas").focus();
				return;}
			}else{dato=1;}
			total=$("#valCartera").val();
			if(Trim(total)=== ""){valorTotal=valorCuotas=0}
			else{
				abono=$("#abonoInicial").val();
				if(Trim(abono)=== ""){abono=0;}
				valorTotal=total-abono;
				valorCuotas=valorTotal/dato
				}
				$("#totalDeuda").html(valorTotal)
				$("#valCuota").html(valorCuotas.toFixed(2))
	
	});
$("#abonoInicial").focus(function (){
	let dato=$("#valCartera").val();
	if (isNaN(dato)){
		$("#valCartera").val("");
		$("#valCartera").focus();
	}});
	
$("#numeroCuotas").focus(function (){
	let dato=$("#valCartera").val();
	if (isNaN(dato)){
		$("#valCartera").val("");
		$("#valCartera").focus()
	}
	
	});
  
$("input[id='consultaClienteCartera']").keyup(function (){
			let php = null;											
	let dato=$(this).val();
	if (Trim(dato)!=""){//"'%".$dato."%'"

		inicioListar('clientes',list_res_pacientes_2,php,null,'nombre',null,dato,'idCliente','apellido','Paciente');	
		
		
		}else{
			limpia_linea('tablasListaPaciente','indiceListaPaciente');
			llenaBusqueda()
			$(this).focus();}
	
	
	});
 
$('#buscaCliente').click(function(){
    llenaBusqueda();
    $('#btn_busquedaCliente').trigger('click');
   // $.colorbox({overlayClose:false, inline:true, href:"#busquedaCliente",width:"90%", height:"50%"});
});
$('#guardarCartera').click(function(){
			 let valCuota=Trim($('#valCuota').html())	
		 let totalDeuda=Trim($('#totalDeuda').html())
		   let codigoCliente=Trim($('#codigoCliente').val())
		 	let nombreYapellido=Trim($('#nombreYapellido').val())
		  let carteraDescripcion=Trim($('#carteraDescripcion').val())
		  let valCartera=Trim($('#valCartera').val())
		 let abonoInicial=Trim($('#abonoInicial').val())
		 let numeroCuotas=Trim($('#numeroCuotas').val())
		 let intervalos=Trim($('#intervalos').val())
			if(codigoCliente=== "" || 
                                Trim($("#errorCedula2").html()) !== "")
                                    {$("#codigoCliente").focus();
			return; }
			
				if( valCartera==0){$("#valCartera").focus();
			return; }else{if(isNaN(valCartera)){
				alert('el valor de la cartera debe ser un numero');
				$("#valCartera").focus();
				return;
				}}
				if(abonoInicial=== ""){abonoInicial=0;}else{if(isNaN(abonoInicial)){
				alert('el valor del abono debe ser un numero');
				$("#abonoInicial").focus();
				return;
				}}
				if(numeroCuotas=== ""){numeroCuotas=1}else{if(isNaN(numeroCuotas)){
				alert('el valor del Numero Cuotas debe ser un numero');
				$("#numeroCuotas").focus();
				return;
				}}
				if(intervalos=== ""){
			intervalos=1;
			}
			if(parseInt(abonoInicial)>parseInt(valCartera)){
				alert("el abono inicial no puede ser mayor al valor del credito");
				$("#abonoInicial").val(0)
				$("#abonoInicial").focus();
				return;
			}
			
		 let datos_json= "labeIDcartera="+ encodeURIComponent(Trim($('#labeIDcartera').html()))+"&"+	
		  "dataLabel="+ encodeURIComponent(Trim($('#dataLabel').html())	)+"&"+
		   "codigoCliente="+ encodeURIComponent(Trim($('#codigoCliente').val()))+"&"+
		 	 "nombreYapellido="+ encodeURIComponent(Trim($('#nombreYapellido').val()))+"&"+	
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
 


  
});

function llenaCarteraId(){
	let respuesta_json = this.req.responseText;
	$("#labeIDcartera").html(respuesta_json);
		}
		
function llenaCarteraCliente(){
	let respuesta_json = this.req.responseText;
	//alert (respuesta_json);
		let objeto_json = eval('('+respuesta_json+')');
				nFila=0;
				let num_filas = objeto_json.filas;
				let texto;
	if (num_filas>0){
		texto="";
		$("#nombreYapellido").html(objeto_json.datos[nFila]['nombre']);   
	}else
   		{texto="la cedula no registrada";
		 $("#nombreYapellido").html("");}
	$("#errorCliente").html(texto);
	}	
	

	
 
		
function llenaBusqueda(){ 
		/*limpia_linea('tablasListaPaciente','indiceListaPaciente');
		let datosAjax = {
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
let respuesta_json = this.req.responseText;
alert(respuesta_json);

	$('#Linktabs-2').trigger('click'); 
	} 