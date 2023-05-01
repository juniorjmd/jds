<?php 
include '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
$disabled="disabled";
echo'<input type="hidden" name="cadenaEnvio" id="cadenaEnvio" value="">';
 include '../db_conection.php';
 if($_POST['registrar']=='activo'){
		$conn= cargarBD();
		$stmt = $conn->stmt_init();
		include '../php/funcionesMysql.php';
		$fecha ="'".normalize_date($_POST["fecha"],"-")."'"; 
		$totalEfec=$_POST['venta']+$_POST['ventasElectronicas']+$_POST['abonoCartera']-$_POST['gastos']-$_POST['retiros']-$_POST['abonoCreditos']-$_POST['nomina']-$_POST['bancos'];
		$query="INSERT INTO  `cierrediario` ( `fecha`,hora ,`idUsuario` ,`totalVenta` ,`totalVentaElectronica`,`totalGasto` ,`totalRetiro`  ,`totalBancos`,`total_nomina` ,`total_abonos_credito`,`TOTAL_COMPRAS` ,`total_abonos_cartera` ,`total_pagos_iva` ,`totalEfectivo` ,`saldoActual` ,`saldoInicial`)VALUES (  ".$fecha.", CURTIME(),   '".$_SESSION["usuarioid"]."',  '".$_POST['venta']."', '".$_POST['ventasElectronicas']."','".$_POST['gastos']."',  '".$_POST['retiros']."',  '".$_POST['bancos']."', '".$_POST['nomina']."', '".$_POST['abonoCreditos']."','".$_POST['compras']."', '".$_POST['abonoCartera']."','".$_POST['pagosIva']."','".$totalEfec."',  '".$_POST['saldoAct']."',  '".$_POST['saldoAnterio']."');";	
//	echo $query;
		$stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo crear la tabla de ingresos:' . $conn->error);
		 
		}else{	
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
		}}
 echo'<form method="post" autocomplete="off" action="cierreCaja.php">';
 //////////////////////////`pagos a creditos totales`
 $conn= cargarBD();
  $query2="SELECT IFNULL(SUM(`valorAbono`),0) AS TOTAL FROM `abonoscredito` WHERE `estado`='activo' and fuente_pago = 'caja' ";
//echo $query2;

$ventasElectronicas=$venta=$abonoCartera=$NOMINA=$gastos=$retiros=$abonoCredito=$pagosIva=$COMPRAS=$bancos=0;

$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	$abonoCredito=$row["TOTAL"];
if($row["TOTAL"]!=0)
	{$abonoCredito=$row["TOTAL"];$disabled="";}
	else{$abonoCredito="0";}
echo'<input type="hidden" name="abonoCreditos" id="abonoCreditos" value="'.$abonoCredito.'" >';
}$result->free();
 //////////////////////////`abono de cartera totales`
 $conn= cargarBD();
 $query2="SELECT SUM(`valorAbono`) AS TOTAL FROM `abonoscartera` WHERE `estado`='activo'";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	$abonoCartera=$row["TOTAL"];
if($row["TOTAL"]!=0)
	{$abonoCartera=$row["TOTAL"];$disabled="";}
	else{$abonoCartera="0";}
echo'<input type="hidden" name="abonoCartera" id="abonoCartera" value="'.$abonoCartera.'" >';
}$result->free();

 //////////////////////////`ventas totales`
 $ayuda="&nbsp;";
 $conn= cargarBD();
 $query2="SELECT SUM(`valorTotal`) AS TOTAL FROM `ventas` WHERE    estadoFactura <> 'C' AND `estado`='activo' AND `tipoDeVenta`='EFECTIVO'";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	$venta=$row["TOTAL"];
if($row["TOTAL"]!=0)
	{$venta=$row["TOTAL"];$disabled="";}
	else{$venta="0";}
echo'<input type="hidden" name="venta" id="venta" value="'.$venta.'" >';
}$result->free(); 

//////////////////////////`ventas de contado pagado con datafono `
 $conn= cargarBD();
 $query2="SELECT SUM(`valorTotal`) AS TOTAL FROM `ventas` WHERE   estadoFactura <> 'C' AND `estado`='activo' AND `tipoDeVenta`='ELECTRONICA'";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	$ventasElectronicas=$row["TOTAL"];
if($row["TOTAL"]!=0)
	{$ventasElectronicas=$row["TOTAL"];$disabled="";}
	else{$ventasElectronicas="0";}
echo'<input type="hidden" name="ventasElectronicas" id="ventasElectronicas" value="'.$ventasElectronicas.'" >';
}$result->free();

//////////////////////////`cierrediario`
$query2="SELECT * FROM  `cierrediario` ";

