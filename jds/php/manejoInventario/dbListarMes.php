<?php

$mysqli = new mysqli('localhost','root','1234','prueva');
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}


$tabla=$_POST["tabla"];
$columna=$_POST["columna"];
//`fecha` = 
 
$query= "SELECT * FROM ".$tabla." WHERE MONTH( `".$columna."`) = MONTH(CURDATE()) ";
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
