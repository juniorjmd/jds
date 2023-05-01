  let id_grupo_producto_activo = '';
   let Global_preventa = 0;
   let Global_PsIVA = 0;
   let Global_IVA = 0;
   let Global_porcent_IVA = 0;
$(document).ready(function(){
	//console.clear();
 
	//console.log('INICIO');
        $('.ordenarPor27072020').change(function(){
            $($(this).data('search')).trigger('keypress'); 
             console.log('INICIO'+$(this).data('search'));
        });
	$('.busquedas').keypress(function(key){
		let dato =  $(this).val();
		let invoker = $(this).data('invoker');
		let tabla = null;
		let funcion = null;
		let php = $(this).data('url_php');
                if(php == '')php = null;
		let ordenar = '';
		let columna = null;
		let igual = null;
		let columna2 = null;
		let columna3 = null;
                let nomAplicacion = null;
                let auxOrden = '';
                let tecla =   key.which ; 
                let idOrden = $(this).data('select_orden');
                if (idOrden != ''){
                if ( $(idOrden).length &&  
                        $($(this).data('select_orden')).val().trim() !== '' ) {
                      auxOrden  = $($(this).data('select_orden')).val();
                       tecla = 13;
                  }}
               if ( ordenar.trim() !== '' &&  auxOrden.trim() !== ''){
                                            ordenar += '|'+auxOrden;
                                        }else if(auxOrden.trim() !== '')
                                        {
                                             ordenar = auxOrden;
                                        }
	 	console.log('orden '+idOrden + ' y auxOrden '+auxOrden );
                 
		if (tecla === 13  ){
				console.log('press enter con el valor '+dato +' - '+invoker);
                               
                                
				if ( dato.trim()!=='')
                                {
					switch(invoker){
						case 'proveedores':
							funcion = list_res_prov;
							tabla 		= 'proveedores';
							columna 	= 'nit';
							columna2	= 'nombre';
							columna3	= 'razonSocial';
							ordenar 	='idCliente';
						break;
                                                
                                                case 'nuevaCuenta':
                                                        funcion = llenaCarteraCliente;
							tabla 		= 'clientes';
							columna 	= 'nit';
							/*columna2	= 'nombre';
							columna3	= 'razonSocial';*/
							ordenar 	='idCliente';
                                                        igual = true;
                                                break;
                                                //newCreditoProveedor
                                                case 'newCreditoProveedor':
                                                        funcion = llenaCreditoCredito;
							tabla 		= 'proveedores';
							columna 	= 'nit';
							/*columna2	= 'nombre';
							columna3	= 'razonSocial';*/
							ordenar 	='idCliente';
                                                        igual = true;
                                                break;
						case 'clientes':
							funcion = list_res_Cli;
							tabla 		= 'clientes';
							columna 	= 'nit';
							columna2	= 'nombre';
							columna3	= 'razonSocial';
							ordenar 	='idCliente';
						break;
                                                case 'clientes_busqueda_nueva_cartera':
							funcion = list_res_pacientes_2;
							tabla 		= 'clientes';
							columna 	= 'nit';
							columna2	= 'nombre';
							columna3	= 'razonSocial';
							ordenar 	='idCliente';
						break;
                                                 case 'proveedor_busqueda_nueva_credito':
                                                     funcion = list_res_proveedores;
							tabla 		= 'proveedores';
							columna 	= 'nit';
							columna2	= 'nombre';
							columna3	= 'razonSocial';
							ordenar 	= 'idCliente';
						break;
						case 'articulos':
							funcion = list_res_articulo;
							tabla 		= 'producto';
							columna 	= 'nombre';
							columna2	= 'idProducto';
							columna3	= 'Grupo';
							ordenar 	= 'nombre'; 
						break;
                                                case 'listadoModCartera':
							funcion = list_res_Cartera;
							tabla 		= 'cartera';
							columna 	= 'nombre';
							columna2	= 'refFact';
							columna3	= 'idCliente';
							ordenar 	= 'nombre'; 
                                                        nomAplicacion   = 'Cartera'
						break;
                                                //list_res_Credito
                                                 case 'listadoModCredito':
                                                        funcion = list_res_Credito;
							tabla 		= 'credito';                                                        
                                                        columna 	= 'nombre';
							columna2	= 'descripcion';
							columna3	= 'idCliente';
							ordenar 	= 'nombre'; 
                                                        nomAplicacion   = 'Credito';
                                                break;
					}
                                       
					console.log('press enter con el valor '+dato+columna);
					inicioListar(tabla,funcion,php,ordenar,columna,igual,dato,columna2,columna3,nomAplicacion) 
					console.log('//press enter con el valor '+dato);
		}else{
			switch(invoker){        case 'listadoModCartera':                                                                                                    
                                                      nomAplicacion = 'Cartera';
							reinicio= inicioListar('cartera',list_res_Cartera,php,ordenar,columna,igual,dato,columna2,columna3,nomAplicacion);
						break;
						case 'proveedores':							
							reinicio= inicioListar('proveedores',list_res_prov,php);
						break;
						case 'clientes':
							reinicio= inicioListar('clientes',list_res_Cli,php);
						break;
                                                case 'articulos':
						        reinicio= inicioListar('producto',list_res_articulo,php);
						break; 
                                                 case 'clientes_busqueda_nueva_cartera':
                                                     reinicio= inicioListar('clientes',list_res_pacientes_2,php);
						break;
                                                 case 'proveedor_busqueda_nueva_credito':
                                                     reinicio= inicioListar('proveedores',list_res_proveedores,php);
						break;
                                                //list_res_proveedores
                                                 case 'listadoModCredito':                                                     
                                                      nomAplicacion = 'Credito';
                                                      reinicio= inicioListar('credito',list_res_Credito,php,ordenar,columna,igual,dato,columna2,columna3,nomAplicacion);
                                                 break;
                                                 case 'newCreditoProveedor':  
                                                      reinicio= inicioListar('proveedores',list_res_Credito,php);
                                              
					}
		}}
	});
        

});
function llenaCarteraCliente(){
	let respuesta_json = this.req.responseText;
	//alert (respuesta_json);
		let objeto_json = eval('('+respuesta_json+')');
				nFila=0;
				let num_filas = objeto_json.filas;
				let texto;
                                let aa = document.getElementById("nombreYapellido");
	if (num_filas>0){
            
            //alert(aa.type);
		texto="";
                if (aa.type === 'text'){
		$("#nombreYapellido").val(objeto_json.datos[nFila]['nombre']);   
                }else{
		$("#nombreYapellido").html(objeto_json.datos[nFila]['nombre']);  }
	}else
   		{texto="la cedula no registrada";
		   if (aa.type === 'text'){
		$("#nombreYapellido").val("");   
                }else{
		$("#nombreYapellido").html("");  }
             
    
    
    
    }
	$("#errorCliente").html(texto);
	}	

