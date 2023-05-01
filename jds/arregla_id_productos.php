<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'db_conection.php';
$aux_array = array();
$aux_array_2 = array();
$mysqli = cargarBD();

$query2="SELECT * FROM `producto` order by idlinea";
//echo $query2;
$result = $mysqli->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$codigo=substr($row["idProducto"],2);
	echo $codigo.'<br>';
} 
}

$codigo++;

//$query="SELECT  * FROM  `ventas` WHERE `idVenta`='".$ventaId."' ";   update producto set `idProducto` = '' where `IDLINEA` = 
$query="SELECT  * FROM  `producto` order by IDLINEA ";
//echo $query;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
$contador = 0;
$idProducto= "";
while ($row = $result->fetch_assoc()) {
	$aux_array [$contador]['sql']= "update producto set `idProducto` = 'MV".$row['IDLINEA']."' where `IDLINEA` = ".$row['IDLINEA'];
	$contador = $contador +1;
	if($idProducto == $row['idProducto'] )
	{$datosNum++;
		
	}
	$idProducto=$row['idProducto'];
}
echo "se actualizaran ".$contador." productos<br>" ;
$variable = '';
echo sizeof($cars);
$contador = 0;
$conta=0;
//echo lenght($aux_array_2) ;
foreach ($aux_array as $aux_array_2 ){
	foreach ($aux_array_2 as $query_act ){
	$variable = $variable.'<br>'.$query_act;
	$result = $mysqli->query($query_act);
	}
	$contador = $contador +1;
}

echo $variable;
echo '<br>';
echo "se actualizaron ".$contador." productos<br>" ;

mysqli_close($mysqli);
?>