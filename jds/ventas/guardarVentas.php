<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
obtenertVariables();
include '../php/db_conection.php';
$mysqli = cargarBD();
$idLinea=0;
$queryLinea="SELECT * FROM  `ventastemp` order by idLinea ";
$resultLinea = $mysqli->query($queryLinea);
while ($rowCombo = $resultLinea->fetch_assoc()) {
	$idLinea=$rowCombo["idLinea"];
	}
$idLinea++;
$stmt = $mysqli->stmt_init();
 /*
cantidadVendida='+encodeURIComponent($("#cantidadVenta").val())
                                +'&cantidadDescontar
  *   */
if (isset($_SESSION["fechaVentas"])&&$_SESSION["fechaVentas"]!=''){
	$fechaActual = "'".trim($_SESSION["fechaVentas"]).' '.date('G:i:s')."'";
}else{
	$fechaActual = "CURRENT_TIMESTAMP";
}
$CANT =   number_format ( trim($_POST['cantidadDescontar']), 2);
$CANT = str_replace(',', '', $CANT);
$_POST['cantidadVendida'] = number_format ( trim($_POST['cantidadVendida']), 2);
$_POST['cantidadVendida'] = str_replace(',', '', $_POST['cantidadVendida']);
$query="INSERT INTO  `ventastemp` (`idLinea` ,`codMesa` ,`idVenta` ,`idProducto` ,`nombreProducto` ,`presioVenta` ,`porcent_iva`,`presioSinIVa`,`IVA`,`cantidadVendida` ,`descuento` ,`valorTotal` ,`usuario` ,`fecha`,`hora`,`maq_activa`  , cant_real_descontada)VALUES ( '".$idLinea."',  '".$_POST['codMesa']."',  '".$_POST['IdVenta']."',  '".$_POST['idProducto']."',  '".$_POST['nombreProducto']."',  '".$_POST['presioVenta']."', '".$_POST['porcent_iva']."','".$_POST['PsIVA']."','".$_POST['IVA']."', '".$_POST['cantidadVendida']."',  '0',  '".$_POST['valorTotal']."',  '".$_SESSION["usuarioid"]."',  ".$fechaActual." , CURTIME() ,'".$_POST['mesaActivada']."','$CANT');";
 //echo $query;
 $stmt->prepare($query);
$total=0;


if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
$datos['mensaje']='No se pudo insertar:' . $stmt->error;
$datos['estado']=2;
}else{
	
$auxQuery="UPDATE  `producto` SET  `cantActual` = (`cantActual`-".$CANT." ),`ventas`=`ventas`+".$CANT." WHERE CONVERT(`idProducto` USING utf8 ) =  '".$_POST['idProducto']."' LIMIT 1 ;";		
$datos['auxQuery']=$auxQuery;
$stmt->prepare($auxQuery);
if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
$datos['mensaje']='No se pudo actualizar el listado de producto:' . $stmt->error;
$datos['estado']=2;
$Query_delete="delete from `ventastemp` WHERE CONVERT(`idLinea` USING utf8 ) =  '".$idLinea."' LIMIT 1 ;";		
$result = $mysqli->query($Query_delete);
}else{$query_select="select * from producto WHERE CONVERT(`idProducto` USING utf8 ) =  '".$_POST['idProducto']."' LIMIT 1 ;";			
$result = $mysqli->query($query_select);
while ($row = $result->fetch_assoc()) {
$datos['dato']=$row;
	}
$datos['estado']= 1;
$datos['mensaje']='todo bien';
}
}
echo json_encode($datos);	

?>
