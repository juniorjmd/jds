<?php include '../php/inicioFunction.php';
verificaSession_2("../login/"); 
require_once '../Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();

?>
<?php 
include '../db_conection.php';
$mysqli = cargarBD();
$independiente=true;
?>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

<script src="../bootstrap/js/bootstrap.min.js"></script>


<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<meta charset="utf-8">
 

<!-- Optional theme --> 
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script> 
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="jquery.gmap.js"></script>
<style>
#mapa_1{ width:100%;max-width: 700px; height: 70%; max-height: 450px; border: 1px solid #777; overflow: hidden; margin: 10 auto; }

.panel .panel-default{width : 100%; height:100%;  margin : 0px ;   }
	
 
button 	{vertical-align: -webkit-baseline-middle;}
#container{width : 100%;  }
</style>
<body>
<div class="panel panel-default" >
<div style='height:45px' class="panel-heading">
<div id='cordinates'></div>
<div  style='float:left'>
<span style="font-size:20px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 
 
<div style="float:right ; margin-right: 10px">
 
<a  href="../index.php"    ><span class="glyphicon glyphicon-log-out" aria-hidden="true">MenuPincipal</span></a>

</div><div style="float:right ; margin-right: 10px">
 
<a  href="index.php"    ><span class="glyphicon glyphicon-log-out" aria-hidden="true">Inicio</span></a>

</div> 

</div> 
<div id='container'>
</div></div>
</body>