<?php
require_once '../../../php/helpers.php';  
//echo print_r(FILTRAR_DATOS_RFC_EASYSALE_CLIENTES());
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../../'. str_replace('\\','/',$nombre_clase ).'.php' ;
  //  ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });

new Core\Config();  
if ($_SESSION['access']==false){
    header('Location: ../../');
}
include '../../../jds/db_conection.php';
 $conn= cargarBD(); 
guardarNuevaPersona();
guardarNuevaCuenta();
$busquedaDinamica = null;
// $json ='{"action":"VERIFICAR_Y_ELIMINAR_GRUPO_CNT","id_grupo":"2","cod_grupo":"12"}';
//   var_dump(json_decode($json, true));echo '<br>';
//  $_POST = json_decode($json, true);      
$action = $_POST['action'];
$nomTableCabecera = $_POST['cabeceras'];  
if (isset($_POST['columnas'])){
    $cabeceras = obtenerNomCabeceraBusqueda($nomTableCabecera);
    $busquedaDinamica = true;
   
   switch ($_POST['concordancia']){
       case '0':
           $signo = '=';
           $ini=$fin = '';
           break;
       case '1':
           $signo = 'like';
            $ini=$fin = '%';
           break;
       case '3':
           $signo = 'like';
            $ini='%';
            $fin = '';
           break;
       case '2':
           $signo = 'like';
           $ini= '';
            $fin = '%';
           break;
   }
    if ($_POST['columnas'] == '*'){
         $where =' where';
         foreach ($cabeceras as $key => $value) {
             if ($key > 0)$where.= ' or ';
            $where.= " $value  $signo  '$ini{$_POST['item']}$fin'";
         }
        
    }else{
        $where = " where {$_POST['columnas']} $signo  '$ini{$_POST['item']}$fin'";
    }
}
       
