<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
$orden = '';
if (isset($_POST['orden'])){
	$orden = ' ORDER BY '.$_POST['orden'].' ASC ';
}
$query='SELECT * FROM '.$_POST["tabla"];

if(isset($_POST["dato"]))
{$query=$query."'".$_POST["dato"]."' ";}

if(isset($_POST["query2"]))
{$query=$query.$_POST["query2"];}

if(isset($_POST["dato2"]))
{$query=$query."'".$_POST["dato2"]."';";}


//$query="SELECT * FROM sucursales";
if($query){
	$query .=$orden;
$result = $mysqli->query($query);
//printf("Affected rows (SELECT): %d\n", $mysqli->affected_rows);
$conta=0;}

$llamado=$_POST["respuesta"];
//echo"   esto es el llamado  ". $llamado."   y esto es el quety   ".$query;
switch ($llamado) {
case "sucursales":
 $filas=$result->num_rows;


break;	

case "verificar":
$tabla=$_POST["tabla"];
$columna=$_POST["columna"];
$dato=$_POST["dato"];
$query="SELECT * FROM `".$tabla."` WHERE `".$columna."` = '".$dato."'";
$result = $mysqli->query($query);
 $filas=$result->num_rows;
break;	

case "entradas":
 $filas=0;
 $filas=$result->num_rows;
 if ($filas>0){
 while ($row = $result->fetch_row()) {
    $filas=  $row[0];
	   //printf("%s\n",$filas);
    }}

break;
case "cartera":
$filas=0;

 $filas=$result->num_rows;
 if ($filas>0){
while ($row = $result->fetch_row()) {
    $filas=  $row[0];
	   //printf("%s\n",$filas);
 }}

break;
case "clientes":
$filas=0;

 $filas=$result->num_rows;
 if ($filas>0){
while ($row = $result->fetch_row()) {
    $filas=  $row[0];
	   //printf("%s\n",$filas);
    }
 }
break;
case "proveedores":
$filas=0;

 $filas=$result->num_rows;
 if ($filas>0){
while ($row = $result->fetch_row()) {
    $filas=  $row[0];
	   //printf("%s\n",$filas);
 }}

break;

}

//$result->free();

//printf("\n%s",$row[0]);
$mysqli->close();
echo $filas+1;
?>
