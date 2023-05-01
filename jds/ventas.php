<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 
?>
<!doctype html>
<html>
<head>
<title>ventas</title>
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" src="jsFiles/trim.js" language="javascript1.1" ></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="jsFiles/fullScreen.js"></script>
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
$("#full").fullscreen();
	////////modulo busqueda
	$(document).keydown(function(e){
		//alert(e.keyCode)
		var tecla=e.keyCode;
		if(tecla==27){$("#cerrarBuscar").trigger("click");
		$("#cerrarConf").trigger("click");
	}
	if(tecla==113){$('#inicioBuscar').trigger("click");
	}
	if(tecla==115){$("#config").trigger("click");
	}
	});
	
	
	$("#busqueda").keyup(function(){
	$('#frameBusqueda').attr('src',"busquedaFrame.php?id="+encodeURIComponent($(this).val())+"&nocache=" + Math.random());});
	$("#cerrarBuscar").click(function(){
		$("#busquedaArticulo").css("display","none")
		});	
	$('#limpiar').click(function(){
	$("#busqueda").val('');	
	$('#frameaux').attr('src',"busquedaFrame.php");
	})
	$('#inicioBuscar').click(function(){
		$("#limpiar").trigger("click");
			OcultaYMuestra("","#busquedaArticulo");
			});	
	///////fin modulo		
	$('#abrirCajon').click(function(){
			$.ajax({
						url: 'abrirCaja.php',  
						type: 'POST',
						
						data: false,
						});
			});	
	var cantAct;
	$("#suma10").click(function(){
		var venta=parseInt($("#cantidadVenta").val());
		venta=venta+10;$("#cantidadVenta").val(venta);
		var cantActual=parseInt($("#cantActualArt").val());
		if(cantActual<venta){
		r = confirm("Esta intentando facturar por ensima de la existencia actual del producto, desea facturar la existencia actual del producto o desea cancelar la venta");
		if(r==true){$("#cantidadVenta").val(cantActual);enviar();}
		else{$("#cerrarliquidar").trigger("click");}
		}

		});
		$("#guardarliquidar").click(function(){
			$("#cantidadVenta").val()
			if($("#cantidadVenta").val()!="0"){
				enviar();
				}
		});
				$("#cerrarliquidar").click(function(){
				$("#liquidar").css("display","none");
				 $(".filasData").removeAttr('disabled');	
				 $(".calculadora").removeAttr('disabled');
				 $("#suma10").removeAttr('disabled');
				 if($("#cantidadVenta").val()!="0"){$('input.gruposBT:first').trigger("click");}
				 $("#cantidadVenta").val(0)	
				//selecciona el primer elemento input que contenga la clase gruposBT
				});
				 
			$("#organizador").change(function(){
			$(".orden").css("display","none")
			//alert($(this).val());
			$("#"+$(this).val()).css("display","inline")
			if($(this).val()=="menuGrupos"){
				$('input.gruposBT:first').trigger("click");//selecciona el primer elemento input que contenga la clase gruposBT
				}else{ 
				$('input.labBT:first').trigger("click");//selecciona el primer elemento input que contenga la clase gruposBT
				 }
			}) 
			$('.gruposBT').click(function(){
				datos='idGrupo='+encodeURIComponent($(this).attr('id'))
				$("#grupoSelect").val($(this).attr('id'));
				$('#frame1').attr('src', 'listadoVentasNuevo.php?columna=idGrupo&dato='+$(this).attr('id'));
				});
			$('.labBT').click(function(){
				datos='idLab='+encodeURIComponent($(this).attr('id'))
				$("#grupoSelect").val($(this).attr('id'));
				$('#frame1').attr('src', 'listadoVentasNuevo.php?columna=idLab&dato='+$(this).attr('id'));
				});
			
			$('.combos').click(function(){
				$("#grupoSelect").val("combos");
				$('#frame1').attr('src', 'listadoCombos.php');
				});
			
		$('.calculadora').click(function(){r=true;
				var venta=parseInt($("#cantidadVenta").val());
				venta=venta+parseInt($(this).val());$("#cantidadVenta").val(venta);
				var cantActual=parseInt($("#cantActualArt").val());
				var peticionCant=parseInt($("#cantidadVenta").val());
				if(cantActual<peticionCant){
				 r = confirm("Esta intentando facturar por ensima de la existencia actual del producto, desea facturar la existencia actual del producto o desea cancelar la venta");
				 	if(r==true){$("#cantidadVenta").val(cantActual);}
					else{$("#cantidadVenta").val(0);}
					}
				if(r == true)
				{if($("#grupoSelect").val()=="combos"){
					enviarCombo();
					}else{enviar();}}else{
			$("#cantidadVenta").val(0);
			$("#cerrarliquidar").trigger("click");}
				});