function llenaCreditoCredito(){
	let respuesta_json = this.req.responseText;
	//alert (respuesta_json);
let objeto_json = eval('('+respuesta_json+')');
                nFila=0;
                let num_filas = objeto_json.filas;
                let texto; 

               let aa = document.getElementById("razonSociallb");
	if (num_filas>0){
            //alert(aa.type);
		texto="";
                if (aa.type === 'text'){
		$("#razonSociallb").val(objeto_json.datos[nFila]['razonSocial']);   
                }else{
		$("#razonSociallb").html(objeto_json.datos[nFila]['razonSocial']);  }
	}else{texto="la cedula no registrada";
		   if (aa.type === 'text'){
		$("#razonSociallb").val("");   
                }else{
		$("#razonSociallb").html("");  }}     
             
             
	$("#errorCliente").html(texto);
        
        }
         	  
			
  
function listar_tipos_medidas_creadas(){
    let lista = '';
    let url_base = $('#url_base_aplicacion').val()
    if (url_base == ''){url_base = '../';}
     OcultaYMuestra("#creacion","#medidas");
    url_base = url_base + 'php/db_listar_nuevo.php';
    //alert(url_base)
  //  alert(id_grupo_producto);
    	let datosAjax = {
		tabla: 'vw_medidas_relacionadas_grupos',
		inicio: '',    
		datosRequeridos:'',
                where:true ,
                columna1:'id_grupo',
                dato:id_grupo_producto_activo,
                igual:true
		/*
		proced : 'GET_PRODUC_BARCODE',
		datosProce:[valorEnviar]*/
		};
                
		$.ajax({url: url_base,  
			type: 'POST',
			data: datosAjax,
			dataType: "json",
			 beforeSend: function() {
				console.log(JSON.stringify(datosAjax))
                                $('#cont_lista_medidas').html(lista)
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
				console.log(JSON.stringify(data))
				let total = data['filas'];
				let datosTabla=data['datos'];
				if (total > 0 ){ 
                                    let auxDato;
                                    let medidas; 
                                    lista = '<table>';
                                    let aux_num_medidas = 0;
				for(let i =0; i<datosTabla.length;i++){
					auxDato=datosTabla[i] ; 
                                        medidas = 'edad'+auxDato.id;
                                        aux_num_medidas++;
                                        if (aux_num_medidas == 15){
                                            aux_num_medidas =0; 
                                            lista += '</td><td>'
                                        }
                                        lista += '<input type="radio" class="medidas" id="'+medidas+'" data-codigo="'+auxDato.codigo+'" '+
                                                ' data-m1="'+auxDato.m1+'" data-m2="'+auxDato.m2+'" data-m3="'+auxDato.m3+'" data-pulgadas="'+auxDato.total_pulgadas+'" '+
                                                ' data-pies="'+auxDato.total_pies+'" data-medida="'+auxDato.medida+'" value="'+auxDato.medida+'">'+auxDato.medida+
                                                '<br>';
                                        
					}
                                       lista+='</td></tr></table>';
                                         
                                        //console.log(lista)
                                        $('#cont_lista_medidas').html(lista)
                                        add_evento_nav_lista_medidas();
                                        $('.medidas').unbind('click').click(function(){
                                            $('#aux_nombre_venta').val('')
                                             $('.medidas').prop( "checked",false )
                                             $(this).prop( "checked",true )
                                             let pulgadas  = $(this).data('pulgadas') 
                                             let pies  = $(this).data('pies') 
                                             let medida = $(this).val();
                                             $('#aux_nombre_venta').val(medida)
                                             $('#InombreP').val($('#InombreP').val()+' - '+medida)
                                             if ($('#cantTranformada').val() == '') $('#cantTranformada').val(0)
                                             ///////////////////////////////////////////77777
                                              let cont =  $('#cantTranformada') ;
                                                if (Trim(cont.val()) == '' )
                                                {cont.val(0); 
                                                    } 
                                               try{
                                                let nwCNT =  cont.val().replace(',','.')

                                                let repetir = 0;
                                                for (i = 0 ; i< nwCNT.length;i++)
                                                {  if(nwCNT[i] == '.'){
                                                     repetir++;   
                                                } 
                                                } 
                                                if (/^([0-9])*[.]?[0-9]*$/.test(nwCNT)){}else{
                                                    $(this).val(0);
                                                        alert('error : La cantidad digitada no es un numero valido '  );
                                                    return false;}
                                                let axnwCNT
                                                axnwCNT =  parseFloat(nwCNT) 
                                                if (Number.isNaN(axnwCNT) || repetir>1) 
                                                 throw "exite un error en la cantidad a ser transformada"  

                                               cont.val(nwCNT)
                                               $('#cantidad_producto_real').val(cont.val()) 

                                                
   
                                             
                                             ////////////////////////////////////////////777777
                                             
                                             
                                             
                                             
                                             let cantidad = $('#cantTranformada').val();
                                             let pies_aux = parseFloat(pies).toFixed(2);
                                             let  total_pies = pies_aux * parseFloat(cantidad).toFixed(2)//regresar
                                             let padre_aux = $(window.parent.document);//$(padre).find
                                             let presio_venta_unidad = parseFloat( Global_preventa ).toFixed(2) * pies_aux;
                                             let presio_siva_venta_unidad = parseFloat(Global_PsIVA).toFixed(2) * pies_aux;
                                             let total_iva = parseFloat(Global_IVA).toFixed(2) * pies_aux;
                                            
                                           presio_venta_unidad = parseFloat(presio_venta_unidad).toFixed(2)
                                            presio_siva_venta_unidad = parseFloat(presio_siva_venta_unidad).toFixed(2)
                                            total_iva = parseFloat(total_iva).toFixed(2)
                                            
                                            $("#Presio_producto").val(presio_venta_unidad)
					    $("#Presio_sin_iva_producto").val(presio_siva_venta_unidad)
					    $("#iva_producto").val(total_iva)
                                            ////////////////////////////////////////////////////
                                              
                                          $("#cantidad_producto").val(cantidad)
                                          $('#cantidad_producto_real').val(total_pies)                                           
                                           $("#total_remision").val(presio_venta_unidad * cantidad)
                                           }   
                                               catch(err){
                                                   alert('error : ' + err );
                                                   return false;
                                               }  
                                        })
                                        //$("#transformar").css("display","inline") 
					}
                                        else{ 
						alert('no existen medidas Generadas para realizar la venta')
					}
				 },error: function(a,e,b){
					 console.log("se genero un error"+JSON.stringify(a,e,b))
					}});//fin bloque obtencion de datos producto
}


