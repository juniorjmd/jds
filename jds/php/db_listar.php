<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
//datos_json :where=-1&order=%20ORDER%20BY%20%60razonSocial%60%20ASC&respuesta=proveedores&nocache=0.7916082898936156

//$json ='{"where":"-1","order":"ORDER BY razonSocial ASC","respuesta":"proveedores"}';
// var_dump(json_decode($json, true));echo '---<br>';
//  $_POST = json_decode($json, true);    

if (count($_POST) > 0){ 
$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);}// obtiene los valores de las varibles
// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
$nombre_campo = $tags2[$i]; 
$valor = $valores2[$i];
$$nombre_campo = $valor;
//$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
  // eval($asignacion);
}

$query='select * from '.$respuesta;

if (isset($where) && $where != '-1'){	
    $dato = trim($dato);
	$query.= ' where '.$where ;
	if (isset($iguales) && $iguales == '1'){
		$query.=  " = '".$dato."'";
	}else {$query.=  " LIKE '%".$dato."%'";}
	if (isset($tabla2)){
		if (isset($iguales) && $iguales == '1'){
		$query.=  ' OR `'.$tabla2."` = '".$dato."'";
	}else {$query.=  ' OR `'.$tabla2."` LIKE '%".$dato."%'";}
	}
	if (isset($tabla3)){
		if (isset($iguales) && $iguales == '1'){
		$query.=  ' OR `'.$tabla3."` = '".$dato."'";
	}else {$query.=  ' OR `'.$tabla3."` LIKE '%".$dato."%'";}
	}
}
if (isset($order) AND $order != '-1'){
	$query.=" $order";
}
//echo $query;
$data = array();
$result = $mysqli->query($query);
$datos["query"] = $query;
$datos["filas"]=$mysqli->affected_rows;
$i=0;
//echo $datos["filas"];
if ($datos["filas"]>0){
	while ($row = $result->fetch_assoc()) {
$data[$i] =$row;
$i++;
}}

//print_r($data);
$datos["datos"]=$data;
hlp_arrayReemplazaAcentos_utf8_decode($datos);
$mysqli->close();

echo json_encode($datos);
?>
