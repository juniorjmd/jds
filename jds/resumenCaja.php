<?php 
include 'php/inicioFunction.php';
verificaSession_2("login/");

include 'db_conection.php';
 $conn= cargarBD();
 	$todasVentas=0;
 //$query2="SELECT * FROM  `ventas` WHERE  `estado` =  'activo' AND estadoFactura = 'A' ORDER BY  `ventas`.`codMesa` ASC ";

     $query2=   "SELECT * FROM jdpsoluc_jds_dm_4.ventas left join (
SELECT  cod_modulos , nom_modulo, dir_modulo FROM jdpsoluc_jds_dm_4.mst_modulos group by cod_modulos, nom_modulo, dir_modulo  
) as modulo on cod_modulos = codMesa 
WHERE  `estado` =  'activo' AND estadoFactura = 'A' ORDER BY  `ventas`.`codMesa` ASC  ;";
        $result = $conn->query($query2);
$aux="";
$mesa="";
$disable="disabled";
$help="<tr><td align='center' colspan='4'>NO HA REALIZADO NINGUNA VENTA EL DIA DE HOY</td>
</tr>";
while ($row = $result->fetch_assoc()) {
	$disable="";
	$help="";
if($mesa!=$row['codMesa']){

if (trim($mesa) !== ''){
  $html.= " <tr><td align='center' colspan='4'>".$aux.amoneda($venta)."</td></tr>  ";
}
$mesa=$row['codMesa'];
$html.=" <tr><td align='center' colspan='4' height='38' style='color:#006699;background-color:#7DA2FF;font: 15px  'Trebuchet MS', sans-serif;font-weight: bold;' >Modulo ".$row['nom_modulo']."</td>
</tr>
<tr><td align='center'>FECHA</td><td align='center'>HORA</td><td align='center'>CANTIDAD</td><td align='center'>TOTAL</td>
</tr>";$venta=0;$aux="TOTAL VENDIDO POR EL MODULO  ";
}

$venta=$venta+$row['valorTotal'];
$todasVentas=$todasVentas+$row['valorTotal'];
$html=$html."<tr><td align='center'>".$row['fecha']."</td><td align='center'>".$row['hora']."</td><td align='center'>". $row['cantidadVendida']."</td><td align='center'>".amoneda($row['valorTotal'])."</td></tr>";
}
$html=$html."
<tr><td align='center' colspan='4' nowrap>".$aux.amoneda($venta)."</td>
</tr>" ; 
	$dir="ventas/nFacturacion.php"; 
        ?>

 <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>

<table width="363"   align="center" class="table">
 <tr>
   <td align="right"><input type="image" src="imagenes/print.jpg" width="57" height="53" id="print" title="REGRESAR A VENTAS"   <?php echo $disable; ?>>
       <a href="<?php echo $dir; ?>" style="text-decoration:none"> 
           <img  src="imagenes/ICONO-FACTURAS.jpg" id="print" width="57" height="53"></a></td></tr>
 </table>
 <table width="363"  border="1" align="center" style="border:thin">
<tr> <td  height='48' colspan="4" align="center">RESUMEN DE VENTAS ACTIVAS<br/>TOTAL FACTURADO : 
<?php echo amoneda($todasVentas);  ?>
</td>
<?PHP echo $help.$html;?>
</tr> 
 
 </table>
 
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
	$("#print").click(function(){
		$.ajax({
						url: 'printer_config/printerResumen.php',  
						type: 'POST',
						
						data: null,
						success: {}
					});
		
		})
	
	});

</script>