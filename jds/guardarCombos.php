<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 
include 'db_conection.php';
$auxHtml="";
$ventaCombo=true;
$mysqli = cargarBD();
//echo "esto es auxhtml ".$auxHtml;

$idLinea=0;
$queryLinea="SELECT * FROM  `ventastemp` ORDER BY  `ventastemp`.`idLinea` ASC  ";
$resultLinea = $mysqli->query($queryLinea);

$idLineaAux="";
while ($rowCombo = $resultLinea->fetch_assoc()) {
	if($idLineaAux!=$rowCombo["idLinea"]){$img='<img id="'.$rowCombo["idLinea"].'"  src="imagenes/close (1).png" class="venta" style=" cursor:pointer">';}else{$img="";}
	$idLineaAux=$row["idLinea"];
	$idLinea=$rowCombo["idLinea"];

	if($rowCombo["idVenta"]==$_POST['IdVenta']){
	$auxHtml= $auxHtml.'<tr><td>'.$img.'</td>
<td>'.$rowCombo["nombreProducto"].'</td>
<td>'.$rowCombo["presioVenta"].'</td>
<td align="center">'.$rowCombo["cantidadVendida"].'</td>
<td align="right">'.$rowCombo["valorTotal"].'</td>
</tr>';$total=$total+$rowCombo["valorTotal"];
$totalArt=$totalArt+$rowCombo["cantidadVendida"];}
}



$queryCombo="SELECT * FROM  `relacioncombo` WHERE CONVERT(  `relacioncombo`.`id` USING utf8 ) =  '".$_POST['idProducto']."'";
$resultCombo = $mysqli->query($queryCombo);
$datosNumCombo=$mysqli->affected_rows;
$idLinea++;
$cont=0;
if($datosNumCombo>0){
while ($rowCombo = $resultCombo->fetch_assoc()) {
	$cont++;
	$rowCombo["id"];
	$rowCombo["idProducto"];
	$rowCombo["nombre"];
	$cantidad=$rowCombo["cantidad"]*$_POST['cantidadVendida'];
	if($cont==1){$valorTotal=$_POST['valorTotal'];}else{$valorTotal=0;}
	

$stmt = $mysqli->stmt_init();
$query="INSERT INTO  `ventastemp` (
`idLinea` ,`codMesa` ,`idVenta` ,`idProducto` ,`nombreProducto` ,`presioVenta` ,`cantidadVendida` ,`descuento` ,`valorTotal` ,`usuario` ,`fecha`,`hora`)VALUES ('".$idLinea."',
  '".$_POST['codMesa']."',  '".$_POST['IdVenta']."',  '".$rowCombo['idProducto']."',  '".$rowCombo["nombre"]."',  '0',  '".$cantidad."',  '0',  '".$valorTotal."',  '".$_POST['usuario']."',  CURRENT_TIMESTAMP ,CURTIME() );";
$stmt->prepare($query);
if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{
	$total=$total+$valorTotal;
	
$totalArt=$totalArt+$cantidad;
if($cont==1){$img='<img id="'.$idLinea.'"  src="imagenes/close (1).png" class="venta" style=" cursor:pointer">';}else{$img="";}
$auxHtml= $auxHtml. '<tr><td>'.$img.'</td>
<td>'.$rowCombo["nombre"].'</td>
<td>0</td>
<td align="center">'.$cantidad.'</td>
<td align="right">'.$valorTotal.'</td>
</tr>';


$auxQuery="UPDATE  `producto` SET  `cantActual` = `cantActual`-".$cantidad.",`ventas`=`ventas`+".$cantidad." WHERE CONVERT(`idProducto` USING utf8 ) =  '".$rowCombo["idProducto"]."' LIMIT 1 ;";		
$result = $mysqli->query($auxQuery);	
}
}

	}	
//echo "esto es auxhtml ".$auxHtml;
 ?>
 <tr>
<td colspan="5" height="40px" id="MA"><?php echo $_POST['mesaActivada'];?></td>
</tr>
<tr><td height="10px" ></td>
<td height="40px">PRODUCTO</td>
<td align="center">PRECIO</td>
<td align="center">CANT.</td>
<td align="center">TOTAL</td>
</tr>
<?php echo $auxHtml;?>
 <tr>
<td colspan="5">&nbsp;</td>
</tr>
<tr>
<td height="40px">&nbsp;</td><td>&nbsp;</td>
<td>TOTAL</td>
<td><span id="totalVenta"><?php echo $total;?></span></td>
<input type="hidden" id="cantidadVendida" value="<?php echo $totalArt;?>">
</tr>
<tr>
<td colspan="4"><?php echo '
<input type="button" id="cerrarVenta" value=" Cerrar Mesa " title="Cierra la caja y genera la factura de cobro" class="facturasBT">
<input type="button" id="print" value=" Imp. Parcial " title="Imprime el corte parcial de la factua" class="facturasBT">';?></td>

</tr>
<?php
echo '<input type="hidden" value="'.$_POST['IdVenta'].'" id="IdVenta">';
include"printerPedido.php";
?>
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
				$("#"+$("#mesaActiva").val()).trigger('click');
			}
		});
		}
	
	});
</script>