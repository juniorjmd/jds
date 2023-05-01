<?php 
ini_set('display_errors', '1');
require ('..\php_class\printRemisiones.class.php');
		$factura_print = new printFactura(11,1,1);
		$factura_print->generar('F');
	 	echo '<div id="portapdf"> 
    <object data="'.$factura_print->getNArchivo().'" type="application/pdf" width="100%" height="100%"></object></div> ';
 
		?>