function iniciarListas(){
			asignarEvento();
			OcultaYMuestra(".divListas","#divListas1");
			$("#atrasDiv").unbind('click')
			$("#siguienteDiv").unbind('click');
			$("#atrasDiv").click(function(){
				let anterior=$("#anterior").html();
				let actual=$("#actual").html();
				OcultaYMuestra("#divListas"+actual,"#divListas"+anterior);
				let NumDiv=parseInt($("#numeroDiv").val());
				switch(NumDiv){
				case  1:
				break;
				case  2:
					$("#anterior").html(actual);
					$("#actual").html(anterior);
					$("#siguiente1").html(actual);
					break;
					default://///////////////////////
					$("#actual").html(anterior);
					let penultimo=$("#siguiente"+(NumDiv-2)).html();
					$("#anterior").html(penultimo);
					let ultimo=parseInt($("#siguiente"+(NumDiv-1)).html())
					for(i=2;i<NumDiv;i++){//inicio for
						let aux=parseInt($("#siguiente"+i).html())
						if(aux==1){aux=NumDiv;}else{aux--;}
						$("#siguiente"+i).html(aux);}//fin for
					$("#siguiente1").html(actual);
				break;
			}
		});
///////////////////////////////////////////////			
		$("#siguienteDiv").click(function(){
			let anterior=$("#anterior").html();
			let actual=$("#actual").html();
			let siguiente=$("#siguiente1").html();
			OcultaYMuestra("#divListas"+actual,"#divListas"+siguiente);
			let NumDiv=parseInt($("#numeroDiv").val());
			switch(NumDiv){
				case  1:
				break;
				case  2:
					$("#anterior").html(actual);
					$("#actual").html(anterior);
					$("#siguiente1").html(actual);
				break;
				default://///////////////////////
					$("#actual").html(siguiente);
					let ultimo=parseInt($("#siguiente"+(NumDiv-1)).html())
					for(i=1;i<NumDiv;i++){//inicio for
						let aux=parseInt($("#siguiente"+i).html())
						if(aux==NumDiv){aux=1;}
						else{aux++;}
						$("#siguiente"+i).html(aux);}//fin for
					$("#anterior").html($("#siguiente"+(NumDiv-1)).html());
				break;
				}
		});
//////////////////////////////////////////////////		

 }// JavaScript Document
 
 function imprimeVenta(idVenta){
$("#cerrarVenta").unbind('click')
$("#cerrarVenta").click(function(){
	
	if($("#tipoVenta").val()=="DATAFONO"){
		let VAUCHE; 
		do {
		VAUCHE= prompt("POR FAVOR INTRODUSCA EL NUMERO DEL VAUCHE PARA CONTINUAR");}
		while (Trim(VAUCHE) == ""&&VAUCHE!=null);
		if (VAUCHE == null){return; }
	}
	 data='IdVenta='+encodeURIComponent(idVenta);
	  datosAjax=data
		  +'&codMesa='+encodeURIComponent($("#mesaActiva").val())
		   +'&tipoVenta='+encodeURIComponent($("#tipoVenta").val())
		  +'&cantidadVendida='+encodeURIComponent($("#cantidadVendida").val())
		  +'&valorParcial='+encodeURIComponent($("#totalSinIva").html())
		  +'&valorIVA='+encodeURIComponent($("#totalIVA").html())		  
		  +'&descuento='+encodeURIComponent("0")
		  +'&valorTotal='+encodeURIComponent($("#totalVenta").html())
		 +'&usuario='+encodeURIComponent("ADMINISTRADOR")
		 +"&abrir="+encodeURIComponent("abrirCajon")
		 +"&idCliente="+encodeURIComponent($("#idCliente").val())
		 +"&nombreCliente="+encodeURIComponent($("#nombreCliente").val())
		 +"&idCliente3="+encodeURIComponent($("#idCliente3").val())
		  +"&VAUCHE="+encodeURIComponent(VAUCHE)
		  +"&nocache=" + Math.random()
		  //alert(datosAjax)
		$.ajax({url: 'CerrarVentas.php',  
				type: 'POST',
				async: true,
				data: datosAjax,
				success: function(responseText){
					//alert(responseText)
				r = confirm("DESEA COPIA DE LA FACTURA");
				 	if(r==true){$("#print").trigger('click');}
					//alert($("#MA").html()+"tiene que activar")
					let datosAjax='mesaid='+encodeURIComponent($("#mesaActiva").val())+
					"&mesaActivada="+encodeURIComponent($("#MA").html())+
					"&nocache=" + Math.random();
					$.ajax({
						url: 'listaPedido.php',  
						type: 'POST',
						async: true,
						data: datosAjax,
						beforeSend: function(){
							$(".filasData").attr("disabled","disabled")
						 },
						//una vez finalizado correctamente
						success: function(responseText){//alert(responseText)
							$("#contenedor").html(responseText);
							$(".filasData").removeAttr('disabled');
						},//si ha ocurrido un error
						error: function(){
							message = $("<span class='error'>Ha ocurrido un error.</span>");
							alert(message);
						}
					});
				$('#'+$("#mesaActiva").val()).trigger('click');
				OcultaYMuestra("#contenedorPrincipal","#divCliente"); 
$("#nombreidCliente").focus();},//si ha ocurrido un error
						error: function(){
							message = $("<span class='error'>Ha ocurrido un error.</span>");
							alert(message);
						}
					})
		});
$("#print").unbind('click')	
	$("#print").click(function(){
		$.ajax({url: 'printer2.php',  
				type: 'POST',
				async: true,
				data: data,
				success: function(responseText){//alert(responseText)
				}
					})
		});}
 
 //////////////////////////////////////////////////////////////////
function asignarEvento(){
	$(".filasData").unbind('click');
		 $(".filasData").click(function(){
						 if ($("#ayudame").html()=="SELECCIONE UNA MESA"){
							alert ("POR FAVOR SELECCIONE UNA MESA PARA FACTURAR")
							}else{
						$("#cantidadVenta").val(0);
						enableDisable(".filasData")
						  $.ajax({
						url: 'verificaCantidad.php',  
						type: 'POST',
						
						data: "idProducto="+$(this).attr("id"),
						success: function(responseText){
						$("#cantActualArt").val(Trim(responseText))
						}
					});
						cantAct=$("#cantActualArt").val();
					 let stock=$("#stock_"+$(this).attr("id")).val()
						 if(cantAct<10)
						 {enableDisable("#suma10");
						 enableDisable("#guardarliquidar");
						 $(".calculadora").each(function(index, element) {
						           cantida=parseInt($(this).val()) 
									  if(cantida>cantAct){
										  $(this).attr("disabled","disabled");
										  }
									  });
							 }
					 $("#idProducto").val($(this).attr("id"))
					 $("#nombreProducto").val( $("#NP_"+$(this).attr("id")).val())
					 $("#presioVenta").val($("#PV_"+$(this).attr("id")).val())
					 $("#liquidar").css("display","inline")
						 }
					});
		 }
