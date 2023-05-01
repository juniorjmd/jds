<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>NOMINA #<?php echo $_GET['idSF'];?></title>
 

 <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script> 
</head>

<body><table align="center"><tr>
  <td colspan="4" align="right"><a href="nomina.php" style="text-decoration:none">
<img src="imagenes/images (1).jpg" width="45" height="35" title="ir a nomina"></a> 
      <!--<input type="image" src="imagenes/imprimir.png" width="36" height="30" title="imprimir reporte">--></td>
</tr>
<?php 
include 'db_conection.php';
 $conn= cargarBD();
$query2="SELECT `nomina`.*, `empleados`.* FROM  `nomina` inner join `empleados` on `empleados`.id=`nomina`.pagadoA WHERE `idSF`=".$_GET['idSF'];
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
$usuario=$row["nombreUsuario"];
$fecha=$row["fecha"];
$totalParcial=$row["totalParcial"];
$empleado=$row["nombre"]." ".$row["apellido"];
$idEmpleado=$row["pagadoA"];
$totalAbonos=$row["abonos/Anticipos"];
$totalEfectivo=$row["totalPagado"];
$diasPagados=$row["diasTrabajados"];
$descripcion=$row["descripcion"];
$montoPorDia=$row["monto_dia"];
}
$result->free();
echo'
<tr>
<td colspan="4" align="center"><h2><strong>Pago de Nomina # '.$_GET['idSF'].'</strong></h2></td></tr><tr>
<td colspan="4" align="center"><h4><strong>'.$descripcion.'</strong></h2></td>
</tr><tr>&nbsp;</tr><tr>
<td align="right">FECHA  &nbsp;&nbsp;</td><td class="ent">'.$fecha.'</td><td align="right">USUARIO  &nbsp;&nbsp;</td><td class="ent">'.$usuario.'</td>
</tr>
<tr>
<td align="right">EMPLEADO  &nbsp;&nbsp;</td><td class="ent">'.$empleado.'</td><td align="right">CC.  &nbsp;&nbsp;</td><td class="ent">'.$idEmpleado.'</td>
</tr><tr>
<td align="right">VALOR x DIA  &nbsp;&nbsp;</td><td class="ent">'.amoneda($montoPorDia).'</td><td align="right">DIAS LABORADOS  &nbsp;&nbsp;</td><td class="ent">'.$diasPagados.'</td>
</tr><tr>
<td align="right">SUB TOTAL  &nbsp;&nbsp;</td><td class="ent">'.amoneda($totalParcial).'</td><td align="right">ANTICIPOS  &nbsp;&nbsp;</td><td class="ent">'.$totalAbonos.'</td></tr><tr>
<td align="right" colspan="2">TOTAL ENTREGADO  &nbsp;&nbsp;</td><td class="ent">'.amoneda($totalEfectivo).'</td>
</tr></table><br>';

$query2="SELECT * FROM  `abonosnomina`  WHERE `id_pago_nomina`=".$_GET['idSF'];
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows >0){
echo '<table align="center" width="500"><tr><td align="center" colspan="3">DESCIPCION DE LOS ABONOS</td></tr>
<tr><td>USUARIO</td><td>FECHA</td><td>CANTIDAD</td></tr>';
while ($row = $result->fetch_assoc()) {
echo '<tr class="ent"><td>'.$row["nombreUsuario"].
'</td><td>'.$row["fecha"].
'</td><td align="right">'.$row["cantidad"].'</td></tr>';
}

echo '</table >';
}
$result->free();
$conn->close();
?></body>
</html>