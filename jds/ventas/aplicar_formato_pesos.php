<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
$auxDR=$_POST["datosConvertir"];
if(is_null($auxDR)){
$datos_convertidos[$cout]=amoneda('0', pesos); }else{
	$cout=0;
	foreach ($auxDR as $value) {
	$datos_convertidos[$cout]=amoneda($value, pesos); 
	$cout++;}
	}

$datos["datos"]=$datos_convertidos;

echo json_encode($datos);
?> 
