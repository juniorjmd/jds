<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");?>
<?php 
include 'db_conection.php';
$conn= cargarBD();
if($_POST['restablecer']){
	$query="SELECT * FROM `".$_POST['tabla']."` WHERE `".$_POST['columna']."`='".$_POST['dato']."'";
	$result = $conn->query($query);
	while ($row = $result->fetch_assoc()) {
	$idProducto =$row['idProducto'];
	$cantVent =$row['cantidadVendida'];
}
$auxQuery="UPDATE  `producto` SET  `cantActual` = `cantActual`+".$cantVent.",`ventas`=`ventas`-".$cantVent." WHERE CONVERT(`idProducto` USING utf8 ) =  '".$idProducto."' LIMIT 1 ;";		
$result = $conn->query($auxQuery);
}
$query="DELETE FROM `".$_POST['tabla']."` WHERE `".$_POST['columna']."`='".$_POST['dato']."'";
$result = $conn->query($query);
?>