<?php  include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/"); ?>
<?php 

$disabled="disabled";
 include '../php/db_conection.php';
echo "<div id='print' align='center'>";
include '../php/funcionesMysql.php';
$mes=date(m,strtotime($_GET['fecha']));
$anio=date(Y,strtotime($_GET['fecha']));
switch ($mes){
	case 1:
	$mesSpa="ENERO";
	break;
	case 2:
	$mesSpa="FEBRERO";
	break;
	case 3:
	$mesSpa="MARZO";
	break;
	case 4:
	$mesSpa="ABRIL";
	break;
	case 5:
	$mesSpa="MAYO";
	break;
	case 6:
	$mesSpa="JUNIO";
	break;
	case 7:
	$mesSpa="JULIO";
	break;
	case 8:
	$mesSpa="AGOSTO";
	break;
	case 9:
	$mesSpa="SEPTIEMBE";
	break;
	case 10:
	$mesSpa="OCTUBRE";
	break;
	case 11:
	$mesSpa="NOVIEMBRE";
	break;
	case 12:
	$mesSpa="DICIEMBRE";
	break;
	
	}
	
echo '<table width="100%"  style=" border-bottom-color:#06C">
<tr>
<td >'.$_GET['fecha']."
</br><span>RESUMEN DEL MES DE ".$mesSpa." DE LA SUCURSAL</br>".$_GET['sucursal'].'</span></br></br></td><td ><a href="cierreCaja.php"><img src="../imagenes/pay-day-icon-9928159.jpg" height="60" width="60" title="regresar a cierre" /></a><input type="image"  id="printBoton"  src="../imagenes/imprimir.png" height="60" width="60" title="imprimir informe" /></td></tr></table>';
$fecha1="'".normalize_date($mes."/01/".$anio,"-")."'"; 	
if($mes==12)
{$anio++;
$mes=01;
}else{$mes++;}
$fecha2="'".normalize_date($mes."/01/".$anio,"-")."'"; 	
 $conn= cargarBD();
 $query2="SELECT IFNULL(SUM(`valorTotal`),0) AS TOTAL, IFNULL(SUM(`COSTOS`),0) AS COSTOS    FROM `ventas` WHERE tipoDeVenta <> 'CREDITO' AND estadoFactura <> 'C' AND fecha>=".$fecha1."and fecha<".$fecha2;
 //echo $query2."</br></br>";//muestra las ventas del mes completo 
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
if($row["TOTAL"]!=0)
	{$TOTALVENTA=$row["TOTAL"];}
	else{$TOTALVENTA="0";}
 if($row["COSTOS"]!=0)
	{$PRECIOCOSTO=$row["COSTOS"];}
	else{$PRECIOCOSTO="0";}       
}$result->free();
        

        
$GANANCIABRUTA=$TOTALVENTA-$PRECIOCOSTO;


//////////////////////////COMPRAS
$query2="SELECT SUM(`valorTotal`) AS TOTAL FROM `compras` WHERE   `referencia`= 'ninguno' AND  fecha>=".$fecha1."and fecha<".$fecha2;
//$query2="SELECT IFNULL(SUM(`valorGasto`),0) AS TOTAL FROM `gastos` WHERE fecha>=".$fecha1."and fecha<".$fecha2;
//echo $query2."</br>";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$COMPRAMES=$row["TOTAL"];$disabled="";}
	else{$COMPRAMES="0";}
}
$result->free();
//////////////////////////gasto
$query2="SELECT IFNULL(SUM(`valorGasto`),0) AS TOTAL FROM `gastos` WHERE fecha>=".$fecha1."and fecha<".$fecha2;
//echo $query2."</br>";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$GASTOMES=$row["TOTAL"];$disabled="";}
	else{$GASTOMES="0";}
}
$result->free();
////////////////////////////////salidas en efectivo
$query2="SELECT IFNULL(SUM(`valorGasto`),0) AS TOTAL FROM `salidasefectivo` WHERE  fecha>=".$fecha1."and fecha<".$fecha2;
        
