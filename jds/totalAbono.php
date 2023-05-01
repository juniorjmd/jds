<?php
	$query2="SELECT * FROM  `abonosnomina`  where id_empleado = '".$_POST['codigo']."' AND estado = 'ACTIVO'";
echo $query2;
$result = $conn->query($query2);
$abonosActual=0;
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$abonosActual=$abonosActual+$row["cantidad"];
} 
}
echo $abonosActual;
?>