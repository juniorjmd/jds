<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../db_conection.php';
verificaSession_2("../login/");
require_once '../Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();

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
#totales{float:right; vertical-align: -webkit-baseline-middle;}
#btn_muestra_menu{display:none}
.panel-heading {height:8%}

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
		$("#busqueda").keyup(function(){
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

<div  style='float:left'>
<span style="font-size:26px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 
<div style="float:right; margin-right: 10px">
<a  href="../login/"    ><span class="glyphicon glyphicon-off" aria-hidden="true">Salir</span></a>
</div>
	<div style="float:right; margin-right: 10px">
	<a  href="../indexFacVent.php"    ><span class="glyphicon glyphicon-barcode" aria-hidden="true">Fact.&Venta</span></a>
	</div>
</div>

<div>
<div class='alert alert-success' id='seccionBuscar'>
BUSCAR <input type="text" id="busqueda" > <img src="../imagenes/limpiar_nuevo.png"  id="limpiar">
<?php 
if ($detect->isMobile() or $detect->isTablet() or $detect->isAndroidOS() or $detect->isiOS()){
echo '</br>';
}?>
<div id='totales'> 


<div  style="float:right; margin-right:10px; margin-top:-5px">T. Deuda Actual:<br/><span style='margin-left:auto;margin-right:auto' id='sp_3' >$ 00.000.00</span> </div>
<div  style="float:right; margin-right:10px; margin-top:-5px">T. Abonos Recibidos:<br/><span style='margin-left:auto;margin-right:auto' id='sp_4' >$ 00.000.00</span>  </div>
<div  style="float:right; margin-right:10px; margin-top:-5px">Numero de prestamos :<br/><span style='margin-left:auto;margin-right:auto' id='sp_2' >0000</span>  </div>
<div  style="float:right; margin-right:10px; margin-top:-5px;  ">Total prestado :<br/><span style='margin-left:auto;margin-right:auto' id='sp_1' >0000</span>  </div>
</div></div>
<div>
<iframe id="frameaux" src="enviosView.php" style="border:none; padding:0; height:100%; width:100%; margin:0"></div></div>
</div>