switch ($action){
    case 'LISTAR_TRANSACCIONES':
        utf8_string_array_decode($_POST);
        foreach($_POST as $key => $value )
            {
                    $$key = $value;
            } 
        TRY {
        
            
        $conexion =\Class_php\DataBase::getInstance();  
            $link = $conexion->getLink();
            $WHERE = '';
            $WHERE_a = '';
            IF(ISSET($fechaInicio) && ISSET($fechaFin)){
                if ($fechaInicio!='' && $fechaFin != '')
                    {$WHERE .= " WHERE fecha_transaccion between '$fechaInicio' and '$fechaFin' ";
                     $WHERE_a .= ' WHERE ';
                    } 
            }
           
            $ORIGEN_TRANSACCION =  TRIM($ORIGEN_TRANSACCION);
            $PARAMETRO_BUSQUEDA =  TRIM($PARAMETRO_BUSQUEDA);
             if ($PARAMETRO_BUSQUEDA != '')
             {
                 if($WHERE_a === ''){ $WHERE_a .= ' WHERE ';}else{$WHERE .= " and ";}
                 $WHERE .= " cod_comprobante = {$PARAMETRO_BUSQUEDA}  ";
                 if($ORIGEN_TRANSACCION === ''){ $ORIGEN_TRANSACCION = 'operaciones';}
                 }
                 
             
            
             if (ISSET($ORIGEN_TRANSACCION) && $ORIGEN_TRANSACCION != '')
             { if($WHERE_a === ''){
                 $WHERE_a .= ' WHERE ';
             }else{
                  $WHERE .= " and ";
             }
                 $WHERE .= " origen_comprobante = '{$ORIGEN_TRANSACCION}'  ";}
                 
                 
            
            $query=" select * from vw_transacciones  $WHERE_a $WHERE ;";
    
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
            $datos['query'] = $query; 
            $datos['datos'] = $aux_datos;
            $datos['filas'] = sizeof( $aux_datos) ;
            $datos['error']='';
       if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera); 
            $datos['nombreCabecera']=$nomTableCabecera;
        } 
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;
    
        }      
        
        break;
    case 'GUARDAR_DATOS_OPERACIONES'://obtener el listado completo de la tabla de menus. 
         utf8_string_array_decode($_POST);
        foreach($_POST as $key => $value )
            {
                    $$key = $value;
            }  
          try {     
            $conexion = \Class_php\DataBase::getInstance();
            $link = $conexion->getLink(); 
    
    $nitBusqueda;
    $idOperacion = $_SESSION["ID"].date('ymYHis');
            //reg[2][numCuenta]
    $cout = 0;
            foreach ($reg as $key => $value) {
               $query =  "INSERT INTO `cnt_transacciones`"
                       . "( `id_cuenta`,`varlor_credito`,`varlor_debito`,`fecha_transaccion`,"
                       . "`relacion_tabla`,`ingreso_saldos`,`usuario`,`fecha_ingreso`, "
                       . "cod_tercero,cod_comprobante, origen_comprobante) "
                       . "VALUES( id_cuenta_contable({$value['numCuenta']}) ,"
                       . "{$value['credito']},{$value['debito']},curdate(),'operaciones',"
                       . "'N','{$_SESSION["ID"]}' ,now(),'$nitBusqueda' , '$idOperacion' ,"
                       . " 'operaciones');";
                 $consulta = $link->prepare($query);
            $datos['query'][$cout] = $query;
            $continua = true;
                if ($consulta->execute()){
                  $datos['error'][$cout]='ok'; 
                }else{
                     $datos['error'][$cout]='error'; 
                     $continua = false;
                     break;
                }
            $cout++;
            } 
            if($continua){
               $queryFinal = "INSERT INTO  `operaciones` ( `usuario`, `nombre`, `fecha`,   `idAux`) VALUES "
                           . "( '{$_SESSION["ID"]}','$nombreOperacion',curdate() ,'$idOperacion'); ";                    
               $consulta = $link->prepare($queryFinal);
                    $datos['queryFinal'] = $queryFinal;
                    if ($consulta->execute()){
                      $datos['error']='ok';  

                    }else{ $datos['error']='Error al tratar de ingresar los valores a la base de datos TABLA (operaciones)'; }
                }else{
                    $datos['error']='Error al tratar de ingresar los valores a la base de datos TABLA (transacciones)';
                $consulta = $link->prepare("delete from cnt_transacciones where cod_comprobante = '$idOperacion' ");
               $consulta->execute() ;
            }
    
            
    
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;
    
        }
        
    
    break; 
    case 'LISTAR_DATOS_OPERACIONES':
         try{
          utf8_string_array_decode($_POST);
            $conexion =\Class_php\DataBase::getInstance();  
            $link = $conexion->getLink();
            $WHERE = '';
            $WHERE_a = '';
            if ($fechaInicio!='' && $fechaFin != '')
            {$WHERE .= " WHERE fecha between '$fechaInicio' and '$fechaFin' ";
             $WHERE_a .= ' WHERE ';
            }
    
            $PARAMETRO_BUSQUEDA =  TRIM($PARAMETRO_BUSQUEDA);
             if ($PARAMETRO_BUSQUEDA != '')
             { if($WHERE_a === ''){
                 $WHERE_a .= ' WHERE ';
             }else{
                  $WHERE .= " and ";
             }
                 $WHERE .= " nombre LIKE '%{$PARAMETRO_BUSQUEDA}%' ";}
            
            $query=" select cod_operacion, usuario, nombre, fecha, totalD, idAux, totalC , nombreCompleto "
                    . " from operaciones "
                    . " left join usuarios usr on usr.ID = usuario "
                    . " $WHERE_a $WHERE  ORDER by fecha,nombre;";
    
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
            $datos['query'] = $query; 
            $datos['datos'] = $aux_datos;
            $datos['filas'] = sizeof( $aux_datos) ;
            $datos['error']='';
       if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera); 
            $datos['nombreCabecera']=$nomTableCabecera;
        } 
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;
    
        }  
        break;
   case 'GUARDAR_DATOS_GASTOS_OPERATIVOS':  
       try{
          utf8_string_array_decode($_POST);
            $conexion =\Class_php\DataBase::getInstance();  
            $link = $conexion->getLink();
            $where = '';
         $_POST['DATOS'] = str_replace(',', '),(', $_POST['DATOS']);
        $query2 = "truncate table gastos_seleccionados";
         $consulta = $link->prepare($query2);
            $datos['query'] = $query;
            if ($consulta->execute()){
              $datos['error']='ok';  
               $query = "INSERT INTO gastos_seleccionados( cuenta_selec )  VALUES({$_POST['DATOS']})";
            
   
            $consulta = $link->prepare($query);
            $datos['query'] = $query;
            $datos['query2'] = $query2;
            if ($consulta->execute()){
              $datos['error']='ok';  
                
            }else{ $datos['error']='Error al tratar de ingresar los valores a la base de datos TABLA (cuenta_selec)'; }  
            }else{ $datos['error']='Error al tratar de eliminar los datos de la TABLA (cuenta_selec)'; }
       
    
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;
    
        }
       break;
       
       
 //<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE MODULO DE CUENTAS CONTABLES...">
      case 'EXTRAER_BALANCE_GENERAL':
          utf8_string_array_decode($_POST);
         try {
            $conexion = \Class_php\DataBase::getInstance();
            //activos
            $cod_clase = '1';
            $fechaInicio=$fechaFin = '';
            if( isset($_POST['fechaInicial']) && trim($_POST['fechaInicial'])!= '' )
                {
                $fechaInicio= trim($_POST['fechaInicial']);
                }
            if( isset($_POST['fechaFinal']) && trim($_POST['fechaFinal'])!= '' )
                {
                $fechaFin = trim($_POST['fechaFinal']);
                }else{ $fechaFin  = $fechaInicio;}
                
            $WHERE = "";
            if ($fechaInicio!='' && $fechaFin != '')
            {$WHERE .= " and  fecha_transaccion between '$fechaInicio' and '$fechaFin' ";}
            
            $query="SELECT nro_cuenta,  nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo, sum(varlor_debito) debito, sum(varlor_credito) credito "
                    .",(sum(varlor_debito) - sum(varlor_credito)) saldo ,abs((sum(varlor_debito) - sum(varlor_credito))) saldo_vabs FROM  vw_transacciones"
                    ." where cod_clase = $cod_clase  $WHERE  group by nro_cuenta, nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo;";
                        
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
            $saldo=0;
            foreach ($aux_datos as $key => $value) {
            $saldo += $value['saldo'];
            }
            //utf8_string_array_encode($aux_datos); 
            $datos['saldo_total_activo'] = $saldo;
            $datos['datos_activo'] = $aux_datos;
            $datos['filas_activo'] = sizeof( $aux_datos) ;
            //pasivos  
            $cod_clase = '2';
            $query="SELECT nro_cuenta,  nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo, sum(varlor_debito) debito, sum(varlor_credito) credito "
                    .",(sum(varlor_debito) - sum(varlor_credito)) saldo ,abs((sum(varlor_debito) - sum(varlor_credito))) saldo_vabs FROM  vw_transacciones"
                    ." where cod_clase = $cod_clase  $WHERE  group by nro_cuenta, nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo;";
            
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll();
             $saldo=0;
            foreach ($aux_datos as $key => $value) {
            $saldo += $value['saldo'];
            }
            //utf8_string_array_encode($aux_datos); 
            $datos['saldo_total_pasivo'] = $saldo;
            $datos['datos_pasivo'] = $aux_datos;
            $datos['filas_pasivo'] = sizeof( $aux_datos) ;
            //patrimonio  
            $cod_clase = '3';
            $query="SELECT nro_cuenta,  nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo, sum(varlor_debito) debito, sum(varlor_credito) credito "
                    .",(sum(varlor_debito) - sum(varlor_credito)) saldo ,abs((sum(varlor_debito) - sum(varlor_credito))) saldo_vabs FROM  vw_transacciones"
                    ." where cod_clase = $cod_clase  $WHERE  group by nro_cuenta, nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo;";
        
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
            $saldo=0;
            foreach ($aux_datos as $key => $value) {
            $saldo += $value['saldo'];
            }
            //utf8_string_array_encode($aux_datos); 
            $datos['saldo_total_patrimonio'] = $saldo;
            $datos['datos_patrimonio'] = $aux_datos;
            $datos['filas_patrimonio'] = sizeof( $aux_datos) ;
              $datos['error']='';
    
                 }
        catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null; 
        }
        break;
       
       case 'EXTRAER_ESTADO_DE_RESULTADO':
          utf8_string_array_decode($_POST);
         try {
            $conexion = \Class_php\DataBase::getInstance();
            //activos
            $cod_clase = '4';
            $fechaInicio=$fechaFin = '';
            if( isset($_POST['fechaInicial']) && trim($_POST['fechaInicial'])!= '' )
                {
                $fechaInicio= trim($_POST['fechaInicial']);
                }
            if( isset($_POST['fechaFinal']) && trim($_POST['fechaFinal'])!= '' )
                {
                $fechaFin = trim($_POST['fechaFinal']);
                }else{ $fechaFin  = $fechaInicio;}
                
            $WHERE = "";
            if ($fechaInicio!='' && $fechaFin != '')
            {$WHERE .= " and  fecha_transaccion between '$fechaInicio' and '$fechaFin' ";}
            
            $query="SELECT nro_cuenta,  nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo, sum(varlor_debito) debito, sum(varlor_credito) credito "
                    .",(sum(varlor_debito) - sum(varlor_credito)) saldo ,abs((sum(varlor_debito) - sum(varlor_credito))) saldo_vabs FROM  vw_transacciones"
                    ." where cod_clase = $cod_clase  $WHERE  group by nro_cuenta, nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo;";
                        
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
            $saldo=0;
            foreach ($aux_datos as $key => $value) {
            $saldo += $value['saldo'];
            }
            //utf8_string_array_encode($aux_datos); 
            $datos['saldo_total_activo'] = $saldo;
            $datos['datos_activo'] = $aux_datos;
            $datos['filas_activo'] = sizeof( $aux_datos) ;
            //pasivos  
            $cod_clase = '5';
            $query="SELECT nro_cuenta,  nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo, sum(varlor_debito) debito, sum(varlor_credito) credito "
                    .",(sum(varlor_debito) - sum(varlor_credito)) saldo ,abs((sum(varlor_debito) - sum(varlor_credito))) saldo_vabs FROM  vw_transacciones"
                    ." where cod_clase = $cod_clase  $WHERE  group by nro_cuenta, nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo;";
            
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll();
             $saldo=0;
            foreach ($aux_datos as $key => $value) {
            $saldo += $value['saldo'];
            }
            //utf8_string_array_encode($aux_datos); 
            $datos['saldo_total_pasivo'] = $saldo;
            $datos['datos_pasivo'] = $aux_datos;
            $datos['filas_pasivo'] = sizeof( $aux_datos) ;
            //patrimonio  
            $cod_clase = '6';
            $query="SELECT nro_cuenta,  nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo, sum(varlor_debito) debito, sum(varlor_credito) credito "
                    .",(sum(varlor_debito) - sum(varlor_credito)) saldo ,abs((sum(varlor_debito) - sum(varlor_credito))) saldo_vabs FROM  vw_transacciones"
                    ." where cod_clase = $cod_clase  $WHERE  group by nro_cuenta, nombre_cuenta,  cod_clase, nombre_clase, cod_grupo, nombre_grupo;";
        
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
            $saldo=0;
            foreach ($aux_datos as $key => $value) {
            $saldo += $value['saldo'];
            }
            //utf8_string_array_encode($aux_datos); 
            $datos['saldo_total_patrimonio'] = $saldo;
            $datos['datos_patrimonio'] = $aux_datos;
            $datos['filas_patrimonio'] = sizeof( $aux_datos) ;
              $datos['error']='';
    
                 }
        catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null; 
        }
        break;
       
 
 
