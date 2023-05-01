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
.col-md-4 img {border:none; width:100px ; height: 100px} 
</style>
<title>JD solution`s</title>
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
<div style='float:right; margin-right: 10px'> 
<a href="usuarios/_setting.php" class="btn btn-success " role="button">
     <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
</a>
</div>

<?php 
if($_SESSION["Usuarios"]=="si"){
echo' <div style="float:right; height : 100% ; "> 
  <a    href="usuarios/" >
      <img src="imagenes/configuracion.png" alt="..."  style="height : 100% ; width: 50px"  title="configuracion de usuarios">
    </a>
 </div>';} 
?>
<?php 
if($_SESSION["Usuarios"]=="si"){
echo' <div style="float:right; height : 100% ; "> 
  <a    href="poss/" >
      <img src="imagenes/dvol/nosotros.png" alt="..."  style="height : 100% ; width: 50px"  title="posicionamiento global">
    </a>
 </div>';} 
?>
</div>
 <br/>
<div align="center">
 
<div class="alert alert-success" role="alert" id='principal'>  
<div class="row">
<?php if($_SESSION["Facturacion"]=="si"){
	
	echo'<div class="col-md-4" >
  <a   class="thumbnail"  href="indexFacVent.php" >
      <img src="imagenes/dvol/ventas.jpg" alt="..." >
      <div class="caption">
        <span>Facturacion & ventas<span>     
      </div>
    </a>
 </div>
	';} 
if($_SESSION["Inventarios"]=="si"){
	
	echo' 
	<div class="col-md-4"  >
  <a   class="thumbnail"  href="inventario.php" >
      <img src="imagenes/proveedores.jpg" alt="..." >
      <div class="caption">
        <span>Inventarios<span>     
      </div>
    </a>
 </div>';} 
	 
if($_SESSION["Transacciones"]=="si"){
	echo'<div class="col-md-4" >
  <a   class="thumbnail"  href="menuTrans.php"  >
      <img src="imagenes/conta.PNG" alt="..." >
      <div class="caption">
        <span>Transacciones<span>     
      </div>
    </a>
 </div>';} 
?>
 
</div></div>
<br/>
 <div class="alert alert-warning" role="alert" id='principal_sec'>
 <div class="row">
<?php		

	
if($_SESSION["Empleados"]=="si"){
	
	echo'<div class="col-md-4" >
  <a   class="thumbnail"  href="empleado.php" >
      <img src="imagenes/empleados.jpg" alt="..." >
      <div class="caption">
        <span>Nomina<span>     
      </div>
    </a>
 </div>';} 
		
if($_SESSION["Proveedores"]=="si"){
	
	echo' <div class="col-md-4" >
  <a   class="thumbnail"  href="provedores.php" >
      <img src="imagenes/proveedores2.jpg" alt="..." >
      <div class="caption">
        <span>Proveedores<span>     
      </div>
    </a>
 </div>';} 	

if($_SESSION["Clientes"]=="si"){
	
	echo'<div class="col-md-4" >
  <a   class="thumbnail"  href="clientes.php" >
      <img src="imagenes/clientes.png" alt="..." >
      <div class="caption">
        <span>Clientes<span>     
      </div>
    </a>
 </div> ';} 	
	
?>
 </div></div></div>
</div>
</body>
</html>
