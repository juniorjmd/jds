<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
$tabla=$_POST["tabla"];
$columna=$_POST["columna"];
$dato=$_POST["dato"];
$iqual=$_POST["iqual"];


$query= "SELECT * FROM ".$tabla." WHERE `".$columna."` LIKE '%".$dato."%'";

if ($iqual)
{
if($_POST["respuesta"]){$query="SELECT articulo . * , ".$_POST["respuesta"]."inventario.Pventa
FROM  `articulo` ,  `".$_POST["respuesta"]."inventario` WHERE articulo.`codigo` =  '".$dato."' AND ".$_POST["respuesta"]."inventario.`idProducto` =  '".$dato."';";}
}
//echo $query;
$result = $mysqli->query($query);
///printf("Affected rows (SELECT): %d\n", $mysqli->affected_rows);

if (($_POST["respuesta"])&&($mysqli->affected_rows==0)){$query= "SELECT * FROM ".$tabla." WHERE `".$columna."` = '".$dato."'";
$result = $mysqli->query($query);}


$datos["filas"]=$mysqli->affected_rows;


$i=0;

while ($row = $result->fetch_assoc()) {
$data[$i]=$row;
$data[$i]['Pventa']=0;
$i++;
}
$datos["datos"]=$data;
$result->free();

$mysqli->close();

//printf("<p>todo se hiso muy bien</p>");
echo json_encode($datos);
?>
