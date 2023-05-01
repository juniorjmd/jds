<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../db_conection.php';
verificaSession_2("../login/");
require_once '../Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();
$mysqli = cargarBD();
$query="SELECT * FROM `marcas`;";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
} 

$select = '<option value="todos">Todas las Marcas</option>';
$selected = '';
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	if ((isset($itemBusqueda))&&( trim($itemBusqueda) === trim($row['idlab'])  )){
		$selected = 'selected';
	}
	else {$selected = '';}
	
	$row['idlab'];
	$row['laboratorio'];
	$select = $select."<option value='".$row['idlab']."'  ".$selected.">".$row['laboratorio']."</option>";
	
}}
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
body{ background-image: url(imagenes/images%20(4).jpg);
background-repeat: no-repeat;
background-position:bottom;
}
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
.panel-heading {height:6%}
select{vertical-align: -webkit-baseline-middle;}
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
#printSeccion{float:left;  vertical-align: -webkit-baseline-middle; margin-left:10px ; margin-top :1px}
</style>
<title>JDS/Reportes</title>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
		
		var datosAjax='idBusqueda='+encodeURIComponent($("#busqueda").val())
				+"&nocache=" + Math.random(); 
				//alert(datosAjax);
				$.ajax({
						url: '../printerKardex.php',  
						type: 'POST',
						
						data: datosAjax,
 						success: function(data) {
							
								}	
					});
		
 });

</script> 


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
Seleccione Marca/laboratorio <select  id="busqueda" name='itemBusqueda' > <?php echo $select; ?></select>
<input type='submit' style='display:' id='enviar1' class="btn btn-default  "  >
</form>
</div>
<div class="btn-group" role="group" aria-label="..." id='printSeccion'>
<button type="button" class="btn btn-default  " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    POS </button>
  <button type="button" class="btn btn-default  " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Impresora  </button> 
</div></div><div>
<?php 
if (isset($itemBusqueda))
{
if ($itemBusqueda === 'todos' ) 
	{$where = '';
$sqlAux = 'select COUNT(*) from producto GROUP BY `idLab`';
$result = $mysqli->query($sqlAux);
$numeroBusquedas=$mysqli->affected_rows;
}
else {$where =" where idLab = '".$itemBusqueda."'";
$numeroBusquedas = 1;}
	$sqlCardex = "SELECT * FROM `producto` ".$where ."  ORDER BY  `idLab`";
	$result = $mysqli->query($sqlCardex);
	$result2 = $mysqli->query($sqlCardex);
	$datosNumCardex=$mysqli->affected_rows;
	$lab="";
	$countDiv =1;
	$conteo = 0; 
	if($datosNumCardex>0){
		$numeroBusquedas = $numeroBusquedas + $datosNumCardex;
		$numeroPorDiv = (round($numeroBusquedas/2) )+1 ;
	/*
	while ($row = $result2->fetch_assoc()) {	
		$auxNumLns = (strlen(trim($row["idProducto"]))+strlen(trim($row["nombre"]))+strlen(trim($row["cantActual"])) +10);
		$numLns=$auxNumLns/48;
		if(is_float($numLns))
		{
			echo $auxNumLns." : ".$numLns.'es flotante   : '.round($numLns, 0, PHP_ROUND_HALF_UP).'<br>';
		}
		else {echo $auxNumLns." : ".$numLns.'no es flotante '.$numLns.'<br> ';}
	}*/
	 while ($row = $result->fetch_assoc()) {
		if ($countDiv == 1 || $countDiv == $numeroPorDiv ){
			if ( $countDiv == $numeroPorDiv){
				echo '</table></div>';
			}
			echo '<div class="cardex"> <table class="table">';
			
		}
		if($lab !=  $row['laboratorio']){
			$conteo++ ; 
			$print=true;$lab =  $row['laboratorio'];
		}
		if ($print){
			echo "<tr><td colspan='4'>Marca :  ".$row['laboratorio'].'</td></tr>';
			$print=false; 
		$countDiv++;
		}
		echo "<tr><td style='width:1%'>".$row['idProducto']." </td> <td style='width:65%'>|  ".$row['nombre']." </td> <td  style='width:10%'>| ".$row['cantActual'].'</td> <td style="width:10%">|_____</td> </tr>';
		$countDiv++;
	} 
	echo '</table></div>';}
}?>
</div>
</div>