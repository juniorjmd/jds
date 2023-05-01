<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
$user = cargaDatosUsuarioActual();
include '../php/funcionesMysql.php';
$conn= cargarBD();
date_default_timezone_set("America/Bogota"); 
 
 
    
foreach ($_POST as $key => $value) {
    $$key = $value;
}

try{
    

 $conn= cargarBD();
  $conexion =\Class_php\DataBase::getInstance();
 
 $link = $conexion->getLink();   
foreach ($PRO_REMISION as $key => $value) {
    if ($value['newcnt'] > 0){
        $query = "delete from aux_tabla_parametros where cod_duenio_registros = 'REMISION';";
        if (!$conn->query($query)){
             throw new Exception('Error al intentar limpiar la tabla aux_tabla_parametros , por favor verificar.');
        }
        
        $query = " insert into aux_tabla_parametros (id_registro_int , id_registro_dec, cod_duenio_registros)"
                ."value ( {$value['id_rem_det']} ,{$value['newcnt']} , 'REMISION' )";
        $stmt = $conn->stmt_init();
       // $stmt->prepare($query);
 
$consulta = $link->prepare($query);
//if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion 
 if(!$consulta->execute()){          //Si no se puede insertar mand  
$alert = 'No se pudo ingresar el cierre de la remision :' . $conn->error;
     echo "<script> location.href = '".URL_BASE."jds/ordenes_de_carga/devolucion_remision.php?dev_id_orden_compra={$id_orden_compra}&dev_id_remision={$num_remision}&alert_1=Error al ingresar los datos'; </script>"; 
}else{ 
    $query_final = "call sp_devolucion_prd_remision('".$user->getUserLoguin()."');";
    $stmt = $conn->stmt_init();
    $stmt->prepare($query_final);
    
$consulta = $link->prepare($query_final);
    if(!$consulta->execute()){ 
        echo "<script> location.href = '".URL_BASE."jds/ordenes_de_carga/devolucion_remision.php?devolucion_remision.php?dev_id_orden_compra={$id_orden_compra}&dev_id_remision={$num_remision}&alert_1=Error al ingresar los datos'; </script>"; 
    }else{
        echo"<script> location.href = '".URL_BASE."jds/ordenes_de_carga/facturar_remisiones.php?orden_compra_remision_factura={$id_orden_compra}&ingreso=ok'; </script>"; 
        }
  
} 
    }
    
    
}
}  catch ( Exception $e){
    $alert = $e . $conn->error;
     echo "<script> location.href = '".URL_BASE."jds/ordenes_de_carga/devolucion_remision.php?dev_id_orden_compra={$id_orden_compra}&dev_id_remision={$num_remision}&error_1={$alert}'; </script>"; 
 
}