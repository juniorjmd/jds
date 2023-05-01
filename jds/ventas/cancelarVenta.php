<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../php/db_conection.php';
$conn= cargarBD();
$mysql_conn =  cargarBD();
	$query="SELECT * FROM `ventastemp` WHERE `idVenta` ='".$_POST['dato']."'";
	$result = $conn->query($query);
	$count =0;
	while ($row = $result->fetch_assoc()) {
		$count = $count + 1;
		$idProducto =$row['idProducto'];
	$cantVent =$row['cantidadVendida'];
		$auxQuery="UPDATE  `producto` SET  `cantActual` = `cantActual`+".$cantVent.",`ventas`=`ventas`-".$cantVent." WHERE CONVERT(`idProducto` USING utf8 ) =  '".$idProducto."' LIMIT 1 ;";		
		$update[$count] = $auxQuery;
		$query="DELETE FROM `ventastemp` WHERE `idLinea` ='".$row['idLinea']."'";
		$delete[$count] = $query;
	echo $auxQuery; 
	echo $query;}
	
for ($i = 1 ; $i<= $count ; $i++){
	$result = $mysql_conn->query($update[$i]);
	$result = $mysql_conn->query($delete[$i]);
}
if(isset($_POST['eliminar_venta'])){
$query="DELETE FROM `ventacliente` WHERE `idVenta` ='".$_POST['dato']."'";
echo $query;
	$result = $mysql_conn->query($query);
}
mysqli_close($conn);
mysqli_close($mysql_conn);
?>