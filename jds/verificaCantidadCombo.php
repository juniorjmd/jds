<?php 
include 'db_conection.php';
$mysqli = cargarBD();
$query="SELECT * FROM `relacioncombo` INNER JOIN producto on (relacioncombo.idProducto = producto.idProducto) WHERE `id`= '".$_POST['idCombo']."'";
$cantidadActual=$i=0;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
$actualPromedio;
while ($row = $result->fetch_assoc()) {
	$i++;
	$actualPromedio=floor($row["cantActual"]/$row["cantidad"]);
	if($i==1){$cantidadActual=$actualPromedio;}
	if ($cantidadActual>$actualPromedio){
$cantidadActual=$actualPromedio;}
	}	
echo $cantidadActual;
 ?>