///////////////funciones de limpiesa
function OcultaYMuestra(clase1,clase2){if(Trim(clase1)!=""){	
$(clase1).each(function(){		  
			 $(this).css("display", "none")
			});}

	if(clase2){
		$(clase2).each(function(){
			 $(this).css("display", "block")						  	
			  });}
	}

	function OcultaYMuestraPadre(clase1,clase2)
{if(Trim(clase1)!=""){	
 padre = $(window.parent.document);
$(padre).find(clase1).each(function(){		  
			 $(padre).find(this).css("display", "none")
			});}

	if(clase2){
		$(padre).find(clase2).each(function(){
			 $(padre).find(this).css("display", "block")						  	
			  });}
	}

function enableDisable(clase1,clase2)
{if(Trim(clase1)!=""){	
$(clase1).each(function(){		  
			 $(this).attr('disabled', 'disabled');
			});}

	if(clase2){
		$(clase2).each(function(){
			 $(this).removeAttr('disabled');					  	
			  });}
	}



function limpiaVal(clase1){
	$(clase1).each(function(){	
			if($(this).get(0).tagName=="SELECT"){$(this).val("none");}else{	
			 $(this).val("");}
			});
	
	}
function limpiaHtml(clase1){
	$(clase1).each(function(){
			if($(this).get(0).tagName!="SELECT"){
			 $(this).html("");}
			});}
	
function recogerDatos(clase){
		let i=0;
		let datosJson="";
		$(clase).each(function(){
		
			if($(this).html()){
			datosJson=datosJson+ $(this).attr('id')+"=" + encodeURIComponent($(this).html())+"&";
			}
			else{datosJson=datosJson+ $(this).attr('id')+"=" + encodeURIComponent($(this).val())+"&";
			}	
			//alert( $(this).attr('id'))
		});return datosJson;}
	
	function recogerDatos2(clase){
		let i=0;
		let datosJson="";
		$(clase).each(function(){
			if($(this).val()){let dato=$(this).val(); 
			datosJson=datosJson+ $(this).attr('id')+"=" + encodeURIComponent($(this).val())+"&";
				}
			else{datosJson=datosJson+ $(this).attr('id')+"=" + encodeURIComponent($(this).html())+"&";
			}	
		});return datosJson;}


///////////////comunicacion con base de datos//////////////////////////////////////////////////////////////
function cargaSucursalesMenu(suc){
				if(suc){datosJson="suc=" + encodeURIComponent(suc) 
				+"&nocache=" + Math.random();}else{
				datosJson="";}
				carga_insert(datosJson,function(){
							let respuesta_json = this.req.responseText;
							$("#menuMovSuc").html(respuesta_json);
							},"php/menuSuc.php");}
							 
							
		
					
function cargaSelect(tabla,columna,dato,direccion,txt,value)//tabla a donde buscaremos los datos...columna y dato si se va a buscar algo especifico a mostrar, direccion el id del select, txt es la columna de los textos y value es la comunna de los value...
{	let query="SELECT * FROM "+tabla; 
	datos_json="query=" + encodeURIComponent(query) 
		+"&tabla=" +encodeURIComponent(tabla) 
		+"&txt=" +encodeURIComponent(txt) 
		+"&value=" +encodeURIComponent(value) ;
	if((dato)&&(columna)){
	datos_json=datos_json+"&dato=" + encodeURIComponent(dato) 
	+"&columna=" +encodeURIComponent(columna) }
	datos_json=datos_json+"&nocache=" + Math.random();
	carga_listar(datos_json,function(){let respuesta_json = this.req.responseText;
									  $(respuesta_json).appendTo(direccion);									   
									   },"php/db_cargaSelect.php");}
									   
function cargaSelect2(tabla,columna,dato,direccion,txt,value)//tabla a donde buscaremos los datos...columna y dato si se va a buscar algo especifico a mostrar, direccion el id del select, txt es la columna de los textos y value es la comunna de los value...
{	let query="SELECT * FROM "+tabla; 
	datos_json="query=" + encodeURIComponent(query) 
		+"&tabla=" +encodeURIComponent(tabla) 
		+"&txt=" +encodeURIComponent(txt) 
		+"&value=" +encodeURIComponent(value) ;
	if((dato)&&(columna)){
	datos_json=datos_json+"&dato=" + encodeURIComponent(dato) 
	+"&columna=" +encodeURIComponent(columna) }
	datos_json=datos_json+"&nocache=" + Math.random();
	carga_listar(datos_json,function(){let respuesta_json = this.req.responseText;
									  $(respuesta_json).appendTo(direccion);									   
									   },"../php/db_cargaSelect.php");}


function eliminar(tabla,columna,dato,respuesta,funcion,php)
{
	if(confirm('�realmente desea leminar todos los datos.?')){
		let datos_json = "dato=" + encodeURIComponent(dato) 
		+"&tabla=" +encodeURIComponent(tabla) 
		+"&columna=" +encodeURIComponent(columna) 
		+"&respuesta=" +encodeURIComponent(respuesta) 
		+"&nocache=" + Math.random();
		carga_borrarUpdate(datos_json,funcion,php);
	}else{}
	}

