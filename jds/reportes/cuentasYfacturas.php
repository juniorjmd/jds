<?php
include '../php/inicioFunction.php'; 
verificaSession_2("login/");
include '../db_conection.php';
$totalPrestamosIniciales = $totalAbonosAcumulado= $totalDeudaActual =0;
if($_GET['id']){$auxQ=" WHERE c.nombre LIKE'%".$_GET['id']."%' OR cl.razonSocial LIKE'%".$_GET['id']."%'";
$auxQ= $auxQ." or c.idCuenta LIKE'%".$_GET['id']."%' OR cl.nit LIKE'%".$_GET['id']."%' ";
}
$mysqli = cargarBD();
//ORDER BY  `producto`.`Grupo` ASC 
//$query=" SELECT * FROM allProductPlusTotalSales ".$auxQ." order by IDLINEA";
/*SELECT c.idCuenta ,c.refFact, c.nombre , c.fechaIngreso, c.descripcion, c.TotalInicial , c.valorInicial , c.abonoInicial, 
c.valorCuota , c.TotalActual, cl.nit , cl.razonSocial , cl.telefono , cl.direccion ,IFNULL(ab.Tabono,0) ,fa.* FROM `cartera`c 
left join clientes cl on cl.idCliente = c.idCliente left join (select sum(valorAbono) AS Tabono , idFactura as abidf 
from abonoscartera group by idFactura) ab on ab.abidf = c.idCuenta left JOIN factenvios fa on fa.id_factura = c.refFact 
ORDER by 1,3*/

$query="SELECT c.idCuenta ,c.refFact, c.nombre , c.fechaIngreso, c.descripcion, c.TotalInicial , c.valorInicial , ".
" c.abonoInicial, c.valorCuota , c.TotalActual, cl.nit , cl.razonSocial , cl.telefono , cl.direccion ,".
" IFNULL(ab.Tabono,0) ,	fa.`id_factura`, fa.`fechaInicio`, fa.`fechaFinal`, fa.`fechaIngreso`, fa.`flete`, fa.`descuento`, ".
" fa.`s_combustible`, fa.`otros`, fa.`arancel`, fa.`iva_arancel`, fa.`c_administrativos`, fa.`manejos`, fa.`iva_manejos`, ".
" fa.`otros_costos`, fa.`valor_total`, fa.`id_cliente`, fa.`cod_factura`, fa.`cuenta_cliente`,  fa.`ref_1`, fa.`ref_2`, ".
" fa.`ref_3`, fa.`ref_4`, fa.`ref_5` ".
" FROM `cartera`c left join clientes cl on cl.idCliente = c.idCliente ".
" left join (select sum(valorAbono) AS Tabono , idFactura as abidf from abonoscartera group by idFactura) ab ".
" on ab.abidf = c.idCuenta left JOIN factenvios fa on fa.id_factura = c.refFact  ".$auxQ." ORDER by 1,3";
echo $query;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
?>
<body>

<div id='header'> <img src="../imagenes/SIM_logo_WIP.png"   > </div>
<table border="0" width="100%" style="">
<tr bordercolor="#000033"   >
<td  >Cuenta</td>
	<td  align="center" style='width:25%'>Descripcion</td>
	<td  >Fecha inicio</td>
    <td  align="center">Monto</td>
	<td  >1er Abono</td>
	<td  >Deuda inicial</td>
	<td  >valor X cuotas</td>
	<td  >T. abonos</td>
	<td  >Deuda actual</td>
	<td align="center">Ra. Social</td>
	<td align="center">Nombre</td>
    <td  align="center">NIT</td>
	<td  >Telefono</td>
	<td  align="center" style='width:10%'>Direccion</td>
</tr>
<style>
</style>
<?php

if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$color="#7DA2FF";
	if($row['cantActual']<$row['stock']){
	$color="#FF9194";}
	//ALTER TABLE `cartera` ADD `refFact` VARCHAR(60) NOT NULL DEFAULT 'N/A' AFTER `TotalActual`;
	$listaInv='';
	//echo $row['refFact'];
	if (trim($row['refFact']) != 'N/A') {
		$envioDato = $row['refFact'];$listaInv='listaInv';}
	echo'<tr align="center"    >';
	echo '<td>'.$row['idCuenta'].'</td>';
	echo '<td align="left">'.$row['descripcion'].'</td>';
	echo '<td>'.$row['fechaIngreso'].'</td>';
	echo '<td align="right">'.amoneda($row['TotalInicial'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['abonoInicial'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['valorInicial'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['valorCuota'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['Tabono'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['TotalActual'],"pesos").'</td>';
	echo '<td align="left">'.$row['razonSocial'].'</td>';
	echo '<td align="left">'.$row['nombre'].'</td>';
	echo '<td>'.$row['nit'].'</td>';
	echo '<td>'.$row['telefono'].'</td>';
	echo '<td>'.$row['direccion'].'</td></tr>';
	$totalDeudaActual= $totalDeudaActual + ($row['TotalActual'] );
	$totalAbonosAcumulado=$totalAbonosAcumulado+$row['Tabono'];
	$totalPrestamosIniciales=$totalPrestamosIniciales + $row['valorInicial'];
	}

}else{echo'<tr><td align="center" colspan="14">NO POSEE NINGUN REGISTRO</td></tr>';}
?></table>
<div   > 
<div  style="float:right; margin-right:10px; margin-top:-5px">T. Deuda Actual:<br/><span style='margin-left:auto;margin-right:auto' id='sp_3' >$ 00.000.00</span> </div>
<div  style="float:right; margin-right:10px; margin-top:-5px">T. Abonos Recibidos:<br/><span style='margin-left:auto;margin-right:auto' id='sp_4' >$ 00.000.00</span>  </div>
<div  style="float:right; margin-right:10px; margin-top:-5px">Numero de prestamos :<br/><span style='margin-left:auto;margin-right:auto' id='sp_2' >0000</span>  </div>
<div  style="float:right; margin-right:10px; margin-top:-5px;  ">Total prestado :<br/><span style='margin-left:auto;margin-right:auto' id='sp_1' >0000</span>  </div>
</div>

<form action="reporteFactura.php" method="post">
<input type="hidden" id="dato" name="codigo">
<input type="submit" id="enviar" style="display:none">
</form>
<input type='hidden' value='<?php echo amoneda($totalAbonosAcumulado,"pesos");?>' id='totalAbonosAcumulado'/>
<input type='hidden' value='<?php echo amoneda($totalPrestamosIniciales,"pesos");?>' id='totalPrestamosIniciales'/>
<input type='hidden' value='<?php echo $datosNum;?>' id='totalPrestamos'/>
<input type='hidden' value='<?php echo amoneda($totalDeudaActual,"pesos");?>' id='totalDeudaActual'/>
</body>
<link type="text/css" href="../css/menuContextual.css" rel="stylesheet" />
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>

<script type="text/javascript" >

$(document).ready(function(){
 $("#sp_1").html($('#totalPrestamosIniciales').val())
 $("#sp_2").html($('#totalPrestamos').val())
 $("#sp_3").html($('#totalDeudaActual').val())
 $("#sp_4").html($('#totalAbonosAcumulado').val())
	 
});
</script> 