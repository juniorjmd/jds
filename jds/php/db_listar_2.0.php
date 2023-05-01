<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php'; 
$mysqli = cargarBD();
if( isset($_POST["tabla"])){
$tabla=$_POST["tabla"];}
$limit="";
$inicial=$_POST['inicio'];
$columnasRequeridas='';

$auxDR=$_POST["datosRequeridos"];
if(is_null($auxDR)){
$columnasRequeridas='*';}else{
	$cout=0;
	foreach ($auxDR as $value) {
		$cout++;
		if($cout>1){$coma=" , ";}else{$coma=" ";}
	$columnasRequeridas=$columnasRequeridas.$coma.$value;}
	}
$datos["where"]=$_POST['where'];
if(isset($_POST['where'])){
		if(isset($_POST["igual"])){
			$asignar="=";
			$porcent="";
			}else{$asignar="LIKE ";
			$porcent="%";}
		$primeBusqueda ="WHERE ".$_POST["columna1"].$asignar."'".$porcent.$_POST["dato"].$porcent."'";
		if(isset($_POST["tabla2"])){$segundaBusqueda=$_POST['conector'].' '.$_POST["tabla2"].$asignar."'".$porcent.$_POST["dato"].$porcent."'";}
		if(isset($_POST["tabla3"])){$terceraBusqueda=$_POST['conector'].' '.$_POST["tabla3"].$asignar."'".$porcent.$_POST["dato"].$porcent."'";}
}

if($inicial!="")
{	if($_POST['tamanioBloque']){$bloquePmetro=$_POST['tamanioBloque'];}
							else{$bloquePmetro='30';}
	$limit='LIMIT '.$inicial.' ,'.$bloquePmetro;
	$queryaux="select * from `".$tabla."`".$primeBusqueda.$segundaBusqueda.$terceraBusqueda.' ;';
//echo $query;
$result2 = $mysqli->query($queryaux);
$totalRegistrosDB=$mysqli->affected_rows;
$siguiente=$inicial+$bloquePmetro;
$anterior=$inicial-$bloquePmetro;
$ultimo=(verificaNumeroDeIntervalos($totalRegistrosDB,$bloquePmetro,NULL)-1)*$bloquePmetro;
if($anterior<0){$anterior=$ultimo;}
if($siguiente>$totalRegistrosDB){$siguiente=0;}
		$datos['anterior']=$anterior;
		$datos['siguiente']=$siguiente;
		$datos['ultimo']=$ultimo;
}

$query="select ".$columnasRequeridas." from `".$tabla."`".$primeBusqueda.$segundaBusqueda.$terceraBusqueda.$limit.' ;';
//echo $query;
$result = $mysqli->query($query);
$datos["filas"]=$mysqli->affected_rows;
$i=0;
while ($row = $result->fetch_assoc()) {
$data[$i] =$row;
$i++;
}

$datos["query"]=$query;
  $datos["datos"]=$data;
$result->free();
$mysqli->close();
echo json_encode($datos);
?>