$result = $conn->query($query2);
$saldoAnt_aux = 0;
if($result->num_rows==0){$saldoAnt='  <input type="hidden" id="saldoAnterio" name="saldoAnterio" value="0" ><input  type="text" id="auxInicial"   align="right" placeholder="Ingrese el valor inicial"> ';
$ayuda='<img  src="../imagenes/automatico.jpg" height="30px" title="es el valor con el que comienza el ejercicio, es decir el saldo inicial en efectivo con el que se cuenta, si la casilla esta en blanco se sobreentiende que el valor es cero (0) ">';}else{

while ($row = $result->fetch_assoc()) {
	if($row["saldoActual"]!=0)
	{$saldoAnt_aux = $saldoAnt=$row["saldoActual"];
	
	echo'<input type="hidden" name="saldoAnterio" id="saldoAnterio" value='.$saldoAnt.' >';
	}
	else{$saldoAnt_aux =$saldoAnt="0";
	echo'<input type="hidden" name="saldoAnterio" id="saldoAnterio" value='.$saldoAnt.' >';
}
}}

$result->free();

//////////////////////////NOMINA
$query2="SELECT SUM(`cantidad`) AS TOTAL FROM `abonosnomina` WHERE `estado`='activo' ";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$NOMINA=$row["TOTAL"];$disabled="";}
	else{$NOMINA="0";}
}
echo'<input type="hidden" name="nomina" id="nomina" value="'.$NOMINA.'" >'	;

$result->free();

//////////////////////////gasto
$query2="SELECT SUM(`valorGasto`) AS TOTAL FROM `gastos` WHERE `estado`='activo' ";
$result = $conn->query($query2);
if($result->num_rows>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$gastos=$row["TOTAL"];$disabled="";}
	else{$gastos="0";}
}}
echo'<input type="hidden" name="gastos" id="gastos" value="'.$gastos.'" >'	;

$result->free();
/*
$pagosIva=0;
////////////////////////////////PAGOS IVA
$query2="SELECT SUM(`IVA`) AS TOTAL FROM `pagosiva` WHERE  `estado`='ACTIVO' ";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$pagosIva=$row["TOTAL"];$disabled="";}
	else{$pagosIva="0";}
}*/
echo'<input type="hidden" name="pagosIva" id="pagosIva" value="'.$pagosIva.'" >';

////////////////////////////////salidas en efectivo
$query2="SELECT SUM(`valorGasto`) AS TOTAL FROM `salidasefectivo` WHERE  `estado`='activo' ";
$result = $conn->query($query2);
if($result->num_rows>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$retiros=$row["TOTAL"];$disabled="";}
	else{$retiros="0";}
}}
echo'<input type="hidden" name="retiros" id="retiros" value="'.$retiros.'" >';
////////////////////////////////COMPRAS EN EFECTIVO LAS DE CREDITO NO SE METEN A MENOS QUE TENGAN ABONOS INICIALES
$query2="SELECT SUM(`valorTotal`) AS TOTAL FROM `compras` WHERE  `estado`='activo' AND `referencia`= 'ninguno' ";
$result = $conn->query($query2);
if($result->num_rows>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$COMPRAS=$row["TOTAL"];$disabled="";}
	else{$COMPRAS="0";}
}}
//echo $query2;
////////////////////////////////DEPOSITOS EN BANCOS O VENTAS HECHAS CON DATAFONO 
$query2="SELECT SUM(`VALOR`) AS TOTAL FROM `bancos` WHERE  `estado`='activo'  ";
$result = $conn->query($query2);
$bancos = 0;
if($result->num_rows>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL"]!=0)
	{$bancos=$row["TOTAL"];$disabled="";}
	else{$bancos="0";}
}}
echo'<input type="hidden" name="bancos" id="bancos" value="'.$bancos.'" >';
//echo $query2;
////////////////////////////////////////compras realizadas a credito pero que se hizo un abono inicial
$query2="SELECT SUM(`credito`.`abonoInicial`) AS TOTAL_ABONOS FROM `compras` 
 INNER JOIN `credito`  ON `compras`.referencia=`credito`.idCuenta WHERE  `estado`='activo' AND `referencia`<>'ninguno' ";
$result = $conn->query($query2);
if($result->num_rows>0){
while ($row = $result->fetch_assoc()) {
	if($row["TOTAL_ABONOS"]!=0)
	{$COMPRAS=$COMPRAS+$row["TOTAL_ABONOS"];$disabled="";}}}
echo'<input type="hidden" name="compras" id="compras" value="'.$COMPRAS.'" >';


//echo "$saldoAnt_aux - $ventasElectronicas - $venta - $abonoCartera";
$saldoAct=($saldoAnt_aux+$ventasElectronicas+$venta+$abonoCartera);

