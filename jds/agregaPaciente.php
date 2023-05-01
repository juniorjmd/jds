<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'php/db_conection.php';
$mysqli = cargarBD();
$llamado=trim($_POST["llamado"]);

$query="SELECT * FROM   `clientes`   ORDER BY  `clientes`.`idCliente` ASC ";
$idClienteAux  = 0;
$result = $mysqli->query($query);
$filas=$mysqli->affected_rows;
if($filas>0){
while ($row = $result->fetch_assoc()) {
$idClienteAux = $row['idCliente'];
}}
$idClienteAux++;
switch ($llamado) {
case "revisar":
$query="SELECT * FROM   `clientes` WHERE `nit` = '".$_POST['idCliente']."'";
$result = $mysqli->query($query);
///printf("Affected rows (SELECT): %d\n", $mysqli->affected_rows);
$i=0;
$datos["error"]="";
$filas=$mysqli->affected_rows;

if($filas>0){
while ($row = $result->fetch_assoc()) {
$data[$i] =$row;
$idClienteAux = $row['nit'];
$i++;
}
$query2="INSERT INTO  `ventacliente` (`id_relacion` ,`idCliente` ,`idVenta`)VALUES (NULL ,  '".$idClienteAux."',  '".$_POST['IdVenta']."');";
	$mysqli->query($query2);
	$datos["error"]="cliente agregado a venta";
}else{
	$datos["error"]="LA CEDULA NO SE ENCUENTRA REGISTRADA...  DESEA AGREGAR A CLIENTES. ".$idClienteAux;
	}

$datos["datos"]=$data;
$datos["filas"]=$filas;
$result->free();

$mysqli->close();

echo json_encode($datos);
break;

case "agregar":

$query="INSERT INTO  `clientes` (`idCliente` ,`nit` ,`nombre` ,`razonSocial` ,`direccion` ,`telefono` ,`email`)
VALUES (
'00".$idClienteAux."',  '".$_POST['nit']."',  '".$_POST['nombre']."',  '".$_POST['razonSocial']."',  '',  '".$_POST['telefono']."',  '".$_POST['email']."'
)";
$stmt = $mysqli->stmt_init();
 $stmt->prepare($query);
if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear el nuevo cliente:' . $conn->error);
break;
}else{
	if($_POST['procesoDB']=="actualizar"){$query2="UPDATE `ventacliente` SET  `idCliente` =  '".$_POST['nit']."' WHERE  `ventacliente`.`idVenta` ='".$_POST['IdVenta']."' LIMIT 1 ;";
	}
	else{$query2="INSERT INTO  `ventacliente` (`id_relacion` ,`idCliente` ,`idVenta`)VALUES (NULL ,  '".$_POST['nit']."',  '".$_POST['IdVenta']."');";
	}
	$mysqli->query($query2);
	$datos["error"]="todo bien";

}

$mysqli->close();

echo json_encode($datos);

break;
case "actualizar":
$query="SELECT * FROM   `clientes` WHERE `nit` = '".$_POST['idCliente']."'";
$result = $mysqli->query($query);
$i=0;
$datos["error"]="";
$filas=$mysqli->affected_rows;

if($filas>0){
while ($row = $result->fetch_assoc()) {
$data[$i] =$row;
$idClienteAux = $row['nit'];
$i++;
}
$query2="UPDATE `ventacliente` SET  `idCliente` =  '".$idClienteAux."' WHERE  `ventacliente`.`idVenta` ='".$_POST['IdVenta']."' LIMIT 1 ;";
	$mysqli->query($query2);
	$datos["error"]="cliente agregado a venta";
}else{
	$datos["error"]="LA CEDULA NO SE ENCUENTRA REGISTRADA...  DESEA AGREGAR A CLIENTES.";
	}

$datos["datos"]=$data;
$datos["filas"]=$filas;
$result->free();

$mysqli->close();

echo json_encode($datos);break;
}
?>
