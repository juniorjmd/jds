<?PHP include 'php/inicioFunction.php';
verificaSession_2("login/");
/*hala los abonos realidazos al trabajador*/
	$empleado=$_POST['empleadoId'];
	

include 'db_conection.php';
 $conn= cargarBD();
$query="SELECT  SUM(`cantidad`) AS TOTAL FROM  `abonosnomina` WHERE  `id_empleado` =  '".$empleado."' AND  `estadoNomina` =  'ACTIVO'" ;
//echo $query;

$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
 $total=$row["TOTAL"];
}

//echo $total;

$query="SELECT * FROM  `empleados`  WHERE  `id` =  '".$empleado."' " ;
//echo $query;

$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
 $id=$row["id"];
 $monto_dia=$row["monto_dia"];
}
$envio=array();
$envio['total']=$total;
$envio['idEmpleado']=$id;
$envio['monto_dia']=$monto_dia;
 echo json_encode($envio);
 
 
?>