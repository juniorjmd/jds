<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
$query='select `codigo` from articulo';
$result = $mysqli->query($query);
$filas=$result->num_rows;
if($filas!=0){
	$codigo='MG'.($filas+1);
	$iteracion=$flag=1;
	while ($flag==1){
		$iteracion++;
		$query2="SELECT * 
FROM  `articulo` 
WHERE  `codigo` =  '".$codigo."'";
		//echo $query2;
		$result2 = $mysqli->query($query2);
		if($result2->num_rows==0)
		{$flag=0;}else{$codigo='MG'.($filas+$iteracion);}
		}
	}
else{$codigo='MG'.($filas+1);}
echo $codigo;

?>