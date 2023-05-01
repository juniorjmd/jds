<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
$total=0;
if($_POST['mesaid']){$mesaid=$_POST['mesaid'];
$tablaIinicio=$tablaFinal="";}else{$mesaid="M1";
$tablaIinicio="<table width='100%'>"; $tablaFinal="</table>";
}
$query="SELECT * FROM  `ventas` WHERE  `codMesa` =  '".$mesaid."' ORDER BY  `ventas`.`orden` ASC ";
//echo '<span>'.$query.'</span>';
$ultVenta="";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$ultVenta=$row['idVenta'];
	////echo ' esto es ultima venta '.$ultVenta.' esto es id venta '.$row['idVenta'].'---- ';
	}
$ventaActual=substr($ultVenta, strlen($mesaid.'_'));
////echo $ventaActual;
}
else{$ventaActual=0;}

$ventaActual++;
////echo $ventaActual;
////echo $ultVenta;
$idVenta=$mesaid."_".$ventaActual;
	
$query="SELECT * FROM  `ventastemp` WHERE  `idVenta`='".$idVenta."' ORDER BY  `ventastemp`.`idLinea` ASC ";

$html2="";
$html='';
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
if($datosNum>0){
$idLineaAux="";
while ($row = $result->fetch_assoc()) {
	if($idLineaAux!=$row["idLinea"]){$img='<img id="'.$row["idLinea"].'"  src="imagenes/close (1).png" class="venta" style=" cursor:pointer" height="20px" width="20px">';}else{$img="";}$idLineaAux=$row["idLinea"];
	$tSinIVA=$row["presioSinIVa"]*$row["cantidadVendida"];
	$html=$html.'<tr>
<td>'.$img.'</td>
<td>'.$row["nombreProducto"].'</td>
<td align="right">'.$row["presioSinIVa"].'</td>
<td align="center">'.$row["cantidadVendida"].'</td>
<td align="right">'.$tSinIVA.'</td>
</tr>';
$totalArt=$totalArt+$row["cantidadVendida"];
$totalSinIvan=$totalSinIvan+$tSinIVA;
$valorIva=$row["porcent_iva"]/100;
	$IVA=round($tSinIVA*$valorIva, 2);
$ivaVendido=$ivaVendido+$IVA;
$total=$total+$row["valorTotal"];
	}}
	echo $tablaIinicio;
?>
<tr>
<td colspan="5" height="40px" id="MA"><?php echo $_POST['mesaActivada'];?></td>
</tr>
<tr><td height="10px"  ></td>
<td height="40px">PRODUCTO</td>
<td align="center">PRECIO</td>
<td align="center">CANT.</td>
<td align="center">TOTAL</td>
</tr>
<?php
echo $html;
 ?>
 <tr>
<td colspan="4" >&nbsp;<?php echo $html2; ?></td>
</tr>
<tr>
<td >&nbsp;</td><td>&nbsp;<?php //echo $query;?></td>

<td>SUB TOTAL</td>
<td align="right"><span id="totalSinIva"><?php echo round($totalSinIvan, 2);?></span></td>
<input type="hidden" id="cantidadVendida" value="<?php echo $totalArt;?>">
</tr>

<tr>
<td >&nbsp;</td><td>&nbsp;</td>

<td>IVA... </td>
<td align="right"><span id="totalIVA"><?php 
echo round($ivaVendido, 2);?></span></td>
</tr>
<tr>
<td >&nbsp;</td><td>&nbsp;<?php //echo $query;?></td>

<td>TOTAL VENTA</td>
<td align="right"><span id="totalVenta"><?php echo round($totalSinIvan+$ivaVendido, 2);?></span></td>
</tr>

<?php
echo $tablaFinal.'
<input type="hidden" value="'.$idVenta.'" id="IdVenta">';
if($datosNum>0){
echo '<td colspan="4"><input type="button" id="cerrarVenta" value=" Cerrar Mesa " title="Cierra la caja y genera la factura de cobro" class="facturasBT">
<input type="button" id="print" value=" Imp. Parcial " title="Imprime el corte parcial de la factua" class="facturasBT"></td>';}
?>

<style>
.botonMesa{ height:40;  }
</style>
<style>
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
</style>
<script type="application/javascript" language="javascript">
imprimeVenta($("#IdVenta").val())

$(".venta").click(function(){
	var dato=$(this).attr("id");
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ARTICULO");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent("ventastemp")
		  +"&restablecer="+encodeURIComponent(" ")
		  +"&columna="+encodeURIComponent('idLinea');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			$('#frame1').attr('src',$('#frame1').attr('src'));
			//$("#"+$("#mesaActiva").val()).trigger('click');
			iniciaFactura();
			}
		});
		}
	
	});
</script>