//</editor-fold> 
 //<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE MODULO DE CUENTAS CONTABLES...">  
    case 'GET_LISTADO_CLASES_CNT':
          utf8_string_array_decode($_POST);
         try {
            $conexion =\Class_php\DataBase::getInstance(); 
            $where = '';
             if(isset($_POST['idPadre'])){
            $where = " where id_clase = ".$_POST['idPadre'];
        }
            $aux_datos = $conexion->where('cnt_clase',$where );
            //print_r($aux_datos);
            $datos['where'] =$where; 
             //utf8_string_array_encode($aux_datos); 
             $datos['datos'] = $aux_datos;
             $datos['filas'] = sizeof( $aux_datos) ;
              $datos['error']='';
       if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera); 
            $datos['nombreCabecera']=$nomTableCabecera;
        } 
                 }
        catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null; 
        }
        break;
    
     case 'GET_LISTADO_GRUPOS_CNT':
          utf8_string_array_decode($_POST);
         try {
            $conexion =\Class_php\DataBase::getInstance(); 
            $where = '';
             if(isset($_POST['idPadre']) && trim($_POST['idPadre']!= '')){
            $where = " where cod_clase = ".$_POST['idPadre'];
            
        }
            $array_digitos = array();
            $aux_datos = $conexion->where('vw_cnt_grupos',$where );
            if(isset($_POST['idPadre']) && trim($_POST['idPadre']!= '')){
                foreach ($aux_datos as $key => $value) {
                    $array_digitos[$key] = $value['digito'];
                }
            
             }
             $datos['digitosArr'] =$array_digitos; 
              $datos['digitosArrTamanio'] = sizeof($array_digitos);
            //print_r($aux_datos);
            $datos['where'] =$where; 
             //utf8_string_array_encode($aux_datos); 
             $datos['datos'] = $aux_datos;
             $datos['filas'] = sizeof( $aux_datos) ;
              $datos['error']='';
       if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera); 
            $datos['nombreCabecera']=$nomTableCabecera;
        } 
                 }
        catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null; 
        }
        break;
      
     
    case 'GUARDAR_DATOS_GRUPOS_CNT'://obtener el listado completo de la tabla de menus. 
         utf8_string_array_decode($_POST);
          try {                        
            $conexion = \Class_php\DataBase::getInstance();
            $link = $conexion->getLink();
            $_POST['tipo_proveedor'] = TRIM($_POST['tipo_proveedor']);
            // HELLO WORLD! 
            $_POST['NOM_GRUPO']= ucwords(strtolower(TRIM($_POST['nombre']))); 
            if (TRIM($_POST['claseid']) == ''){ $datos['error']='Debe escoger la clase a la que pertenece el grupo!!'; }else{
            $cod_grupo = TRIM($_POST['claseid']).TRIM($_POST['digito']);
            
            if(isset($_POST['cod_grupo']) and trim($_POST['cod_grupo'])!= ''){
               $id_grupo = trim($_POST['cod_grupo']);
               $query = "UPDATE cnt_grupos SET nombre_grupo = '{$_POST['NOM_GRUPO']}'  ".
                    "WHERE id_grupo = $id_grupo";
            }else{
            $query = "INSERT INTO cnt_grupos( cod_clase,cod_grupo,nombre_grupo )  VALUES("
            . "'{$_POST['claseid']}','{$cod_grupo}','{$_POST['NOM_GRUPO']}')";
            
            }
            $consulta = $link->prepare($query);
            $datos['query'] = $query;
            if ($consulta->execute()){
              $datos['error']='ok';  
                
            }else{ $datos['error']='Error al tratar de ingresar los valores a la base de datos TABLA (grupos)'; }
    }
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;
    
        }
        
    
    break;   
    case 'VERIFICAR_Y_ELIMINAR_GRUPO_CNT'://obtener el listado completo de la tabla de menus.
    
        //$datos['error'] = $nuevoMenu->eliminarMenu();
         TRY {
             
            $conexion = \Class_php\DataBase::getInstance();
            $query="select count(*) as total from cnt_cuenta where cod_grupo = {$_POST['cod_grupo']} ;";
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
        
            //print_r($aux_datos);
            //echo $aux_datos[0]['total'];
            $result = '';
            if($aux_datos[0]['total'] > 0 ){
                $result ="el grupo posee cuentas asignadas, debe eliminar estas para poder eliminar.";
            }else{
        $_result =$conexion->eliminarDato('cnt_grupos' ,   $_POST['id_grupo'] ,'id_grupo');
      switch ($_result[0]['result']){
           case '100':
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
            }}
       $datos['error'] = $result;
      } catch (PDOException $e) {
        $datos['error'] = 'Error de conexión: ' . $e->getMessage();
           
     }
    
    break;

   
    case 'GET_LISTADO_CUENTAS_MAYORES_CNT':
          utf8_string_array_decode($_POST);
         try {
            $conexion =\Class_php\DataBase::getInstance(); 
            $where = '';
             if(isset($_POST['idPadre']) && trim($_POST['idPadre'])!= '' ){
                $where = " where cod_clase = ".$_POST['idPadre'];            
            }
            
             if(isset($_POST['idGrupo']) && trim($_POST['idGrupo'])!= '' ){
                 if ($where == '') { $where = " where ";}else {$where .= " and ";}
                $where .= " cod_grupo = ".$_POST['idGrupo'];            
            }
            $array_digitos = array();
            $aux_datos = $conexion->where('vw_cnt_cuenta',$where );
           
             $datos['digitosArr'] =$array_digitos; 
              $datos['digitosArrTamanio'] = sizeof($array_digitos);
            //print_r($aux_datos);
            $datos['where'] =$where; 
             //utf8_string_array_encode($aux_datos); 
             $datos['datos'] = $aux_datos;
             $datos['filas'] = sizeof( $aux_datos) ;
              $datos['error']='';
       if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera); 
            $datos['nombreCabecera']=$nomTableCabecera;
        } 
                 }
        catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null; 
        }
        break;
    case 'GUARDAR_DATOS_CUENTAS_MAYORES_CNT'://obtener el listado completo de la tabla de menus. 
         utf8_string_array_decode($_POST);
          try {                        
            $conexion = \Class_php\DataBase::getInstance();
            $link = $conexion->getLink();
            $_POST['tipo_proveedor'] = TRIM($_POST['tipo_proveedor']);
            // HELLO WORLD! 
            $_POST['NOM_CUENTA']= ucwords(strtolower(TRIM($_POST['nombre']))); 
            if (TRIM($_POST['cod_grupo']) == ''){ $datos['error']='Debe escoger el grupo a la que pertenece la cuenta!!'; }else{ 
            $cod_cuenta = TRIM($_POST['cod_grupo']).str_pad( TRIM($_POST['digito']), 2, "0", STR_PAD_LEFT); 
           
            if(isset($_POST['id_cuenta']) and trim($_POST['id_cuenta'])!= ''){
               $id_cuenta = trim($_POST['id_cuenta']);
               $query = "UPDATE cnt_cuenta SET nombre_cuenta = '{$_POST['NOM_CUENTA']}' ".
                    "WHERE id_cuenta = $id_cuenta";
            }else{
            $query = "INSERT INTO cnt_cuenta(  cod_cuenta,cod_grupo, nombre_cuenta )  VALUES("
            . "'{$cod_cuenta}','{$_POST['cod_grupo']}','{$_POST['NOM_CUENTA']}')";
            
            }
            $consulta = $link->prepare($query);
            $datos['query'] = $query;
            if ($consulta->execute()){
              $datos['error']='ok';  
                
            }else{ $datos['error']='Error al tratar de ingresar los valores a la base de datos TABLA (cuenta mayor)'; }
    }
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;
    
        }
        
    
    break;   
    case 'VERIFICAR_Y_ELIMINAR_CUENTAS_MAYORES_CNT'://obtener el listado completo de la tabla de menus.
    
        //$datos['error'] = $nuevoMenu->eliminarMenu();
         TRY {
             //id_cuenta, cod_grupo, cod_cuenta, nombre_cuenta  
            $conexion = \Class_php\DataBase::getInstance();
            $query="select count(*) as total from cnt_cuentas where cod_cuenta = {$_POST['cod_cuenta']} ;";
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
        
            //print_r($aux_datos);
            //echo $aux_datos[0]['total'];
            $result = '';
            if($aux_datos[0]['total'] > 1 ){
                $result ="la cuenta posee subcuentas asignadas, debe eliminar estas para poder eliminar.";
            }else{
        $_result =$conexion->eliminarDato('cnt_cuenta' ,   $_POST['id_cuenta'] ,'id_cuenta');
      switch ($_result[0]['result']){
           case '100':
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
            }}
       $datos['error'] = $result;
      } catch (PDOException $e) {
        $datos['error'] = 'Error de conexión: ' . $e->getMessage();
           
     }
    
    break;


      case 'GET_LISTADO_SUBCUENTAS_CNT':
          utf8_string_array_decode($_POST);
         try {
            $conexion =\Class_php\DataBase::getInstance(); 
            $where = '';
             if(isset($_POST['idPadre']) && trim($_POST['idPadre'])!= '' ){
                $where = " where cod_clase = ".$_POST['idPadre'];            
            }
            
             if(isset($_POST['idGrupo']) && trim($_POST['idGrupo'])!= '' ){
                 if ($where == '') { $where = " where ";}else {$where .= " and ";}
                $where .= " cod_grupo = ".$_POST['idGrupo'];            
            }
             if(isset($_POST['cod_cuenta']) && trim($_POST['cod_cuenta'])!= '' ){
                 if ($where == '') { $where = " where ";}else {$where .= " and ";}
                $where .= " cod_cuenta = ".$_POST['cod_cuenta'];            
            }
            $array_digitos = array();
            $aux_datos = $conexion->where('vw_cnt_scuentas',$where );
           
             $datos['digitosArr'] =$array_digitos; 
              $datos['digitosArrTamanio'] = sizeof($array_digitos);
            //print_r($aux_datos);
            $datos['where'] =$where; 
             //utf8_string_array_encode($aux_datos); 
             $datos['datos'] = $aux_datos;
             $datos['filas'] = sizeof( $aux_datos) ;
              $datos['error']='';
       if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera); 
            $datos['nombreCabecera']=$nomTableCabecera;
        } 
                 }
        catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null; 
        }
        break;
    case 'GUARDAR_DATOS_SUBCUENTAS_CNT'://obtener el listado completo de la tabla de menus. 
         utf8_string_array_decode($_POST);
          try {     
              /*digito : $('#digito').val() , 
          nombre : $('#Nombre').val()   ,  
          Descripcion : $('#Descripcion').val() ,   
          claseid : $('#PadreId').val(),  
          cod_grupo : $('#cod_grupo').val(),
          cod_cuenta :  $('#cod_cuentas').val() */
            $conexion = \Class_php\DataBase::getInstance();
            $link = $conexion->getLink(); 
            // HELLO WORLD! 
            $_POST['NOM_CUENTA']= ucwords(strtolower(TRIM($_POST['nombre']))); 
            if (TRIM($_POST['cod_cuenta']) == ''){ $datos['error']='Debe escoger la cuenta a la que pertenece la subcuenta!!'; }else{ 
            
                $cod_cuenta = TRIM($_POST['cod_cuenta'])  ; 
                $numeroCuenta = TRIM($_POST['cod_cuenta']).  TRIM($_POST['digito']) ; 
           
            if(isset($_POST['id_cuenta']) and trim($_POST['id_cuenta'])!= ''){
               $id_cuenta = trim($_POST['id_cuenta']);
               $query = "UPDATE cnt_cuentas SET nombre_cuenta = '{$_POST['NOM_CUENTA']}'"
               . " , nro_cuenta =  '{$numeroCuenta}' ".
                    "WHERE id_cuenta = $id_cuenta";
            }else{
            $query = "INSERT INTO cnt_cuentas(  cod_cuenta, nro_cuenta,  nombre_cuenta )  VALUES("
            . "'{$cod_cuenta}','{$numeroCuenta}','{$_POST['NOM_CUENTA']}')";
            
            }
            $consulta = $link->prepare($query);
            $datos['query'] = $query;
            if ($consulta->execute()){
              $datos['error']='ok';  
                
            }else{ $datos['error']='Error al tratar de ingresar los valores a la base de datos TABLA (cuenta mayor)'; }
    }
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;
    
        }
        
    
    break; 
    
    case 'VERIFICAR_Y_ELIMINAR_SUBCUENTAS_CNT'://obtener el listado completo de la tabla de menus.
    
        //$datos['error'] = $nuevoMenu->eliminarMenu();
         TRY {
             //id_cuenta, cod_grupo, cod_cuenta, nombre_cuenta  
            $conexion = \Class_php\DataBase::getInstance();
            $query="select count(*) as total from cnt_transacciones where cod_cuenta = {$_POST['id_cuenta']} ;";
            $link = $conexion->getLink();            
            $consulta = $link->prepare($query);
            $consulta->execute(); 
            $aux_datos =  $consulta->fetchAll(); 
        
            //print_r($aux_datos);
            //echo $aux_datos[0]['total'];
            $result = '';
            if($aux_datos[0]['total'] > 0 ){
                $result ="la cuenta posee transacciones asignadas por lo que no es posible eliminar la cuenta.";
            }else{
        $_result =$conexion->eliminarDato('cnt_cuentas' ,   $_POST['id_cuenta'] ,'id_cuenta');
      switch ($_result[0]['result']){
           case '100':
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
            }}
       $datos['error'] = $result;
      } catch (PDOException $e) {
        $datos['error'] = 'Error de conexión: ' . $e->getMessage();
           
     }
    
    break;
        
        //</editor-fold>
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE MENUS...">
    case 'GET_LISTADO_MENU'://obtener el listado completo de la tabla de menus.
        $where = null;
        if(isset($_POST['idPadre'])){
            $where = " where id_clase = ".$_POST['idPadre'];
        }
        $arrayMenus = array();
    
       $datos = Class_php\MenuSistema::recuperarTodos($where);
       
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera); 
            $datos['nombreCabecera']=$nomTableCabecera;
        } 
    
    break;
    case 'GET_LISTADO_PADRES_DISPONIBLES'://obtener el listado completo de la tabla de menus.
        $where = null;
        if(isset($_POST['idPadre'])){
            $datos = Class_php\MenuSistema::get_menus_no_child($_POST['idPadre']); 
        }
        else{
           $datos = Class_php\MenuSistema::recuperarTodos($where); 
        }
    break;
    case 'GUARDAR_DATOS_MENUS'://obtener el listado completo de la tabla de menus.
        $nuevoMenu = new Class_php\MenuSistema($_POST['idmenus'],$_POST['nombre'],$_POST['Descripcion'],$_POST['PadreId'],null,$_POST['Url']);
        $datos['error'] = $nuevoMenu->guardar();
    
    break;
    case 'VERIFICAR_Y_ELIMINAR_MENU'://obtener el listado completo de la tabla de menus.
        $nuevoMenu = new Class_php\MenuSistema($_POST['idMenu']);
        $datos['error'] = $nuevoMenu->eliminarMenu();
    
    break;
