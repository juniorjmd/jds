<?php 
include 'php/inicioFunction.php';
include 'db_conection.php';
verificaSession_2("login/");
date_default_timezone_set("America/Bogota"); 

 $conn= cargarBD();
$usuarioID=$_SESSION["usuarioid"];

$queryInicial = 'delete from listacompraedicion where idCompra = '.$jk567.' ;';
$conn->query($queryInicial);
$queryInicial = "insert into listacompraedicion SELECT null,  idCompra, idProducto, nombreProducto, presioCompra, cantidad, valorTotal,".
        " usuario, iva, porcent_iva, valorsiva,'E' ,idLinea ,cantidad FROM `listacompra` where `listacompra`.idCompra =  $jk567 ;";

//echo $queryInicial;
$conn->query($queryInicial);
$queryCompra 	=    " select compras.* , ifnull(credito.valorInicial,0) as 'valorInicial', "
					." ifnull(abonoInicial,0) as 'abonoInicial', ifnull(TotalInicial,0) as 'TotalInicial',  "
					." ifnull(TotalActual,0) as 'TotalActual', ifnull(valorCuota,0) as 'valorCuota' "
					." from compras left join credito on credito.idCuenta = compras.referencia where compras.idCompra = ".$jk567;	
					
$result = $conn->query($queryCompra);
//echo $queryCompra;
$row = $result->fetch_assoc();
if ($row['referencia'] == 'ninguno')
    {$tipo_de_compra 	= 		1;} 
else
    {$tipo_de_compra 	= 		2;}
$fechaIngreso 		= 		$row ['fecha'];
$provedor_id		= 		$row ['codPov'];
$total_venta 		= 		$row ['valorTotal'];
$abonoInicial		= 		$row ['abonoInicial'];
$referencia			= 		$row['referencia'] ;

$diferencia = $row['TotalInicial'] - $row['TotalActual'] ;
echo '<input type="hidden" value="'.$diferencia.'" name="difCredito" id="difCredito" />';

//# idCompra, codPov, cantidadVendida, valorParcial, descuento, valorTotal, fecha, usuario, estado, idCierre, referencia
//'1', '001', '2', '4000', '0', '4000', '2015-10-03', '9', 'revisado', '24', 'ninguno'

$query2="SELECT * FROM  `proveedores`  ";
$result = $conn->query($query2);
$provedor="";
$usuarioID=$_SESSION["usuarioid"];
while ($row = $result->fetch_assoc()) {
	if ($provedor_id == $row["nit"]){$check = 'selected'; }else{$check = ''; }
	$provedor=$provedor.'<option value="'.$row["nit"].'" '.$check.'>'.$row["razonSocial"].'</option>';
}
$result->free();
 
$conn->close();

 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Compras...</title>

<link href="ayuda/jquery-ui.css" rel="stylesheet">
<link media="screen" rel="stylesheet" href="css/colorbox.css" />
<style>
.boton{
        font-size:15px;
        font-family: "Arial Narrow";
        font-weight:bold;
        color:white;
        background: #993300;
        border:1px;
		border-color:white;
		cursor:pointer;

		}
.boton:hover {
        background:#CCC;
        border:1px;
		border-color:white;
		}
		#cancelar{ height:20px; width:150px; margin-left:10px; margin-top:5px}
#aceptar{ height:20px; width:150px; margin-left:10px; margin-top:5px}
#final{ height:20px; width:150px; margin-left:10px; margin-top:5px; float:left}

.Estilo1 {
	font-family: "Arial Narrow";
	color: #993300;
	font-weight: bold;
	font-size: 17px;
}
.Estilo2 {
	font-family: "Arial Narrow";
	font-size: 17px;
	color: #993300;
}

.venta {
background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}

select.text4 {   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}

input.text6 {   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}

.venta1 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta2 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta3 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta4 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta5 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta21 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta31 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta41 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta51 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta311 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.venta511 {background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}


</style>

<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script><link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
<script type="text/javascript" src="jsFiles/listas.js"></script>

