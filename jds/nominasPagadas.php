<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'db_conection.php';
 $conn= cargarBD();
 if(isset($_POST['empleadoId'])){$NOMBRE="`pagadoA`= '".$_POST['empleadoId']."'";}
if(isset($_POST['SI'])){$AND=" AND ";}else{$AND="";}
if(isset($_POST['fecha'])){$FECHA="`fecha`= '".$_POST['fecha']."'"; } else {$FECHA='';}

$query2="SELECT * FROM  `nomina` WHERE".$NOMBRE.$AND.$FECHA;
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows >0){
while ($row = $result->fetch_assoc()) {
    if($row["descripcion"] == '' ){$row["descripcion"] = '&nbsp;';}
	echo "<tr><td><a href='desplegarNominas.php?idSF=".$row["idSF"]."'><img src='imagenes/libro.jpg'></a></td>
	<td>".$row["nombreUsuario"]."</td>
	<td>".$row["fecha"]."</td>
	<td>".$row["totalParcial"]."</td>
	<td>".$row["pagadoA"]."</td>
	<td>".$row["porConceptoDe"]."</td>
	<td>".$row["descripcion"]."</td>
	</tr>";
}
}else{echo "<tr><td colspan='7'>NO EXISTE NINGUN REGISTRO CON ESA CONBINACION DE BUSQUEDA, INTENTE DE NUEVO POR FAVOR O ACTUALICE...</td>
</tr>";}
$datos["datos"]=$data;
$result->free();
$conn->close();

?>