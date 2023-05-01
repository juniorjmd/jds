<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<style>
 
a{vertical-align: -webkit-baseline-middle;}
#principal  {width:50%;margin-left:auto;margin-right:auto}
#principal_sec {width:50%;margin-left:auto;margin-right:auto}
.col-md-3 img  {border:none; width:100px ; height: 100px} 
</style>
<title>JSD/Fact. & Venta</title>
</head>
<body >
<div class="panel panel-default">
<div style='height:55px' class="panel-heading">

<div  style='float:left'>
<span style="font-size:26px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 

<div style="float:right">
<a  href="login/"    ><span class="glyphicon glyphicon-log-out" aria-hidden="true">Salir</span></a>
</div>
<div style="float:right ; margin-right: 10px">
 <a  href="index.php"    ><span class="glyphicon glyphicon-home" aria-hidden="true">MenuPincipal</span></a>
</div>
<div style='float:right; margin-right: 10px'> 
<a href="usuarios/_setting.php" class="btn btn-success " role="button">
     <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
</a>
</div>
</div>
 <br/>
<div align="center">
 
<div class="alert alert-success" role="alert" id='principal'>  
<div class="row">
<?php 
if (!ISSET($_GET['KLJ_jkl'])){
	$_SESSION["fechaVentas"]='';
} 
if($_SESSION["Facturacion"]=="si"){

	echo'<div class="col-md-3" >
  <a   class="thumbnail"  href="ventas/nFacturacion.php" >
      <img src="imagenes/caja (2).jpg" alt="..." >
      <div class="caption">
        <span>POS Normal<span>     
      </div>
    </a>
 </div>
	';} 	
	 if($_SESSION["Facturacion"]=="si"){
	echo'<div class="col-md-3" >
  <a   class="thumbnail"  href="ventas/" >
      <img src="imagenes/dvol/iconos_software_pro_90.png" alt="..." >
      <div class="caption">
        <span>POS imagenes<span>     
      </div>
    </a>
 </div>
	 '; }

if($_SESSION["Facturacion"]=="si"){
	
	echo' 
	<div class="col-md-3"  >
  <a   class="thumbnail"  href="reportes" >
      <img src="imagenes/dvol/historias.jpg" alt="..." >
      <div class="caption">
        <span>Reportes<span>     
      </div>
    </a>
 </div>';} 
	 
if($_SESSION["Facturacion"]=="si"){
	echo'<div class="col-md-3" >
  <a   class="thumbnail"  href="devoluciones/"  >
      <img src="imagenes/dvol/cambio2.jpg" alt="..." >
      <div class="caption">
        <span>Devoluciones<span>     
      </div>
    </a>
 </div>';} 
?>
 
</div></div></div></div>