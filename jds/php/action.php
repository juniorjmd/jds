<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/"); 
//  $json ='{"action":"GUARDAR_RELACION_MEDIDAS_GRUPOS","medida":1,"arrayGrupos":["3","4"]}';
//  var_dump(json_decode($json, true));echo '<br>';
//  $_POST = json_decode($json, true);  
//$action = $_POST['action'];
    
switch ($action){
    case 'GUARDAR_RELACION_MEDIDAS_GRUPOS':
    /* medida : $('#medida').val() ,
            arrayGrupos*/
        $arrayGrupos = $_POST['arrayGrupos'];
    
       $conexion = Class_php\DataBase::getInstance();
       $link = $conexion->getLink();
      //   $link->beginTransaction();
      try { 
         $_result = $conexion->eliminarDato('tipo_medida_grupo', $_POST['medida'],'id_tipo_medida');
         switch ($_result[0]['result']){
           case '100':
         foreach ($arrayGrupos as $value) {
         //echo '<br>'."call `sp_insert_recurso_perfil`('{$_POST['medida']}', '$value', '{$_SESSION["usuario_logeado"]}' )" ;
         $consulta = $link->prepare("call `sp_insert_medida_grupo`(:medida, :id_grupo,  :user  )");
         $consulta->bindParam(':medida', $_POST['medida']);
         $consulta->bindParam(':id_grupo', $value); 
         $consulta->bindParam(':user', $_SESSION["usuario_logeado"] );
         $consulta->execute(); 
            $array =  $consulta->fetchAll(); 
            switch ($array[0]['result']){
                case '100':
                case '101':              
                     $result ='ok';  
                break;
                case '-1':
                     $result ='not ok';  
                     break 1;   
                break;           
              }
              
            }
            if ($result == 'ok'){           
           //      $link->commit();
            }else{ 
           //     $link->rollBack();
            }
              $result ='ok';  
           break;
           case '-1':
                $result ='_table';  
           break;   
           case '-2':
                $result ='_dato';  
           break;   
           case '-3':
                $result ='_COLUMNA';  
           break;   
           default :
                $result = $_result[0]['result'];
           break;
       } 
       
       $datos['error'] = $result;
       $conexion = null;
                
      } catch (PDOException $e) {
    $datos['error'] =  'Error de conexión: ' . $e->getMessage();
                
}
        
    break;
} 
 echo json_encode($datos);
?>



