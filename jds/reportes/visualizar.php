<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../db_conection.php';
verificaSession_2("../login/");
$mysqli = cargarBD();

$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
$$tags2[$i]=$valores2[$i]; 
}
?>
		<style>
body{ background-image:url(imagenes/images%20(4).jpg)
background-repeat: no-repeat;
background-position:bottom;
}
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
<body>
<div class="panel panel-default">
<div style='' class="panel-heading">

<div  style='float:left'>
<span style="font-size:150%; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 

 
  <div style='float:right; margin-right: 10px'>
<a  href="../login/"    ><span class="glyphicon glyphicon-lock" aria-hidden="true">Salir</span></a></div>
 <div style='float:right; margin-right: 10px'>
<a  href="../devoluciones/"    ><span class="glyphicon glyphicon-home" aria-hidden="true">inicio</span></a></div>
 <div style='float:right; margin-right: 10px'>
<a  href="../"    ><span class="glyphicon glyphicon-cog" aria-hidden="true">Menu_Principal</span></a></div>

</div>

        <div class="well" align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:1%">
         <div class="panel-heading" align="left">DESCRIPCION</div>
        <table width="80%" class="table">
        <tr><td  > <span>Factura No.&nbsp;:&nbsp;</span>
        <?php echo $num_factura; ?></td>
        <td > <span>Fecha&nbsp;:&nbsp;</span>
        <?php echo $fechaVenta; ?></td>
        <td > <span>Hora&nbsp;:&nbsp;</span>
        <?php echo $horaVenta; ?></td>
        <td > <span>Codigo de venta&nbsp;:&nbsp;</span>
        <?php echo $idVenta;  ?></td>
        </tr> <tr>
        
         <td > <span>tipo de venta&nbsp;:&nbsp;</span>
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
       </table>

        <form action="p_devolucion.php" method="post">
       <input type="hidden" name="idVenta" id="idVenta" value=" <?php echo $cod_venta; ?>"/>
       <div class="panel panel-default" style = 'width : 90%;height:90%;margin:0px;'>
  <!-- Default panel contents -->
 		 <div class="panel-heading" align="left">PRODUCTOS</div>
        
         <?php 
		$query="SELECT * FROM  ventastemp where idVenta = '".trim($idVenta)."';";
		//echo $query;
		//cantidadVendida , valorParcial , valorIVA, valorTotal, fecha, hora, usuario , nit , razonSocial 
		$result = $mysqli->query($query);
		$datosNum=$mysqli->affected_rows;
		$contador = 0;
		$idProducto= "";
		if ($datosNum > 0){
			 ?>
             <input type="hidden" name="num_tipos_productos" value="<?php echo $datosNum; ?>">
             <table style="width:90%" class="table">
			 <tr align="center"><td>CODIGO</td><td>DESCRIPCION</td><td>PRECIO</td><td>IVA</td><td>CANT</td><td>TOTAL</td></tr>
			 <?php
			 $cont_tp = 1;
			while ($row = $result->fetch_assoc()) {
				echo' <input type="hidden" name="linea_'.$cont_tp.'" value="'.$row['idLinea'].'">';
			   echo  '<tr><td>'.$row['idProducto'].'</td>';   
				echo  '<td>'.$row['nombreProducto'].'</td>'; 
				echo  '<td  align="right">'.$row['presioSinIVa'].'</td>';
				echo '<td  align="right">'.$row['IVA'].'</td>';
				echo '<td align="center"> <span class="badge">'.$row['cantidadVendida'].'</span></td>';
				echo '<td  align="right">'.$row['valorTotal'].'</td></tr>';
				$cont_tp = $cont_tp + 1;
			}
		
			 ?>
               <tr>        
        
        <td colspan="6"  align="right"><div class="btn-group" role="group" aria-label="...">
        <a class="btn btn-primary" href="reimpFact.php">
 <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> regresar </a>
    </div>  </td>
</tr>
             </table>
        </div>   </form>
		</div>
		<?php 
		}

?>
 <form action="devolucion_final.php" method="post" autocomplete='off'>
		<input type='hidden' value='<?php echo trim($idVenta);?>' id='df67_5675' name='df67_5675' >
		<input type='hidden' value='<?php echo trim($num_factura);?>' id='consecutivo' name='consecutivo' >
		<input type='submit' id='segundo_form' style='display:none'>
</form>

</div></body>
<meta charset="utf-8">
<title>JDS/Reportes</title>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript"  >
	 
</script>