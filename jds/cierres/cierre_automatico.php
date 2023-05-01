<?php 
include '../php/inicioFunction.php';
verificaSession_3("../login/");
 include '../db_conection.php';
 
 //////////////////////////`pagos a creditos totales`
 $conn= cargarBD();
 $query2="SELECT SUM(`valorAbono`) AS TOTAL FROM `abonoscredito` WHERE `estado`='activo'";
//echo $query2;
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$abonoCredito=$row["TOTAL"];
if($row["TOTAL"]!=0)
	{$abonoCredito=$row["TOTAL"];$disabled="";}
	else{$abonoCredito="0";}
}$result->free();}
 //////////////////////////`abono de cartera totales`

 $query2="SELECT SUM(`valorAbono`) AS TOTAL FROM `abonoscartera` WHERE `estado`='activo'";
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$abonoCartera=$row["TOTAL"];
if($row["TOTAL"]!=0)
	{$abonoCartera=$row["TOTAL"];$disabled="";}
	else{$abonoCartera="0";}
}$result->free();}

 //////////////////////////`ventas totales`
 $query2="SELECT SUM(`valorTotal`) AS TOTAL FROM `ventas` WHERE `estado`='activo' AND `tipoDeVenta`='EFECTIVO'";
//echo $query2;
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$venta=$row["TOTAL"];
if($row["TOTAL"]!=0)
	{$venta=$row["TOTAL"];$disabled="";}
	else{$venta="0";} 
}$result->free(); }

//////////////////////////`ventas de contado pagado con datafono `

 $query2="SELECT SUM(`valorTotal`) AS TOTAL FROM `ventas` WHERE `estado`='activo' AND `tipoDeVenta`='ELECTRONICA'";
//echo $query2;
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$ventasElectronicas=$row["TOTAL"];
if($row["TOTAL"]!=0)
	{$ventasElectronicas=$row["TOTAL"];$disabled="";}
	else{$ventasElectronicas="0";} 
}$result->free();
}
//////////////////////////`cierrediario`
$query2="SELECT * FROM  `cierrediario` ";

$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){

while ($row = $result->fetch_assoc()) {
	 $saldoAnt=$row["saldoActual"];	 
	}}else{$saldoAnt="0";
	$result->free();
}
//////////////////////////NOMINA
$query2="SELECT SUM(`cantidad`) AS TOTAL FROM `abonosnomina` WHERE `estado`='activo' ";
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$NOMINA=$row["TOTAL"];$disabled="";}
	else{$NOMINA="0";}
} 
$result->free();
}
//////////////////////////gasto
$query2="SELECT SUM(`valorGasto`) AS TOTAL FROM `gastos` WHERE `estado`='activo' ";
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$gastos=$row["TOTAL"];$disabled="";}
	else{$gastos="0";}
} 
$result->free();
}
////////////////////////////////PAGOS IVA
$query2="SELECT SUM(`IVA`) AS TOTAL FROM `pagosiva` WHERE  `estado`='ACTIVO' ";
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$pagosIva=$row["TOTAL"];$disabled="";}
	else{$pagosIva="0";}
} 
$result->free();
}
////////////////////////////////salidas en efectivo
$query2="SELECT SUM(`valorGasto`) AS TOTAL FROM `salidasefectivo` WHERE  `estado`='activo' ";
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$retiros=$row["TOTAL"];$disabled="";}
	else{$retiros="0";}
} $result->free();}
////////////////////////////////COMPRAS EN EFECTIVO LAS DE CREDITO NO SE METEN A MENOS QUE TENGAN ABONOS INICIALES
$query2="SELECT SUM(`valorTotal`) AS TOTAL FROM `compras` WHERE  `estado`='activo' AND `referencia`= 'ninguno' ";
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$COMPRAS=$row["TOTAL"];$disabled="";}
	else{$COMPRAS="0";}
} $result->free();}
////////////////////////////////DEPOSITOS EN BANCOS O VENTAS HECHAS CON DATAFONO 
$query2="SELECT SUM(`VALOR`) AS TOTAL FROM `bancos` WHERE  `estado`='activo'  ";
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$bancos=$row["TOTAL"];$disabled="";}
	else{$bancos="0";}
}
$result->free();}
////////////////////////////////////////compras realizadas a credito pero que se hizo un abono inicial
$query2="SELECT SUM(`credito`.`abonoInicial`) AS TOTAL_ABONOS FROM `compras` 
 INNER JOIN `credito`  ON `compras`.referencia=`credito`.idCuenta WHERE  `estado`='activo' AND `referencia`<>'ninguno' ";
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL_ABONOS"]!=0)
	{$COMPRAS=$COMPRAS+$row["TOTAL_ABONOS"];$disabled="";}} 