function inicioListar(tabla,funcion,php,ordenar,columna,igual,dato,columna2,columna3,nomAplicacion){
			//console.log('datos recibidos '+tabla+php+ordenar+'columna:'+columna+igual+dato+columna2+columna3)
			let queryAux="";
			console.log(tabla);
			if(columna){
				console.log('si esta columna');
				}else{columna='-1'}
			console.log(columna);
			queryAux=queryAux+"where=" + encodeURIComponent(columna)+"&"
			console.log(queryAux);
			if(columna!='-1'){
			if(igual){
					queryAux=queryAux+"iguales=" + encodeURIComponent("1")+"&dato=" + encodeURIComponent(dato)+"&" ;
					}
				else{
					queryAux=queryAux+"iguales=" + encodeURIComponent("0")+"&dato="+ encodeURIComponent(dato)+"&" ;
					}
			if(columna2){queryAux=queryAux+"tabla2=" + encodeURIComponent(columna2)+"&" ;}
			if(columna3){queryAux=queryAux+"tabla3=" + encodeURIComponent(columna3)+"&" ;}
			}
			if(!ordenar){queryAux=queryAux+"order=-1" ;}else{
                           // let pizza = "porción1 porción2 porción3 porción4 porción5 porción6";
                                let  colOrdenar = ordenar.split('|');
                                let ordenarColumna = '';
                                let coma =  ' ORDER BY '; 
                                let tipOrden = 'ASC'; 
                                 if ( $("#tipoOrdena27072020").length &&  $("#tipoOrdena27072020").val().trim() !== '' ) {
                                    tipOrden  = $("#tipoOrdena27072020").val();
                                }
                                     for (let columna of colOrdenar) {
                                        ordenarColumna += coma + " `"+columna+"` "+tipOrden;
                                        coma = ', ';
                                      }                           
				queryAux=queryAux+"order=" + encodeURIComponent(ordenarColumna ) ;
				}
			
		let datos_json = queryAux
		+"&respuesta=" +encodeURIComponent(tabla) 
		+"&nocache=" + Math.random();
		console.log('datos_json :'+datos_json)
		if (nomAplicacion){if (nomAplicacion!=='sL'){
		limpia_linea('tablasLista'+nomAplicacion,'indiceLista'+nomAplicacion);}}else{
		limpia_linea('tablasLista'+tabla,'indiceLista'+tabla);}
		
		carga_listar(datos_json,funcion,php);
				
	}
function log(dato)
{
	console.log(dato)
}
function clear()
{
	console.clear()
}

function crearId(tabla,destino,php,orden){
	
	let datos_json='';
	if(orden){
		 datos_json = "orden=" + encodeURIComponent(orden)+'&'
	}
	 datos_json = datos_json+"tabla=" + encodeURIComponent(tabla) +
		"&respuesta="+ encodeURIComponent(tabla) +
		 "&nocache="+ Math.random();
		 
	
		 carga_crear_id(datos_json,function(){ $(destino).val("00"+this.req.responseText);$(destino).html("00"+this.req.responseText); },php);
	
	}
///////////////funciones de respuesta//////////////////////////////////////////////////////
	function llenaEditSuc(){
		let encabezados =['id_suc','nombre_suc' ,'dir','mail','tel1'  ,'tel2' ,'ciudad','descripcion' ];
let datos=this.datosParaEnvio;
let datos2=this.datosParaEnvio;
	i=0;
	$(".lbrespuesta").each(function(){
		cabeza=encabezados[i]
		i++
		//alert($(this).attr('id'))
		$(this).html(datos[cabeza])						  	
			  });
	i=1;
	$(".Mrespuesta").each(function(){
		cabeza=encabezados[i]
		i++;
		//alert($(this).attr('id'))
		$(this).val(datos2[cabeza])						  	
			  });
	OcultaYMuestra("#listado","#Mostrar");
	}
function cambiaClinte(idColumna,dato,tabla,columna1,identificador,columna2,nombreCambiar){
	
		let datos_json= "idColumna="+encodeURIComponent(idColumna)+
					"&dato="+encodeURIComponent(dato)+
					"&tabla="+encodeURIComponent(tabla)+
					"&columna1="+encodeURIComponent(columna1)+
					"&identificador="+encodeURIComponent(identificador)+
					"&columna2="+encodeURIComponent(columna2)+
					"&nombreCambiar="+encodeURIComponent(nombreCambiar)+
					"&respuesta="+ encodeURIComponent("cambioCliente") +
					"&nocache="+ Math.random();
					carga_borrarUpdate(datos_json,function(){},"../php/editar_eliminar.php")
	
	
	}	
function llenaEditProv(){
	if($("#posicion").val()){
		let datos=this.datosParaEnvio;
$("#ventas #idCliente").html(datos['idCliente']);
$("#cliente").html(datos['razonSocial']);
cambiaClinte("idVenta",$("#codigoIngreso").html(),$("#ventaTemp").val(),"idCliente",$("#ventas #idCliente").html(),"cliente",$("#cliente").html())
	}else{
			enableDisable(".Mrespuesta");
			enableDisable("#saveEdicion");
			$("#saveEdicion").attr('src', 'imagenes/accept (2).png');
			$("#EliminarBoton").attr('src', 'imagenes/basurero.jpg');
			$("#EditarBoton").attr('src', 'imagenes/ui-icons_lapiz.png');
		let encabezados =['idCliente' ,'nombre','nit','razonSocial','email' ,'telefono','direccion'  ];
let datos=this.datosParaEnvio;
let datos2=this.datosParaEnvio;
	i=0;
	$(".lbrespuesta").each(function(){
		cabeza=encabezados[i]
		i++
		//alert($(this).attr('id'))
		$(this).html(datos[cabeza])						  	
			  });
	i=1;
	$(".Mrespuesta").each(function(){
		cabeza=encabezados[i]
		i++;
		//alert($(this).attr('id'))
		$(this).val(datos2[cabeza])						  	
			  });
	OcultaYMuestra("#Nuevo","#Mostrar");
	}}
		
	
function llenaEditCli(){
	if($("#posicion").val()){
		let datos=this.datosParaEnvio;
$("#ventas #idCliente").html(datos['idCliente']);
$("#cliente").html(datos['razonSocial']);
cambiaClinte("idVenta",$("#codigoIngreso").html(),$("#ventaTemp").val(),"idCliente",$("#ventas #idCliente").html(),"cliente",$("#cliente").html())
	}else{
			enableDisable(".Mrespuesta");
			enableDisable("#saveEdicion");
			$("#saveEdicion").attr('src', 'imagenes/accept (2).png');
			$("#EliminarBoton").attr('src', 'imagenes/basurero.jpg');
			$("#EditarBoton").attr('src', 'imagenes/ui-icons_lapiz.png');
		let encabezados =['idCliente' ,'nombre','nit','razonSocial','email' ,'telefono','direccion'  ];
let datos=this.datosParaEnvio;
let datos2=this.datosParaEnvio;
	i=0;
	$(".lbrespuesta").each(function(){
		cabeza=encabezados[i]
		i++
		//alert($(this).attr('id'))
		$(this).html(datos[cabeza])						  	
			  });
	i=1;
	$(".Mrespuesta").each(function(){
		cabeza=encabezados[i]
		i++;
		//alert($(this).attr('id'))
		$(this).val(datos2[cabeza])						  	
			  });
	OcultaYMuestra("#Nuevo","#Mostrar");
		}}
		
	