//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE USUARIOS...">
  case 'GET_LISTADO_USUARIOS'://obtener el listado completo de la tabla de menus.
       if (is_null($busquedaDinamica)){
        if(isset($_POST['idUsuario'])){
            $where = " where ID = ".$_POST['idUsuario'];
      }}
        $arrayMenus = array();
    
        $datos = Class_php\Usuarios::recuperarTodos($where);
       $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);
       $datos['nombreCabecera']=$nomTableCabecera;
    break;
    
    case 'GUARDAR_DATOS_USUARIO'://obtener el listado completo de la tabla de menus.
    // $ID = null,$Login,$Nombre1,$Nombre2 = '',$Apellido1,$Apellido2 = '',$nombreCompleto = null,$estado = 'A',$pass = '' ) {
        //echo 'entro';
        $change = true;
        if (!isset($_POST['pass']) || $_POST['pass']=='')
            {$_POST['pass'] = sha1(PASS_INICIAL); }else
                {$change =false;}
     //$ID = null,$Login = null,$Nombre1 = null,$Nombre2 = '',$Apellido1 = null,$Apellido2 = '',$nombreCompleto = null,$estado = 'A',$pass = '' ,$mail = null, $change = 0 ,$codRemision = null   
        $nuevoUsuario = new Class_php\Usuarios(  $_POST['ID'] 
         ,  $_POST['Login'] 
         ,  $_POST['Nombre1']
         ,  $_POST['Nombre2'] 
         ,  $_POST['Apellido1'] 
         ,  $_POST['Apellido2']
         ,  NULL //NOMBRE COMPLETO
         ,  $_POST['estado'] 
         ,  $_POST['pass'] 
         , $_POST['mail']  ); 
 //print_r($nuevoUsuario);
        $datos['error'] = $nuevoUsuario->guardar($change);
    
    break;
