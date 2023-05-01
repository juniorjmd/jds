<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
$llamado=$_POST["respuesta"];
$codBusqueda=$_POST["dato"];

$auxQ="";

switch ($llamado) {
case "entradas":
$query="SELECT DISTINCT`codEntrada` FROM  `entradasimplicito` WHERE  `codProducto` =".$codBusqueda;
$auxQ= $llamado."  WHERE `codEntrada` ";
break;	
case "salidas":
$query="SELECT DISTINCT `codSalida` FROM  `salidasimplicito` WHERE  `codProducto` =".$codBusqueda;
$auxQ=$llamado."  WHERE `codSalida` ";
break;	
case "ventas":
$query="SELECT DISTINCT `idVenta` FROM  `ventasimplicito` WHERE  `idProducto` =".$codBusqueda;
$auxQ=$llamado."   WHERE `idVenta` ";
break;	














}
//echo $query;

$result = $mysqli->query($query);
$datos["filas"]=$mysqli->affected_rows;
$i=0;
while ($row = $result->fetch_row()) {
  	$query2="SELECT * FROM ".$auxQ."=". $row[0];
	//echo $query2;
	$result2 = $mysqli->query($query2);

	while ($row2 = $result2->fetch_assoc()) {
	$data[$i] =$row2;
}
	$i++;
}
	
$datos["datos"]=$data;
$result->free();
$mysqli->close();
echo json_encode($datos);
?>