$saldoAct+=(-$NOMINA-$gastos-$retiros-$abonoCredito-$pagosIva-$COMPRAS-$bancos);


 
echo'<input type="hidden" name="saldoAct" id="saldoAct" value="'.$saldoAct.'" >';
//echo $saldoAct;	
$result->free();
?>
<link href="../ayuda/jquery-ui.css" rel="stylesheet">
<script src="../ayuda/external/jquery/jquery.js"></script>
<script src="../ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="../js/trim.js"></script>

<div align="center">
<table width="870" height="325" >
<tr>
<td colspan="7" height="50" bgcolor="#003399" style="color:#CCC; padding:10px"><strong>CIERRE DE CAJA <input type="text" id="fecha" name="fecha" size="12px"value="<?php echo date("m/d/Y");?>">
 <?php echo " DE ".$_GET["sucursal"]; ?></strong></td>
</tr>
<tr>
<td width="29" rowspan="13" bgcolor="#003399">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td width="304" align="right" bgcolor="#3850F1"><strong>SALDO ANTERIOR</strong></td>
<td width="32">&nbsp;</td>
<td width="183" align="right"><?php echo $saldoAnt; ?></td>
<td width="61"><?php echo $ayuda; ?></td>
<td width="196" rowspan="13" bgcolor="#3850F1">

<input type="hidden" value="" name="registrar" id="registrar">
<input type="button" value="Abrir Cajon"  name="abrirCajon" id="abrirCajon" class="boton">
<input type="button" value="Resumen" id="resumenMes" title="desplega el resumente completo del mes asta antes del corte que se piensa realizar" class="boton"><br/>  
  <input type="submit" value="Registar" id="registro" title="realizar el corte, despues de realizado el corte los gastos, retiros y ventas se generaran para el siguiente corte" class="boton" <?php echo $disabled; ?>>  
  <input type="button" value="Cancelar" id="cancelar" title="Salir de cierre de caja y volver a facturacion" class="boton"><input type="button"  id="Buscar" value="buscar"title="buscar un cierre de caja especifico" class="boton"></td><td width="33" rowspan="13" bgcolor="#003399">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
</tr>
<tr> 
<td bgcolor="#3850F1" align="right"><strong>VENTA DIARIA</strong></td>
<td>&nbsp;</td>
<td align="right"><?php echo amoneda($venta, pesos); ?></td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#3850F1" align="right"><strong>VENTAS ELECTRONICAS</strong></td>
<td>&nbsp;</td>
<td align="right" ><?php echo amoneda($ventasElectronicas, pesos); ?></td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#3850F1" align="right"><strong>ABONOS DE CARTERA</strong></td>
<td>&nbsp;</td>
<td align="right" ><?php echo amoneda($abonoCartera, pesos); ?></td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#3850F1" align="right"><strong>PAGO NOMINA</strong></td>
<td>&nbsp;</td>
<td align="right" bgcolor="#EC3E4A" style="color:#CCC; font-size:18px"><strong><?php echo amoneda($NOMINA, pesos); ?></strong></td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#3850F1" align="right"><strong>GASTOS</strong></td>
<td>&nbsp;</td>
<td align="right" bgcolor="#EC3E4A" style="color:#CCC; font-size:18px"><strong><?php echo amoneda($gastos, pesos); ?></strong></td>
<td>&nbsp;</td>
</tr>

<tr>
<td bgcolor="#3850F1" align="right"><strong>DEPOSITOS/CONSIGNACIONES</strong></td>
<td>&nbsp;</td>
<td align="right" bgcolor="#EC3E4A"style="color:#CCC; font-size:18px"><strong><?php echo amoneda($bancos, pesos); ?></strong></td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#3850F1" align="right"><strong>PAGOS A SOCIOS</strong></td>
<td>&nbsp;</td>
<td align="right" bgcolor="#EC3E4A"style="color:#CCC; font-size:18px"><strong><?php echo amoneda($retiros, pesos); ?></strong></td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#3850F1" align="right"><strong>COMPRAS EN EFECTIVO</strong></td>
<td>&nbsp;</td>
<td align="right" bgcolor="#EC3E4A"style="color:#CCC; font-size:18px"><strong><?php echo amoneda($COMPRAS, pesos); ?></strong></td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#3850F1" align="right"><strong>PAGOS A PROVEDOR</strong></td>
<td>&nbsp;</td>
<td align="right" bgcolor="#EC3E4A"style="color:#CCC; font-size:18px"><strong><?php echo amoneda($abonoCredito, pesos); ?></strong></td>
<td>&nbsp;</td>
</tr>
<!--- PAGOS IVA 
<tr>
<td bgcolor="#3850F1" align="right"><strong>PAGOS DEL IVA</strong></td>
<td>&nbsp;</td>
<td align="right" bgcolor="#EC3E4A"style="color:#CCC; font-size:18px"><strong><?php echo amoneda($pagosIva, pesos); ?></strong></td>
<td>&nbsp;</td>
</tr>
-->
<tr>
<td bgcolor="#3850F1" align="right"><strong>SALDO ACTUAL</strong></td>
<td>&nbsp;</td>
<td align="right" id="saldoActlb"><?php echo amoneda($saldoAct, pesos); ?></td>
<td>&nbsp;</td>
</tr>
<tr>
<td bgcolor="#3850F1" colspan="4" >&nbsp;</td></tr>