$result = $conn->query($query2);
        
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$SALIDASEFECTIVO=$row["TOTAL"];}
	else{$SALIDASEFECTIVO="0";}
}


////////////////////////////////////////////////////////
 
$query2="SELECT   IFNULL(sum(`abonoscartera`.`valorAbono`),0)AS TOTAL
FROM `abonoscartera` where  fecha>=".$fecha1."and fecha<".$fecha2;
$result = $conn->query($query2);
//echo $query2."</br>";
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$abonoscartera=$row["TOTAL"];}
	else{$abonoscartera="0";}
}
////////////////////////////////////////////////////////

$query2="SELECT   IFNULL(sum(`abonoscredito`.`valorAbono`),0)AS TOTAL
FROM `abonoscredito` where  `estado` in ('revisado' ,'activo') and fuente_pago = 'caja' and fecha>=".$fecha1."and fecha<".$fecha2;
//echo $query2."</br>";
//$query2="SELECT IFNULL(SUM(`valorAbono`),0) AS TOTAL FROM `abonoscredito` WHERE `estado`='activo' and fuente_pago = 'caja' ";
 
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$abonoscredito_efectivo=$row["TOTAL"];}
	else{$abonoscredito_efectivo="0";}
}
////////////////////////////////////////////////////////


$query2="SELECT   IFNULL(sum(`abonoscredito`.`valorAbono`),0)AS TOTAL
FROM `abonoscredito` where `estado` in ('revisado' ,'activo') and fuente_pago != 'caja' and fecha>=".$fecha1."and fecha<".$fecha2;
//echo $query2."</br>";
// $query2="SELECT IFNULL(SUM(`valorAbono`),0) AS TOTAL FROM `abonoscredito` WHERE `estado`='activo' and fuente_pago != 'caja' ";

$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$abonoscredito_bancos=$row["TOTAL"];}
	else{$abonoscredito_bancos="0";}
}
////////////////////////////////////////////////////////
        
$query2="SELECT   IFNULL(sum(`abonosnomina`.`cantidad`),0)AS TOTAL".
" FROM `abonosnomina` where  fecha>=".$fecha1."and fecha<".$fecha2;
//echo $query2."</br>";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$abonosnomina=$row["TOTAL"];}
	else{$abonosnomina="0";}
}
////////////////////////////////////////////////////////
        
$query2="SELECT   IFNULL(sum(`bancos`.`VALOR`),0)AS TOTAL ".
" FROM `bancos` where  FECHA>=".$fecha1."and FECHA<".$fecha2;
//echo $query2."</br>";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$bancos=$row["TOTAL"];}
	else{$bancos="0";}
}
////////////////////////////////////////////////////////
        
        

  $pagosiva=0;   
  /*
$query2="SELECT   IFNULL(sum(`pagosiva`.`IVA`),0)AS TOTAL".
" FROM `pagosiva` where  FECHA>=".$fecha1."and FECHA<".$fecha2;
//echo $query2."</br>";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$pagosiva=$row["TOTAL"];}
	else{$pagosiva="0";}
}*/
////////////////////////////////////////////////////////


        
$retefuente_pagada = 0;
/*$query2="SELECT   IFNULL(sum(`retefuente_pagada`.`totalRf`),0)AS TOTAL".
" FROM `retefuente_pagada` where  FECHA>=".$fecha1."and FECHA<".$fecha2;
$result = $conn->query($query2);
//echo $query2."</br>";
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$retefuente_pagada=$row["TOTAL"];}
	else{$retefuente_pagada="0";}
}*/
////////////////////////////////////////////////////////

        




//////////////////////////////////////////////////////////////////7
	