$result->free();}

$saldoAct=$saldoAnt+$ventasElectronicas+$venta+$abonoCartera-$NOMINA-$gastos-$retiros-$abonoCredito-$pagosIva-$COMPRAS-$bancos; 
		$stmt = $conn->stmt_init();
		$totalEfec=$venta+$ventasElectronicas+$abonoCartera-$gastos-$retiros-$abonoCredito -$NOMINA-$bancos ;
		$query="INSERT INTO  `cierrediario` ( `fecha` ,`hora`,`idUsuario` ,`totalVenta` ,`totalVentaElectronica`,`totalGasto` ,`totalRetiro`  ,`totalBancos`,`total_nomina` ,`total_abonos_credito`,`TOTAL_COMPRAS` ,`total_abonos_cartera` ,`total_pagos_iva` ,`totalEfectivo` ,`saldoActual` ,`saldoInicial`)VALUES (  CURDATE(),CURTIME() ,'".$_SESSION["usuarioid"]."',  '".$venta ."', '".$ventasElectronicas."','".$gastos."',  '".$retiros."',  '".$bancos."', '".$NOMINA."', '".$abonoCredito."','".$COMPRAS."', '".$abonoCartera."','".$pagosIva."','".$totalEfec."',  '".$saldoAct."',  '".$saldoAnt."');";	
		$datos['query']=$query;
		$stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		$datos['resultado']='nok';
		$datos['msq']='No se pudo ingresar los datos a la tabla cierrediario : ' . $conn->error;
		$conn->close();
		
		}else{	$datos['resultado']='ok';
		$query2="UPDATE `ventas` SET  `estado` ='revisado', `idCierre`='".$stmt->insert_id."'  WHERE `estado`='activo'";
		$result = $conn->query($query2);
		$query2="UPDATE `compras` SET  `estado` ='revisado', `idCierre`='".$stmt->insert_id."'  WHERE `estado`='activo'";
		$result = $conn->query($query2);
		$query2="UPDATE `gastos` SET  `estado` = 'revisado'  WHERE `estado`='activo'";
		$result = $conn->query($query2);
		$query2="UPDATE `bancos` SET  `estado` = 'revisado'  WHERE `estado`='activo'";
		$result = $conn->query($query2);
		$query2="UPDATE `salidasefectivo` SET  `estado` = 'revisado'  WHERE `estado`='activo'";
		$result = $conn->query($query2);
		$query2="UPDATE `abonoscartera` SET  `estado` = 'revisado'  WHERE `estado`='activo'";
		$result = $conn->query($query2);
		 $query2="UPDATE `abonoscredito` SET  `estado` = 'revisado'  WHERE `estado`='activo'";
		$result = $conn->query($query2);
		 $query2="UPDATE `abonosnomina` SET  `estado` = 'revisado'  WHERE `estado`='activo'";
		$result = $conn->query($query2);
		$query2="UPDATE `pagosiva` SET  `estado` = 'revisado' , `id_cierre_de_caja`='".$stmt->insert_id."'   WHERE `estado`='ACTIVO'";
		$result = $conn->query($query2);
		$query2="SELECT   `cierrediario`.*, concat(`usuarios`.nombre1,' ',`usuarios`.nombre2 ) as `nombre` , `usuarios`.`Apellido1`  FROM  `cierrediario` "
                        . "JOIN `usuarios`  ON  `usuarios` .id =  `cierrediario`.idUsuario where "
                        . "cierrediario.idCierre = ".$stmt->insert_id." ORDER BY  `cierrediario`.`fecha` DESC ";
$datos["query2"] =$query2;
$result = $conn->query($query2);
$datosNum=$conn->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
$datos["fecha"] = $row["fecha"];
$datos["horas"] = $row["hora"];
$datos["user"] = $row["nombre"]." ".$row["apellido"];
$datos["saldoInicial"] = amoneda($row["saldoInicial"], pesos);
$datos["totalVenta"] = amoneda($row["totalVenta"], pesos);
$datos["total_abonos_cartera"] = amoneda($row["total_abonos_cartera"], pesos);
$datos["total_nomina"] = amoneda($row["total_nomina"], pesos);
$datos["TOTAL_COMPRAS"] = amoneda($row["TOTAL_COMPRAS"], pesos);
$datos["saldoActual"] = amoneda($row["saldoActual"], pesos);
$datos["totalEfectivo"] = amoneda($row["totalEfectivo"], pesos); 
$datos["total_pagos_iva"] = amoneda($row["total_pagos_iva"], pesos); 
$datos["total_abonos_credito"] = amoneda($row["total_abonos_credito"], pesos); 
$datos["totalRetiro"] = amoneda($row["totalRetiro"], pesos); 
$datos["totalGasto"] = amoneda($row["totalGasto"], pesos); 
$datos['resultado']= 'ok'; 
if(function_exists(printer_open)){
if($handle = printer_open("puntoVenta")){
	printer_set_option($handle, PRINTER_MODE, "raw");
	printer_write($handle, "________________________________________________");
	printer_write($handle, "\r\n");
	printer_write($handle, "             DROGUERIA\r\n");
	printer_write($handle, rellenar($_SESSION["sucursalNombre"],28,'pp',''));
	printer_write($handle, "\r\n");
	printer_write($handle, rellenar('TEL: '.$_SESSION["tel1"],31,'pp',''));
	printer_write($handle, "\r\n");
	printer_write($handle, rellenar('NIT '.$_SESSION["nit_sucursal"].' REGIMEN '.$_SESSION["tip_regimen"],38,'pp',''));
	printer_write($handle, "\r\n");
	printer_write($handle, rellenar($_SESSION["dir"],30,'pp',''));
	printer_write($handle, "\r\n");
	printer_write($handle, rellenar($_SESSION["ciudad"],34,'pp',''));
	printer_write($handle, "\r\n\n");
	printer_write($handle, "________________________________________________");	
	printer_write($handle, "               FECHA ". $row["fecha"]."\r\n");
	printer_write($handle, "                  HORA ". $row["hora"]."\r\n");
	printer_write($handle, "  Usuario :". trim($row["nombre"])." ".trim($row["apellido"])."\r\n"); 
	printer_write($handle, "                   Venta : ". $datos["totalVenta"]."\r\n");
	printer_write($handle, "  Abonos A Cartera : ". $datos["total_abonos_cartera"]."\r\n");
	printer_write($handle, "               Compras : ". $datos["TOTAL_COMPRAS"] ."\r\n"); 
	printer_write($handle, "            Pagos IVA : ". $datos["total_pagos_iva"] ."\r\n"); 
	printer_write($handle, " Abonos  A Credito : ".$datos["total_abonos_credito"]  ."\r\n"); 
	printer_write($handle, "                 Retiros : ". $datos["totalRetiro"] ."\r\n"); 
	printer_write($handle, "                 Gastos : ". $datos["totalGasto"] ."\r\n");
	printer_write($handle, "                Efectivo : ". $datos["totalEfectivo"] ."\r\n"); 
	
}
}

} }
$conn->close();
		}
echo json_encode($datos);		
?>