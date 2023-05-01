<?php 

function listar_directorios_ruta($ruta){ 
   // abrir un directorio y listarlo recursivo 
   if (is_dir($ruta)) { 
      if ($dh = opendir($ruta)) { 
         while (($file = readdir($dh)) !== false) { 
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio 
            //mostraría tanto archivos como directorios 
            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($ruta . $file); 
            if (is_dir($ruta . $file) && $file!="." && $file!=".."){ 
               //solo si el archivo es un directorio, distinto que "." y ".." 
               echo "<br>Directorio: $ruta$file"; 
               listar_directorios_ruta($ruta . $file . "/"); 
            } 
         } 
      closedir($dh); 
      } 
   }else 
      echo "<br>No es ruta valida"; 
}
 
//RFC Call for ZMCV_RFC_CONSULTA_DESPACHOS
//Generated by saprfc_test.php (http://saprfc.sourceforge.net)

//Login to SAP R/3
//$login = array (
//"ASHOST"=>ASHOST_SAP,
//"SYSNR"=>SYSNR_SAP, 
//"CLIENT"=>CLIENT_SAP,
//"USER"=>USER_SAP,
//"PASSWD"=>PASSWD_SAP); 
$login = array ( "ASHOST"=>"172.20.67.135",
			"SYSNR"=>"00",
			"CLIENT"=>"053",
			"USER"=>"user_sd",
			"PASSWD"=>"usersd01");

$rfc = saprfc_open ($login );
if (! $rfc ) { echo "RFC connection failed"; exit; }
//Discover interface for function module ZMCV_RFC_CONSULTA_DESPACHOS
$fce = saprfc_function_discover($rfc,"ZMCV_RFC_CONSULTA_DESPACHOS");
if (! $fce ) { echo "Discovering interface of function module failed"; exit; }
//It's possible to define interface manually. If you would like do it, uncomment following lines:
//Set import parameters. You can use function saprfc_optional() to mark parameter as optional.
saprfc_import ($fce,"FECHA_FIN","20080330");//AAAAMMDD
saprfc_import ($fce,"FECHA_INI","20080101");//AAAAMMDD
saprfc_import ($fce,"LGORT","");
saprfc_import ($fce,"MATNR","");
saprfc_import ($fce,"ORDEN","");
saprfc_import ($fce,"REMISION","");
saprfc_import ($fce,"WERKS","");
//Fill internal tables
saprfc_table_init ($fce,"ZMCV_LE_DESPACHO");
//Do RFC call of function ZMCV_RFC_CONSULTA_DESPACHOS, for handling exceptions use saprfc_exception()
$rfc_rc = saprfc_call_and_receive ($fce);
if ($rfc_rc != SAPRFC_OK) { if ($rfc == SAPRFC_EXCEPTION ) echo ("Exception raised: ".saprfc_exception($fce)); else echo (saprfc_error($fce)); exit; }
//Retrieve export parameters
$rows = saprfc_table_rows ($fce,"ZMCV_LE_DESPACHO");
for ($i=1;$i<=$rows;$i++)
	$ZMCV_LE_DESPACHO[] = saprfc_table_read ($fce,"ZMCV_LE_DESPACHO",$i);
//Debug info
saprfc_function_debug_info($fce);
saprfc_function_free($fce);
saprfc_close($rfc);
