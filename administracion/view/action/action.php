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
$busquedaDinamica = null;
// $json ='{"action":"GUARDAR_DATOS_USUARIO","ID":"","Login":"jds_luis","Nombre1":"luis","Nombre2":"alejandro","Apellido1":"zarabia","Apellido2":"carmona","estado":"A","pass":"","mail":"luisint11@gmail.com"}';
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
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE MENUS...">
    case 'GET_LISTADO_MENU'://obtener el listado completo de la tabla de menus.
        $where = null;
        if(isset($_POST['idPadre'])){
            $where = " where PadreId = ".$_POST['idPadre'];
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
//<editor-fold defaultstate="collapsed" desc="ACTIONS PARA MANEJO DE CLIENTES - AREAS DE VENTA  - CENTROS LOGISTICOS...">

    case 'GET_LISTADO_AREAS_DE_CONTROL':
                 $where = null;
         if(isset($_POST['idUsuario']) && $_POST['idUsuario'] != '' ){
                $tabla = 'relacion_usuario_areas_de_control';
                $where = " where codUsuario = '{$_POST['idUsuario']}'" ;
            }else{
                $tabla = 'aux_relacion_usuario_areas_de_control';
                $where = "";
            }
      $where =   " WHERE ACC not in (SELECT codAreasControl  FROM $tabla $where)";
       try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
            $consulta = $link->prepare("select * from areas_de_control $where " );
            $datos['query'] = "select * from areas_de_control $where ";
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
    case 'GET_LISTADO_CLIENTES_POR_USUARIO':
    if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
        $datos= \Class_php\Usuarios::recuperarTodosClientes(" where id_usuario = '{$_POST['idUsuario']}' ");
    }
    else{
        $datos = \Class_php\Usuarios::recuperarClientesTmp();
        }
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);   
            $datos['nombreCabecera']=$nomTableCabecera;
        }
     break;
    case 'GET_LISTADO_AREAS_DE_VENTA_POR_USUARIO':
    if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
        $datos= \Class_php\Usuarios::recuperarTodosAreasVentas(" where cod_usuario = '{$_POST['idUsuario']}' ");
    }
    else{
        $datos = \Class_php\Usuarios::recuperarAreasVentasTmp();
        }
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);    
            $datos['nombreCabecera']=$nomTableCabecera;
        }
     break;
    case 'ELIMINAR_RELACION_MAIL_NOTIFICACION_CLIENTE':
                TRY {
       $conexion =Class_php\DataBase::getInstance(); 
       if (isset($_POST['id_correo']) && $_POST['id_correo'] != ''){
             $_result =$conexion->eliminarDato('relacion_mail_cliente',  $_POST['id_relacion'],'id_relacion');
        }
        else{
            $_result =$conexion->eliminarDato('aux_relacion_mail_cliente',  $_POST['id_cliente_SAP'],'id_cliente_SAP');
        }
     
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
    case 'GET_LISTADO_CLIENTES_MAIL_NOTIFICACIONES':
       try {     
        if (isset($_POST['id_correo']) && $_POST['id_correo'] != '')
            { 
                $conexion =\Class_php\DataBase::getInstance();
                $link = $conexion->getLink();      
                $consulta = $link->prepare("SELECT * FROM  relacion_mail_cliente  where id_correo_notificacion = {$_POST['id_correo']}  ");
                $datos['query'] = "SELECT * FROM  relacion_mail_cliente  where id_correo_notificacion = {$_POST['id_correo']}  ";
                $consulta->execute();
                $registros = $consulta->fetchAll(); 
                $datos['error']='';
                $datos['datos'] = $registros;
                $datos['filas'] = sizeof( $registros) ;
            }
            else{ 
                $conexion =\Class_php\DataBase::getInstance();
                $link = $conexion->getLink();      
                $consulta = $link->prepare('SELECT distinct * FROM aux_relacion_mail_cliente    ');
                $datos['query'] = 'SELECT distinct * FROM aux_relacion_mail_cliente ';
                $consulta->execute();
                $registros = $consulta->fetchAll(); 
                $datos['error']='';
                $datos['datos'] = $registros;
                $datos['filas'] = sizeof( $registros) ; 
                }  
        }
        catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null; 
        }
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);    
            $datos['nombreCabecera']=$nomTableCabecera;
        }
     break;
    case 'GUARDAR_RELACION_CLIENTE_CORREO_NOTIFICACION':
        IF (!ISSET($_POST['tipo_relacion']) || $_POST['tipo_relacion'] == '') {$_POST['tipo_relacion'] = '1';}
       IF (!ISSET($_POST['tipo_notificacion']) || $_POST['tipo_notificacion'] == '') {$_POST['tipo_notificacion'] = '1';}
      // echo $_POST['id_correo'];
      try { 
       $conexion =\Class_php\DataBase::getInstance();
       $link = $conexion->getLink();     
       IF (!ISSET($_POST['id_correo']) || $_POST['id_correo'] == ''){ 
             IF (ISSET($_POST['id_relacion']) && $_POST['id_relacion'] != '')    /*Modifica*/ {  
              $consulta = $link->prepare("call  sp_Crear_editar_tmp_cliente_mail_notificacion(:_id_relacion,:_id_cliente_SAP, :_tipo_relacion ,  :_tipo_notificacion, '0000',  :usuarioIngresado , :_FULLNAME_SAP)");
              $consulta->bindParam(':_id_relacion', $_POST['id_relacion']);
              $consulta->bindParam(':_id_cliente_SAP', $_POST['COD_CLI_SAP']);
              $consulta->bindParam(':_FULLNAME_SAP', $_POST['FULLNAME']);
              $consulta->bindParam(':_tipo_relacion', $_POST['tipo_relacion']);
              $consulta->bindParam(':_tipo_notificacion', $_POST['tipo_notificacion']); 
              $consulta->bindParam(':usuarioIngresado', $_SESSION["usuario_logeado"] );  
              $consulta->execute(); 
           }else /*Inserta*/ {  
                 $consulta = $link->prepare("call  sp_Crear_editar_tmp_cliente_mail_notificacion('',:_id_cliente_SAP, :_tipo_relacion ,  :_tipo_notificacion, '0000',  :usuarioIngresado , :_FULLNAME_SAP)");
              //$consulta->bindParam(':_id_relacion', $_POST['id_relacion']);
              $consulta->bindParam(':_id_cliente_SAP', $_POST['COD_CLI_SAP']);
              $consulta->bindParam(':_FULLNAME_SAP', $_POST['FULLNAME']);
              $consulta->bindParam(':_tipo_relacion', $_POST['tipo_relacion']);
              $consulta->bindParam(':_tipo_notificacion', $_POST['tipo_notificacion']); 
              $consulta->bindParam(':usuarioIngresado', $_SESSION["usuario_logeado"] );  
              $consulta->execute();  
           } 
      //echo  "call  sp_Crear_editar_tmp_cliente_mail_notificacion('{$_POST['id_relacion']}','{$_POST['COD_CLI_SAP']}', '{$_POST['tipo_relacion']}' ,  '{$_POST['tipo_notificacion']}', '0000',  '{$_SESSION["usuario_logeado"]}' , '{$_POST['FULLNAME']}')";
     
       }else{ 
           IF (ISSET($_POST['id_relacion']) && $_POST['id_relacion'] != '')    /*Modifica*/ { 
              $consulta = $link->prepare("call  sp_Crear_editar_cliente_mail_notificacion(:_id_relacion,:_id_cliente_SAP, :_tipo_relacion ,  :_tipo_notificacion, :_id_correo,  :usuarioIngresado , :_FULLNAME_SAP)");
              $consulta->bindParam(':_id_relacion', $_POST['id_relacion']);
              $consulta->bindParam(':_id_cliente_SAP', $_POST['COD_CLI_SAP']);
              $consulta->bindParam(':_FULLNAME_SAP', $_POST['FULLNAME']);
              $consulta->bindParam(':_tipo_relacion', $_POST['tipo_relacion']);
              $consulta->bindParam(':_tipo_notificacion', $_POST['tipo_notificacion']);
              $consulta->bindParam(':_id_correo', $_POST['id_correo']); 
              $consulta->bindParam(':usuarioIngresado', $_SESSION["usuario_logeado"] );  
              $consulta->execute(); 
           }else /*Inserta*/ {
                 $consulta = $link->prepare("call  sp_Crear_editar_cliente_mail_notificacion('',:_id_cliente_SAP, :_tipo_relacion ,  :_tipo_notificacion, :_id_correo,  :usuarioIngresado , :_FULLNAME_SAP)");
              //$consulta->bindParam(':_id_relacion', $_POST['id_relacion']);
              $consulta->bindParam(':_id_cliente_SAP', $_POST['COD_CLI_SAP']);
              $consulta->bindParam(':_FULLNAME_SAP', $_POST['FULLNAME']);
              $consulta->bindParam(':_tipo_relacion', $_POST['tipo_relacion']);
              $consulta->bindParam(':_tipo_notificacion', $_POST['tipo_notificacion']); 
              $consulta->bindParam(':_id_correo', $_POST['id_correo']); 
              $consulta->bindParam(':usuarioIngresado', $_SESSION["usuario_logeado"] );  
              $consulta->execute();  
           } 
           
          // echo "call  sp_Crear_editar_cliente_mail_notificacion('{$_POST['id_relacion']}','{$_POST['COD_CLI_SAP']}', '{$_POST['tipo_relacion']}' ,  '{$_POST['tipo_notificacion']}', '{$_POST['id_correo']}',  '{$_SESSION["usuario_logeado"]}', '{$_POST['FULLNAME']}')";
       }
        $conexion = null;
       $array =  $consulta->fetchAll();
       switch ($array[0]['result']){
           case '100':
           case '101':
                $datos['error']  ='ok';  
           break;
           case '-1':
           case '-2':
                $datos['error']  ='not ok';  
           break; 
       default :
           $datos['error']  =$array[0]['result'];  
           break;
       } 
      
      $conexion = null;
       } catch (PDOException $e) {
     $datos['error'] =  'Error de conexión: ' . $e->getMessage();
           
}
    break;
    case 'GUARDAR_DATOS_USUARIO_AREAS_DE_CONTROL': //GUARDAR_DATOS_USUARIO_AREAS_DE_CONTROL
        $nuevoUsuario = new Class_php\Usuarios(  $_POST['ID_cliente'] 
         ,  $_POST['Login'] 
         ,  $_POST['Nombre1']
         ,  $_POST['Nombre2'] 
         ,  $_POST['Apellido1'] 
         ,  $_POST['Apellido2']
         ,  NULL //NOMBRE COMPLETO
         ,  $_POST['estado'] 
         ,  $_POST['pass']  ); 
        
        IF (ISSET($_POST['ID_cliente']) && $_POST['ID_cliente'] != ''){        
             $datos['error']  = $nuevoUsuario->guardarAreasDeControlUsuario($_POST['id_relacion'],$_POST['ACC'],$_POST['DENOMINACION'] );
        }ELSE{//$_id_relacion = null,$_id_cliente_SAP, $_nombre_cliente_SAP, $_estado
            $datos['error'] = $nuevoUsuario->guardarTmpAreasDeControlUsuario($_POST['id_relacion'],$_POST['ACC'],$_POST['DENOMINACION'] );
        }
    break;
    case 'GUARDAR_DATOS_USUARIO_CLIENTES': //GUARDAR_DATOS_USUARIO_AREAS_DE_CONTROL
        $nuevoUsuario = new Class_php\Usuarios(  $_POST['ID_cliente'] 
         ,  $_POST['Login'] 
         ,  $_POST['Nombre1']
         ,  $_POST['Nombre2'] 
         ,  $_POST['Apellido1'] 
         ,  $_POST['Apellido2']
         ,  NULL //NOMBRE COMPLETO
         ,  $_POST['estado'] 
         ,  $_POST['pass']  );
        
        IF (ISSET($_POST['ID_cliente']) && $_POST['ID_cliente'] != ''){        
             $datos['error']  = $nuevoUsuario->guardarClienteUsuario($_POST['id_relacion'],$_POST['KUNNR'],$_POST['FULLNAME'],$_POST['estado']);
        }ELSE{//$_id_relacion = null,$_id_cliente_SAP, $_nombre_cliente_SAP, $_estado
            $datos['error'] = $nuevoUsuario->guardarTmpClienteUsuario($_POST['id_relacion'],$_POST['KUNNR'],$_POST['FULLNAME'],$_POST['estado']);
        }
    break;
    case 'GUARDAR_DATOS_USUARIO_AREAS_DE_VENTA': 
        $nuevoUsuario = new Class_php\Usuarios(  $_POST['ID_cliente'] 
         ,  $_POST['Login'] 
         ,  $_POST['Nombre1']
         ,  $_POST['Nombre2'] 
         ,  $_POST['Apellido1'] 
         ,  $_POST['Apellido2']
         ,  NULL //NOMBRE COMPLETO
         ,  $_POST['estado'] 
         ,  $_POST['pass']  );
        
        IF (ISSET($_POST['ID_cliente']) && $_POST['ID_cliente'] != ''){  
              $datos['error']  = $nuevoUsuario->guardarAreaVentaUsuario($_POST['id_relacion'],$_POST['VKORG'],$_POST['VTWEG'],$_POST['SPART'] );
        }ELSE{//($_id_relacion = null,$_VKORG, $_VTWEG,$_SPART, $_estado)
            $datos['error'] = $nuevoUsuario->guardarTmpAreaVentaUsuario($_POST['id_relacion'],$_POST['VKORG'],$_POST['VTWEG'],$_POST['SPART'] );
        }
    break;
    case 'GUARDAR_DATOS_AREAS_DE_VENTA_CENTROS_LOGISTICOS': 
           
       try { 
       $conexion =\Class_php\DataBase::getInstance();
       $link = $conexion->getLink();   
       $consulta = $link->prepare("call  sp_crear_relacion_centro_log_area_venta('',:_VKORG  , :_VTEXTVKORG  ,  :_VTWEG,:_VTEXTVTWEG,:_SPART  , :_VTEXTSPART  ,:_WERKS  ,:_NAME1  ,:_usuarioIngresado )");
       $consulta->bindParam(':_VKORG', $_POST['VKORG']);
       $consulta->bindParam(':_VTEXTVKORG', $_POST['VTEXTVKORG']);
       $consulta->bindParam(':_VTWEG', $_POST['VTWEG']);
       $consulta->bindParam(':_VTEXTVTWEG', $_POST['VTEXTVTWEG']);
       $consulta->bindParam(':_SPART', $_POST['SPART']); 
       $consulta->bindParam(':_VTEXTSPART',$_POST['VTEXTSPART'] );  
       $consulta->bindParam(':_WERKS',$_POST['WERKS'] );  
       $consulta->bindParam(':_NAME1', $_POST['NAME1'] );   
       $consulta->bindParam(':_usuarioIngresado', $_SESSION["usuario_logeado"] ); 
      // $query =  "call  sp_crear_relacion_centro_log_area_venta('',:_VKORG  , :_VTEXTVKORG  ,  :_VTWEG,:_VTEXTVTWEG,:_SPART  , :_VTEXTSPART  ,:_WERKS  ,:_NAME1  ,:_usuarioIngresado )";
      //  $query=  str_replace(array( ':_VKORG',':_VTEXTVKORG',':_VTWEG', ':_VTEXTVTWEG', ':_SPART',':_VTEXTSPART',':_WERKS',':_NAME1',':_usuarioIngresado'),    array("'{$_POST['VKORG']}'","'{$_POST['VTEXTVKORG']}'","'{$_POST['VTWEG']}'","'{$_POST['VTEXTVTWEG']}'","'{$_POST['SPART']}'","'{$_POST['VTEXTSPART']}'","'{$_POST['WERKS']}'","'{$_POST['NAME1']}'","'{$_SESSION["usuario_logeado"]}'") ,$query);
    
         $consulta->execute();  
       $array =  $consulta->fetchAll();
       switch ($array[0]['result']){
           case '100':
           case '101':
                $datos['error']  ='ok';  
           break;
           case '-1':
           case '-2':
                $datos['error']  ='not ok';  
           break; 
       default :
           $datos['error']  =$array[0]['result'];  
           break;
       } 
      
      $conexion = null;
       } catch (PDOException $e) {
     $datos['error'] =  'Error de conexión: ' . $e->getMessage();
           
}
    break;
    case 'GET_LISTADO_CENTROS_LOGISTICOS':
           header('Content-Type: text/html; charset=ISO-8859-1'); 
         if (!isset($_SESSION['DATOS_RFC_CENTROS']) || $_SESSION['DATOS_RFC_CENTROS'] == '' || sizeof($_SESSION['DATOS_RFC_CENTROS'])== 0){
            $arreglo = GET_DATOS_RFC_CENTROSLOGISTICOS();
            utf8_string_array_encode($arreglo);            
            $_SESSION['DATOS_RFC_CENTROS'] = $arreglo;
         }
        $arreglo =  $_SESSION['DATOS_RFC_CENTROS'] ;
        if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}  
            
        if (!is_null($_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS']) && sizeof($_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS']))
        $datos['datos']= FILTRAR_DATOS_RFC_CENTROSLOGISTICOS($datos['datos'],$_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS'],false);
        $datos['error'] = '';
        $datos['filas'] = sizeof( $datos['datos']) ; 
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'GET_LISTADO_AREAS_DE_VENTAS':
         $datos['error']=''; 
        if (!isset($_SESSION['DATOS_RFC_AREASDEVENTA']) || $_SESSION['DATOS_RFC_AREASDEVENTA'] == '' || sizeof($_SESSION['DATOS_RFC_AREASDEVENTA'])== 0)
            $_SESSION['DATOS_RFC_AREASDEVENTA'] = GET_DATOS_RFC_AREASDEVENTA();
        
        $arreglo = $_SESSION['DATOS_RFC_AREASDEVENTA'];
        
         if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}
           
        
        $datos['filas'] = sizeof( $datos['datos']) ; 
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
        break;
    case 'GET_LISTADO_AREAS_DE_VENTAS_CON_CENTRO_LOG':
          $where = null;
        if(isset($_POST['VKORG'])){
            $where = " where a.VKORG = ".$_POST['VKORG'];
        }        
       try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
             if(isset($_POST['cod_usuario'] )&& $_POST['cod_usuario'] != ''){
                $consulta = $link->prepare("select distinct a.VKORG, vw.VTEXTVKORG, a.VTWEG, vw.VTEXTVTWEG, a.SPART, vw.VTEXTSPART ".
                        " from relacion_usuario_area_venta a ".
                        "inner join vw_SAP_rfc_Areasdeventa vw ".
                        "on vw.`VKORG` = a.VKORG ".
                        "and vw.`VTWEG` = a.VTWEG ".
                        "and vw.`SPART` = a.SPART ".
                        "where a.cod_usuario <>  '{$_POST['cod_usuario']}' and ".
                        "( select count(*) from relacion_usuario_area_venta b ".
                        "where cod_usuario =  '{$_POST['cod_usuario']}' and b.`VKORG` = a.VKORG ".
                        "and b.`VTWEG` = a.VTWEG  ".
                        "and b.`SPART` = a.SPART ) = 0");
                
                $datos['query'] ="select distinct a.VKORG, vw.VTEXTVKORG, a.VTWEG, vw.VTEXTVTWEG, a.SPART, vw.VTEXTSPART ".
                        " from relacion_usuario_area_venta a ".
                        "inner join vw_SAP_rfc_Areasdeventa vw ".
                        "on vw.`VKORG` = a.VKORG ".
                        "and vw.`VTWEG` = a.VTWEG ".
                        "and vw.`SPART` = a.SPART ".
                        "where a.cod_usuario <>  '{$_POST['cod_usuario']}' and ".
                        "( select count(*) from relacion_usuario_area_venta b ".
                        "where cod_usuario =  '{$_POST['cod_usuario']}' and b.`VKORG` = a.VKORG ".
                        "and b.`VTWEG` = a.VTWEG  ".
                        "and b.`SPART` = a.SPART ) = 0";
             }else{
            $consulta = $link->prepare('SELECT distinct VKORG, VTEXTVKORG, VTWEG, VTEXTVTWEG, SPART, VTEXTSPART  FROM clientes.vw_SAP_rfc_Areasdeventa '.$where.'    ');
            $datos['query'] = 'SELECT distinct VKORG, VTEXTVKORG, VTWEG, VTEXTVTWEG, SPART, VTEXTSPART  FROM clientes.vw_SAP_rfc_Areasdeventa '.$where.'    ';
            }
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
    case 'GET_LISTADO_CENTRO_LOG_POR_AREAS_DE_VENTAS':
          $where = null;
           
         if(isset($_POST['VKORG']) && $_POST['VKORG'] != '' && isset($_POST['VTWEG'])&&$_POST['VTWEG']!= "" && isset($_POST['SPART']) && $_POST['SPART']!='' ){
            $where = " where VKORG = '{$_POST['VKORG']}' AND VTWEG ='{$_POST['VTWEG']}' AND  SPART = '{$_POST['SPART']}'" ;
        }  
       try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
            $consulta = $link->prepare('SELECT id_relacion, VKORG, VTEXTVKORG, VTWEG, VTEXTVTWEG, SPART, VTEXTSPART, WERKS, NAME1 FROM clientes.SAP_rfc_Areasdeventa_centros_log '.$where.'    ');
            $datos['query'] = 'SELECT id_relacion, VKORG, VTEXTVKORG, VTWEG, VTEXTVTWEG, SPART, VTEXTSPART, WERKS, NAME1 FROM clientes.SAP_rfc_Areasdeventa_centros_log '.$where.'    ';
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $datos['error']='';
            $datos['datos'] = $registros;
            $datos['filas'] = sizeof( $registros) ;
            $_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS'] = null;
            if($datos['filas'] > 0){
                $I = 0;
                foreach ($registros as $key => $value) {
                    $ARRAY_CENTRO_LOG_POR_AREAS_DE_VENTAS[$I] = $value['WERKS'];
                    $I++;
                }
                $_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS']= $ARRAY_CENTRO_LOG_POR_AREAS_DE_VENTAS;
            }
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;    
        }
              
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
        break;
    case 'GET_LISTADO_CLIENTES':
        
          $datos['error']='';  
      
         if (!isset($_SESSION['DATOS_RFC_EASYSALE_CLIENTES']) || $_SESSION['DATOS_RFC_EASYSALE_CLIENTES'] == '' || sizeof($_SESSION['DATOS_RFC_EASYSALE_CLIENTES'])== 0)
            $_SESSION['DATOS_RFC_EASYSALE_CLIENTES'] = GET_DATOS_RFC_EASYSALE_CLIENTES();
        
          $arreglo=$_SESSION['DATOS_RFC_EASYSALE_CLIENTES']; 
        
        if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
             $nuevoUsuario = new Class_php\Usuarios($_POST['idUsuario'] );
             $arrayClientesRelacionados = array();
             $arrayClientesRelacionados = $nuevoUsuario->getClientesUsuario();
             $arreglo= FILTRAR_DATOS_RFC_EASYSALE_CLIENTES($arreglo,$arrayClientesRelacionados,false);
        }else{
           
        $arreglo= FILTRAR_DATOS_RFC_EASYSALE_CLIENTES($arreglo); }
            if (isset($_POST['columnas'])&& isset($_POST['item']) && isset($_POST['concordancia'])){ 
            $datos['datos'] = verificaContenidoArray( $arreglo , $_POST['columnas'] ,$_POST['item'] , $_POST['concordancia'] );}
            else{$datos['datos'] = $arreglo;}
            $datos['filas'] = sizeof( $datos['datos']) ;        
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);    
            $datos['nombreCabecera']=$nomTableCabecera;
        }
        break;
    case 'GET_LISTADO_CLIENTES_CON_MAIL_RELACIONADO':
          if($busquedaDinamica) { 
               if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
        $query = " SELECT distinct    id_cliente_SAP, tipo_relacion, tipo_notificacion,  nom_cliente_SAP  FROM  `relacion_mail_cliente`
            $where And   `relacion_mail_cliente`.`tipo_notificacion` = ID_TIP_NOTIFICACION('cargo pedido SAP')
                    AND  `relacion_mail_cliente`.`tipo_relacion` = ID_TIPO_RELACION('para') 
                     and id_cliente_SAP not in (
                     select id_cliente_SAP from  vw_relacion_usuario_clientes where id_usuario = {$_POST['idUsuario']});";
                   
        }else{
             $query = " SELECT distinct    id_cliente_SAP, tipo_relacion, tipo_notificacion,  nom_cliente_SAP  FROM  `relacion_mail_cliente`
            $where And   `relacion_mail_cliente`.`tipo_notificacion` = ID_TIP_NOTIFICACION('cargo pedido SAP')
                    AND  `relacion_mail_cliente`.`tipo_relacion` = ID_TIPO_RELACION('para') 
                     and id_cliente_SAP not in (
                     select id_cliente_SAP from  Aux_relacion_usuario_clientes);";
        } 
          }else{
             if (isset($_POST['idUsuario']) && $_POST['idUsuario'] != ''){
        $query = " SELECT distinct    id_cliente_SAP, tipo_relacion, tipo_notificacion,  nom_cliente_SAP  FROM  `relacion_mail_cliente`
            WHERE   `relacion_mail_cliente`.`tipo_notificacion` = ID_TIP_NOTIFICACION('cargo pedido SAP')
                    AND  `relacion_mail_cliente`.`tipo_relacion` = ID_TIPO_RELACION('para') 
                     and id_cliente_SAP not in (
                     select id_cliente_SAP from  vw_relacion_usuario_clientes where id_usuario = {$_POST['idUsuario']});";
                   
        }else{
             $query = " SELECT distinct    id_cliente_SAP, tipo_relacion, tipo_notificacion,  nom_cliente_SAP  FROM  `relacion_mail_cliente`
            WHERE   `relacion_mail_cliente`.`tipo_notificacion` = ID_TIP_NOTIFICACION('cargo pedido SAP')
                    AND  `relacion_mail_cliente`.`tipo_relacion` = ID_TIPO_RELACION('para') 
                     and id_cliente_SAP not in (
                     select id_cliente_SAP from  Aux_relacion_usuario_clientes);";
        } 
          }
  
        
        
         try {                   
            $conexion = Class_php\DataBase::getInstance();
            $link = $conexion->getLink();//vw_SAP_rfc_Areasdeventa
            $consulta = $link->prepare($query);
            $datos['query'] = $query;
            $consulta->execute();
            $registros = $consulta->fetchAll();
            $datos['error']='';
            $datos['datos'] = $registros;
            $datos['filas'] = sizeof( $registros) ;
            $_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS'] = null;
//            if($datos['filas'] > 0){
//                $I = 0;
//                foreach ($registros as $key => $value) {
//                    $ARRAY_CENTRO_LOG_POR_AREAS_DE_VENTAS[$I] = $value['WERKS'];
//                    $I++;
//                }
//                $_SESSION['CENTRO_LOG_POR_AREAS_DE_VENTAS']= $ARRAY_CENTRO_LOG_POR_AREAS_DE_VENTAS;
//            }
    
        } catch (PDOException $e) {
               $datos['error']='Error de conexión: ' . $e->getMessage();
               $datos['datos'] =null;    
        }
              
        if ($nomTableCabecera and $nomTableCabecera != ''){
            $datos['cabeceras'] = obtenerNomCabecera($nomTableCabecera);       
            $datos['nombreCabecera']=$nomTableCabecera;
        }
    break;
    case 'ELIMINAR_DATOS_USUARIO_CLIENTES': 
         $nuevoMenu = new Class_php\Usuarios( $_POST['id_usuario']);
        $datos['error'] = $nuevoMenu->eliminarRelacionCliente($_POST['dato_eliminar']);
            
        break;
    case 'ELIMINAR_DATOS_USUARIO_AREAS_DE_VENTA': 
         $nuevoMenu = new Class_php\Usuarios( $_POST['id_usuario']);
        $datos['error'] = $nuevoMenu->eliminarRelacionAreaDeVenta($_POST['dato_eliminar']);
            
        break;
     case 'ELIMINAR_DATOS_USUARIOS_AREAS_DE_CONTROL': 
         $nuevoMenu = new Class_php\Usuarios( $_POST['id_usuario']);
        $datos['error'] = $nuevoMenu->eliminarRelacionAreaDeControl($_POST['dato_eliminar']);
            
        break;
    case 'ELIMINAR_DATOS_TMP_USUARIO_CLIENTES':
        $datos['error']  =  Class_php\Usuarios::eliminaRelacionTemporal();
     break;
    case 'ELIMINAR_DATOS_TMP_USUARIO_AREA_DE_VENTA':
        $datos['error']  =  Class_php\Usuarios::eliminaRelacionAreaDeVentaTemporal();
     break;
    case 'ELIMINAR_DATOS_TMP_USUARIO_AREA_DE_CONTROL':
        $datos['error']  =  Class_php\Usuarios::eliminaRelacionAreaDeControlTemporal();
     break;
   case 'ELIMINAR_AREAS_DE_VENTAS_CENTROS_LOG':
        TRY {
       $conexion =Class_php\DataBase::getInstance(); 
      $_result =$conexion->eliminarDato('SAP_rfc_Areasdeventa_centros_log',  $_POST['id_relacion'],'id_relacion');
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
//</editor-fold>
}

 echo json_encode($datos);