<?php 
ini_set('display_errors', '1');
require ('../php_class/printFactura.class.php');
		$factura_print = new printFactura(3,4);
		$factura_print->generar('F'); 
	 	echo '<div id="portapdf"> 
    <object data="'.$factura_print->getNArchivo().'?'.date('Hms').'" type="application/pdf" width="100%" height="100%"></object></div> ';
 
		?>