<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
$user = cargaDatosUsuarioActual();
include '../php/funcionesMysql.php';
$conn= cargarBD();
print_r($_POST); 

$_id_orden_compra ; $_pago_retefuente ;$_tipo_venta ;
$_USUARIO =  $user->getId(); 

$_pago_retefuente = strtoupper($_pago_retefuente);
if ($_pago_retefuente != 'S')
{//$_porc_retefuente = $_SESSION['porcent_retefuente_venta'];
//}else{
$_porc_retefuente = 0 ;}
/*
 *
in _abonoInicial decimal(12,2),
in _numCuotas decimal(12,2),
in _intervalo decimal(12,2)
 *   */
    //call sp_asignar_consecutivo_factura(2, 'M1')
IF(TRIM($_abonoInicial)=='') $_abonoInicial = 0; 
IF(TRIM($_numCuotas)=='')  $_numCuotas= 0; 
IF(TRIM($_intervalo)=='') $_intervalo = 0; 
   
$query= "call  sp_facturar_orden_compra($_id_orden_compra, '$_USUARIO' , '$_pago_retefuente', $_porc_retefuente ,'$_tipo_venta','$_abonoInicial','$_numCuotas','$_intervalo','$_num_vauche');";
 echo $query;
$result2 = $conn->query($query); 
$datosNum=$conn2->affected_rows;
  $row = $result2->fetch_assoc();
  print_r($row);
  //result, id_int_venta, id_venta
if($row['result'] == '100'){
  $url= URL_BASE . 'jds/printer_config/reimpresion_facturas.php?IdVenta='.$row['id_venta'] ;
   header("Location: $url");
}else{ 
   header("Location: facturar_remisiones.php?error=No se pudo realizar la facturacion de las remisiones por favor intente mas tarde&num_orden_compra_aux=$_id_orden_compra");
}