?>
<link href="../ayuda/jquery-ui.css" rel="stylesheet">
<script src="../ayuda/external/jquery/jquery.js"></script>
<script src="../ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="../js/trim.js"></script>
<div align="center">
    <table width="813"  style=" border-bottom-color:#06C">
<tr>
<td colspan="7" align="center">&nbsp;</td>
</tr>
<tr>
<td colspan="7" align="center"><h2>RESUMEN ENTRADAS DEL MES</h2></td>
</tr>

<tr>
<td colspan="7" align="center">&nbsp;</td>
</tr>
<tr>
    <td width="85">&nbsp;</td><td width="37">&nbsp;</td><td width="159" style=" text-align: center">TOTAL VENTA</td>
    <td width="178" style=" text-align: center">PRECIO COSTO</td><td style=" text-align: center">GANANCIA BRUTA</td><td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr><td>&nbsp;</td>
<tr><td>&nbsp;</td>
<td>&nbsp;</td><td class="respuesta" style="color: #06C; text-align: right" nowrap ><?php echo amoneda($TOTALVENTA,pesos);?> </td>
<td  class="respuesta" style="color: #EA0012; text-align: right" nowrap ><?php echo amoneda($PRECIOCOSTO,pesos);?> </td>
<td class="respuesta" style="color: #63F; text-align: right" nowrap  ><?php echo amoneda($GANANCIABRUTA,pesos);?> </td><td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td colspan="7" align="center">&nbsp;</td>
</tr>
<tr>
<td width="85">&nbsp;</td><td width="37">&nbsp;</td><td width="159" style=" text-align: center"> ABONOS A CARTERA</td> 
 <td width="38">&nbsp;</td>
</tr>
<tr>
<td width="85">&nbsp;</td><td width="37">&nbsp;</td><td class="respuesta" nowrap style="color: #06C"><?php echo amoneda($abonoscartera,pesos);?></td>
 <td width="38">&nbsp;</td>
</tr>
<tr>
<td colspan="7" align="center">&nbsp;</td>
</tr>
<tr>
<td colspan="7" align="center"><h2>RESUMEN SALIDA DEL MES</h2></td>
</tr>
<tr>
<td colspan="7" align="center">&nbsp;</td>
</tr>
<tr>
<td height="34">&nbsp;</td><td colspan="2">GASTO DEL MES</td><td class="respuesta" nowrap style="color: #EA0012"><?php echo amoneda($GASTOMES,pesos);?></td>
<td width="157">PAGOS A SOCIOS</td><td class="respuesta" nowrap style="color: #EA0012"><?php echo amoneda($SALIDASEFECTIVO,pesos);?></td>
<td width="38">&nbsp;</td>
</tr>
<!--INICIO DE PAGOS  -->
<tr>
<td height="34">&nbsp;</td>
 <td colspan="2">PAGOS DE NOMINA</td><td class="respuesta" nowrap style="color: #EA0012"><?php echo amoneda($abonosnomina,pesos);?></td>
 
 <td width="157">COMPRAS EN EFECTIVO</td><td class="respuesta" nowrap style="color: #EA0012"><?php echo amoneda($COMPRAMES,pesos);?></td>

<td width="38">&nbsp;</td>
</tr>

<tr>
<td height="34">&nbsp;</td><td colspan="2">PAGOS A CREDITO EN EFECTIVO</td><td class="respuesta" nowrap style="color: #EA0012"><?php echo amoneda($abonoscredito_efectivo,pesos);?></td>
<td width="157">PAGOS A CREDITO POR BANCOS</td><td class="respuesta" nowrap style="color: #EA0012"><?php echo amoneda($abonoscredito_bancos,pesos);?></td>
<td width="38">&nbsp;</td>
</tr>

 
<!-- PAGOS IMPUESTOS
<tr>
<td >&nbsp;</td><td colspan="2">PAGOS IVA</td><td class="respuesta" nowrap style="color: #EA0012"><?php echo amoneda($pagosiva,pesos);?></td> 
<td  >PAGO RETEFUENTE</td><td  class="respuesta" nowrap style="color: #EA0012"><?php echo amoneda($retefuente_pagada,pesos);?></td>
<td width="38">&nbsp;</td>
</tr>
 -->
