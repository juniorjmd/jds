<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
 $conn= cargarBD();
//$query="SELECT * FROM `relacioncombo` INNER JOIN producto on (relacioncombo.idProducto = producto.idProducto) WHERE `id`= '".$_POST['idCombo']."'";


/*SELECT * FROM  `vw_ventas_temp` WHERE  `fecha` BETWEEN  '2014-12-19' AND  '2014-12-20' AND  `hora` BETWEEN  '00:00' AND  '02:15' ORDER BY  `vw_ventas_temp`.`fecha` ASC */

if($_GET['iklme']){$iklme=" AND   `idProducto`='".$_GET['iklme']."'";}else{$iklme='';}
$query="SELECT * FROM `vw_ventas_temp`".$where.$iklme." ORDER BY  `fecha` DESC  ";
$time1='00:01:00';
$time2='23:59:59';
date_default_timezone_set('UTC');
$fecha1=$fecha2=date('Y-m-d' );

if($_POST['dateInicial']!=''){
	$fecha1=$_POST['dateInicial'];
if($_POST['dateFinal']!=''){$fecha2=$_POST['dateFinal'];}else{$fecha2=$fecha1;}
if($_POST['timeInicial']!=''){$time1=$_POST['timeInicial'];}
if($_POST['timeFinal']!=''){$time2=$_POST['timeFinal'];}

}
$parametros ="";
$query= "SELECT DISTINCT * FROM  `vw_ventas_temp` WHERE  `fecha` >=  '".$fecha1.' '.$time1."' AND  `fecha` <= '".$fecha2.' '.$time2."' ".$iklme." ORDER BY  `vw_ventas_temp`.`fecha` ASC";
$parametros  = array(
        1 => array("columna" => 'fecha',"dato" => "$fecha1 $time1","relacion" => '>=',) ,
        2 => array("columna" => 'fecha',"dato" => "$fecha2 $time2","relacion" => '<=' )  
) ;
IF(ISSET($_POST['nitBusqueda']) && TRIM($_POST['nitBusqueda'])!='')
{$parametros[3]= array("columna" => 'idCliente',"dato" => TRIM($_POST['nitBusqueda']) ,"relacion" => '=' );

$query= "SELECT DISTINCT * FROM  `vw_ventas_temp` WHERE idCliente = '".TRIM($_POST['nitBusqueda'])."' AND `fecha` >=  '".$fecha1.' '.$time1."' AND  `fecha` <= '".$fecha2."'  ".$iklme." ORDER BY  `vw_ventas_temp`.`fecha` ASC";

}
if($_GET['vtlme']){$query= "SELECT DISTINCT * FROM  `vw_ventas_temp` WHERE  `idVenta` =  '".$_GET['vtlme']."'";
$parametros  = array(
        1 => array("columna" => 'idVenta',"dato" => "{$_GET['vtlme']}","relacion" => '=',)  
) ;
} 
//echo $query;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
$actualPromedio;
$html="";
$IVA_VENTA = 0;
$venta_sin_iva = $VENTA = $IVA_VENTA = 0;
$Eventa_sin_iva = $EVENTA = $EIVA_VENTA = 0;
$Cventa_sin_iva = $CVENTA = $CIVA_VENTA = 0;
while ($row = $result->fetch_assoc()) {
    
    hlp_utf8_string_array_encode($row);
    $ESTADO = 'ACTIVO';
    if($row['estadoFactura'] == 'C'){$ESTADO = 'CANCELADA';}
	$html=$html."<tr>
 <td align='center' >
 <input type='image' id='".$row['idVenta']."' class='ventas' src='imagenes/texto.png'  ></a></td>
  <td align='center' > <input type='image' id='".$row['idProducto']."' class='productos' src='imagenes/flechaAdelante.jpg' width='38' height='25'></td>
  <td align='center' >".$row['fecha']."</td>
  <td align='center' >".$row['hora']."</td>      
  <td align='right'>".$row['nombre']."</td>
  <td align='right'>".$ESTADO."</td>
  <td align='right'>".$row['nombreProducto']."</td>
  <td align='center'>".$row['cantidadVendida']."</td>
  <td align='right'>".$row['presioVenta']."</td>
  <td align='right'>".$row['valorTotal']."</td>
 </tr>";
 if($row['estadoFactura'] == 'A'){
     switch ($ESTADO) {
         case 'CREDITO':
 $Cventa_sin_iva += $row['presioSinIVa'] * $row['cantidadVendida'];
 $CVENTA+=$row['valorTotal'];
 if($row['IVA'] > 0){
     
 $CIVA_VENTA += (($row['valorTotal'] * $row['IVA'] ) / 100 );
}

             break;
             
             case 'ELECTRONICA':
 $Eventa_sin_iva += $row['presioSinIVa'] * $row['cantidadVendida'];
 $EVENTA+=$row['valorTotal'];
 if($row['IVA'] > 0){
     
 $EIVA_VENTA += (($row['valorTotal'] * $row['IVA'] ) / 100 );
}

             break;

         default:
              $venta_sin_iva += $row['presioSinIVa'] * $row['cantidadVendida'];
 $VENTA+=$row['valorTotal'];
 if($row['IVA'] > 0){
     
 $IVA_VENTA += (($row['valorTotal'] * $row['IVA'] ) / 100 );
}
             break;
     }

 }

 }
 
$tabla = 'vw_ventas_temp';
$nombreArchivo = 'listaProductosVendidos';
$tipoTabla=1;
$datos_cabecera = array( 
    "idVenta" =>'VENTA',
    "fecha" =>'FECHA',
    "hora" =>'HORA',
    "nombre" =>'CLIENTE',
    "estadoFactura" =>'EST. FACTURA',
    "nombreProducto" =>'DESCRIPCION',
    "cantidadVendida" =>'CANTIDAD',
    "presioVenta" =>'PRECIO',
    "valorTotal" =>'TOTAL',
       
) ;
?>
<link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
 <div id='ContBusquedaPersonas'></div>
<div id='contenedor'  align="center"> 
 <form action="productosVendidos.php" method="post" autocomplete="off" id="formularioEvio">
 <table width="200" >
   <tr>
     <td>desde</td>
     <td><input type="date" name="dateInicial"  value="<?php echo $fecha1; ?>"></td>
     <td>hora</td> <td><input type="time"  value="<?php echo $time1; ?>" name="timeInicial"></td>
     <td>hasta</td>
     <td><input type="date" name="dateFinal" value="<?php echo $fecha2;  ?>"></td> <td>hora</td>
     <td><input type="time" value="<?php echo $time2; ?>"  name="timeFinal"></td>
     <td><input type="submit" value="PROCESAR" id="enviar"></td>
   </tr>
   <tr>
     <td>CLIENTE (nit/cedula)</td>
 
     <td> <?php agregarBusquedaPersonas('cliente','contenedor',[
    "clase" => "gasto",
    "value" => TRIM($_POST['nitBusqueda'])
         ],'N','2');?></td><td>CLIENTE</td> 
     <td colspan="5"><input type="TEXT" style="width: 100%" value="<?php echo TRIM($_POST['cliente']);?>" id="cliente" name="cliente"></td>
   </tr>
 </table></form>
     
     
<table >
    
    <tr><td  align="right" colspan="3" >EFECTIVO:</td><td  align="right"   >SUBTOTAL </td><td    style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px" align="right"><?PHP echo  round($venta_sin_iva, 2); ?>
 </td> <td  align="right"   >IVA</td><td      style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px" align="right"><?PHP echo round($IVA_VENTA, 2); ?>
 </td>
  <td align="right"  >TOTAL </td><td   align="right"   style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px"><?PHP echo round($VENTA); ?>
 
 </td></tr> 
 <tr><td  align='center' colspan="2" >&nbsp;</td><td   align='center' colspan="5" >&nbsp;</td></tr>
 
  <tr><td  align="right" colspan="3" >CREDITO:</td><td  align="right"   >SUBTOTAL </td><td  style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px" align="right"><?PHP echo  round($Cventa_sin_iva, 2); ?>
 </td> <td  align="right"   >IVA</td>     <td  style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px" align="right"><?PHP echo round($CIVA_VENTA, 2); ?>
 </td>
  <td align="right"  >TOTAL </td><td   align="right"   style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px"><?PHP echo round( $CVENTA); ?>
 
 </td></tr> 
 <tr><td  align='center' colspan="2" >&nbsp;</td><td   align='center' colspan="5" >&nbsp;</td></tr>
 
  <tr><td  align="right" colspan="3" >ELECTRONICA:</td><td  align="right"   >SUBTOTAL </td><td  style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px" align="right"><?PHP echo  round($Eventa_sin_iva, 2); ?>
 </td> <td  align="right"  >IVA</td>     <td  style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px" align="right"><?PHP echo round( $EIVA_VENTA, 2); ?>
 </td>
  <td align="right"   >TOTAL </td><td   align="right"   style=" font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#009; font-size:24px"><?PHP echo round($EVENTA); ?>
 
 </td></tr> 
 
 <tr><td  align='center' colspan="2" >&nbsp;</td><td   align='center' colspan="5" >&nbsp;</td></tr>
 <tr><td  align='center' colspan="2" ><?php agregarExcelDinamico($tabla,$nombreArchivo,$tipoTabla,   $datos_cabecera , $parametros ) ; ?></td><td   align='center' colspan="5" >&nbsp;</td></tr>
 

 <tr>

 <td width="52"  align='center' >VENTA</td>
  <td width="100" align='center'>PRODUCTO</td>
 
  <td width="93" align='center'>FECHA</td>
  <td width="103" align='center'>HORA</td>
  <td  align='center'>CLIENTE</td>
  <td align='center'>EST. FACTURA</td>
  <td width="225" align='center'>DESCRIPCION</td>
  <td width="81" align='center'>CANTIDAD</td>
  <td width="86" align='center'>PRECIO</td>
  <td width="84" align='center'>TOTAL</td>
 </tr>
 <?php echo $html;?>
 </table></div>
 
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
	$('.productos').click(function(){
		var direccion ='productosVendidos.php?iklme='+$(this).attr('id')
		$('#formularioEvio').attr('action',direccion);
		$('#enviar').trigger('click');
	});
	
		$('.ventas').click(function(){
		var direccion ='productosVendidos.php?vtlme='+$(this).attr('id')
		$('#formularioEvio').attr('action',direccion);
		$('#enviar').trigger('click');
	});
	
	});
</script>