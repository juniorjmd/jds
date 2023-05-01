<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../db_conection.php'; 
require_once '../Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();
$mysqli = cargarBD();
//ORDER BY  `producto`.`Grupo` ASC 
//$query=" SELECT * FROM allProductPlusTotalSales ".$auxQ." order by IDLINEA";

$query="select * from clientes";
//echo $query;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
$clientes = '<option value="">Selecciones Cliente</option>';
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$clientes = $clientes . '<option value="'.$row['idCliente'].'"> '.$row['razonSocial'].' </option>';
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
body{ background-image:url(imagenes/images%20(4).jpg)
background-repeat: no-repeat;
background-position:bottom;
}
button 	{vertical-align: -webkit-baseline-middle;}
a{vertical-align: -webkit-baseline-middle;}
#principal  {width:50%;margin-left:auto;margin-right:auto}
#principal_sec {width:50%;margin-left:auto;margin-right:auto}
img {border:none; height:110% ; cursor: pointer} 
#botonesConfig   {float:right;vertical-align: -webkit-baseline-middle;}
#botonesConfig a {float:right;vertical-align: -webkit-baseline-middle; margin-left:5px}
#seccionBuscar{height:9%}
#busqueda{width:200px}
#limpiar {border:none; height:110% ; cursor: pointer}
#totales{ vertical-align: -webkit-baseline-middle;}
#btn_muestra_menu{display:none}
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

</style>
<title>JDS/Reportes</title>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
		$("#busqueda").change(function(){
			$('#frameaux').attr('src',"enviosView.php?id="+encodeURIComponent($(this).val())+"&nocache=" + Math.random());
			//alert($('#frameaux').attr('src'))
			});	
		$('#limpiar').click(function(){
			$("#busqueda").val('');	
			$('#frameaux').attr('src',"enviosView.php");
			})
		
 });

</script> 


<div class="panel panel-default">
<div style='' class="panel-heading">

<div style="float:right; margin-right: 10px">
<a  href="../login/"    ><span class="glyphicon glyphicon-off" aria-hidden="true">Salir</span></a>
</div>
	<div style="float:right; margin-right: 10px">
	<a  href="../indexFacVent.php"    ><span class="glyphicon glyphicon-barcode" aria-hidden="true">Fact.&Venta</span></a>
	</div>
</div>

<div>
 <div class='row alert-success'id='' style='margin-top:10px ; padding:10px'>
 <div class="col-xs-3" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">Cliente </span>
<select id="busqueda" class="form-control" aria-describedby="basic-addon1">
<?php echo $clientes ;?>
</select>

  </div></div>
<div class="col-xs-3" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">F. Inicio</span>
  <input type="date" class="form-control"   aria-describedby="basic-addon1" name='fechaInicio' value='<?php echo $fechaInicio;?>'>
</div>
</div>
<div class="col-xs-3" >
<div class="input-group">
  <span class="input-group-addon" id="basic-addon1">F. Venc.</span>
  <input type="date" class="form-control"   aria-describedby="basic-addon1" name='fechaFinal' value='<?php echo $fechaFinal;?>'>
</div>
</div>
<div class="col-xs-3" >
<button type="button" class="btn btn-danger" aria-label="Left Align">
  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
  Buscar
</button>
</div>

</div>

<div>
<iframe id="frameaux" src="cuentasYfacturas.php" style="border:none; padding:0; height:100%; width:100%; margin:0"></div></div>
</div>

