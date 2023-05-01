<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>menu transacciones</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<style>
 
tabla{width:100%}
tabla a{ 
color:#069;  text-decoration:none}
img{width:100px; height:100px}
</style>
</head>

<body>
<div class="panel panel-default" >
<div style='height:55px' class="panel-heading">

<div  style='float:left'>
<span style="font-size:26px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 
<div style="float:right">
 
<a  href="index.php"    ><span class="glyphicon glyphicon-log-out" aria-hidden="true">MenuPincipal</span></a>

</div>
</div>

<br><br><br><br><br> 

<div align="center">
<table   >
<tr>
<td width="130" align="center"><a href="cierres"><img  src="imagenes/cierreCaja.png" height="130px"  width="130px"></br>cierres</a></td>
<td width="130" align="center">  <a href="gastos.php"><img src="imagenes/ICONO-FACTURAS.jpg"  ></br>Gastos</a></td>
<td width="130" align="center">  <a href="bancos.php"><img src="imagenes/bancos.jpg"  ></br>Bancos</a></td>
<td width="130" align="center"><a href="salidasEfectivo.php"><img src="imagenes/images (7).jpg"  ></br>Salidas en Efectivo</a></td><td width="130" align="center"><a href="indexNomina.php"><img src="imagenes/pay-day-icon-9928159.jpg"  ></br>
Nomina</a></td>
<td width="130" align="center"><a href="pagoIVA.php"><img src="imagenes/pagoIva.jpg"  ></br>
Pago IVA</a></td>
<td width="130" align="center"><a href="pagoRetefuente.php"><img src="imagenes/retefuente.jpg"  ></br>Pago Retefuente</a></td><td width="6" >&nbsp;</td>
<td width="130" align="center"><a href="menuCompras.php"><img src="imagenes/compras.jpg"  ></br>Compras</a></td><td width="6" >&nbsp;</td>
<td width="130" align="center"><a href="nuevaCuenta.php"><img  src="imagenes/descarga.jpg" height="110px"  width="130px"></br>Cuentas Por Cobrar</a></td>
<td width="130" align="center"><a href="nuevoCredito.php"><img src="imagenes/pagos.jpg"  ></br>Cuentas Por Pagar</a></td><td width="6" >&nbsp;</td>
</tr>
</table><br><br><br> </div></div>
</body>
</html>