<tr>
<td bgcolor="#003399" colspan="7">&nbsp;&nbsp;&nbsp;</td>
</tr>
</table></form></div>
<style>
#listado td { padding-left:5px; padding-right:5px; background-color: #CCC;  }
</style>
<?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaCierre';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 

<div id="listado" align="center"><br>
    <table id="tabla_resultados" style="font-size:12px" >
<tr style="">
<td >FECHA</td>
<td>USUARIO</td>
<td>SAL. ANTERIOR</td>
<td>VENTA</td>
<td>CARTERA</td>
<td>NOMINA</td>
<td>COMPRAS</td>
<td>GASTO</td>
<td>RET. EFECTIVO</td>
<td>CREDITOS</td>
<td>PAGO DE IVA</td>
<td>EFECTIVO</td>
<td>SALDO ACTUAL</td>
</tr>
<?php
$query2="SELECT `cierrediario`.*, `usuarios`.`nombre1` as nombre , `usuarios`.`apellido1` as apellido FROM `cierrediario` JOIN `usuarios` "
        ." ON `usuarios`.id = `cierrediario`.idUsuario "
        ." ORDER BY `cierrediario`.`fecha` DESC , `cierrediario`.`hora` DESC";
 $result = $conn->query($query2);
 $filas=$result->num_rows;
 if ($filas > 0){
     
while ($row = $result->fetch_assoc()) {
amoneda($COMPRAS, pesos);
echo "<tr><td nowrap >".$row["fecha"]."</td>
<td nowrap >".$row["nombre"]." ".$row["apellido"]."</td>
<td nowrap  align='right'>".amoneda($row["saldoInicial"], pesos)."</td>
<td  nowrap align='right'>".amoneda($row["totalVenta"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["total_abonos_cartera"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["total_nomina"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["TOTAL_COMPRAS"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["totalGasto"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["totalRetiro"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["total_abonos_credito"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["total_pagos_iva"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["totalEfectivo"], pesos)."</td>
<td nowrap  align='right'>".amoneda($row["saldoActual"], pesos)."</td>
</tr>";
}
$result->free();
}


$conn->close();
?> </table> 
</div>
<style>
table {font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;}
td { padding-right:15px; padding-top:5px; padding-bottom:5px}
.boton{font-size:15px;
        font-family:Verdana,Helvetica;
        font-weight:bold;
        color:white;
        background:#638cb5;
        border:1px;
		border-color:white;
		cursor:pointer;
		}
.boton:hover {
        background:#CCC;
        border:1px;
		border-color:white;
		}
#resumenMes{ height:40px; width:150px; margin-left:10px; margin-top:0px}

#abrirCajon{ height:40px; width:150px; margin-left:10px; margin-top:0px}
#registro{ height:90px; width:150px; margin-left:10px; margin-top:0px}
#cancelar{ height:40px; width:85px; margin-left:10px; margin-top:0px; float:left}
#Buscar{ height:40px; width:65px;	}
#auxInicial{height:40px; font-size:20px}
</style>
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script language="javascript1.1" src="../jsFiles/trim.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);

$('#fecha').datepicker({selectOtherMonths: true,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
					'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
						 onSelect: function (date) {
									}
			});	
		$("#auxInicial").keyup(function(e){
			var key = e.charCode || e.keyCode || 0;
			var $final;
			var inicial;
			if(((key>=48)&&(key<=57))||((key>=96)&&(key<=105))||((key==8)&&(Trim($(this).val())!=""))){
				inicial=parseFloat($(this).val());}
			else{inicial=0;}
				var gastos= parseFloat($("#gastos").val());
				var retiros= parseFloat($("#retiros").val());
				var venta= parseFloat($("#venta").val());
				var $Auxfinal=inicial+venta;
				var $auxfinal=retiros+gastos
				$final=$Auxfinal-$auxfinal
				$("#saldoAnterio").val(Trim($(this).val()));
				$("#saldoActlb").html($final)
				$("#saldoAct").val($final)
			});
		$('#registro').click(function(){
			$("#registrar").val('activo');
			});	
				$('#abrirCajon').click(function(){
			$.ajax({
						url: 'abrirCaja.php',  
						type: 'POST',
						
						data: false,
						});
			});	
		$('#resumenMes').click(function(){
		location.href='cierreCajaAux.php?fecha='+$("#fecha").val();
			});	
			$('#cancelar').click(function(){
		location.href='../menuTrans.php'
			});	
   });			 
					

</script>