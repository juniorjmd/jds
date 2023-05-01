<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
include 'funcionesMysql.php';
$yaSeHizo="1";
$conn= cargarBD();
$stmt = $conn->stmt_init();
$stmt2 = $conn->stmt_init();
$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
$$tags2[$i]=$valores2[$i]; 
}
$query= "INSERT INTO `ultposiciones` 
(`idRegistro`, `idUsuario`, `latitud`, `longitud`) VALUES (NULL, '".$idUsuario."', '".$latitud."', '".$longtud."');";
$stmt->prepare($query);
 if(!$stmt->execute()){
		echo '-1';
	}
	else {echo 'ok';}

$stmt->close();

?>
