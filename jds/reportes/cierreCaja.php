<?php 
include '../php/inicioFunction.php';
verificaSession_2("../login/");
 include '../db_conection.php';
  $conn= cargarBD();
require_once '../Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();
$mysqli = cargarBD();
$query="SELECT * FROM `usuarios`;";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
} 

$select = '<option value="todos">Todas los Usuarios</option>';
$selected = '';
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if ((isset($itemBusqueda))&&( trim($itemBusqueda) === trim($row['id'])  )){
		$selected = 'selected';
	}
	else {$selected = '';}
	
	$select = $select."<option value='".$row['id']."'  ".$selected.">".$row['nombre']." ".$row['apellido']."</option>";
	
}}
if (isset($itemBusqueda))
{
if ($itemBusqueda === 'todos' ) 
	{$where = '';
$sqlAux = 'select COUNT(*) from producto GROUP BY `idLab`';
$result = $mysqli->query($sqlAux);
$numeroBusquedas=$mysqli->affected_rows;
}
else {$where =" where `usuarios`.id = '".$itemBusqueda."'";
$numeroBusquedas = 1;}}

if (trim($finicial)!='')
{	if (trim($ffinal)==''){
		$ffinal = $finicial;
}}
if (trim($ffinal)!='')
{	if (trim($finicial)==''){
		$finicial =$ffinal ;
}}

if (((trim($finicial)!='')&&(trim($ffinal)!=''))){
	if ($where != ''){
		$where=$where.' AND';
	}else{$where= ' where';}
	$where=$where." `cierrediario`.`fecha` BETWEEN '".$finicial."' AND '".$ffinal."'";
}
if (trim($hinicial)!=''){
if (trim($hfinal)==''){
		$hfinal = $hinicial;
}}
if (trim($hfinal)!='')
{	if (trim($hinicial)==''){
		$hinicial = $hfinal ;
}}

if (((trim($hinicial!='')))&&(trim($hfinal!=''))){
	if ($where != ''){
		$where=$where.' AND';
	}else{$where= ' where';}
	$where=$where." `cierrediario`.`hora` BETWEEN '".$hinicial."' AND '".$hfinal."'";
}
?>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<meta charset="utf-8">

<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<style>
 
.cardex{float:left; width:45%; margin-right:5%; }

button 	{vertical-align: -webkit-baseline-middle;}
a{vertical-align: -webkit-baseline-middle;}
#principal  {width:50%;margin-left:auto;margin-right:auto}
#principal_sec {width:50%;margin-left:auto;margin-right:auto}
img {border:none; height:110% ; cursor: pointer} 
#botonesConfig   {float:right;vertical-align: -webkit-baseline-middle;}
#botonesConfig a {float:right;vertical-align: -webkit-baseline-middle; margin-left:5px}
#seccionBuscar{height:7%;padding : 5}
#busqueda{width:200px}
#limpiar {border:none; height:110% ; cursor: pointer}
#totales{float:right; vertical-align: -webkit-baseline-middle;}
#btn_muestra_menu{display:nol nn ne}
form{font-size : 16px;}
form > input{vertical-align: -webkit-baseline-middle;height:35px}
form > select{vertical-align: -webkit-baseline-middle;height:35px}
.panel-heading {height:6%}
@media screen and (min-width:300px) and (max-width:800px)  {
body{font-size:0.8em;}
.panel-heading {height:5%}
a > span {font-size:15px;}
#busqueda{width:70%}
#limpiar {  height:50%  }
#seccionBuscar{height:70px}
#totales{float:none; margin-top:10px}
#btn_muestra_menu{display:inline;  margin-top:-7px}
#botonesConfig{float:none; display : none}
#filasData > span{ font-size :0.5em; }
ul   img {width:30px ; height:30px }
.panel-heading {height:35px}
}
.cardex .table {font-size:12px} 
#printSeccion{float:left;  vertical-align: -webkit-baseline-middle; margin-left:10px ; margin-top : 1px}

</style>
<title>JDS/Reportes</title>

<div class="panel panel-default">
<div style='' class="panel-heading">

<div  style='float:left'>
<span style="font-size:20px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 
<div style="float:right; margin-right: 10px">
<a  href="../login/"    ><span class="glyphicon glyphicon-off" aria-hidden="true">Salir</span></a>
</div>
	<div style="float:right; margin-right: 10px">
	<a  href="../indexFacVent.php"    ><span class="glyphicon glyphicon-barcode" aria-hidden="true">Fact.&Venta</span></a>
	</div>
</div>

<div class="panel-body">
    
<div class='alert alert-success' id='seccionBuscar'>
<div style='float:left'>
<form  autocomplete="off" method="POST" >
Usuario: <select id="busqueda" name='itemBusqueda' ><?php echo $select; ?></select> fecha inicial <input type='date' name='finicial' value='<?php echo $finicial; ?>'  style='width:145px'> fecha final <input type='date' name='ffinal' value='<?php echo $ffinal; ?>' style='width:145px'>
hora inicial <input type='time' name='hinicial' value='<?php echo $hinicial; ?>'> hora final <input type='time' name='hfinal' value='<?php echo $hfinal; ?>'>
<input type='submit' style='display:' id='enviar1' class="btn btn-default  "  >
</form>
</div>
<div class="btn-group" role="group" aria-label="..." id='printSeccion'>
<button type="button" class="btn btn-default  " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    POS </button>
  <button type="button" class="btn btn-default  " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Impresora  </button> 
</div></div>
<div id="listado" align="center">
<table class='talble' style="font-size:12px" >
<tr style="">
<td >FECHA</td>
<td >HORA</td>
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

$query2="SELECT   `cierrediario`.*, `usuarios`.`nombre` , `usuarios`.`apellido`  FROM  `cierrediario` JOIN `usuarios`  ON  `usuarios`.id =  `cierrediario`.idUsuario ".$where ."  ORDER BY  `cierrediario`.`fecha` DESC , `cierrediario`.`hora` DESC ";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
amoneda($COMPRAS, pesos);
echo "<tr><td>".$row["fecha"]."</td>
<td>".$row["hora"]."</td>
<td>|".$row["nombre"]." ".$row["apellido"]."|</td>
<td align='right' nowrap>".amoneda($row["saldoInicial"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["totalVenta"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["total_abonos_cartera"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["total_nomina"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["TOTAL_COMPRAS"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["totalGasto"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["totalRetiro"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["total_abonos_credito"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["total_pagos_iva"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["totalEfectivo"], pesos)."|</td>
<td align='right' nowrap>".amoneda($row["saldoActual"], pesos)."|</td>
</tr>";

}
echo'</table>';
$result->free();
$conn->close();
?>
</div>
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
		 
			$('#cancelar').click(function(){
		location.href='../menuTrans.php'
			});	
   });			 
					

</script>