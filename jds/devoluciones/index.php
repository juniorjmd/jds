<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
		$mysqli = cargarBD();
		
$num_factura = $_POST['num_factura'];
?>
<style>
 
button 	{vertical-align: -webkit-baseline-middle;}
a{vertical-align: -webkit-baseline-middle;}
img {border:none; height:110% ; cursor: pointer} 
.panel-heading {height:8%}

@media screen and (min-width:300px) and (max-width:800px)  {
body{font-size:0.8em;}
a > span {font-size:15px;}
.panel-heading {height:35px}
}

</style>
<title>JDS/Devoluciones</title>
<body>
<div class="panel panel-default">
 

<div class="well" align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:3%">
<form  autocomplete="off" method="post">
<input autofocus type="number" id="num_factura" name="num_factura" value="<?php echo $num_factura; ?>" placeholder="No. de factura">  
<br/><br/><button class="btn">
 <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
Consultar

</button></div>
</td></tr>
</table>
</form>
</div>

<?php 
if (isset($num_factura)){
	if (trim($num_factura)!='' ){
		$query="SELECT j.idVenta as idVenta, cantidadVendida , valorParcial , valorIVA, valorTotal, fecha, hora, usuario,nit,razonSocial, tipoDeVenta ,estadoFactura ,U.nombre1 as nombre , U.apellido1 as apellido
				FROM  `ventas` j
				LEFT JOIN ventacliente y ON j.idVenta = y.`idVenta` 
				LEFT join clientes F on y.idCliente = F.nit 
				LEFT join usuarios U on j.usuario = U.id
		 WHERE `orden`= ".$num_factura ;
                 //cantidadVendida , valorParcial , valorIVA, valorTotal, fecha, hora, usuario , nit , razonSocial 
		$result = $mysqli->query($query);
		$datosNum=$mysqli->affected_rows;
		$contador = 0;
		$idProducto= "";
		if ($datosNum > 0){
			while ($row = $result->fetch_assoc()) {
			$cod_venta = $row['idVenta'];
			$cantidadVendida=$row['cantidadVendida'];
			$subTotal = $row['valorParcial'];
			$total = $row['valorTotal'];
			$fechaVenta = $row['fecha'];
			$horaVenta = $row['hora'];
			$vendedor = $row['nombre'].' '.$row['apellido'];//U.nombre , U.apellido
			$tipoVenta = $row['tipoDeVenta'];
			$codigoCliente = $row['nit'];
			$razonSocialCliente = $row['razonSocial'];
			$iva = $row['valorIVA'];
			$estadoFactura = $row['estadoFactura'];
			//$estadoFactura = 'C'; estado C es cancelada, A es actia.
			} 
			$activo = 'disabled';
			if ($estadoFactura == 'A'){$activo = '';}
			else{echo '<div class="alert alert-danger" role="alert" id="estadoAlert"><strong>Ooops</strong> La factura que intenta consultar se encuentra cancelada. </div>
       ';}
		?>
		<style>
			#estadoAlert{ width:30%; margin-left:60px}
		</style>
		 <form action="devolucion.php" method="post">
        <div class="well" align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:1%">
       <input type="hidden" name="num_factura" id="num_factura" value="<?php echo $num_factura; ?>"/>
       <input type="hidden" name="idVenta" id="idVenta" value="<?php echo $cod_venta; ?>"/>
	   <input type="hidden" name="cantidadVendida" id="cantidadVendida" value="<?php echo $cantidadVendida; ?>"/>
       <input type="hidden" name="subTotal" id="subTotal" value="<?php echo $subTotal; ?>"/>
       <input type="hidden" name="total" id="total" value="<?php echo $total; ?>"/>
       <input type="hidden" name="fechaVenta" id="fechaVenta" value="<?php echo $fechaVenta; ?>"/>
       <input type="hidden" name="horaVenta" id="horaVenta" value="<?php echo $horaVenta; ?>"/>
       <input type="hidden" name="vendedor" id="vendedor" value="<?php echo $vendedor; ?>"/>
       <input type="hidden" name="tipoVenta" id="tipoVenta" value="<?php echo $tipoVenta; ?>"/>
       <input type="hidden" name="codigoCliente" id="codigoCliente" value="<?php echo $codigoCliente; ?>"/>      
       <input type="hidden" name="razonSocialCliente" id="razonSocialCliente" value="<?php echo $razonSocialCliente; ?>"/>     
       <input type="hidden" name="iva" id="iva" value="<?php echo $iva; ?>"/>
        <table width="80%">
        <tr><td height="55" > <span>No. factura&nbsp;:&nbsp;</span>
        <?php echo $num_factura; ?></td>
        <td > <span>fecha&nbsp;:&nbsp;</span>
        <?php echo $fechaVenta; ?></td>
        <td > <span>hora&nbsp;:&nbsp;</span>
        <?php echo $horaVenta; ?></td></tr>
        <tr><td colspan="5" height="33"> <span>vendedor&nbsp;:&nbsp;</span>
        
        <?php echo $vendedor; ?></td>
       
        
        </tr>
		<tr>
         <td height="33"> <span>tipo de venta&nbsp;:&nbsp;</span>
        <?php echo $tipoVenta; ?></td>
        <td > <span>cant. productos&nbsp;:&nbsp;</span>
        <?php echo  $cantidadVendida; ?></td>
        <td><span>sub total&nbsp;:&nbsp;</span>
        <?php echo  $subTotal; ?></td>
        <td><span>iva&nbsp;:&nbsp;</span>
        <?php echo  $iva; ?></td>
         <td><span>total&nbsp;:&nbsp;</span>
        <?php echo  $total; ?></td>
         </tr>
         <tr>
        
        <td height="33"> <span>cliente</span>
      </td></tr>
        <tr>        
        <td height="33"> <span>identificacion&nbsp;:&nbsp;</span>
        <?php echo  $codigoCliente; ?></td>
        <td colspan="5"><span>nombre/ra. social&nbsp;:&nbsp;</span>
        <?php echo  $razonSocialCliente; ?></td>
        <td>
        
        </tr>
        </tr>
		<tr>        
        
        <td colspan="6"  align="right">&nbsp;
        </td>
        </tr>
        <tr>        
        
        <td colspan="6"  align="right">
        <button class="btn btn-primary btn-lg"  <?php echo $activo;?> >
 <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
generar Devolucion

</button>
        </td>
        </tr>
        </table>
</div>
        <div id="container" style = 'width : 90%;height:90%;margin:0px;'>
         <?php 
		
		
		 ?> 
        </div>   </form>
		
		<?php 
		}else {?>
        <div class="well" align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:3%">
        <span>No. factura
        <?php echo $num_factura; ?> no se encuentra registrado</span>
        </div>
         <?php }
}}
?>

</div></body>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
 
});
</script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />