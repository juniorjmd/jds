<?php 
include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'db_conection.php';
$conn= cargarBD();


echo'<input type="hidden" name="venta_neta" id="venta" value="'.$t_v_neta.'" >';
echo'<input type="hidden" name="venta_bruta" id="venta" value="'.$t_v_bruta.'" >';
echo'<input type="hidden" name="venta_iva" id="venta" value="'.$t_v_iva.'" >';
echo'<input type="hidden" name="venta_rt" id="venta" value="'.$t_v_rt.'" >'; 



if($_POST["venta_neta"]){
	$stmt = $conn->stmt_init();
		$query="INSERT INTO 
 `retefuente_pagada` (id_usuario,FECHA,total_venta_bruta,total_venta_neta,IVA,totalRf) VALUES (
		'".$_SESSION["usuarioid"]."','".date("Y-m-d")."','".$_POST['venta_bruta']."','".$_POST['venta_neta']."','".$_POST['venta_iva']."','".$_POST['venta_rt']."');";	
		echo $query;
		$stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo crear la tabla de ingresos:' . $conn->error);
		break;
		}else{	
		$query2="UPDATE `retefuente` SET  `estado` ='PAGADO'  WHERE `estado`='ACTIVO'";
		$result = $conn->query($query2);
		echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!!!!!!!!!</div><br><br>';
		 echo '<script>setTimeout(function() {
        window.location="pagoRetefuente.php"
    },3500);</script>';
		}	
	}
$t_v_neta=0;
$t_v_bruta=0;
$t_v_iva=0;
$t_v_rt=0;

$query_retefuentes_generadas ="SELECT * FROM retefuente ".
"left join usuarios on usuarios.id = retefuente.id_usuario where estado =  'ACTIVO' ;";
 //echo $query_retefuentes_generadas;
$result = $conn->query($query_retefuentes_generadas);
$lineas_retefuente ='<table style="width:90%"><tr><td colspan="8" align="center">RETENCIONES REALIZADAS EN COMPRAS</td></tr><tr><td>
 Cod. venta </td><td> Fecha de creacion </td><td> Venta bruta</td><td> Venta neta</td><td> % Retefuente</td><td> IVA</td><td> Retefuente</td><td>  usuario</td></tr>';
while ($row = $result->fetch_assoc()) {
	$lineas_retefuente .= '<tr align="center">'.
	'<td>'.$row["id_venta"].'</td>'.
	'<td>'.$row["FECHA"].'</td>'.
	'<td align="">'."$ ".number_format($row["total_venta_bruta"],2).'</td>'.
	'<td>'."$ ".number_format($row["total_venta_neta"],2).'</td>'.
	'<td>'.$row["porcentaje_retefuente"].'</td>'.
	'<td>'."$ ".number_format($row["IVA"],2).'</td>'.
	'<td>'."$ ".number_format($row["totalRf"],2).'</td>'.
	'<td>'.$row["nombre"].' '.$row["apellido"].'</td>'.
	'</tr>';
	$t_v_neta+= $row["total_venta_neta"];
$t_v_bruta+= $row["total_venta_bruta"];
$t_v_iva+=$row["IVA"];
$t_v_rt+=$row["totalRf"];
	
}$result->free();
$lineas_retefuente .= '</table>';

$query2="SELECT SUM(`valorParcial`) AS VALOR_PARCIAL, SUM(`valorIVA`) AS VALOR_IVA, 
SUM(`valorTotal`) AS VALOR_TOTAL FROM `ventas` WHERE `pago_iva`='NINGUNO'";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	$VALOR_PARCIAL=$row["VALOR_PARCIAL"];
	$VALOR_IVA=$row["VALOR_IVA"];
	$VALOR_TOTAL=$row["VALOR_TOTAL"];
}$result->free();

?>
<form action="pagoRetefuente.php" autocomplete="on" method="post">
<?php
echo'<input type="hidden" name="venta_neta" id="venta" value="'.$t_v_neta.'" >';
echo'<input type="hidden" name="venta_bruta" id="venta" value="'.$t_v_bruta.'" >';
echo'<input type="hidden" name="venta_iva" id="venta" value="'.$t_v_iva.'" >';
echo'<input type="hidden" name="venta_rt" id="venta" value="'.$t_v_rt.'" >'; 
$t_v_neta="$ ".number_format($t_v_neta,2);
$t_v_bruta="$ ".number_format($t_v_bruta,2);
$t_v_iva="$ ".number_format($t_v_iva,2);
$t_v_rt="$ ".number_format($t_v_rt,2);

 ?> 
<div align="center">
<table width="617" border="0">
  <tr>
  <td colspan="4"align="center"><h2>REGISTRO DE LA RETENCION EN LA FUENTE REALIZADA</h2></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Valor de los venta bruta</td>
    <td width="166">&nbsp;<?php echo $t_v_bruta ;?></td>
    <td width="149">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Valor del IVA causado</td>
    <td>&nbsp;<?php echo $t_v_iva ;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;valor de la base</td>
   <td>&nbsp;<?php echo $t_v_neta ;?></td>
    <td>&nbsp;</td>  
  </tr>
  <tr>
    <td width="200">&nbsp;Total Impuesto a pagar</td>
    <td colspan="3" style="font-size:56px; background-color:#C69">&nbsp;<?php echo  $t_v_rt ;?></td>
    
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="image" class="botonIVA" id="registarPago" title="Regista el pago del impuesto"  src="imagenes/accept (2).png"></form><input title="Regresar al menu anterior" type="image" src="imagenes/ICONO-FACTURAS.jpg" id="volverAtras" ></td>
   
  </tr>
</table></div>
<div><br><?php echo $lineas_retefuente;?></div>
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>

<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);

	$('#volverAtras').click(function(e){
		e.preventDefault();
		location.href='menuTrans.php'
			});	
   });			 
					

</script>
