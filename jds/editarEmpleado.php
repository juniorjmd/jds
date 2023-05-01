<?php 
include 'php/inicioFunction.php';
verificaSession_2("login/"); 
include 'db_conection.php';
$conn= cargarBD();
$tabla="";
if($_POST["nombre"]){
	$stmt = $conn->stmt_init();
		$query="UPDATE  `empleados` SET  `nombre`=  '".$_POST['nombre']."' ,`apellido`=  '".$_POST['apellido']."' , `monto_dia`=  '".$_POST['val_por_dia']."'  WHERE  `empleados`.`id` =".$_POST['codigo'].";";
		$stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo insertar los datos en la tabla :' . $conn->error);
		 
		}
	
	}
	
	$query2="SELECT * FROM `empleados` where id= '".$_POST['codigo']."'";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$nombre=$row["nombre"];
	$apellido=$row["apellido"];
	$monto_dia=$row["monto_dia"];
	$id=$row["id"];
} 
}

	$query2="SELECT * FROM  `abonosnomina`  where id_empleado = '".$_POST['codigo']."' AND estadoNomina = 'ACTIVO'";
//echo $query2;
$result = $conn->query($query2);
$abonosActual=0;
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$abonosActual=$abonosActual+$row["cantidad"];
} 
}

$query2="SELECT * FROM   `nomina`  where pagadoA= '".$_POST['codigo']."' ";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) { 
	$tabla=$tabla.'<tr class="listaInv" id="'.$row["id"].'">
	<td>'.$row["id"].'</td>
	<td>'.$row["nombre"].' '.$row["apellido"].'</td>
	<td>'.$row["monto_dia"].'</td>
	</tr>';
} 
}

if($tabla==""){$tabla="<tr><td colspan='4'>No posee ningun pago de nomina registrado</td>
</tr>";} ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Empleados</title>
</head>

<body>
<div align="center" ><br>
  <h1>Edicion de empleados</h1>
  <input id="cancelar" type="image" src="imagenes/cancelar.jpg" height="50" width="60" title="cancelar edicion/regresar a empleados">
<form action="editarEmpleado.php" method="post">
<table>

<td height="41" align="right">Id</td><td><input type="number" name="codigo" id="cod" disabled value="<?php echo $id; ?>"></td>
</tr>
<tr>
<td height="45" align="right">Nombre</td><td><input type="text" name="nombre" value="<?php echo $nombre; ?>"></td><td align="right">Apellido</td><td><input type="text" name="apellido"value="<?php echo $apellido; ?>"></td>
</tr>
<tr>
<td align="right">Valor por dia</td><td><input type="number" name="val_por_dia"  value="<?php echo $monto_dia; ?>"></td><td><input type="image" src="imagenes/accept (2).png" height="50" width="60" id="enviar"></td><td></td>
</tr>
<tr>
<td align="right">ABONOS REALIZADOS DESPUES DEL ULTIMO PAGO</td><td colspan="2" style="font-size:60px;font-family:Comic Sans MS,arial,verdana;color: #06C"><?php echo $abonosActual; ?></td>
</tr>

</table>
</form></div>
<div id="listadoEmpleados" align="center">
<table width="609" height="55">
<tr style="font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif">
<td width="142" height="48">IDENTIFICACION</td>
<td width="334" align="center"> NOMBRE/APELLIDO </td>
<td width="170">PAGO POR DIA ($)</td>
</tr>
<?php echo $tabla; ?>
</table>
</div>

</body>
</html>



<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<style >
.listaInv{ cursor:pointer; color:#039; font-family:Comic Sans MS,arial,verdana; font-size:18px}
.listaInv:hover{ background-color: #06C;color: #9C0}
</style>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$("#enviar").click(function(){
	$("#cod").css("display","none");
	$("#cod").removeAttr("disabled");
	});
	
	$("#cancelar").click(function(){
	location.href="empleado.php";
	});
	
})

</script>