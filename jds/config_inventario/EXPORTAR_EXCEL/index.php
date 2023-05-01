<?php

include_once '../../php/inicioFunction.php';
include_once '../../php/db_conection.php';
session_sin_ubicacion_3("../../login/");
header("Expires: 0");
$filename = "inventario_".date('dmY').".xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

$mysqli = cargarBD();
$stmt = $mysqli->stmt_init();
$aux=''; 


//print_r($_POST );

foreach($_POST as $key => $value )
{
	$$key = $value;
}

/////////////////////////
$query="SELECT * FROM producto;";
$result = $mysqli->query($query);


?>

  <table border='1' id='tabla_1' style='margin-top:70px;'>
  
  <tr>
  <td>codigo de barra</td>
  <td>nombre</td>
  <td>cantidad inicial</td>
  <td>compra</td>
  <td>ventas</td>
  <td>devolucion</td>
  <td>cantidad actual</td>
  <td>nueva_cant_inicial</td>
  <td>total_nuevo</td>
  
  </tr>
<?php
if($result->num_rows>0){
	$cont=0;
while ($row = $result->fetch_assoc()) {
	$row['nombre'] = trim($row['nombre']);
	$row['barcode'] = strval(trim($row['barcode']));
	echo"<tr class='lineas'>		
	<td>{$row['barcode']}</td><td>{$row['nombre']}</td>
	<td>{$row['cantInicial']}</td> 
	<td>{$row['compras']}</td>
	<td>{$row['ventas']}</td>
	<td>{$row['devoluciones']}</td>
	<td>{$row['cantActual']}</td>
	<td>_________</td>
	<td>_________</td></tr>"; 
	$cont++;
}

$result->free();
}
?>
</table>
