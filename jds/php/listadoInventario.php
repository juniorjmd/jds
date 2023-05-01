<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'funcionesMysql.php';
include 'db_conection.php';
$mysqli = cargarBD();
$llamado=$_POST["respuesta"];
$date=$_POST["dato1"];

$fecha1 =normalize_date($date,"-"); 


if($_POST["dato2"])
{$date=$_POST["dato2"];

$fecha2 =normalize_date($date,"-"); 
}
//echo $fecha1;

switch ($llamado) {
case "buscarCitas":

$query=$_POST["query"]."'".$fecha1."'".$_POST["query2"]."'".$fecha2."' 
ORDER BY `hora`  ASC";


break;	

case "revisaNuevasCitas":

$query=$_POST["query"]."'".$fecha1."'".$_POST["query2"]."'".$_POST["ubicacionGrid"]."' AND  (estadoCita <> 'diferido' AND estadoCita <> 'cancelada' )ORDER BY `hora`  ASC";
//echo $query;
break;	
case "fecha":

$query="SELECT * FROM agenda WHERE `fecha` = '".$fecha1."' 
ORDER BY `hora`  ASC";
break;	

case "diferidos":
$fecha1=$_POST["fecha"];
$query=$_POST["query"]."'".$fecha1."'AND  (estadoCita ='diferido'  )ORDER BY `hora`  ASC";

break;	
}
$result = $mysqli->query($query);
//printf("Affected rows (SELECT): %d\n", $mysqli->affected_rows);
$datos["filas"]=$mysqli->affected_rows;
$i=0;
$aux;
while ($row = $result->fetch_assoc()) {
$aux=$row;
$data[$i]=$aux;
$i++;
}
$datos["datos"]=$data;
$datos["aux"]=$aux["ubicacionGrid"];	
$result->free();

$mysqli->close();
echo json_encode($datos);
?>