//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE PERFILES...">
case 'GET_LISTADO_RECURSOS_PERFILES':
    $nuevoPerfil = new Class_php\Perfiles(  $_POST['Perf_ID']   );
    $datos = $nuevoPerfil->listarRecursos();
    break;
//     GUARDAR_RECURSOS_PERFILES
case 'GUARDAR_RECURSOS_PERFILES':
        $nuevoPerfil = new Class_php\Perfiles(  $_POST['Perf_ID'] );
        $datos['error'] = $nuevoPerfil->guardar_recurso( $_POST['arrayRecursos']);
    break;
case 'GUARDAR_DATOS_PERFILES':
        $nuevoPerfil = new Class_php\Perfiles(  $_POST['Perf_ID'],$_POST['Perf_Nombre'],$_POST['estado']  );
        $datos['error'] = $nuevoPerfil->guardar();
    break;
case 'GUARDAR_DATOS_AREAS_DE_CONTROL':
     try {                   
        $conexion = Class_php\DataBase::getInstance(); 
        $link = $conexion->getLink();            
        $consulta = $link->prepare("call `sp_Crear_editar_AreasDeControl`(:_codAreasControl, :_nomAreasControl,   :user  )");
        $consulta->bindParam(':_codAreasControl', $_POST['ACC']);
        $consulta->bindParam(':_nomAreasControl', $_POST['DENOMINACION']); 
        $consulta->bindParam(':user', $_SESSION["usuario_logeado"] );
        $consulta->execute(); 
        $conexion = null;
  
      $array =  $consulta->fetchAll(); 
       switch ($array[0]['result']){
           case '100':
           case '101':
                $result ='ok';  
           break;
           case '-1':
                $result ='not ok';  
           break;           
       }
        $datos['error']=$result; 
        
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;    
        }
    
    break;
