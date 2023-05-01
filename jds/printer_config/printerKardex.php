<?php
//error_reporting(0);
if(!$incluido){ include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
}
date_default_timezone_set("America/Bogota"); 
foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
} 

if ($itemBusqueda === 'todos' ) 
	{$where = '';
$sqlAux = 'select COUNT(*) from producto GROUP BY `idLab`';
$result = $mysqli->query($sqlAux);
$numeroBusquedas=$mysqli->affected_rows;
}
else {$where =" where idLab = '".$itemBusqueda."'";
$numeroBusquedas = 1;}
	$sqlCardex = "SELECT * FROM `producto` ".$where ."  ORDER BY  `idLab`";
	$result = $mysqli->query($sqlCardex);
	$datosNumCardex=$mysqli->affected_rows;
	$lab="";
	$countDiv =1;
	$conteo = 0;
	

$query="";
$result = $mysqli12->query($query);
$datosNum=$mysqli12->affected_rows;
if($handle = printer_open("puntoVenta"))
{
////echo printer_get_option($handle, PRINTER_DRIVERVERSION);
$lfont = printer_create_font("Arial", 10, 8, PRINTER_FW_BOLD, false, false, false, 0);
$lfont2 = printer_create_font("Arial", 40, 20, PRINTER_FW_BOLD, false, false, false, 0);
printer_select_font($printer, $lfont);
printer_set_option($handle, PRINTER_ORIENTATION, PRINTER_ORIENTATION_PORTRAIT );
if($_POST['abrir'])
{printer_write($handle,  chr(27). chr(112). chr(0). chr(100). chr(250));
}
 
printer_set_option($handle, PRINTER_MODE, "raw");
printer_write($handle, "________________________________________________");
printer_write($handle, "\r\n");
printer_write($handle, "             DROGUERIA\r\n");
printer_select_font($printer, $lfont2);
printer_write($handle, rellenar($_SESSION["sucursalNombre"],28,' '));
printer_select_font($printer, $lfont);
printer_write($handle, "\r\n");
printer_write($handle,rellenar('TEL: '.$_SESSION["tel1"],31,' '));
printer_write($handle, "\r\n");
printer_write($handle,rellenar('NIT '.$_SESSION["nit_sucursal"].' REGIMEN '.$_SESSION["tip_regimen"],38,' '));
printer_write($handle, "\r\n");
printer_write($handle, rellenar($_SESSION["dir"],30,' '));
printer_write($handle, "\r\n");
printer_write($handle, rellenar($_SESSION["ciudad"],34,' ')); 
printer_write($handle, "\r\n");
printer_write($handle, "________________________________________________");
printer_write($handle, "\r\n");
printer_write($handle, "\r\n");
printer_write($handle, "               FECHA ".date("d-M-Y")."\r\n");
printer_write($handle, "                  HORA ".date("g:i:s"));
printer_write($handle, "\r\n"); 
///////////////////////////////////777
if($datosNumCardex>0){
		$numeroBusquedas = $numeroBusquedas + $datosNumCardex;
		$numeroPorDiv = (round($numeroBusquedas/2) )+1 ;
	while ($row = $result->fetch_assoc()) {
		if ($countDiv == 1 || $countDiv == $numeroPorDiv ){
			if ( $countDiv == $numeroPorDiv){
			}		
		}
		if($lab !=  $row['laboratorio']){
			$conteo++ ; 
			$print=true;$lab =  $row['laboratorio'];
		}
		if ($print){
			printer_write($handle,"____Marca : ".$row['laboratorio']."___");
			$print=false; 
		$countDiv++;
		}
		$numLns=(round((strlen(trim($row["idProducto"]))+strlen(trim($row["nombre"]))+strlen(trim($row["cantActual"])) +10)/48));
		if(is_float($numLns))
		{
			echo $numLns.'es flotante';
		}
		else {echo $numLns.'no es flotante';}
		printer_write($handle, $row['idProducto']."| ".$row['nombre']."| ".$row['cantActual'].'|_____');
		$countDiv++;
	}
	}

///////////////////////////////////
printer_write($handle, "\r\n\r\n================================================\r\n\r\n");

printer_write($handle, "\r\n");
printer_write($handle, "\n\n\n\n");
printer_write($handle, "________________________________________________");
printer_write($handle, "\r\n");
printer_write($handle, chr(10) . chr(10) . chr(10) . chr(10) . chr(29) . chr(86) . chr(49) . chr(12)); 

printer_close($handle);}
?>