<!--FIN DE PAGOS  -->

<tr>
<td colspan="7" align="center">&nbsp;</td>           
</tr>
<tr><td height="34">&nbsp;</td>
<td colspan="2">SALDO TOTAL DEL MES</td><td colspan="2" nowrap style="font-size:60px;font-family:Comic Sans MS,arial,verdana;color: #06C"><?php echo amoneda(($TOTALVENTA + $abonoscartera)-$COMPRAMES -$SALIDASEFECTIVO - $GASTOMES -  $abonoscredito_efectivo - $abonosnomina - $retefuente_pagada - $pagosiva - $bancos, pesos);?></td><td colspan="2">&nbsp;</td>
</tr>
<tr><td height="34">&nbsp;</td>
<td colspan="2">SALDO BANCOS DEL MES</td><td colspan="2" nowrap style="font-size:60px;font-family:Comic Sans MS,arial,verdana;color: #06C"><?php echo amoneda( $bancos, pesos);;?></td><td colspan="2">&nbsp;</td>
</tr>




</table></div>

<?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'resumenMes'.$mesSpa;$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
<div align="center">
    <table id="tabla_resultados">
        <tr>
            
   
 
            <td><div align="center"><span>LISTADO DE GASTOS</span></div></td>
        </tr>
         <tr>
            <td>
<table border="1px" style=" width:950px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
<td width="172"><strong>USUARIO</strong></td>
<td width="72"><strong>FECHA</strong></td>
<td width="69"><strong>VALOR</strong></td>
<td width="91"><strong>PAGADO A</strong></td>
<td width="109"><strong>POR CONCEPTO</strong></td>
<td width="168"><strong>SUCURSAL</strong></td>
<td width="171"><strong>DESCRIPCION</strong></td>
</tr><tbody id="tablaGastos">
<?php 
$query2="SELECT  `gastos`. * ,  `sucursales`.nombre_suc
FROM  `gastos` LEFT JOIN  `sucursales` ON  `gastos`.`idSucursal` =  `sucursales`.id_suc where `gastos`.`idSucursal` = '{$_SESSION["id_suc"]}' and`gastos`.fecha>=".$fecha1."and `gastos`.fecha<".$fecha2;
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>".$row["nombreUsuario"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["valorGasto"]."</td>
<td>".$row["pagadoA"]."</td>
<td>".$row["porConceptoDe"]."</td>
<td>".$row["nombre_suc"]."</td>
<td>".$row["descripcion"]."</td>
</tr>";

}

$datos["datos"]=$data;
$result->free();
?>
</tbody></table><br></td>
        </tr>
        
        <tr><td><div align="center">
                    <span>LISTADO DE PAGOS A SOCIOS</span></div></td></tr>
        <tr><td>
<table border="1px" style=" width:950px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
<td width="172"><strong>USUARIO</strong></td>
<td width="72"><strong>FECHA</strong></td>
<td width="69"><strong>VALOR</strong></td>
<td width="91"><strong>PAGADO A</strong></td>
<td width="109"><strong>POR CONCEPTO</strong></td>
<td width="168"><strong>SUCURSAL</strong></td>
<td width="171"><strong>DESCRIPCION</strong></td>
</tr><tbody id="tablaSalidas">
<?php 
$query2="SELECT  `salidasefectivo`. * ,  `sucursales`.nombre_suc
FROM  `salidasefectivo` LEFT JOIN  `sucursales` 
ON  `salidasefectivo`.`idSucursal` =  `sucursales`.id_suc where 
`salidasefectivo`.`idSucursal` = '{$_SESSION["id_suc"]}' and `salidasefectivo`.fecha>=".$fecha1."and `salidasefectivo`.fecha<".$fecha2;
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>".$row["nombreUsuario"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["valorGasto"]."</td>
<td>".$row["pagadoA"]."</td>
<td>".$row["porConceptoDe"]."</td>
<td>".$row["nombre_suc"]."</td>
<td>".$row["descripcion"]."</td>
</tr>";

}

