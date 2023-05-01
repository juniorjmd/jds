<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
error_reporting(0);
date_default_timezone_set("America/Bogota"); 
include 'db_conection.php';

$auxR=((int)$numR+1)*27-strlen($string2) .'</br>';
if($_POST['sucursal'] ){$sucursal= $_POST['sucursal'];}else{$sucursal="EL SITIO";}

$inicio=24-strlen($sucursal)/2;
$spc="";
for($i=1;$i<=$inicio;$i++)
{$spc=$spc." ";}
$sucursal=$spc.$sucursal;

$mysqli12 = cargarBD();
$query="SELECT * FROM  `ventas` WHERE  `estado` =  'activo' ORDER BY  `ventas`.`codMesa` ASC";
$result = $mysqli12->query($query);
$datosNum=$mysqli12->affected_rows;
if($handle = printer_open("puntoVenta"))
{
//echo printer_get_option($handle, PRINTER_DRIVERVERSION);
printer_set_option($handle, PRINTER_MODE, "raw");
printer_set_option($handle, PRINTER_SCALE, 75);
printer_set_option($handle, PRINTER_ORIENTATION, PRINTER_ORIENTATION_PORTRAIT );
printer_write($handle, "\r\n");
printer_write($handle, $sucursal);
printer_write($handle, "\r\n");
printer_write($handle, "               FECHA ".date("d-M-Y")."\r\n");
printer_write($handle, "                  HORA ".date("g:i:s"));
printer_write($handle, "\r\n");
printer_write($handle, "            TIPO DE VENTA : CONTADO\r\n");
printer_write($handle, "               RESUMEN DE VENTAS   ");

$aux="";
$mesa="";
$totalVenta=0;
while ($row = $result->fetch_assoc()) {
	$totalVenta=$totalVenta+$row['valorTotal'];
	if($mesa!=$row['codMesa']){
$mesa=$row['codMesa'];
printer_write($handle, "\r\n     ");
printer_write($handle, $aux.$venta."\r\n");
printer_write($handle, "\r\n     MESA ".$mesa."\r\n\r\n");

printer_write($handle, "      FECHA        HORA     CANTIDAD     TOTAL");
$venta=0;$aux="     TOTAL VENDIDO POR LA MESA  ";
}
$venta=$venta+$row['valorTotal'];
$inicio=(6-strlen($row['cantidadVendida']))+(8-strlen($row['valorTotal']));
$spc="";
for($i=1;$i<=$inicio;$i++)
{$spc=$spc." ";}

printer_write($handle, "\r\n    ".$row['fecha']."    ".$row['hora']."     ".$row['cantidadVendida'].$spc.$row['valorTotal']);
printer_write($handle, "\r\n");
}

printer_write($handle, "\r\n     ");
printer_write($handle, $aux.$venta."\r\n");
printer_write($handle, "\r\n\r\n================================================\r\n\r\n");
printer_write($handle, "            valorTotal:         $".$totalVenta."\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_close($handle);}
?>