////////////////////////////////////////////////////////////////////////////////////				
			OcultaYMuestra("#Mostrar");
//////////////////////////////////////////////////		
$("#config").click(function(){OcultaYMuestra("","#configuracion");});
$("#cerrarConf").click(function(){OcultaYMuestra("#configuracion");});
		iniciaFactura()	
		
////////inicio//////
//String.fromCharCode(e.which)
$("#ingresoCliente :input").keypress(function(e){
		//alert(e.which)
		var tecla=e.which;
				if (tecla==13){
					if($("#auxNombre").val()!=""){var llamado;
						if($("#llamado").val()=="actualizacion"){llamado="actualizar";}else{llamado="crear";}	
				var datosAjax='idCliente='+encodeURIComponent($("#id").val())
				+'&nit='+encodeURIComponent($("#nombreidCliente").val())
				+'&nombre='+encodeURIComponent($("#auxNombre").val())
				+'&razonSocial='+encodeURIComponent($("#auxNombre").val())
				+'&telefono='+encodeURIComponent($("#auxTelefono").val())
				+'&email='+encodeURIComponent($("#auxEmail").val())
				+'&IdVenta='+encodeURIComponent($("#IdVenta").val())
				+'&procesoDB='+encodeURIComponent(llamado)
				+'&llamado='+encodeURIComponent("agregar")
				+"&nocache=" + Math.random();
				//alert(datosAjax);
				$.ajax({
						url: 'agregaPaciente.php',  
						type: 'POST',
						
						data: datosAjax,
 						success: function(data) {
							location.reload();
								}	
					});
						}else{
					alert("el nombre no debe estar en blanco")
					$("#auxNombre").focus()
					}}});
$("#nombreidCliente").keypress(function(e){
		//alert(e.which)
		var tecla=e.which;
				if (tecla==13){
				if(Trim($("#nombreidCliente").val())==""){}
				else{
				var llamado
				if($("#llamado").val()=="actualizacion"){llamado="actualizar";}else{llamado="revisar";}	
				var datosAjax='idCliente='+encodeURIComponent($(this).val())
				+'&IdVenta='+encodeURIComponent($("#IdVenta").val())
				+'&llamado='+encodeURIComponent(llamado)
				+"&nocache=" + Math.random()
                        
                               //console.log(datosAjax);
				$.ajax({
						url: 'agregaPaciente.php',  
						type: 'POST',
						
						data: datosAjax,
						 dataType: "json",
 						success: function(data) {
								var datos=data["datos"];
								var filas=data["filas"];
								var error=data["error"];
							if(filas !=0){
								location.reload();
								}else{
								if(error!=""){
								 r = confirm(error);
							if(r==true){crearId('clientes','#id')	
								OcultaYMuestra("","#ingresoCliente");
								$("#auxNombre").focus()}
							}}}
			});	
				}
				}
	});
	$("#cambiaCliente").click(function(){
		$("#llamado").val("actualizacion");
		OcultaYMuestra("#contenedorPrincipal","#divCliente"); 
$("#nombreidCliente").focus();})
////////////////la funcion que muestra los modulos de venta o de ingreso del cliente esta en listapedido//
		 }); /////////////////////
 
function enviarCombo(){
	 var valorTotal= parseInt($("#cantidadVenta").val())*parseInt($("#presioVenta").val());
				datosAjax='codMesa='+encodeURIComponent($("#mesaActiva").val())
				+'&IdVenta='+encodeURIComponent($("#IdVenta").val())
				+'&idProducto='+encodeURIComponent($("#idProducto").val())
				+'&nombreProducto='+encodeURIComponent($("#nombreProducto").val())
				+'&presioVenta='+encodeURIComponent($("#presioVenta").val())
				+'&cantidadVendida='+encodeURIComponent($("#cantidadVenta").val())
				+'&mesaActivada='+encodeURIComponent($("#MA").html())
				+'&valorTotal='+encodeURIComponent(valorTotal)
				+"&nocache=" + Math.random()
				$.ajax({
            url: 'guardarCombos.php',  
            type: 'POST',
         	
            data: datosAjax,
            beforeSend: function(){
                $(".filasData").attr("disabled","disabled")		      
            },//una vez finalizado correctamente
            success: function(responseText){
			$("#contenedor").html(responseText);
               $(".filasData").removeAttr('disabled');
			   $("#cerrarliquidar").trigger("click")
			 },
            //si ha ocurrido un error
            error: function(){
                message = $("no se pudo insertar el producto en este momento");
               alert(message);
			$("#cerrarliquidar").trigger("click")            
			}
        })
	 }	 
 /////////////////
 function iniciaFactura(){
			var datosAjax='mesaid='+encodeURIComponent("M1")+"&mesaActivada="+encodeURIComponent("LOCAL 1")+"&nocache=" + Math.random();
			$("#mesaActiva").val("M1")
			$.ajax({
            url: 'listaPedido.php',  
            type: 'POST',
         	async: true,
            data: datosAjax,
            beforeSend: function(){
                $(".filasData").attr("disabled","disabled")
			 },
            //una vez finalizado correctamente
            success: function(responseText){
				$("#contenedor").html(responseText);
			    $(".filasData").removeAttr('disabled');
            },//si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                alert(message);
            }
        });}
 ///////////////////