$datos["datos"]=$data;
$result->free(); 

?>
</tbody></table></br></td></tr> 
        <tr><td><div align="center"><span>LISTADO DE RETIROS BANCOS</span></div></td></tr>
        <tr><td>
<table border="1px" style=" width:950px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
<td nowrap ><strong>ID</strong></td>
<td  width="72"><strong>PROVIENE DE </strong></td>
<td width="69"><strong>VALOR</strong></td>
<td width="91"><strong>VAUCHE</strong></td>
<td width="109"><strong>FECHA</strong></td>
<td width="168"><strong>DESCRIPCION</strong></td> 
</tr><tbody id="tablaBancos">
<?php 
/*id_deposito, provieneDe, VALOR, VAUCHE, FECHA, HORA, DESCRIPCION, IMANGEN, estado*/
$query2="SELECT  * from bancos where   FECHA >= $fecha1  and  FECHA < $fecha2 ; ";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>".$row["id_deposito"]."</td>
<td>".$row["provieneDe"]."</td>
<td>".$row["VALOR"]."</td>
<td>".$row["VAUCHE"]."</td>
<td>".$row["FECHA"].' - '.$row["HORA"]."</td>
<td>".$row["DESCRIPCION"]."</td>
</tr>";

}

$datos["datos"]=$data;
$result->free(); 
?>
</tbody></table></br></td></tr> 
        <tr><td><div align="center">
                    <span>LISTADO DE PAGOS DE NOMINA</span></div></td></tr>
        <tr><td>
<table border="1px" style=" width:950px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
 
<td nowrap ><strong>USUARIO</strong></td>
<td  width="72"><strong>EMPLEADO</strong></td>
<td width="80"><strong>FECHA</strong></td>
<td width="69"><strong>DESCRIPCION</strong></td>
<td width="91"><strong>DIAS</strong></td>
<td  ><strong>TOTAL PARCIAL</strong></td>
<td  ><strong>ABONOS/ANTICIPOS</strong></td> 
<td  ><strong>TOTAL</strong></td> 
</tr><tbody id="tablaNomina">
<?php 
/*idSF, idUsuario, nombreUsuario, descripcion, fecha, idSucursal, porConceptoDe,
 *  pagadoA, hora, estado, diasTrabajados, totalParcial, abonos/Anticipos, totalPagado*/
$query2=" SELECT *, concat( empleados.nombre,' ',empleados.apellido) as nom_empleado FROM  nomina 
inner join empleados on empleados.id =  nomina.pagadoA where   fecha >= $fecha1  and  fecha < $fecha2 ; ";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>".$row["nombreUsuario"]."</td>
<td>".$row["nom_empleado"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["porConceptoDe"]."</td>
<td>".$row["diasTrabajados"]."</td>
<td>".$row["totalParcial"]."</td>
<td>".$row["abonos/Anticipos"]."</td>
<td>".$row["totalPagado"]."</td>
</tr>";

}

$datos["datos"]=$data;
$result->free(); 
?>
</tbody></table></br></td></tr> 
        
      
   <tr><td><div align="center">
                    <span>LISTADO DE PAGOS A CREDITOS</span></div></td></tr>
        <tr><td>
<table border="1px" style=" width:950px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
       <td width="80"><strong>FECHA ABONO</strong></td>
