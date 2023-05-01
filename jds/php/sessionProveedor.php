<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
//razonSocial  direccion email telefono telefonoCelular ciudad observaciones
include 'db_conection.php';
$mysqli = cargarBD();
$query="SELECT sum( TotalActual ) AS total FROM credito WHERE idProveedor ='".$_SESSION["ProveedorId"]."'"; 
$result = $mysqli->query($query);
while ($row = $result->fetch_assoc()) {
$data =$row;
}
$_SESSION["deudaActual"]=$data["total"];
$result->free();
$mysqli->close();


$seciones = array("ProveedorId"=>$_SESSION["ProveedorId"], "razonSocial"=>$_SESSION["razonSocial"], "direccion"=>$_SESSION["direccion"], "email"=>$_SESSION["email"], "telefono"=>$_SESSION["telefono"], "telefonoCelular"=>$_SESSION["telefonoCelular"], "ciudad"=>$_SESSION["ciudad"], "observaciones"=>$_SESSION["observaciones"],"deudaActual"=>$_SESSION["deudaActual"]);




echo json_encode($seciones);

?>