case 'VERIFICAR_Y_ELIMINAR_AREAS_DE_CONTROL':
TRY {
        
      $conexion =Class_php\DataBase::getInstance();  
      $usuariosAreasDeControl = $conexion->where("relacion_usuario_areas_de_control"," where codAreasControl = '{$_POST['ACC']}' ");
           
       if (sizeof($usuariosAreasDeControl) > 0 ){
         $result = 'No se puede eliminar el AREA DE CONTROL  ya que esta asignado a  uno o mas usuarios';  
       }
       else{
           $_result = $conexion->eliminarDato('areas_de_control',$_POST['ACC'],'ACC');
      switch ($_result[0]['result']){
           case '100':
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
       }
       
        $datos['error']=$result; 
        
      
      } catch (PDOException $e) {
          $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;    
     } 
break;
case 'GET_LISTADO_PERFILES':
    $where = null;
        if(isset($_POST['idPerfil'])){
            $where = " where Perf_ID = ".$_POST['idPerfil'];
        }
        $arrayMenus = array();
    
        $datos = Class_php\Perfiles::recuperarTodos($where);
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera); 
            $datos['nombreCabecera']=$nomTableCabecera;

        }
    break;
case 'GUARDAR_DATOS_PERFILES':
        $nuevoPerfil = new Class_php\Perfiles(  $_POST['Perf_ID']  ,  $_POST['Perf_Nombre'] ,  $_POST['estado']  );
        $datos['error'] = $nuevoPerfil->guardar();
    break;
