<?php include 'php/inicioFunction.php';
verificaSession_2("login/");  
include 'db_conection.php';
$mysqli = cargarBD();
$stmt = $mysqli->stmt_init();
$aux='';
$iva =  (float) $_POST['total_venta'] * (float)  $_POST['p_iva']/100;
if (isset($_POST['edit'])){ 
 if(isset($_POST['editExistente'])){
     $idLinea = $_POST['idLinea'];
     $idCompra = $_POST['idCompra'];
     $query="update listacompraedicion set cantidad_edicion = '{$_POST['Cantidad_a_comprar']}' where idLinea = '$idLinea'";
 }else{
 $query="INSERT INTO  `listacompraedicion` (`idCompra` ,`idProducto` ,`nombreProducto` ,`presioCompra` ,`cantidad` "
       .",`valorTotal` ,`usuario`,`porcent_iva`,`iva`,estado , cantidad_edicion , valorsiva )VALUES (  '{$_POST['id_de_Compra']}'"
       .",'".$_POST['codigo_del_producto']."',  '".$_POST['nombre_del_producto']."',  '{$_POST['precio_de_compra']}'," 
       ."'{$_POST['Cantidad_a_comprar']}', '{$_POST['total_venta']}',  '{$_POST['usuario']}','{$_POST['p_iva']}'," 
 ."'{$iva}','N' ,'{$_POST['Cantidad_a_comprar']}' ,( {$_POST['total_venta']}  - {$iva}) );";}

}ELSE{
    $query="INSERT INTO  `listacompra` 
(`idCompra` ,`idProducto` ,`nombreProducto` ,`presioCompra` ,`cantidad` ,`valorTotal` ,`usuario`,`porcent_iva`,`iva`,valorsiva)VALUES (  '".$_POST['id_de_Compra']."',  '".$_POST['codigo_del_producto']."',  '".$_POST['nombre_del_producto']."',  '".$_POST['precio_de_compra']."',  '".$_POST['Cantidad_a_comprar']."',  '".$_POST['total_venta'].
"',  '".$_POST['usuario']."','".$_POST['p_iva']."','".$iva."' ,( {$_POST['total_venta']}   - {$iva}) );";
} 
$stmt->prepare($query);
if(!$stmt->execute()){ 
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{
if(isset($_POST['editExistente'])){
   // echo"mostrarDetalleFacturaEdicion.php?tabla=listacompraedicion&dato={$idCompra}&col=idCompra";
 echo "<script> location.href = '".URL_BASE.".jds/mostrarDetalleFacturaEdicion.php?tabla=listacompraedicion&dato={$idCompra}&col=idCompra'; </script>";
}else{echo 1;}

}
 ?>
 