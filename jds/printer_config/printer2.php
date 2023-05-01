<?php
//error_reporting(0);
if(!$incluido){ include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
}
date_default_timezone_set("America/Bogota"); 
function imprFacturaVenta( $ventaId = null ,$tipoVenta = null ,$moduloActual = null){
if($_POST['IdVenta'] ){$ventaId=$_POST['IdVenta'];}else{$ventaId="M1_1";}
if($_POST['tipoVenta'] ){$tipoVenta=$_POST['tipoVenta'];}else{$tipoVenta="EFECTIVO";}
if(isset($_POST['moduloActual'])){$moduloActual=$_POST['moduloActual'];}else{$moduloActual='M1';}
$auxR=15-strlen(trim($tipoVenta)) ;
$spc4="";
for($i=0;$i<$auxR;$i++)
{$spc4=$spc4." ";}
$tipoVenta=$spc4.$tipoVenta;
$mesa=substr($ventaId, 0, strpos($ventaId,"_")); 
$auxR=((int)$numR+1)*27-strlen($string2) .'</br>';


$inicio=24-strlen($sucursal)/2;
$spc="";
for($i=1;$i<=$inicio;$i++)
{$spc=$spc." ";}
$sucursal=$spc.$sucursal;
$mysqli12 = cargarBD();
//$moduloActual
$query_tipo_impresion = "SELECT * FROM mst_modulos where cod_modulos = '".$moduloActual."' AND tipo_venta = '$tipoVenta' ;";
$datos['query']=$query_tipo_impresion;
$result = $mysqli12->query($query);
while ($row = $result->fetch_assoc()) {
	$tip_impresion = $row["tip_impresion"];
	$cod_tip_impresion = $row["cod_tip_impresion"];
}
$datos['tipoImpresion']  = $tip_impresion;
if ($tip_impresion === 'P_L'){
		require_once ('..\php_class\printFactura.class.php');
		$factura_print = new printFactura($cod_tip_impresion,$ventaId);
		$factura_print->generar('F');
	 	$datos['modalMsg'] = '<div id="muestaFactura"> <input type="button" id="cerrarFacturaModal" value ="cerrar"><br><object data="'.$factura_print->getNArchivo().'" type="application/pdf" width="100%" height="100%"></object></div> ';
}else{//impresoras de tiquetes.
$query="SELECT  * FROM  `ventas` WHERE `idVenta`='".$ventaId."' ";
//echo $query;
$result = $mysqli12->query($query);
while ($row = $result->fetch_assoc()) {$numFactura=$row["orden"];
$totalVenta=$row["valorTotal"];
$totalIva=$row["valorIVA"];
$subTotal=$row["valorParcial"];
}
$auxR=10-strlen(trim($totalVenta)) ;
$spc4="";
for($i=0;$i<$auxR;$i++)
{$spc4=$spc4." ";}
$totalVenta=$spc4.$totalVenta;

$auxR=10-strlen(trim($totalIva)) ;
$spc4="";
for($i=0;$i<$auxR;$i++)
{$spc4=$spc4." ";}
$totalIva=$spc4.$totalIva;

$auxR=10-strlen(trim($subTotal)) ;
$spc4="";
for($i=0;$i<$auxR;$i++)
{$spc4=$spc4." ";}
$subTotal=$spc4.$subTotal;

$auxR=7-strlen(trim($numFactura)) ;
$spc4="";
for($i=0;$i<$auxR;$i++)
{$spc4=$spc4."0";}
$numFactura=$spc4.$numFactura;
//echo $numFactura."<br>";
$query="SELECT  `ventacliente`.*, clientes.nombre FROM  `ventacliente` join clientes on ventacliente.idCliente=clientes.nit WHERE `ventacliente`.`idVenta`='".$ventaId."' ";
$result = $mysqli12->query($query);
//echo $query;
while ($row = $result->fetch_assoc()) {$nombreCliente=$row["nombre"];
$nitCliente=$row["idCliente"];}

//echo $nombreCliente." asdfa ss".$nitCliente;

$query="SELECT  `ventastemp`.* ,  `producto`.nombre AS  'nomProducto' FROM  `ventastemp` JOIN producto ON  `ventastemp`.idProducto =  `producto`.idProducto WHERE `idVenta`='".$ventaId."' ";
//echo $query;
$result = $mysqli12->query($query);
$datosNum=$mysqli12->affected_rows;
if($handle = printer_open("puntoVenta"))
{
$lfont = printer_create_font("Arial", 10, 8, PRINTER_FW_BOLD, false, false, false, 0);
$lfont2 = printer_create_font("Arial", 40, 20, PRINTER_FW_BOLD, false, false, false, 0);
printer_select_font($printer, $lfont);
printer_set_option($handle, PRINTER_ORIENTATION, PRINTER_ORIENTATION_PORTRAIT );
if($_POST['abrir'])
{printer_write($handle,  chr(27). chr(112). chr(0). chr(100). chr(250));
}
$tope = 10-strlen($ventaActual);
$num_factura='';
for($i=0; $i<$tope ; $i++)
{
	$num_factura=$num_factura.'0';
}
$num_factura=$num_factura.$ventaActual;
//echo 'factura No.'.$num_factura;
printer_set_option($handle, PRINTER_MODE, "raw");
printer_write($handle, "________________________________________________");
printer_write($handle, "\r\n");
printer_write($handle, "             DROGUERIA\r\n");
printer_select_font($printer, $lfont2);
printer_write($handle, rellenar($_SESSION["sucursalNombre"],28,' '));
printer_select_font($printer, $lfont);
printer_write($handle, "\r\n");
printer_write($handle, rellenar('TEL: '.$_SESSION["tel1"],31,' '));
printer_write($handle, "\r\n");
printer_write($handle, rellenar('NIT '.$_SESSION["nit_sucursal"].' REGIMEN '.$_SESSION["tip_regimen"],38,' '));
printer_write($handle, "\r\n");
printer_write($handle, rellenar($_SESSION["dir"],30,' '));
printer_write($handle, "\r\n");
printer_write($handle, rellenar($_SESSION["ciudad"],34,' '));
printer_write($handle, "\r\n\n");
printer_write($handle, "HABILITA RESOL. ".$_SESSION["num_cod_resolucion"]."-".$_SESSION["fec_resolucion"]);
printer_write($handle, "\r\n");
printer_write($handle, "FACTURA DEL ".$_SESSION["num_fac_inicial"]." AL ".$_SESSION["num_fac_final"]);
printer_write($handle, "\r\n");
printer_write($handle, "________________________________________________");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "FACTURA DE VENTA :              No. ".$numFactura);
printer_write($handle, "\r\n");
printer_write($handle, "        T. VENTA :       ".$tipoVenta);
printer_write($handle, "\r\n");
printer_write($handle, "               FECHA ".date("d-M-Y")."\r\n");
printer_write($handle, "                  HORA ".date("g:i:s"));
printer_write($handle, "\r\n");
printer_write($handle, "CLIENTE: ".$nombreCliente."  NIT: ".$nitCliente."\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "  Cant    Descripcion        VR. Und   VA. TOTAL ");
while ($row = $result->fetch_assoc()) {
printer_write($handle, "\r\n");
$string1="  ".$row["cantidadVendida"];
$inicio=8-strlen($string1);
$spc="";
/*
carrera 47 numero 72-68 local 2 tecnoelectronic de la costa 
4210978
3004328333
3566608 */
for($i=1;$i<=$inicio;$i++)
{$spc=$spc." ";}
$string3=trim($row["presioVenta"]);
$inicio=8-strlen($string3);
$spc2="";
////echo $inicio;
for($i=1;$i<$inicio;$i++)
{$spc2=$spc2." ";}
$strcentro="";
for($i=1;$i<=$inicio;$i++)
{$spc2=$spc2." ";}
$spcCentro="\n        ";
$string2=$row["nomProducto"];
$inicio=strlen($string2);
if($inicio>17)
{$inicio=17;}
$aux=0;
for($i=0;$i<$inicio;$i++)
{
	$strcentro=$strcentro.substr($string2,$i,1);$aux++;
}
for($i=0;$i<17-$inicio;$i++)
{
	$strcentro=$strcentro." ";
}


$punto="";
$auxR=8-strlen(trim($row["valorTotal"])) ;
$spc4="";
for($i=0;$i<$auxR;$i++)
{$spc4=$spc4." ";}
printer_write($handle, $string1.$spc.$strcentro.$spc2.$string3."    ".$spc4.$row["valorTotal"]);
} 

printer_write($handle, "\r\n\r\n================================================\r\n\r\n");


printer_write($handle, "              BASE/IMP.:         $".$subTotal."\r\n");
printer_write($handle, "                IVA 16%:         $".$totalIva."\r\n");
printer_write($handle, "            TOTAL VENTA:         $".$totalVenta."\r\n");

IF ($_GET['mIngresado']==''){
	$_GET['mIngresado'] = $totalVenta;
}

printer_write($handle, "               EFECTIVO:         $".$_GET['mIngresado']."\r\n");
IF  ($_GET['t_devolucion'] == ''){
	$_GET['t_devolucion'] = '0.0';
}

printer_write($handle, "        TOTAL DEVUELTO:         $".$_GET['t_devolucion'] ."\r\n");
printer_write($handle, "\r\n             GRACIAS POR SU COMPRA");
printer_write($handle, "\r\n");
printer_write($handle, "\n\n\n\n");
printer_write($handle, "________________________________________________");
printer_write($handle, "\r\n");
printer_write($handle, chr(10) . chr(10) . chr(10) . chr(10) . chr(29) . chr(86) . chr(49) . chr(12)); 

printer_close($handle);}

}

return json_encode($datos);
}
?>