case 'GUARDAR_RELACION_PERFILES_USUARIO':
        $nuevoPerfil = new Class_php\Perfiles(  $_POST['perfil_id']   );
        IF (!isset($_POST['idRelacion']) || $_POST['idRelacion'] == ''){
            $idRelacion = null;
        }else{$idRelacion = $_POST['idRelacion'];}
        $datos['error'] = $nuevoPerfil->guardarRelacion($_POST['user_id'],$idRelacion );
    break;
 case 'VERIFICAR_Y_ELIMINAR_PERFIL'://obtener el listado completo de la tabla de menus.
        $nuevoPerfil = new Class_php\Perfiles($_POST['Perf_ID']);
        $datos['error'] = $nuevoPerfil->eliminarPerfil();
    
    break;
case 'GET_LISTADO_PERFILES_USUARIOS':
    $where = null;
        if(isset($_POST['idPerfil'])){
            $where = " where Perf_ID = ".$_POST['idPerfil'];
        }
        $arrayMenus = array();
    
        $datos = Class_php\Perfiles::recuperarRelacionesUsuarios($where);
        $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);
        $datos['nombreCabecera']=$nomTableCabecera;

    break;
//</editor-fold>
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE AREAS DE CONTROL...">
 case 'GET_LISTADO_AREAS_DE_CONTROL':
          $where = null;
        if(isset($_POST['ACC'])){
            $where = " where ACC = ".$_POST['ACC'];
        }        
       try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();
            $consulta = $link->prepare('SELECT * FROM  areas_de_control '.$where.'    ');
            $datos['query'] = 'SELECT * FROM  areas_de_control '.$where.'    ';
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $datos['error']='';
            $datos['datos'] = $registros;
            $datos['filas'] = sizeof( $registros) ;
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;    
        }
       
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);  
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
        case'GET_LISTADO_AREAS_DE_CONTROL_POR_USUARIO':
    if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
        $datos= \Class_php\Usuarios::recuperarTodosAreasDeControl(" where codUsuario = '{$_POST['idUsuario']}' ");
    }
    else{
        $datos = \Class_php\Usuarios::recuperarAreasDeControlTmp();
        }
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);   
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
 //</editor-fold>
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE CORREOS DE NOTIFICACION...">
//GET_LISTADO_MAIL_PERFILAS
 case 'GET_LISTADO_MAIL_NOTIFICACIONES':
          $where = null;
        if(isset($_POST['id_correo'])){
            $where = " where id_correo = ".$_POST['id_correo'];
        }        
       try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();
            $consulta = $link->prepare('SELECT * FROM  correos_notificacion '.$where.'    ');
            $datos['query'] = 'SELECT * FROM  correos_notificacion '.$where.'    ';
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $datos['error']='';
            $datos['datos'] = $registros;
            $datos['filas'] = sizeof( $registros) ;
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;    
        }
       
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);  
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'LIMPIAR_TABLA_TMP_relacion_mail_cliente':
        TRY {
       $conexion =Class_php\DataBase::getInstance(); 
      $_result =$conexion->truncateTable('aux_relacion_mail_cliente');
      switch ($_result[0]['result']){
           case '100':
                $datos['error'] ='ok';  
           break;
           case '-1':
                $datos['error'] ='_table';  
           break;   
           case '-2':
                $datos['error'] ='_dato';  
           break;   
           case '-3':
                $datos['error'] ='_COLUMNA';  
           break;   
       default :
                $datos['error'] = $_result[0]['result'];
           break;
       }
      } catch (PDOException $e) {
        $datos['error']= 'Error de conexión: ' . $e->getMessage();
           
     }
        break;
    case 'ELIMINAR_MAIL_NOTIFICACION':
        TRY {
       $conexion =Class_php\DataBase::getInstance(); 
      $_result =$conexion->eliminarDato('correos_notificacion',  $_POST['id_correo'],'id_correo');
      switch ($_result[0]['result'])
      {
           case '100':
                $datos['error'] ='ok';  
           break;
           case '-1':
                $datos['error'] ='_table';  
           break;   
           case '-2':
                $datos['error'] ='_dato';  
           break;   
           case '-3':
                $datos['error'] ='_COLUMNA';  
           break;   
       default :
                $datos['error'] = $_result[0]['result'];
           break;
       }
      }
      catch (PDOException $e) {
        $datos['error']= 'Error de conexión: ' . $e->getMessage();
           
     }
        break;
     case 'GUARDAR_DATOS_MAIL_NOTIFICACIONES':
       try { 
          $conexion =Class_php\DataBase::getInstance();
            $link = $conexion->getLink(); 
            if (!isset($_POST['_id_correo']) ||$_POST['_id_correo'] == ''){
                $_POST['_id_correo'] = "";
            } 
         $consulta = $link->prepare("call `sp_Crear_editar_mail_notificacion`(  :_id_correo, :_nombre_usuario, :_mail, :_mail_reemplazo, :user  )");           
         $consulta->bindParam(':_id_correo', $_POST['_id_correo']);
         $consulta->bindParam(':_nombre_usuario', $_POST['_nombre_usuario']);
         $consulta->bindParam(':_mail', $_POST['_mail']);
         $consulta->bindParam(':_mail_reemplazo', $_POST['_mail_reemplazo']); 
         //$consulta->bindParam(':estado', $_POST['estado']);
         $consulta->bindParam(':user', $_SESSION["usuario_logeado"] );
         $consulta->execute();
    //echo "call `sp_Crear_editar_mail_notificacion`(  '{$_POST['_id_correo']}', '{$_POST['_nombre_usuario']}', '{$_POST['_mail']}', '{$_POST['_mail_reemplazo']}', '{$_SESSION["usuario_logeado"]}'  )";
      $conexion = null;
  
      $array =  $consulta->fetchAll();
           
       switch ($array[0]['result']){
           case '100':
               case '101':
                $datos['error']  ='ok';  
           break;
           case '-1':
                $datos['error']  ='not ok';  
           break;           
       }
           
      } 
      catch (PDOException $e) {
          $datos['error']  =  'Error de conexión: ' . $e->getMessage();
}
    break;
////</editor-fold>
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE RECUROS...">
    case 'GET_LISTADO_RECURSOS':
          $where = null;
        if(isset($_POST['id_menu'])){
            $where = " where id_menu = ".$_POST['id_menu'];
        }
        $arrayMenus = array();
    
       $datos = Class_php\MenuSistema::recuperarRecursos($where);
       
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);  
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'GUARDAR_DATOS_RECURSOS':
        $nuevoMenu = new Class_php\MenuSistema(  $_POST['menuDelSistema'] );
        $datos['error'] = $nuevoMenu->guardarPerfil(
                $_POST['ID_recurso'],
                $_POST['tipoRecurso'],
                $_POST['nombreRecurso'],
                $_POST['id_sistema'],
                $_POST['estado']
                );
        
    break;
//</editor-fold>
           
}

 echo json_encode($datos);