<td width="69"><strong>DESCRIPCION</strong></td>
<td width="91"><strong>PROVEEDOR</strong></td>
<td  ><strong>FECHA CREDITO</strong></td>
<td  ><strong>TOTAL ABONO</strong></td> 
<td  ><strong>PAGADO POR</strong></td> 
<td  ><strong>VALOR INICIAL CRT</strong></td> 
</tr><tbody id="tablaNomina">
<?php 
/*idSF, idUsuario, nombreUsuario, descripcion, fecha, idSucursal, porConceptoDe,
 *  pagadoA, hora, estado, diasTrabajados, totalParcial, abonos/Anticipos, totalPagado*/
$query2="SELECT A.*,ifnull(B.descripcion ,'') as descripcion ,ifnull(b.nombre,'')as nombre ,ifnull(b.fechaIngreso,'')as fechaIngreso ,ifnull(b.TotalInicial,0) as TotalInicial  FROM abonoscredito A
        LEFT JOIN credito b ON idCuenta = idFactura 
        where   `estado` in ('revisado' ,'activo')  AND   fecha >= $fecha1  and  fecha < $fecha2 ; ";
        
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>".$row["fecha"]."</td>
<td>".$row["descripcion"]."</td>
<td>".$row["nombre"]."</td>
<td>".$row["fechaIngreso"]."</td>
<td>".$row["valorAbono"]."</td>
<td>".$row["fuente_pago"]."</td>
<td>".$row["TotalInicial"]."</td>
</tr>";

}

$datos["datos"]=$data;
$result->free(); 
?>
</tbody></table></br></td></tr> 
        <tr><td><div align="center">
                    <span>LISTADO DE ABONOS A CARTERA</span></div></td></tr>
        <tr><td>
<table border="1px" style=" width:950px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
       <td width="80"><strong>FECHA ABONO</strong></td>
<td width="69"><strong>DESCRIPCION</strong></td>
<td width="91"><strong>CLIENTE</strong></td>
<td  ><strong>FECHA CARTERA</strong></td>
<td  ><strong>TOTAL ABONO</strong></td> 
<td  ><strong>PAGADO POR</strong></td> 
<td  ><strong>VALOR INICIAL CRT</strong></td> 
</tr><tbody id="tablaNomina">
<?php 
/*idSF, idUsuario, nombreUsuario, descripcion, fecha, idSucursal, porConceptoDe,
 *  pagadoA, hora, estado, diasTrabajados, totalParcial, abonos/Anticipos, totalPagado*/
$query2="SELECT A.*,ifnull(B.descripcion ,'') as descripcion ,ifnull(b.nombre,'')as nombre ,ifnull(b.fechaIngreso,'')as fechaIngreso 
,ifnull(b.TotalInicial,0) as TotalInicial  FROM abonoscartera A
        LEFT JOIN cartera b ON idCuenta = idFactura 
        where   `estado` in ('revisado' ,'activo')  AND   fecha >= $fecha1  and  fecha < $fecha2 ; ";
        
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>".$row["fecha"]."</td>
<td>".$row["descripcion"]."</td>
<td>".$row["nombre"]."</td>
<td>".$row["fechaIngreso"]."</td>
<td>".$row["valorAbono"]."</td>
<td>".$row["fuente_pago"]."</td>
<td>".$row["TotalInicial"]."</td>
</tr>";

}

$datos["datos"]=$data;
$result->free(); 
?>
</tbody></table></br></td></tr>     
        
        <tr><td><div align="center">
                    <span>LISTADO DE COMPRAS EFECTIVO</span></div></td></tr>
        <tr><td>
<table border="1px" style=" width:950px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
       <td width="80"><strong>FECHA COMPRA</strong></td>       
<td  ><strong>ID COMPRA</strong></td>
<td width="69"><strong>NIT PROV.</strong></td>
<td width="91"><strong>PROVEEDOR</strong></td>
<td  ><strong>VALOR PARCIAL</strong></td>
<td  ><strong>DESCUENTO</strong></td> 
<td  ><strong>IVA</strong></td> 
<td  ><strong>VALOR COMPRA</strong></td> 
<td  ><strong>REFERENCIA</strong></td> 
</tr><tbody id="tablaNomina">
<?php 
/*idCompra, codPov, cantidadVendida, valorParcial, descuento, t_iva, 
 * valorTotal, fecha, usuario, estado, idCierre, referencia, nombre, razonSocial*/
