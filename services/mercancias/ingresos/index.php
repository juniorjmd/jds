<?php
require_once '../../../php/helpers.php';  
require_once'../../../jds/php/fpdf181/fpdf.php';
//echo print_r(FILTRAR_DATOS_RFC_EASYSALE_CLIENTES());
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../../'. str_replace('\\','/',$nombre_clase ).'.php' ;
  //  ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
new Core\Config();  
header("Content-type:application/json; charset=utf-8");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: * ");

http_response_code(200);

switch ($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
         TRY {   $conexion =Class_php\DataBase::getInstance();  
            $where = '';
            $datos =$conexion->where('ingresos', $where);
            print_r($datos);
      }
      catch (PDOException $e) {
          http_response_code(500);
        $datos['error']= 'Error de conexion: ' . $e->getMessage();
           
     } 

        break;
    case 'POST': 
      $json = file_get_contents('php://input');
      $_POST = json_decode($json, true);  
      foreach ($_POST as $clave => $valor){
          $$clave = $valor;
        }
    
        break;
    default :
        http_response_code(500);
        $datos['error']= 'metodo no permitido';  
}


  
  

 echo json_encode($datos);