<?php 
include 'db_conection.php';
 $conn= cargarBD();

if($_POST['cantidad']){
	$stmt = $conn->stmt_init();
	if($_POST['Tvalor']==="1"){$variacion=$_POST['cantidad'];}
	else{$porc=$_POST['cantidad']/100;
$variacion=' ( `precioVenta`*'.$porc.')';}

if($_POST['Tcambio']==="1"){$signo="+";}else{$signo="-";}
$query="UPDATE  `producto` SET  `precioVenta` =   `precioVenta`".$signo.$variacion;
$stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo crear la tabla de ingresos:' . $conn->error);
		 
		}else{
header('Location: inventario.php');}
}
?>
<meta charset="utf-8">
<title>Actualizar productos</title>
<form action="actuProductos.php" method="post" autocomplete="off">
<div align="center"><br/><br/><br/><br/>

<table>
<tr>
<td>TIPO DE CAMBIO</td><td><select name="Tcambio">
<option value="1">AUMENTO</option>
<option value="2">REDUCCION</option>
</select></td><td rowspan="3"><center><a href="inventario.php" style="text-decoration:none">CANCELAR</a></center><br/><input type="submit" style="height:80px; width:80px" value="MODIFICAR"></td>
</tr>
<tr>
<td>EXPRESADO EN </td><td><select name="Tvalor">
<option value="2">PORCENTAJE</option>
<option value="1">VALOR</option>
</select></td>
</tr>
<tr>
<td>CANTIDAD DE AUMENTO</td><td><input type="number" name="cantidad"></td>
</tr>
</table></div>
</form>