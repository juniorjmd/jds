
<?php
/*ULL ,  '".$_POST['codMesa']."',  '".$_POST['IdVenta']."',  '".$_POST['idProducto']."',  '".$_POST['nombreProducto']."',  '".$_POST['presioVenta']."',  '".$_POST['cantidadVendida']."',  '0',  '".$_POST['valorTotal']."',  '".$_POST['usuario']."',  CURDATE() );";*/error_reporting(0);
date_default_timezone_set("America/Bogota"); 
try{
if($handle = printer_open("puntoVenta"))
{
printer_set_option($handle, PRINTER_MODE, "raw");
printer_set_option($handle, PRINTER_COPIES, "3"); // i want 3 copies
printer_set_option($handle, PRINTER_SCALE, 75);
printer_set_option($handle, PRINTER_ORIENTATION, PRINTER_ORIENTATION_PORTRAIT );
printer_write($handle, $sucursal);
printer_write($handle, "\r\n");
printer_write($handle, "                PEDIDO MESA  ".$_POST['codMesa']."\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "        FECHA ".date("d-M-Y")."   HORA ".date("g:i:s"));
printer_write($handle, "\r\n");
printer_write($handle, "\r\n          ".$_POST['cantidadVendida']."   ".$_POST['nombreProducto']."   \r\n");
printer_write($handle, "\r\n\r\n================================================\r\n\r\n");
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
printer_write($handle, "\r\n");
printer_close($handle);}}
catch (Exception $e) {
   // echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}
?>