<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
$user = cargaDatosUsuarioActual();
include '../php/funcionesMysql.php';
//$cod_tip_impresion,$orden_de_compra,$codigo_remision;
$conn= cargarBD();
$QUERY = "select cod_tip_impresion from mst_modulos where tipo_venta = 'CREAR_REMISION';";
    $result = $conn->query($QUERY);
$num_datos = $conn->affected_rows;
$TABLA = '';
 //echo "$query_inicial---$num_datos";
if ($num_datos >= 1)
{
    while ($row = $result->fetch_assoc()) { 
        $cod_tip_impresion = $row['cod_tip_impresion']; 
}}
//ini_set('display_errors', '1'); 
require ('../php_class/printRemisiones.class.php');
		$factura_print = new printFactura($cod_tip_impresion,$orden_de_compra,$codigo_remision);
		$factura_print->generar('F');
	 	echo '<div id="portapdf"> 
    <object data="'.$factura_print->getNArchivo().'" type="application/pdf" width="100%" height="100%"></object></div> '; 
              
		?>