<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script>
$(document).ready(function(){
	$("#cancelAll").click(function(e){
		auxCan=elimina($("#id_de_Compra").val());
		if(!auxCan){e.preventDefault();}
		});
$('#aceptar').click(function(e){
	e.preventDefault();
	var str="";
	var h=0;var datos_para_envio;
	datos_para_envio='id_de_Compra='+encodeURIComponent($("#id_de_Compra").val())
	+"&usuario=" + encodeURIComponent($("#usurio").val());
	 $(".venta").each(function() {$(this).focus();
	    if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;$(this).focus();
			 return false;
			}else{
				datos_para_envio=datos_para_envio+"&"+$(this).attr("name")+"="+encodeURIComponent(Trim($(this).val()));
				}
    });
	if(h==0){
		datos_para_envio=datos_para_envio+"&edit=ok" +"&nocache=" + Math.random();
		 
		$.ajax({
				url: 'saveCompra.php',  
				type: 'POST',
				
				data: datos_para_envio,
				success: function(respuesta){
					//alert(respuesta)
					if(respuesta==1)
					$('#frame1').attr('src', $('#frame1').attr('src'));
					$(".venta").val("")
					$("#nombreP").html("")
						}
					});
		}
});

$('#tipo_de_compra').val($('#tipo_de_compra_aux').val())
$('#tipo_de_compra').change(function(){
	if($('#tipo_de_compra_aux').val()=='2'){
		$('#tipo_de_compra').val($('#tipo_de_compra_aux').val())
	}
	});
$('#buscarProducto').click(function(e){
e.preventDefault();
//llenaBusqueda()
//regresar
	//limpia_linea('tablasListaArticulo','indiceListaArticulo');
		//	carga_listar(datos_json,respuesta_busqda_articulo);
$.colorbox({overlayClose:false, inline:true, href:"#busquedaArticulo",width:"750px", height:"400px"});
								});
$('#provedor').trigger('change');
$('#provedor').change(function(){
	$('#nombreprovedor').val($("#provedor option:selected").text());
});
$('#final').click(function(){
	var si=true;
	if( $("#fechaIngreso").val()==""  ){si=false; alert("DEBE ESCOGER UNA FECHA...."); return false}
	if($("#provedor").val()=="0"){si=false;alert("DEBE ESCOGER UN PROVEDOR....");  return false}
	if($("#tipo_de_compra").val()=="2"){ $("#credito").css("display","block"); 
		var datos_para_envio='id_de_Compra='+encodeURIComponent($("#id_de_Compra").val());
		$.ajax({
				url: 'revisaTotalCompra.php',  
				type: 'POST',
				
				data: datos_para_envio,
				success: function(respuesta){
					//alert(respuesta)
				$("#costoParcial").val(respuesta);
				$("#valCuotah").val(respuesta);
				$("#TotalInicialh").val(respuesta);
				$("#valCuota").html(respuesta);
				$("#TotalInicial").html(respuesta);
				
				}
					});
	si=false; return false}
	if(si){
	$("#enviar").trigger('click');
	}});

$("#precio").keyup(function(){
	if ((/^([0-9])*[.]?[0-9]*$/.test($(this).val()))&&(/^([0-9])*[.]?[0-9]*$/.test($("#cantidad").val()))){
	var valor=$(this).val()*$("#cantidad").val();
	$("#Tventa").val(valor);}else{$("#Tventa").val("");}
	});
	
$("#abono").keyup(function(){
	if (/^([0-9])*[.]?[0-9]*$/.test($(this).val())){
	var valor=$("#costoParcial").val()-$(this).val();
	$("#TotalInicial").html(valor);
	$("#valCuota").html(valor);
	$("#TotalInicialh").val(valor);
	$("#valCuotah").val(valor);
	}else{
		$("#TotalInicial").html($("#costoParcial").val());
		$("#valCuota").html($("#costoParcial").val());
		$("#TotalInicialh").val($("#costoParcial").val());
		$("#valCuotah").val($("#costoParcial").val());}
	});

$("#numeroCuotas").keyup(function(){var valor
	if ((/^([1-9])*$/.test($(this).val()))  &&  (Trim($(this).val())!="")){
	valor=parseInt($("#TotalInicialh").val())/parseInt($(this).val());
	}
	else{
		valor=$("#costoParcial").val();
	}$("#valCuotah").val(valor);$("#valCuota").html(valor);
	});	
	
$("#cantidad").keyup(function(){
	if ((/^([0-9])*[.]?[0-9]*$/.test($(this).val()))&&(/^([0-9])*[.]?[0-9]*$/.test($("#precio").val()))){
	var valor=$(this).val()*$("#precio").val();
	$("#Tventa").val(valor);}else{$("#Tventa").val("");}
	});
$("#precio").change(function(){
	$(this).trigger("keyup");
	
	
	});
$("#cantidad").change(function(){
	$(this).trigger("keyup");
	});
	
$("#codProduto").blur(function(){$("#precio").focus()})
	
$("#codProduto").keyup(function(){
	if (Trim($(this).val())!=""){
	var valor=$(this).val();
	var query ="SELECT * FROM  `producto` WHERE `idProducto` = " ;
	var datos_json = "query=" + encodeURIComponent(query) +
		"&dato=" + encodeURIComponent(valor) +
		"&iguales=" + encodeURIComponent('1') +
		"&respuesta=" + encodeURIComponent('producto') +
		"&where=" + encodeURIComponent('idProducto') +
		"&order=" + encodeURIComponent('-1') +
		"&nocache=" + Math.random();
		//					inicioListar(tabla,funcion,php,ordenar,columna,igual,dato,columna2,columna3) 
	$.ajax({
				url: 'php/db_listar.php',  
				type: 'POST',
				
				data: datos_json,
				success: function(respuesta){
						var objeto_json = eval("("+respuesta+")");
						var num_filas = objeto_json.filas;	
						if(num_filas>0){
						$('#InombreP').val(objeto_json.datos[0]['nombre']);	
						$('#nombreP').html(objeto_json.datos[0]['nombre']);
						$('#precio').val(objeto_json.datos[0]['precioCompra']);
						$('#codProduto').val(objeto_json.datos[0]['idProducto']);
						$("#precio").trigger("keyup");
						}else{$('#InombreP').val('');	
						$('#nombreP').html('');
						$('#precio').val('');
						$("#precio").trigger("keyup");}
					}
				});
		
	}
	});
	
});			 

