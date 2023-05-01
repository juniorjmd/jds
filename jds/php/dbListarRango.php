<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
/*
$query="SELECT * FROM  `ventas`  WHERE  `fecha`  BETWEEN  '2012-09-1' AND  '2012-09-20'";//rango de recha entre dos fechas
$query="SELECT * FROM  `ventas`  WHERE DAY(  `fecha` ) =17;"//selecciona por dia
$query="SELECT * FROM  `ventas` WHERE MONTH(  `fecha` ) =8 ;";//selecciona por mes

select YEAR(NOW());  #Selecciona el a�o
select MONTH (NOW()) as mes;  #Selecciona el mes
select DAY(NOW()) as dia; #Selecciona el d�a 
select TIME(NOW()) as hora;  #Selecciona la hora
Select LAST_DAY(NOW()); # Selecciona el ultimo dia del mes

*/include 'db_conection.php';
$mysqli = cargarBD();


include 'funcionesMysql.php';
$date=$_POST["dato1"];

$fecha1 =normalize_date($date,"-"); 

$date=$_POST["dato2"];

$fecha2 =normalize_date($date,"-"); 
$tabla=$_POST["tabla"];
$columna=$_POST["columna"];
//`fecha` = 
 
$query= "SELECT * FROM ".$tabla." WHERE  `".$columna."` BETWEEN  '".$fecha1."' AND  '".$fecha2."'; ";
//echo $query;
$result = $mysqli->query($query);
///printf("Affected rows (SELECT): %d\n", $mysqli->affected_rows);
$datos["filas"]=$mysqli->affected_rows;
$i=0;

while ($row = $result->fetch_assoc()) {
$data[$i] =$row;
$i++;
}
$datos["datos"]=$data;
$result->free();

$mysqli->close();

//printf("<p>todo se hiso muy bien</p>");
echo json_encode($datos);
?>
