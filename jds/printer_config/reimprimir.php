<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
include_once '../printer_config/printerManager.php';
session_sin_ubicacion("login/");
$incluido=true;
if(isset($_POST['IdVenta'])){
 $_POST['IdVenta']=    'M1_'.$_POST['IdVenta'] ;
$ventaId=$_POST['IdVenta'];
$tipoVenta=$_POST['tipoVenta'];
$VAUCHE=$_POST['VAUCHE'];
$conn= cargarBD();
$stmt = $conn->stmt_init(); 
/*
orden, idVenta, codMesa, cantidadVendida, valorParcial, descuento, valorIVA, valorTotal, fecha, hora, usuario, estado, idCierre, pago_iva, tipoDeVenta, estadoFactura, fecha_entrega, porc_retefuente, retefuente
 *  */
 $query="SELECT * FROM ventas where idVenta = '{$_POST['IdVenta']}';";
                    $result = $conn->query($query);
                            while ($row = $result->fetch_row()) {
                        $tipoVenta=  $row['tipoDeVenta'];
                        
                             }
$datos =imprFacturaVenta( $_POST['IdVenta'] ,$tipoVenta,NULL , NULL);

print_r($datos);
} 

?>

<form target="reimprimir.php" method="post" >
    
   ingrese codVenta :  M1_<input type="text" name="IdVenta"/>
   <BR> <button type="submit">Enviar</button>
</form>