function elimina(dato){
	r = confirm("REALMENTE DESEA CANCELAR LA COMPRA\n\rEsto borrara completamente la compra del sistema y reversara los productos ingresados.");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent("listacompra")
		  +"&columna="+encodeURIComponent('idCompra');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			//alert(responseText)
			}
		});
	}
	return r;
	}
	
</script>

</head>

<body>
<form action="listadoCompras.php?vtlme=<?PHP echo $jk567;?>&edicionCompra=ok" autocomplete="off" method="post">
<?php 
  
echo '<input type="hidden" value="'.$diferencia.'" name="difCredito" id="difCredito" />'
.'<input type="hidden" value="'.$referencia.'" name="referencia" id="referencia" />'
.'<input type="hidden" value="'.$tipo_de_compra .'" name="tipo_de_compra_aux" id="tipo_de_compra_aux" />'
.'<input type="hidden" value="'.$total_venta .'" name="total_venta_aux" id="total_venta_aux" />';


?>
<div id="credito" align="center" style="font: 15px  'Trebuchet MS', sans-serif; padding:10Px;color: #ffffff; font-weight: bold;position:absolute; background-color:#006699;z-index: 5;left: 30%; top:200px; width:400px; height:200px; display:none">
<table>
<tr>
<td>DEUDA PARCIAL</td>
<td><input type="text" name="costoParcial" id="costoParcial" disabled></td>
</tr>
<tr>
<td>ABONO INICIAL</td>
<td><input type="number" name="abono" id="abono" value='<?php echo $abonoInicial	;?>' ></td>
</tr>

<tr>
<td>VALOR TOTAL DE LA DEUDA</td>
<td><input type="hidden" name="TotalInicial"  id="TotalInicialh"><span id="TotalInicial"></span></td>
</tr>
<tr>
<td>INTERVALOS DE PAGOS</td>
        <td> 
    <select id="aux_intervalo_pagos" name='intervalo_pagos' class="NewCartera" style=" width:100%"><option value="">--</option>
        <option value="8">semanal(8 dias)</option><option value="15">Quincenal(15 dias)</option>
        <option value="30">Mensual(30 dias)</option><option value="45">mes y medio(45 dias)</option>
        <option value="60">Bimestral</option><option value="90">Timestral</option><option value="180">Semestral</option><option value="365">Anual</option></select>
                
              </td>
</tr>
<tr>
<td>NUMERO DE CUOTAS</td>
<td><input type="number" name="numeroCuotas" id="numeroCuotas" value="1" ></td>
</tr>
<tr>
<td>VALOR DE LA CUOTA</td>
<td><input  type="hidden" name="valCuota" id="valCuotah"  ><span id="valCuota"></span></td>
</tr>
<tr>
<tr>
<td><input type="submit" value="enviar" id="cierraCredito"  style="height:40px"></td>
</tr>
<tr>
</table>
</div>

<input type="hidden" name="nombreprovedor" value=" " id="nombreprovedor">


<input type="hidden" name="usuarioID" value="<?PHP echo $usuarioID;?>" id="usurio">
<div id="cuerpo" align="center">

<table width="786" height="256" >
<tr>
  <td><span class="Estilo1">Compra No.</span></td>
  <td class="Estilo1">0000<?PHP echo $jk567;?><input type="hidden" value="<?PHP echo $jk567;?>"   name="id_de_Compra" id="id_de_Compra"></td></tr>
<tr>
<td height="60" valign="middle" class="Estilo2">Tipo de Compra</td><td valign="middle"><select name="tipo_de_compra" id="tipo_de_compra" class="text4"><option value="1" selected>CONTADO</option>
<option value="2">CREDITO</option></select></td>
<td class="Estilo2">Fecha</td>
<td valign="middle"><input type="date" id="fechaIngreso" name="fechaIngreso" value="<?php echo $fechaIngreso ;?>" class="text6"></td>
<td><span class="Estilo2">Proveedor</span>
  <select name="provedor" id="provedor" class="text4">
    <option value="0">........NINGUNO........</option>
    <?php echo $provedor; ?>
  </select><input type="submit" id="enviar"  style="display:none">
