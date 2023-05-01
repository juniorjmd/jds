<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
$query=$_POST["query"];
if (($_POST["dato"])&&($_POST["columna"]))
{
$query=$query."where '".$_POST["dato"]."'='".$_POST["columna"]."';";
}

$value=$_POST["value"];
$txt=$_POST["txt"];
//echo $value."    ".$txt." y el query es ".$query;

$result = $mysqli->query($query);
$filas=$mysqli->affected_rows;
if ($filas	>0){
while ($row = $result->fetch_assoc()) {
if(strstr($row[$value],'�')){ // donde pone ? pon el caracter a buscar
$row[$value]=utf8_decode($row[$value]);
}

if(strstr($row[$txt],'�')){ // donde pone ? pon el caracter a buscar
$row[$txt]=utf8_decode($row[$txt]);
}

echo"<option value='".$row[$value]."'>".$row[$txt]."</option>";

}}
$datos["datos"]=$data;
$result->free();

$mysqli->close();
//echo json_encode($datos);


?>