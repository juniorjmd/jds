<?php 
require_once '../php/helpers.php'; 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../'. str_replace('\\','/',$nombre_clase ).'.php' ;
     require_once $nomClass;
 });

new Core\Config(); 
//   $json ='{"pass":"prom2001josdom","nickname":"juniorjmd","style":"mcv"}';
// var_dump(json_decode($json, true));echo '<br>';
//   $_POST = json_decode($json, true); 
if(!isset($_POST['pass']) || $_POST['pass'] == '') {
$hash = '' ;}else{
$hash = sha1($_POST['pass']);}
if(!isset($_POST['nickname'])){
    $_POST['nickname'] = '';
}

unset($_POST['pass']);
//echo $hash;
 $usuario = Class_php\Usuarios::verificarLogin($_POST['nickname'],$hash);
   if($usuario){   
    if ($usuario->getEstado()== 'A'){  
     $usuario->setFechaIngresoUsuario();
 $datos["error"] ="ok"; 
   $datos['estatus']= is_session_started();
 $datos["datos"][0]=  $usuario->getUserArray(); 
      cargarVariablesSessionUsuario($usuario->getUserArray());
      
      /////////////////////////////////////77777777
         
                
      $conexion =Class_php\DataBase::getInstance(); 
      $link = $conexion->getLink(); 
       $query="select sc.* ,  fr.fec_resolucion ,  fr.num_cod_resolucion ,  fr.num_fac_inicial ,  fr.num_fac_final , fr.prefijo from sucursales sc inner join 
	fac_resolucion fr on sc.cod_resolucion = fr.cod_resolucion where id_suc = '002'";
	$consulta = $link->prepare($query); 
        $consulta->execute();
        $sucursal_datos = $consulta->fetchAll();
       if (sizeof($sucursal_datos) > 0 ){
        foreach ($sucursal_datos as $key => $row) {
          $_SESSION["id_suc"] =$row[ "id_suc" ];
          $_SESSION["N_database"] =$row[ "nom_database" ];
          $_SESSION["N_host"] = $row[ "host" ];
          $_SESSION["N_clavedb"] =  $row[ "clavedb" ];
          $_SESSION["N_usuariodb"] = $row[ "usuariodb" ];
	$_SESSION["tip_regimen"] =$row[ "tip_regimen" ];
        
          $_SESSION[ "tipo_regimen" ] = 'COMUN'; 
        if ($_SESSION["tip_regimen"] == 'S'){
          $row[ "fec_resolucion" ] = '  ';
          $row[ "num_cod_resolucion" ] = '  '; 
          $row[ "num_fac_inicial" ] = '  ';
          $row[ "num_fac_final" ] = '  ';   
          $row[ "prefijo" ] = '  '; 
          $_SESSION[ "tipo_regimen" ] = 'SIMPLIFICADO'; 
          
        } 
         
	$_SESSION["prefijo"] =trim($row[ "prefijo" ]); 
	$_SESSION["fec_resolucion"] =$row[ "fec_resolucion" ];
	$_SESSION["num_cod_resolucion"] =$row[ "num_cod_resolucion" ];
	$_SESSION["sucursalNombre"]=$row[ "nombre_suc" ];
	$_SESSION["sucursalNombre_2"] =$row[ "nombre_sucursal_sec" ];
        $_SESSION[ "prefijo" ] = $row[ "prefijo" ];
        
        
        
	$_SESSION["num_fac_inicial"] =$row[ "num_fac_inicial" ];
	$_SESSION["num_fac_final"] =$row[ "num_fac_final" ];
	$_SESSION["nit_sucursal"] =$row[ "nit_sucursal" ];
	$_SESSION["tel1"]=$row[ "tel1" ];
	$_SESSION["tel2"] =$row[ "tel2" ];  
        
	$_SESSION["telAux"]=$row[ "tel1" ]; 
        if (trim($row[ "tel2" ])!= ''){            
	$_SESSION["telAux"].= " - ". $row[ "tel2" ]; 
        }
	$_SESSION["dir"] =$row[ "dir" ];
	$_SESSION["mail"] =$row[ "mail" ];
	$_SESSION["ciudad"] =$row[ "ciudad" ];	
	$_SESSION["retefuente_aplica"] =$row[ "retefuente_aplica" ];
	$_SESSION["base_retefuente"] =$row[ "base_retefuente" ];  
        $_SESSION['retefuente_aplica_ventas']  =$row['retefuente_aplica_ventas'];
        $_SESSION['base_retefuente_venta']   =$row['base_retefuente_venta' ];
        $_SESSION['porcent_retefuente_venta'] =$row['porcent_retefuente_venta'];
        $_SESSION['tipo_retefuente_ventas'] =$row['tipo_retefuente_ventas'];
        $_SESSION['tipo_retefuente_compras'] =$row['tipo_retefuente_compras'];
        

        
        }
      }          
     
    
      
      /////////////////////////////////////////////
      
       $_SESSION["style"] = $_POST['style'];
       $datos['session'] = $_SESSION;
       $datos['estatus']= is_session_started(); 
    }
    else{
         $datos["error"] = 'El usuario ingresado se encuentra en estado inactivo';
    }
    }else{
        session_destroy();
    $datos["error"] = 'El usuario no ha podido ser encontrado';
 }
   

 echo json_encode($datos);
