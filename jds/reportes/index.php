<?php include '../php/inicioFunction.php';
verificaSession_2("../login/"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="j../s/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<style> 
a{vertical-align: -webkit-baseline-middle;}
#principal  {width:50%;margin-left:auto;margin-right:auto}
#principal_sec {width:50%;margin-left:auto;margin-right:auto}
.col-md-4 img {border:none; width:100px ; height: 100px} 
</style>
<title>JDS/Reportes</title>
</head>
<body >
<div class="panel panel-default">
<div style='height:55px' class="panel-heading">

<div  style='float:left'>
<span style="font-size:26px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 



<div style="float:right; margin-right: 10px">
<a  href="../login/"    ><span class="glyphicon glyphicon-off" aria-hidden="true">Salir</span></a>
</div>
	<div style="float:right; margin-right: 10px">
	<a  href="../indexFacVent.php"    ><span class="glyphicon glyphicon-barcode" aria-hidden="true">Fact.&Venta</span></a>
	</div>
<div style='float:right; margin-right: 10px'> 
<a href="../usuarios/_setting.php" class="btn btn-success " role="button">
     <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
</a>
</div>


</div>
 <br/>
<div align="center">
 
<div class="alert alert-success" role="alert" id='principal'>  
<div class="row">
<div class="col-md-4" >
  <a   class="thumbnail"  href="reimpFact.php" >
      <img src="../imagenes/dvol/descarga.jpg" alt="..." >
      <div class="caption">
        <span>facturas POS<span>     
      </div>
    </a>
 </div>
 
	<div class="col-md-4"   >
  <a   class="thumbnail "  href="repCreditos.php"    >
      <img src="../imagenes/dinero1.jpg" alt="..." >
      <div class="caption">
        <span>Creditos Clientes<span>     
      </div>
    </a>
 </div> 

	<div class="col-md-4"   >
  <a   class="thumbnail "  href="repCardex.php"    >
      <img src="../imagenes/engranajes.jpg" alt="..." >
      <div class="caption">
        <span>Cargar Kardex<span>     
      </div>
    </a>
 </div> 

 
</div></div>
<br/>
 <div class="alert alert-warning" role="alert" id='principal_sec'>
 <div class="row">
 
	
<div class="col-md-4" >
  <a   class="thumbnail"  href="cierreCaja.php" >
      <img src="../imagenes/conta.png" alt="..." >
      <div class="caption">
        <span>Cierres de caja<span>     
      </div>
    </a>
 </div> 
		
  <div class="col-md-4" >
  <a   class="thumbnail"  href="" >
      <img src="../imagenes/dvol/bajoConstruccion.jpg" alt="..." >
      <div class="caption">
        <span>Proveedores<span>     
      </div>
    </a>
 </div> 	

<div class="col-md-4" >
  <a   class="thumbnail"  href="" >
      <img src="../imagenes/dvol/bajoConstruccion.jpg" alt="..." >
      <div class="caption">
        <span>Clientes<span>     
      </div>
    </a>
 </div> 
 </div></div></div>
</div>
</body>
</html>