</form>
<a href="provedores1.php?llamado=145632jlhsue" style="text-decoration:none" id="AnuevoProv2">
  <img src="nuevo_proveedor.png" name="nuevoProv2" width="26" height="22" border="0" align="middle" id="nuevoProv2" title="Nuevo Proveedor"></a>
</td>
<td></td>
<td rowspan="4">





</td>
</tr>
<tr>
<td colspan="6">












<table width="807" border="0">
    <tr>
      <td width="123" bgcolor="#FBFBFB"><span class="Estilo2">Cod. Producto</span></td>
      <td width="280" valign="middle"><input type="text" id="codProduto" class="venta" name="codigo_del_producto" autofocus  ><input type="image" src="buscar.png" id="buscarProducto" title="Buscar Producto" align="middle">
  <a href="CreaProductos.php?llamado=145632jlhsue&AUX=1" style="text-decoration:none" id="AnuevoArt"><img src="iconoproducto.png" name="nuevoArt" width="26" height="22"  border="0" align="middle" id="nuevoArt" title="Crear Nuevo Producto"></a></td>
      <td width="159" bgcolor="#FBFBFB"><span class="Estilo2">Nombre del Producto</span></td>
 	  <td width="227" bgcolor="#FFFFFF"  id="nombreP"  style=" font-size:20px; font-family:Arial Narrow"></td>
      </tr>
    <tr>
      <td bgcolor="#FBFBFB"><span class="Estilo2">Precio</span></td>
      <td><input type="number" id="precio" class="venta" name="precio_de_compra" min="0" step="1"></td>
      <td bgcolor="#FBFBFB"><span class="Estilo2">Cantidad</span></td>
      <td><input type="number" id="cantidad" nombre="cantidad"  class="venta" name="Cantidad_a_comprar" min="0" step="1"></td>
      </tr>
    <tr>
      <td bgcolor="#FBFBFB"><span class="Estilo2">% Iva</span></td>
      <td><SELECT id='p_iva' name='p_iva' class="venta">
         <option value=0 >0</option>
        <option value=19 >19</option>
        <option value=16 >16</option>
        <option value=12 >12</option>
        <option value=10 >10</option>
        <option value=8 >8</option>
        <option value=6 >6</option>
        <option value=5 >5</option>
        <option value=4 >4</option>
        <option value=3 >3</option>
      </SELECT></td>
      <td><span class="Estilo2">Total</span></td>
      <td><input disabled type="text"  align="right" name="total_venta" class="venta" id="Tventa" style=" size:14px; height:25px"></td>
     <input type="hidden" id="InombreP" value="" class="venta" name="nombre_del_producto"> </tr> 
    <tr>
      <td colspan="4"><table width="521" border="0" align="center">
        <tr align="center" valign="middle">
          <td width="162"><input type="button" value="PROCESAR" id="aceptar" class="boton" tabindex="14"></td>
          <td width="186"><a href="menuTrans.php" style="text-decoration:none" id="cancelAll">
            <input type="button" value="CANCELAR" id="cancelar" class="boton"></a></td>
          <td width="164"><input type="button" value="FINALIZAR" id="final"class="boton" ></td>
        </tr>
      </table></td>
      </tr>
  </table>




















</div><div align="center"   >
<iframe width="100%" height="400px" src="mostrarDetalleFacturaEdicion.php?tabla=listacompraedicion&dato=<?PHP echo $jk567;?>&col=idCompra" id="frame1"></iframe></div>
<div style="display:none" width="100%"><div id="busquedaArticulo"  width="100%" style="height:100%" >

  Buscar<input name="text" type="text" class="busquedas" width="400" data-invoker='articulos' />
 <input type="hidden" id="respuestaArticulo" />
 <input type="hidden" id="gridID" />
            <table border="0" id=" Tablacolor" width="695"><tr><td>
             <table  border="0" id="listarTablaproducto" bordercolor="#71D8E3"  width="100%"    >
		  <tr  id="cabPac" align="center"   class="ui-widget-header">
	        <td width="70"  >CODIGO</td>
		    <td width="400"  >NOMBRE/DESCRIPCION</td>
			<td   width="70">PRECIO</td>		
      </tr><tr><td colspan="3">
      <span id=""></span>
      </td></tr>
    </table> </td></tr><tr><td>
		
      <div align="center" id="tablasListaproducto" ></div>    
     <div align="center" id="indiceListaproducto" ></div>
       </td></tr></table>
     </div>
	 </div>
<input id='caption' value='compras' type='hidden'>

</body>
</html>