function llenaEditArt(){
let encabezados =['codigo','grupo','forma','color' ,'tamanio','nombre','presentacion' ,'descripcion1','descripcion2','cantidad'  ,'presioCompra','presioVenta' ,'proveedor','proveedor2' ];
let datos=this.datosParaEnvio;
let datos2=this.datosParaEnvio;
	i=0;
	$(".EditRespuesta").each(function(){
		cabeza=encabezados[i]
		if(i==0){
		$(this).html(datos[cabeza])	}else{$(this).val(datos[cabeza])	}i++					  	
			  });
	
	OcultaYMuestra("#listado","#Mostrar");
		
							
	}	
		
function llenaEditGrup(){
let encabezados =['id_grupo','nom_gr' ,'descripcion','descripcion2'  ];
let datos=this.datosParaEnvio;
let datos2=this.datosParaEnvio;
	i=0;
	$(".EditRespuesta").each(function(){
		cabeza=encabezados[i]
		if(i==0){
		$(this).html(datos[cabeza])	}else{$(this).val(datos[cabeza])	}i++					  	
			  });
	
	OcultaYMuestra("#listado","#Mostrar");
		
							
	}
	
	
function llenaEditForma(){
let encabezados =['id_forma','nom_forma' ,'descripcion' ];
let datos=this.datosParaEnvio;
let datos2=this.datosParaEnvio;
	i=0;
	$(".EditRespuesta").each(function(){
		cabeza=encabezados[i]
		if(i==0){
		$(this).html(datos[cabeza])	}else{$(this).val(datos[cabeza])	}i++					  	
			  });
	OcultaYMuestra("#listado","#Mostrar");
	}	
	
	
function llenaEditColor(){
let encabezados =['id_color','c_name' ,'descripcion' ];
let datos=this.datosParaEnvio;
let datos2=this.datosParaEnvio;
	i=0;
	$(".EditRespuesta").each(function(){
		cabeza=encabezados[i]
		if(i==0){
		$(this).html(datos[cabeza])	}else{$(this).val(datos[cabeza])	}i++					  	
			  });
	OcultaYMuestra("#listado","#Mostrar");			
	}	
	
	
