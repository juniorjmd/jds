<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
include_once '../printer_config/printerManager.php';
session_sin_ubicacion("login/");
$incluido=true;

if(isset($_GET['IdVenta'])){ 
$ventaId=$_GET['IdVenta'];
$tipoVenta=$_GET['tipoVenta'];
$VAUCHE=$_GET['VAUCHE'];
$conn= cargarBD();
$stmt = $conn->stmt_init(); 
/*
orden, idVenta, codMesa, cantidadVendida, valorParcial, descuento, valorIVA, valorTotal, fecha, hora, usuario, estado, idCierre, pago_iva, tipoDeVenta, estadoFactura, fecha_entrega, porc_retefuente, retefuente
 *  */
 $query="SELECT * FROM ventas where idVenta = '{$ventaId}';";
 //echo $query.'<br>';
                    $result = $conn->query($query);
                            while ($row = $result->fetch_row()) {
                        $tipoVenta=  $row['tipoDeVenta'];
                        $codMesa = $row['codMesa'];
                        
                             }
$datos =imprFacturaVenta( $ventaId ,$tipoVenta,$codMesa , NULL);
 
echo $datos['modalMsg'];
} 

?>


<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script>
$(document).ready(function(){
    $('#cerrarFacturaModals').click(function(){
        $(this).parent().remove();
        
    })
});
</script>