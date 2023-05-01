<?php
require_once '../php/helpers.php'; 
require_once '../php/mail_helper.php'; 
  
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../'. str_replace('\\','/',$nombre_clase ).'.php' ;
   //  ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
$id_usuario = $_POST['identificacion']; 
    
    $id_sitio = $_POST['nameWindows'];

$where = " where Login = '$id_usuario'" ;
$arrayMenus = array();

new Core\Config(); 
$datos = \Class_php\Usuarios::recuperarTodos($where); 

 echo'<br><br><br>';
if ( $datos['filas']  == 0){
    
           echo'<center><h2>El usuario ingresado no pertenece a ninguno registrado en la base de datos!!!</h2></center>';
}
else{
    $datos_r = $datos['datos']; 
      $nuevoUsuario = new \Class_php\Usuarios(  $datos_r[0]['ID'] 
         ,  $datos_r[0]['Login'] 
         ,  $datos_r[0]['Nombre1']
         ,  $datos_r[0]['Nombre2'] 
         ,  $datos_r[0]['Apellido1'] 
         ,  $datos_r[0]['Apellido2']
         ,  NULL //NOMBRE COMPLETO
         ,  $datos_r[0]['estado'] 
         ,  sha1(PASS_INICIAL)
         , $datos_r[0]['mail'] ,0,$datos_r[0]['cod_remision']  );  
        $datos['error'] = $nuevoUsuario->guardar(true); 
         
    $Ecof_ui_widget_content=' border: 1px solid #23282D;
    background: #fcfdfd  ;
    color: #505253;
    font-size: 10px';
    $ui_widget_content = '
    border: 1px solid #536675;
    background: #fcfdfd ;
    color: #505253;
     font-size: 10px';
    $mcv_ui_widget_content =' border: 1px solid #23282D;
    background: #fcfdfd ;
    color: #505253;
     font-size: 10px';
    
    $para_externo =  $titulo =  $cuerpoMailExterno = $headers_externo = ''; 
    
    $clase = $id_sitio.'_ui-widget-content';
     $cuerpoMailExterno = reemplazaAcentos(  mail_externo_nueva_pass($id_sitio));
       $cuerpoMailExterno =  str_replace ("%FECHA%",date('d/m/Y'),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%USUARIO%",reemplazaAcentos($datos_r[0]['Login']),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%NOTA%",'',$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%CLIENTE%",reemplazaAcentos($datos_r[0]['nombreCompleto']),$cuerpoMailExterno);
       $cuerpoMailExterno =  str_replace ("%PASS%",'<strong>'.reemplazaAcentos(PASS_INICIAL).'</strong>',$cuerpoMailExterno); 
       
   
    $para_externo  = $datos_r[0]['mail'];
          if (PHP_OS == 'Linux') {
                    $breakLine = "\n";
                } else {
                    $breakLine = "\r\n";
                }
    $headers_externo = "From: Portar de clientes <noresponder@monomeros.com.co>" . $breakLine;
    $headers_externo .= "Reply-to: <noresponder@monomeros.com.co>\nContent-type: text/html" . $breakLine;
                 
        $titulo ='Contraseña restaurada -  portal clientes.';
        
       if (mail($para_externo, $titulo, $cuerpoMailExterno, $headers_externo))//EXTERNO
       {
           echo'<center><h2>Se ha enviado un correo a su direccion registrada con su nueva contraseña!!!</h2></center>';
       }else{
           echo'<center><h2>se presento un error al enviar el mail de notificación de cambio de contraseña por favor vuelta a intentarlo!!!</h2></center>';
       }
}
?>
<script>
//setTimeout(function() {
  //      window.location.href ='../login/'
   // },3000);
</script>