function list_res_Suc(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
//alert(respuesta_json)
let objeto_json = eval("("+respuesta_json+")");

let num_filas = objeto_json.filas;
if (num_filas>0){
	let texto="";
	let encabezados =['id_suc','nombre_suc' ,'tel1' ,'tel2','dir' ,'mail' ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewSuc','tablasListasucursales','indiceListasucursales','listarTablasucursales',0,16,false,false,false,false,llenaEditSuc,false);
	$('#tablasListasucursales').append(texto);
}else {limpia_linea('tablasListasucursales','indiceListasucursales');
	let texto="Todavía no se encuentra registrado ningun sucursal en la base de datos, para registrar haga click <span id='nuevoSucursales' class='menu_click'>aqui.</span>";
	
	$('#tablasListasucursales').html(texto);
	}
	}
	
	
function list_res_articulo(){//evalua la respuesta recibida para listar los colores respuesta_busqda_articulo
console.log('datos :'+this.req.responseText);
let respuesta_json = this.req.responseText;
let objeto_json = eval("("+respuesta_json+")");
let num_filas = objeto_json.filas;
if (num_filas>0){
	console.log('INICIO DE CARGUE EN TABLA');
	let texto="";
	let encabezados =['idProducto','nombre' ,'precioCompra'];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewSuc','tablasListaproducto','indiceListaproducto','listarTablaproducto',0,16,false,false,false,false,llenaArticulo,false);
	$('#tablasListaArticulo').append(texto);
}else {
	let texto="Todavía no se encuentra registrado ningun cliente en la base de datos, para registrar haga click <span id='nuevoCliente' class='menu_click'>aqui.</span>	";
	texto=texto+"<script type='text/javascript'>$(this).unbind('click'); $('#nuevoCliente').click(function(){jQuery.colorbox.close();$('#bt1').trigger('click');});</script>";
	
	$('#tablasListaArticulo').html(texto);
	}
	}	
function llenaArticulo(){
	let caption = $('#caption').val()
	switch(caption){
	case 'compras' :
	$('#InombreP').val(this.datosParaEnvio['nombre']);	
	$('#nombreP').html(this.datosParaEnvio['nombre']);
	$('#precio').val(this.datosParaEnvio['precioCompra']);
	$('#codProduto').val(this.datosParaEnvio['idProducto']);
	$('#cantidad').focus();
	$("#precio").trigger("keyup");
	break;
        case 'remisiones' :
            console.log(JSON.stringify(this.datosParaEnvio))
            $('#InombreP').val(this.datosParaEnvio['nombre']);	 
            $('#precio').val(this.datosParaEnvio['precioVenta']);
            $('#codProduto').val(this.datosParaEnvio['idProducto']);            
            $('#porcent_iva').val(this.datosParaEnvio['porcent_iva']);
            
            $('#cantidad').focus();
            id_grupo_producto_activo = this.datosParaEnvio['idGrupo'];
            Global_preventa = this.datosParaEnvio['precioVenta'];
            Global_PsIVA = this.datosParaEnvio['PsIVA'];
            Global_IVA =  this.datosParaEnvio['IVA'];
            Global_porcent_IVA =  this.datosParaEnvio['porcent_iva'];
            if(this.datosParaEnvio['tipo_producto'] == 'MT')
            {
                $('#cantidad_producto').prop('readonly', true);
               
                listar_tipos_medidas_creadas();
                 $('#porcent_iva').val(Global_porcent_IVA) ;
            }else{
                $('#cantidad_producto').val(0)//.attr('readonly', true);
                $('#cantidad_producto').prop('readonly',false);
                $('#cantidad_producto_real').val(0)
                $('#Presio_sin_iva_producto').val(Global_PsIVA)
                $('#iva_producto').val(Global_IVA)
                $('#Presio_producto').val(Global_preventa) 
            }
           // $("#precio").trigger("keyup");
        break;
}	}
	
	
	
function list_res_prov(){//evalua la respuesta recibida para listar los colores
console.log(this.req.responseText);
let respuesta_json = this.req.responseText;
let objeto_json = eval("("+respuesta_json+")");
let num_filas = objeto_json.filas;
if (num_filas>0){
	console.log('INICIO DE CARGUE EN TABLA');
	let texto="";
	let encabezados =['idCliente','nit' ,'nombre' ,'razonSocial','telefono' ,'direccion','email' ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewSuc','tablasListaproveedores','indiceListaproveedores','listarTablasucursales',0,16,false,false,false,false,llenaEditProv,false);
	$('#tablasListaproveedores').append(texto);
}else {
	let texto="Todavía no se encuentra registrado ningun cliente en la base de datos, para registrar haga click <span id='nuevoCliente' class='menu_click'>aqui.</span>	";
	texto=texto+"<script type='text/javascript'>$(this).unbind('click'); $('#nuevoCliente').click(function(){jQuery.colorbox.close();$('#bt1').trigger('click');});</script>";
	
	$('#tablasListaproveedores').html(texto);
	}
	}	
	
	
function list_res_Cli(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
let objeto_json = eval("("+respuesta_json+")");
let num_filas = objeto_json.filas;
if (num_filas>0){
	let texto="";
	let encabezados =['idCliente','nit' ,'nombre' ,'razonSocial','telefono' ,'direccion','email' ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewSuc','tablasListaclientes','indiceListaclientes','listarTablasucursales',0,16,false,false,false,false,llenaEditCli,false);
	$('#tablasListaclientes').append(texto);
}else {
	let texto="Todavía no se encuentra registrado ningun cliente en la base de datos, para registrar haga click <span id='nuevoCliente' class='menu_click'>aqui.</span>	";
	texto=texto+"<script type='text/javascript'>$(this).unbind('click'); $('#nuevoCliente').click(function(){jQuery.colorbox.close();$('#bt1').trigger('click');});</script>";
	
	$('#tablasListaclientes').html(texto);
	}
	}	
		
	
function list_res_Art(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
//alert(respuesta_json)
let objeto_json = eval("("+respuesta_json+")");

let num_filas = objeto_json.filas;
if (num_filas>0){
	let texto="";
	let encabezados =['codigo','nombre','cantidad'  ,'presentacion','presioVenta' ,'presioCompra','grupo' ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewArt','tablasListaarticulo','indiceListaarticulo','listarTablaarticulo',0,16,false,false,false,false,llenaEditArt,false);
	$('#tablasListaarticulo').append(texto);
}else {limpia_linea('tablasListaarticulo','indiceListaarticulo');
	let texto="Todavía no se encuentra registrado ningun sucursal en la base de datos, para registrar haga click <span id='nuevoSucursales' class='menu_click'>aqui.</span>";
	
	$('#tablasListaarticulo').html(texto);
	}
	}
	
function list_res_inventario(){//evalua la respuesta recibida para listar inventario
let respuesta_json = this.req.responseText;
//alert(respuesta_json)
let inventario=$("#inventario").val();
//alert(inventario)
let objeto_json = eval("("+respuesta_json+")");
let num_filas = objeto_json.filas;
if (num_filas>0){
	let texto="";
	let encabezados =['idProducto','nombreProducto','totalCantidad'  ,'Pventa' ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNew'+inventario,'tablasLista'+inventario,'indiceLista'+inventario,'listarTabla'+inventario,0,16,"idProductoIngreso");
	$('#tablasLista'+inventario).append(texto);
}else {limpia_linea('tablasLista'+inventario,'indiceLista'+inventario);
	let texto="Todavía no existe ninguna existencia de articulo en el inventario, por favor ingrese primero una compra o una entrada";
	
	$('#tablasLista'+inventario).html(texto);
	}
	}	
	
	
	
function list_res_Grup(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
//alert(respuesta_json)
let objeto_json = eval("("+respuesta_json+")");
let num_filas = objeto_json.filas;
if (num_filas>0){
	let texto="";
	let encabezados =['id_grupo','nom_gr' ,'descripcion','descripcion2'  ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewgrupos','tablasListagrupos','indiceListagrupos','listarTablagrupos',0,16,false,false,false,false,llenaEditGrup,false);
	$('#tablasListagrupos').append(texto);
}else {limpia_linea('tablasListagrupos','indiceListagrupos');
	let texto="Todavía no se encuentra registrado ningun grupo en la base de datos, para registrar haga click <span id='nuevoSucursales' class='menu_click'>aqui.</span>";
	
	$('#tablasListagrupos').html(texto);
	}
	}
	
function list_res_Forma(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
//alert(respuesta_json)
let objeto_json = eval("("+respuesta_json+")");
let num_filas = objeto_json.filas;
if (num_filas>0){
	let texto="";
	let encabezados =['id_forma','nom_forma' ,'descripcion' ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewforma','tablasListaforma','indiceListaforma','listarTablaforma',0,16,false,false,false,false,llenaEditForma,false);
	$('#tablasListaforma').append(texto);
}else {limpia_linea('tablasListaforma','indiceListaforma');
	let texto="Todavía no se encuentra registrado ningun grupo en la base de datos, para registrar haga click <span id='nuevoSucursales' class='menu_click'>aqui.</span>";
	
	$('#tablasListaforma').html(texto);
	}
	}
	
function imprimirSelec(nombre,tempImpresion)
{  tempImpresion=tempImpresion||'<style>.ui-widget-content{border:1px solid #a6c9e2;background:#fcfdfd url(http://v3es.sftcdn.net/shared/img/jqueryui/ui-bg_inset-hard_100_fcfdfd_1x100.png) 50% bottom repeat-x;color:#222}.ui-widget-content a{color:#222}.ui-widget-header{border:1px solid #4297d7;background:#5c9ccc url(http://v2es.sftcdn.net/shared/img/jqueryui/ui-bg_gloss-wave_55_5c9ccc_500x100.png) 50% 50% repeat-x;color:#fff;font-weight:bold}.ui-widget-header a{color:#fff}.ui-state-default,.ui-widget-content .ui-state-default{border:1px solid #c5dbec;background:#dfeffc url(http://v2es.sftcdn.net/shared/img/jqueryui/ui-bg_glass_85_dfeffc_1x400.png) 50% 50% repeat-x;font-weight:bold;color:#2e6e9e;outline:0}.ui-widget-lokc-content { border: 1px solid  #999; background: #CCC url(images/ui-bg_inset-hard_100_fcfdfd_1x100.png) 50% bottom repeat-x; color: #960; }.tdFactura{color: #960; font-weight: bold; font-family: Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif; background: #CCC }</style>';
 $(nombre).each(function(){		  
			 tempImpresion=tempImpresion+$(this).html();
			 			});
 let printscreen = window.open('','','left=100,top=1,width=800,height=600,toolbar=0,scrollbars=0,status=0');
printscreen.document.write(tempImpresion);
printscreen.document.close();
printscreen.focus();
printscreen.print();
printscreen.close();
 
}
		
function list_res_Color(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
//alert(respuesta_json)
let objeto_json = eval("("+respuesta_json+")");
let num_filas = objeto_json.filas;
if (num_filas>0){
	let texto="";
	let encabezados =['id_color','c_name' ,'descripcion' ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewcolores','tablasListacolores','indiceListacolores','listarTablacolores',0,16,false,false,false,false,llenaEditForma,false);
	$('#tablasListacolores').append(texto);
}else {limpia_linea('tablasListacolores','indiceListacolores');
	let texto="Todavía no se encuentra registrado ningun grupo en la base de datos, para registrar haga click <span id='nuevoSucursales' class='menu_click'>aqui.</span>";
	
	$('#tablasListacolores').html(texto);
	}
	}	
	
function FullScreenSupportEnabled() {
    return (document.fullscreenEnabled || 
            document.webkitFullscreenEnabled || 
            document.mozFullScreenEnabled ||
            document.msFullscreenEnabled);
}



function elimina_articulo(dato,restaurar){
    
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ARTICULO");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  datos= datos +"&tabla="+encodeURIComponent($('#tabla_actual').val())
                  if (restaurar != '')
                  {datos= datos +"&"+restaurar+"=true"}
		  datos= datos  +"&columna="+encodeURIComponent($('#tabla_actual').data('columna'));
        let url = $('#url_base_aplicacion').val()
         url = url +'EliminaX.php';
         
	$.ajax({
			url: url,  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			//alert(responseText)
			 window.location.reload()
			}
					});
			
			
		}
	}

function list_res_Cartera(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
let objeto_json = eval("("+respuesta_json+")");
//alert(respuesta_json)
let num_filas = objeto_json.filas;
if (num_filas>0){
	let encabezados =['idCuenta','descripcion' ,'fechaIngreso','valorInicial' ,'abonoInicial' ,'numCuotas','valorCuota','TotalActual'];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewCartera','tablasListaCartera','indiceListaCartera','listarTablaCartera',0,15,false,false,false,false,CargaPagCartera,false,false,false,false,'nombre');
}else {
    limpia_linea('tablasListaCartera','indiceListaCartera');
	let texto="no se encuentra registrada ningun Cartera en la base de datos";
		$('#tablasListaCartera').html(texto);
	}
	}
	
	function list_res_pacientes_2(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
let objeto_json = eval("("+respuesta_json+")");
let num_filas = objeto_json.filas;
if (num_filas>0){
	let encabezados =['nit','nombre' ,'apellido'  ,'telefono','email'  ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewPac','tablasListaclientes','indiceListaclientes','listarTablaclientes',0,15,"codigoCliente",false,false,false,false,false);
}else {
	let texto="encuentra registrado ningun paciente en la base de datos";
		$('#tablasListaPaciente').html(texto);
	}
    }
    

function list_res_Credito(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
let objeto_json = eval("("+respuesta_json+")");
console.log(respuesta_json)
let num_filas = objeto_json.filas;
if (num_filas>0){
	let encabezados =['idCuenta','descripcion' ,'fechaIngreso','valorInicial' ,'abonoInicial' ,'numCuotas','valorCuota','TotalActual'];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewCredito','tablasListaCredito','indiceListaCredito','listarTablaCredito',0,15,false,false,false,false,CargaPagCredito,false,false,false,false,'nombreProveedor');
}else {limpia_linea('tablasListaCredito','indiceListaCredito');
	let texto="encuentra registrado ningun Credito en la base de datos";
		$('#tablasListaCredito').html(texto);
	}
	}
        
 
function list_res_proveedores(){//evalua la respuesta recibida para listar los colores
let respuesta_json = this.req.responseText;
let objeto_json = eval("("+respuesta_json+")");
console.log(respuesta_json)
let num_filas = objeto_json.filas;
if (num_filas>0){
	let encabezados =['nit','razonSocial'  ,'telefono','email'  ];
let cargadorLista= new T_find.CargadorContenidos(objeto_json,encabezados,'normalNewPac','tablasListaproveedores','indiceListaproveedores','listarTablaproveedores',0,13,"codigoProveedor",false,false,false,false,false);
}else { 
	let texto="encuentra registrado ningun paciente en la base de datos";
		$('#tablasListaproveedores').html(texto);
	}
	
	}
        
        
function isInPage(node) {
    let span = document.getElementById(node);
  return (node === document.body) ? false : document.body.contains(span);
}

function add_evento_nav_lista_medidas(){
     $('.flechas_medidas').unbind('click').click(function(){
                                            let numero ;
                                             switch($(this).data('movimiento')){
                                                case 'adelante':
                                                    numero =  $(this).data('numero') + 1
                                                break;
                                                case 'atras':
                                                    numero =  $(this).data('numero') - 1
                                                break;
                                            }
                                            
                                            let id_verificar = 'cont_medidas_'+numero;
                                            if(!isInPage(id_verificar)){
                                               numero = 1; 
                                            }
                                            $('.contador_contenedores').html(numero)
                                            $('.flechas_medidas').data('numero',numero)
                                            id_verificar = 'cont_medidas_'+numero;
                                            $('.contenedores_medidas').hide();
                                             $('#'+id_verificar).show();
                                            
                                           
                                            
                                        })
     $('.flechas_medidas').first().trigger('click');
}


function esEntero(numero , tnum){
if(tnum == ''){tnum = 'entero';}
let tipo_numero ='';
    if (isNaN(numero)){
       return false;
    } else {
        if (numero % 1 == 0 ) {
           tipo_numero = 'entero';
        } else {
            tipo_numero = 'float';
        }
		if (tnum == tipo_numero)
		{return true;}
		else{return false;}
    }
}

function validar(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) alert ('Has pulsado enter');
}

function cargar_modal_retefuente_variable(){
    
    let modal = '<button id="retefuentevarible" type="button" class="btn btn-primary hidden" data-toggle="modal" data-target="#modalRetefuenteVariable"> ++++</button>'+
'<!-- Modal --><div class="modal fade" id="modalRetefuenteVariable" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
  '<div class="modal-dialog" role="document">'+
    '<div class="modal-content">'+
     ' <div class="modal-header">'+
      '  <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>'+
       ' <button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
        '  <span aria-hidden="true">&times;</span>'+
        '</button>'+
      '</div>'+
      '<div class="modal-body">'+
     ' <div class="row">'+
     ' <div class="col-md-4">Retefuente actual : </div>'+
     ' <div class="col-md-4 ml-auto" id="miRetefuente"></div>'+
     ' </div>'+ 
     ' <div class="row">'+
     ' <div class="col-md-4">nueva Retefuente : </div>'+
     ' <div class="col-md-4 ml-auto"><input type="text" onkeypress="return NumCheck(event, this,\'float\')" class="" value="" id="retefuente_nueva"></div>'+
     ' </div>'+      
      '</div>'+
     ' <div class="modal-footer">'+
      '  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>'+
       ' <button type="button" id="enviarVentaRetefuente" class="btn btn-primary">Finalizar venta</button>'+
     ' </div>'+
    '</div>'+
  '</div>'+
'</div>';

$('#cuerpoFactura').append(modal);
    
}