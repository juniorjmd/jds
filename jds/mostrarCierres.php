<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Cierres Diarios</title>
<link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script>
$(document).ready(function(){
$("#fecha1").change(function(){
$("#fecha2").attr('min',$("#fecha1").val());});});
</script>
</head>

<body>
<?php 
include 'db_conection.php';
include 'php/funcionesMysql.php';
 $conn= cargarBD();
 $aux="";$where="";
 if($_POST['mostrar']){$aux=" and `fecha` <= ";
	if(trim($_POST['meses'])!="0"){
		switch ($_POST['meses']) {
case"1": $mes="ENERO";break;
case"2": $mes="FEBRERO";break;
case"3": $mes="MARZO";break;
case"4": $mes="ABRIL";break;
case"5": $mes="MAYO";break;
case"6": $mes="JUNIO";break;
case"7": $mes="JULIO";break;
case"8": $mes="AGOSTO";break;
case"9": $mes="SEPTIEMBRE";break;
case"10": $mes="OCTUBRE";break;
case"11": $mes="NOVIENBRE";break;
case"12": $mes="DICIEMBRE";break;}
echo "CIERRE DE CAJA DEL MES DE ".$mes;
		$anio=date("Y");
		$mes=trim($_POST['meses']);
		$dia=1;
		$fecha1=$anio."-".$mes."-".$dia;
		$mes=$mes+1;//2013-01-29
		if(trim($_POST['meses'])=="12"){$anio=$anio+1;$mes=1;}
		$fecha2=$anio."-".$mes."-".$dia;
		}else{
		if($_POST["fecha1"])
		{$fecha1="'".$_POST["fecha1"]."'";echo "CIERRE DE CAJA DESDE ".$_POST["fecha1"];}
		
		if($_POST["fecha2"]!="")
		{$fecha2= "'".$_POST["fecha2"]."'";ECHO "HASTA EL ".$_POST["fecha2"];}else{$aux="";}
			
		}
		$where="WHERE `fecha`>= ";
}
		
$query="SELECT * FROM  `cierrediario` ".$where.$fecha1.$aux.$fecha2." ORDER BY  `fecha` DESC ";
//echo $query;
$result = $conn->query($query);
while ($row = $result->fetch_assoc()) {
$html =$html."<tr>
<td>".$row["idCierre"]."</td>
<td>".$row["saldoInicial"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["totalVenta"]."</td>
<td>".$row["totalGasto"]."</td>
<td>".$row["totalRetiro"]."</td>
<td>".$row["totalEfectivo"]."</td>
<td>".$row["saldoActual"]."</td>
</tr>";



$datos["datos"]=$data;
$result->free();
$conn->close();
}?>
<form action="mostrarCierres.php" method="post" autocomplete="off">
<table align="center">
<tr>
<td>MES DE ESTE AÑO <input type="hidden" name="mostrar" value="si"</td>
<td>
<select name="meses"id="meses">
<option value="0">Ninguno</option>
<option value="1">Enero</option>
<option value="2">Febrero</option>
<option value="3">Marzo</option>
<option value="4">Abril</option>
<option value="5">Mayo</option>
<option value="6">Junio</option>
<option value="7">Julio</option>
<option value="8">Agosto</option>
<option value="9">Septiembre</option>
<option value="10">Octubre</option>
<option value="11">Noviembre</option>
<option value="12">Diciembre</option>
</select></td><td>&nbsp;</td>
<td>FECHA INICIAL</td>
<td>
<input type="date" class="date" name="fecha1" id="fecha1">
</td>
<td>HASTA</td>
<td><input type="date" class="date" name="fecha2" id="fecha2">
</td>
<td><input type="image" src="imagenes/actualizar.png" value="actualizar" height="75" width="75"></td>
</tr>
</table></form>

<table align="center">
<tr>
<td colspan=""></td><td colspan=""></td><td colspan=""></td><td colspan=""></td><td colspan=""></td><td colspan=""></td><td colspan=""></td><td colspan=""></td>
</tr>
<?php echo $html;?>
</table>
</body>
</html>