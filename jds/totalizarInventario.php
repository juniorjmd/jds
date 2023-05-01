

<?php
include 'db_conection.php';
if($_GET['id']){$auxQ="WHERE `nombre` LIKE'%".$_GET['id']."%' OR `Grupo` LIKE'%".$_GET['id']."%'";}
$mysqli = cargarBD();
//ORDER BY  `producto`.`Grupo` ASC 
$query="SELECT * 
FROM  `producto` ".$auxQ." ";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
$i=0;
$html='';
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$i++;
	if($i==15){$i=1;
	$html=$html.'</table><table border="1" width="1133" style="border:thin #7DA2FF">
<tr bordercolor="#000033" >
<td width="41" >ID</td>
	<td width="110" align="center">GRUPO</td>
	<td width="392"align="center">NOMBRE</td>
	<td width="60">PRECIO VENTA</td>
	<td width="67">PRECIO COMPRA</td>
	<td width="58">CANT. INICIAL</td>
	<td width="62">CANT. ACTUAL</td>
	<td width="76">COMPRAS</td>
	<td width="61">VENTAS</td>
	<td width="58">STOCK</td>
	<td width="76">IMG</td></tr>';
	}
	$color="#7DA2FF";
	if($row['cantActual']<$row['stock']){
	$color="#FF9194";}
	$html=$html.'<tr align="center" bgcolor="'.$color.'" id="'.$row['idProducto'].'" class="listaInv" style="cursor:pointer" >
	<td height="55px">'.$row['idProducto'].'</td>
	<td>'.$row['Grupo'].'</td>
	<td>'.$row['nombre'].'</td>
	<td>'.$row['precioVenta'].'</td>
	<td>'.$row['precioCompra'].'</td>
	<td>'.$row['cantInicial'].'</td>
	<td>'.$row['cantActual'].'</td>
	<td>'.$row['compras'].'</td>
	<td>'.$row['ventas'].'</td>
	<td>'.$row['stock'].'</td>
	<td><img src="'.$row['imagen'].'" height="50px" width="60px"></td>
	</tr>';
	}
	$html=$html.'</table>';
}else{echo'<tr><td align="center" colspan="10">NO POSEE NINGUN REGISTRO</td></tr>';}
?>
<table border="1" width="1133" style="border:thin #7DA2FF">
<tr bordercolor="#000033" >
<td width="41" >ID</td>
	<td width="110" align="center">GRUPO</td>
	<td width="392"align="center">NOMBRE</td>
	<td width="60">PRECIO VENTA</td>
	<td width="67">PRECIO COMPRA</td>
	<td width="58">CANT. INICIAL</td>
	<td width="62">CANT. ACTUAL</td>
	<td width="76">COMPRAS</td>
	<td width="61">VENTAS</td>
	<td width="58">STOCK</td>
	<td width="76">IMG</td></tr>
    <?php echo $html;?>
</table>


<link type="text/css" href="css/menuContextual.css" rel="stylesheet" />
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>

<script type="text/javascript" >
$(document).ready(function(){

}); 
</script> 