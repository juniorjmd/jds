<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
			 

$conn= cargarBD();
$connAux=cargarBD();
$query="SELECT * FROM `inventario` ;";
		$result = $conn->query($query);
		$codigoIngreso="";

		while ($row = $result->fetch_row()) {
				$i=$i+1;
				$codigoIngreso=$row[0]; 

				
$queryInvaux="UPDATE `prueva`.`inventario` SET `salidas` =  '0',
`entradas` = '0',
`ventas` = '0',
`totalCantidad` = `inventario`.`cantidad` WHERE `inventario`.`idProducto` =".$codigoIngreso." LIMIT 1 ;";

		 $conn->query($queryInvaux);	

				}

		$query2="TRUNCATE TABLE `salidas`;";
		$conn->query($query2);	
$query2="TRUNCATE TABLE `salidastemp`;";
		$conn->query($query2);	
$query2="TRUNCATE TABLE `salidasimplicito`;";
		$conn->query($query2);	

$query2="TRUNCATE TABLE `entradastemp`;";
		$conn->query($query2);	
$query2="TRUNCATE TABLE `entradas`;";
		$conn->query($query2);	
		$query2="TRUNCATE TABLE `entradasimplicito`;";
		$conn->query($query2);	

		$query2="TRUNCATE TABLE `ventasimplicito`;";
		$conn->query($query2);	
		$query2="TRUNCATE TABLE `ventastemp`;";
		$conn->query($query2);	
		$query2="TRUNCATE TABLE `ventas`;";
		$conn->query($query2);	
		
				
				
				
	?>