function enviar(){
	var valorTotal= parseInt($("#cantidadVenta").val())*parseFloat($("#presioVenta").val());
				datosAjax='codMesa='+encodeURIComponent($("#mesaActiva").val())
				+'&IdVenta='+encodeURIComponent($("#IdVenta").val())
				+'&idProducto='+encodeURIComponent($("#idProducto").val())
				+'&nombreProducto='+encodeURIComponent($("#nombreProducto").val())
				+'&presioVenta='+encodeURIComponent($("#presioVenta").val())
				+'&porcent_iva='+encodeURIComponent($("#porcent_iva").val())
				+'&PsIVA='+encodeURIComponent($("#PsIVA").val())
				+'&IVA='+encodeURIComponent($("#IVA").val())
				+'&cantidadVendida='+encodeURIComponent($("#cantidadVenta").val())
				+'&mesaActivada='+encodeURIComponent($("#MA").html())
				+'&valorTotal='+encodeURIComponent(valorTotal)
				+'&usuario='+encodeURIComponent("ADMINISTRADOR")
				+"&nocache=" + Math.random()
				$.ajax({
            url: 'guardarVentas.php',  
            type: 'POST',
         	
            data: datosAjax,
            beforeSend: function(){
                $(".filasData").attr("disabled","disabled")		      
            },
            //una vez finalizado correctamente
            success: function(responseText){
				var aux="#"+Trim(responseText);
				//$("#mostrar").html(responseText);
				iniciaFactura()	
			    $(".filasData").removeAttr('disabled');
			   $("#cerrarliquidar").trigger("click")
			   
			 },
            //si ha ocurrido un error
            error: function(){
                message = $("no se pudo insertar el producto en este momento");
               alert(message);
			$("#cerrarliquidar").trigger("click")            
			}
        })
	 }	
</script> 
<link media="screen" rel="stylesheet" href="css/menuDesplegable.css" />
<style>
input[type="text"] {
    font-family: Arial, san-serif;  font-size:24px
}
.calculadora{ height:50px; width:50px}
#suma10{ height:50px; width:50px}
#cantidadVenta{height:50px; width:220px; 
}
#liquidar{padding: 10Px; color: #ffffff; font-weight: bold; position: absolute; background-color: #006699; z-index: 5; left: 50%; top: 200px; width: 250px; height: 339px; display:none}

#busquedaArticulo{padding: 10Px; color: #ffffff; font-weight: bold; position: absolute; background-color: #065; z-index: 5; left: 25%; top: 80px;  display:none}
 
