<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
$query=$_POST["query"];
if ($_POST["dato"])
{
$dato=$_POST["dato"];
if(!$_POST["igual"]){
$query=$query."'%".$dato."%'" ;}
else{$query=$query."'".$dato."'" ;}
if($_POST["tabla2"])
{$tablaAux=$_POST["tabla2"];
$query=$query." or ".$tablaAux."  LIKE'%".$dato."%'" ;}
if($_POST["tabla3"])
{$tablaAux=$_POST["tabla3"];
$query=$query." or ".$tablaAux."  LIKE'%".$dato."%'"  ;
}}
$result = $mysqli->query($query);
$afectado=$mysqli->affected_rows;
if($afectado>0){
echo'<a href="#"  class="PacienteImg">';
while ($row =  $result->fetch_row()) {
echo "<img class='tooltips'  title='".$row[5]."' src='".$row[1]."' />";
}
echo "</a>";
}

$result->free();
$mysqli->close();

?>
