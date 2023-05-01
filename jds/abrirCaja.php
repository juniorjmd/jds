<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 

if($handle = printer_open("puntoVenta"))
{
printer_set_option($handle, PRINTER_MODE, "raw");
printer_set_option($handle, PRINTER_COPIES, "3"); // i want 3 copies
printer_set_option($handle, PRINTER_SCALE, 75);
printer_set_option($handle, PRINTER_ORIENTATION, PRINTER_ORIENTATION_PORTRAIT );
printer_write($handle,  chr(27). chr(112). chr(0). chr(100). chr(250));
}
?>