.gruposBT{ background-color:#069; color:#CCC; height:40px; font-weight:bold}
.labBT{ background-color:#069; color:#CCC; height:40px; font-weight:bold}
.combos{ background-color:#069; color:#CCC; height:40px; font-weight:bold}
.facturasBT{ background-color:#069; color:#CCC; height:40px; font-weight:bold}
a{ text-decoration:none; color:#006699}
#tabConf td{ background-color:#7DA2FF}
#tabConf #nop{ background-color: #006699;}
.busqueda{ font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
#divCliente {font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
label{font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif; color: #FC0}
iframe{ border:none}
</style>
</head><body ><div id="contenedorPrincipal">
<input type="hidden" value="" id="cantActualArt">
<input type="hidden" value="" id="mesaActiva">
<input type="hidden" id="llamado">
<div id="mostrar"></div>
<?php 
include 'db_conection.php';
$mysqli = cargarBD();
$query="SELECT * 
FROM  `mesas` ORDER BY  `mesas`.`numero` ASC  ";
$html="";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
while ($row = $result->fetch_assoc()) {
	$html=$html.'<li><a  title="mesas en operacion"   class="menu1"   id="'.$row['codMesa'].'" name="MESA  #'.$row['numero'].'"   >MESA #'.$row['numero'].'</a>	</li>';
	}
?>
<div align="center">
<input type="hidden" id="nombreCliente" class="cliente" name="nombreCliente" ><input type="hidden" id="idCliente" class="cliente" name="idCliente"  >
<table width="1355"  style="border: #993 thin ">
<tr>
<td  align="center" width="411">(f2-busqueda)(f4-menu config.)<br><input type="image"  src="imagenes/pantallaCompleta2.jpg"	title="pasar a pantalla completa" height="45" id="full"> <input type="image"title="configuracion de articulos y ventas"  src="imagenes/configuracion.jpg" height="50" id="config">  &nbsp;<input type="image" src="imagenes/16325437-lupa-buscar-en-la-base-de-datos-icono-aislado-en-blanco.jpg" height="50" title="busqueda de articulos" id="inicioBuscar">&nbsp; <a href="index.php"><input type="image" src="imagenes/home_w.png" height="55" title="regresar a menu de inicio"></a><input type="image" src="imagenes/cambiaCliente.png" height="55" title="cambiar el cliente" id="cambiaCliente" ></td>
<td valign="middle" colspan="2"><div style="background-color: #069; margin-top:3px; margin-bottom:3px; padding:3px ; color:#FFF; font-size:23px" ><label>CLIENTE:</label>
<span id="spanCliente"></span>  <label>| AGRUPAR POR:</label>
<select id="organizador" ><option value="menuGrupos">GRUPO</option><option value="menuLab">POR MARCAS</option></select> 
<label>| TIPO DE VENTA: </label><select id="tipoVenta" ><option value="EFECTIVO"> DE CONTADO</option><option value="CREDITO"> A CREDITO</option><option value="DATAFONO"> CON DATAFONO</option></select> </div>
<div class="orden" id="menuGrupos"><?php 
$query="SELECT * FROM  `grupo` ;";
$result = $mysqli->query($query);	
$i=0;
while ($row = $result->fetch_assoc()) {
	$GrupoInicial[$i]=$row['idGrupo'];
	echo'<input type="button" id="'.$GrupoInicial[$i].'" class="gruposBT" value=" '.$row['GRUPO'].' ">';
		$i++;}
echo'<input type="button" class="combos"  value=" COMBOS ">';
		
///////////////////////////////////////////////////////////////////////////////					
	
echo'<input type="hidden" value="'.$GrupoInicial[0].'" id="grupoSelect">';
?></div>
<div id="menuLab" class="orden" style="display:none">
<?php 
$query="SELECT * FROM  `marcas` ;";
$result = $mysqli->query($query);	
$i=0;
while ($row = $result->fetch_assoc()) {
	$LabInicial[$i]=$row['idlab'];
	echo'<input type="button" id="'.$LabInicial[$i].'" class="labBT" value=" '.$row['laboratorio'].' ">';
		$i++;}
echo'<input type="button" class="combos"  value=" COMBOS ">';//////////////////////////////////////////////////////////////////////////////					
	
echo'<input type="hidden" value="'.$LabInicial[0].'" id="LabSelect">';
?>
</div>
</td>
</tr>
  
  <tr>
    <td  valign="top" bgcolor="#CCCCCC" style="padding:5px">
    <table width="100%" style="color: #039; font-size:17px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
    <tbody id="contenedor">
    <tr><td width=""height="630" align="center" id="ayudame">SELECCIONE UNA MESA</td></tr></tbody>
    </table>
     </td>
    <td colspan="2" width="930"valign="top" >
    
    <div id="listado"  >
   
<iframe id="frame1" src="listadoVentasNuevo.php" width="100%" height="635"></iframe>
</div>
 <div id="script" style="padding:10" >
</div>
    </td>
  </tr>
</table></div>
<div id="liquidar"style="" >
<table border="0"  width="100%">
<tr>
<td colspan="3" ><div align="right">
  <label>
  <input type="image" width="20"  height="20"name="cerrarBoton" id="cerrarliquidar"  title="cerrar" src="imagenes/close-panel-png-md.png" />
  </label>
</div></td>
</tr>
<tr><td height="65" colspan="3" align="center"> <input type="text" value="0" id="cantidadVenta" disabled ></td></tr>
<tr>
<td align="center" height="60"><input type="button" value="1" class="calculadora"/></td>
<td align="center"><input type="button" value="2" class="calculadora"/></td>
<td align="center"><input type="button" value="3" class="calculadora"/></td>
</tr>
<tr>
<td align="center" height="60"><input type="button" value="4" class="calculadora"/></td>
<td align="center" ><input type="button" value="5" class="calculadora"/></td>
<td align="center"><input type="button" value="6" class="calculadora"/></td>
</tr>
<tr>
<td align="center" height="60"><input type="button" value="7" class="calculadora"/></td>
<td align="center"><input type="button" value="8" class="calculadora"/></td>
<td align="center"><input type="button" value="9" class="calculadora"/></td>
</tr>
<tr>
<td colspan="2" align="center" height="60"><input type="button" value="+10" id="suma10" style="width:145px"/> </td><td><input type="image"  id="guardarliquidar" class="" title="aceptar" height="50" width="50"  src="imagenes/accept (2).png"/></td>

</tr>

</table>

</div>

<div id="busquedaArticulo" style="width:650px; height:500px">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="busqueda">BUSQUEDA</span> <input type="text" id="busqueda" class="busqueda" size="40">&nbsp;&nbsp;&nbsp;<input type="image" src="imagenes/cerrar.png" height="20" width="20" id="limpiar"> <input type="image" width="20"  height="20"name="cerrarBoton" id="cerrarBuscar"  title="cerrar" src="imagenes/close-panel-png-md.png" />
<iframe id="frameBusqueda" align="top" style="border:none" src="ventas/busquedaFrame.php" height="90%" width="100%"></iframe>
</div></div>
<div id="divCliente" align="center" style="padding-top:300px">
<a href="index.php"><img src="imagenes/BOTON_VOLVER_MENU3.png" width="142" height="42"></a><a href="login/index.php"><img src="imagenes/botonNewSalirGris.png" width="66" height="65"><a>
<br>
(presione f4-menu config.)<br>
<span>Codigo del cliente </span><input type="text" id="nombreidCliente">
<div id="ingresoCliente" style="display:none">
<table><tr>
<td align="right"><span>Id</span></td><td><input id="id" type="text" disabled></td></tr><tr>
<td><span>Nombre</span></td><td><input id="auxNombre" type="text"></td></tr><tr>
<td align="right">Telefono</span></td><td><input id="auxTelefono" type="text"></td></tr><tr>
<td align="right"><span>Email</span></td><td><input id="auxEmail" type="email" style="
    font-family: Arial, san-serif;  font-size:24px"></td></tr><tr><td colspan="2" align="center"><input type="image" id="enterCliente" src="imagenes/accept (3).png" width="50" height="35"></td></tr>
</table>
</div>


</div>
<div id="configuracion" align="center" style="font: 15px  'Trebuchet MS', sans-serif; padding:10Px;color: #ffffff; font-weight: bold;position:absolute; background-color:#006699;z-index: 5;left: 30%; top:200px; width:400px; height:320px; display:none">
<table align="center" id="tabConf" width="390px">
<tr><td  align="right" colspan="2" id="nop"> <input type="image" src="imagenes/close (1).png" id="cerrarConf"></td></tr>

<tr><td align="center"><a href="grupos.php"><br/><input type="image" src="imagenes/icono_grupo.jpg" height="50" title="VISTA Y CREACION DE GRUPOS"><br/>GRUPOS</a></td> 
<td align="center"><a href="laboratorio.php"><br/><input type="image" src="imagenes/lab.jpg" height="50" title="VISTA Y CREACION DE MARCAS"><br/>MARCAS</a></td></tr>

<tr><td align="center"><a href="productosVendidos.php"><br/><input type="image"  src="imagenes/ICOVENTAS2.jpg" height="50" title="REVISION DE LOS PRODUCTOS VENTIDOS EN DETERMINADA FECHA"><br/>PRODUCTOS VENDIDOS</a></td> <td align="center"><a href="resumenCaja.php"><br/><input type="image" src="imagenes/resumen.jpg" height="50" title="RESUMEN DE LA CAJA"><br/>RESUMEN DE CAJA</a></td></tr>

<tr><td align="center"><a href="cierreCaja.php"><br/><input type="image" src="imagenes/cierre de caja.jpg" height="50" title="CIERRE DE CAJA"><br/>CIERRE DE CAJA</a></td><td align="center"><input type="image" src="imagenes/cajon.jpg"  height="50" title="ABRIR CAJON" id="abrirCajon"></td> </tr>
</table>
</div>

</body></html>
