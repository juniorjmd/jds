<?php include 'php/inicioFunction.php';
verificaSession_2("login/");  
include 'db_conection.php';
$mysqli = cargarBD();
$stmt = $mysqli->stmt_init();
$query="INSERT INTO  `relacioncombo` (`id` ,`idProducto` ,`nombre` ,`cantidad`)VALUES ('".$_POST['codigo_del_combo']."',  '".$_POST['codigo_del_producto']."',  '".$_POST['nombre_del_producto']."',  '".$_POST['cantidad_del_producto']."');";
$stmt->prepare($query);
//echo $query;
if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{echo 1;}
	

 ?>
 