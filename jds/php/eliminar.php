<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$conn=cargarBD();


$tabla=$_POST["tabla"];
$columna=$_POST["columna"];
$dato=$_POST["dato"];
$iqual=$_POST["iqual"];

$query= "DELETE * FROM ".$tabla." WHERE `".$columna."` = '".$dato."'";

if(!$conn->query($query)){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo eliminar:' . $conn->error);
}
else{echo("los datos han sido eliminados con exito");}

$conn->close();
?>





