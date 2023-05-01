<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../php/db_conection.php';
$mysqli = cargarBD();
$query="SELECT * 
FROM  `producto` WHERE  `idProducto` =  '".$_POST['idProducto']."'";
$cantidadActual=0;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
while ($row = $result->fetch_assoc()) {
$cantidadActual=$row["cantActual"];
	}	
echo $cantidadActual;
 ?>