$query2="SELECT 
    A.* , ifnull(B.nombre , '') AS nombre ,ifnull(B.razonSocial ,'') AS razonSocial
     FROM compras A LEFT JOIN  proveedores B ON codPov = nit WHERE     fecha >= $fecha1  and  fecha < $fecha2 ; ";
 // ECHO   $query2;    
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>".$row["fecha"]."</td>
<td>".$row["idCompra"]."</td>
<td>".$row["codPov"]."</td>
<td>".$row["nombre"]."</td>
<td>".$row["valorParcial"]."</td>
<td>".$row["descuento"]."</td>
<td>".$row["t_iva"]."</td>
<td>".$row["valorTotal"]."</td>
<td>".$row["referencia"]."</td>
</tr>";

}

$datos["datos"]=$data;
$result->free(); 
?>
</tbody></table></br></td></tr>  
        
         
 
 <tr><td><div align="center">
                    <span>LISTADO DE VENTAS</span></div></td></tr>
        <tr><td>
<table border="1px" style=" width:950px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
<td width="80"><strong>FECHA VENTA</strong></td>       
<td  ><strong>ID VENTA</strong></td>
<td width="69"><strong>NIT CLIENTE.</strong></td>
<td width="91"><strong>CLIENTE</strong></td>
<td width="91"><strong>TIPO VENTA</strong></td>
<td  ><strong>VALOR PARCIAL</strong></td>
<td  ><strong>DESCUENTO</strong></td> 
<td  ><strong>IVA</strong></td> 
<td  ><strong>RETEFUENTE</strong></td> 
<td  ><strong>VALOR VENTA</strong></td> 
<td  ><strong>COSTO VENTA</strong></td> 
<td  ><strong>REMISIONES</strong></td> 
<td  ><strong>ORDEN DE COMPRA</strong></td> 
</tr><tbody id="tablaNomina">       
<?php 
/*idCompra, codPov, cantidadVendida, valorParcial, descuento, t_iva, 
 * valorTotal, fecha, usuario, estado, idCierre, referencia, nombre, razonSocial*/
$query2="SELECT * FROM vw_ventas_cliente  WHERE  estadoFactura <> 'C' AND fecha >= $fecha1  and  fecha < $fecha2 ; ";
 // ECHO   $query2;    
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
echo "<tr>
<td>".$row["fecha"]."</td>
<td>".$row["idVenta"]."</td>
<td>".$row["nit"]."</td>
<td>".$row["nombre"]."</td>
<td>".$row["tipoDeVenta"]."</td>
<td>".$row["valorParcial"]."</td>
<td>".$row["descuento"]."</td>
<td>".$row["valorIVA"]."</td>
<td>".$row["retefuente"]."</td>
<td>".$row["valorTotal"]."</td>
<td>".$row["COSTOS"]."</td>
<td>".$row["remisiones"]."</td>
<td>".$row["cod_orden_compra"]."</td>
</tr>";

}

$datos["datos"]=$data;
$result->free(); 
?>
</tbody></table></br></td></tr>  
        <tr><td></td></tr>
        <tr><td></td></tr>
    </table>    
 
</div>

<style>
.respuesta{ font-size:25px; font-family:Comic Sans MS,arial,verdana}
span { font-size:18px; font-family:Cambria, "Hoefler Text", "Liberation Serif", Times, "Times New Roman", serif; color: #06C}
</style>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$("#printBoton").click(function(){ 
					$(this).css("display","none");
					imprimirSelec("#print")
					$(this).css("display","inline");
								});
	});
</script>
