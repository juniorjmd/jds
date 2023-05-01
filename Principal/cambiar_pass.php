<?php


require_once '../php/helpers.php'; 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../'. str_replace('\\','/',$nombre_clase ).'.php' ;
  // ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
new Core\Config();
$user = cargaDatosUsuarioActual();
if ($_SESSION['access']==false){ 
    header('Location: ../login/');
}
  
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
         <title>Portal clientes</title> 
         <link href="../css/portada2.css" rel="stylesheet" type="text/css">  
         <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
         <script src="../vendor/jquery.js" type="text/javascript"></script>
         
         <script src="view/js/cambioPass.js" type="text/javascript"></script>
         
         
         <script>
             var url = '../Principal/';          
          $(document).ready(function(){              
            var cargadorLista= new T_find.CargadorContenidos(url); 
              var colorFrente = ""
                var colorAtras = ''
                var topperleft = '' 
                var imagenlogo = ''
                var topper_right = ''
                var footer_img = ''
                var btnIngresar = ''
                var title_01 = ''
                window.name = 'mcv'
                $('#nameWindows').val(window.name)    
                
                   colorFrente = "#008242"
                   colorAtras = "rgba(177, 127, 35, 0.84)" 
                   topperleft = 'topperleft'
                   imagenlogo = '../images/big-logo-logistica.jpg'
                   topper_right = 'topper-right'
                   footer_img  = 'footer-img'
                   btnIngresar='button'
                   title_01 = 'title-01'
               
                $('#td_barra_principal').css("background-color" ,colorFrente )
                $('.colorFondo').css("background-color" ,colorAtras )
                $('#topperleft').addClass(topperleft)
                $('#logoPrincipal').attr('src',imagenlogo)
                $('#topper_right').addClass( topper_right)
                $('#footer-img').addClass(footer_img)
                $('#btnIngresar').addClass(btnIngresar) 
                $('#title_01').addClass( title_01) 
          })
        
         </script>
             
        <title></title>
    </head>
    <body >
     <input type='hidden' id='nameWindows' name='nameWindows'/>    
     <div id="cont_Load_gif" style='padding-left:20%;padding-right: 20%;display: none ' >
        
         <span style="float: left; color: gray;font-size: 13px "  >Cargando&nbsp;</span>  
<div class="loadingDiv" id="esperaMarcas" style="height:20px; width:100px;  " >
    <div id="blockG_1" class="facebook_blockG"></div>
    <div id="blockG_2" class="facebook_blockG"></div>
    <div id="blockG_3" class="facebook_blockG"> </div></div>
     </div>     
 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="920">
        <br><br><br><br><br><br><br><br><br><br>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tbody>
        <tr><td width="50%" class="mini-gray" valign="middle">
                       <div align="center">
                           <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                               <thead>
                                   <tr>
                                       <th colspan="2"> <h2>Cambio de Contraseña</h2></th>
                                   </tr>
                               </thead>
                           <tbody> 
                           <tr>
                                   <td height="30" width='25%' nowrap style="text-align:right">
                                            Contraseña anterior: 
                                   </td>
                                   <td height="30" ><input name="password_ant" type="password" id="password_ant" size="13"></td>
                           </tr>
                           <tr>
                                  <td height="30" nowrap style="text-align:right">Contraseña nueva: 
                                   </td>
                                   <td height="30"><input name="password_nw_1" type="password" id="password_nw_1" size="13"></td>
                           </tr>
                           <tr>
                                   <td height="30" nowrap style="text-align:right">Confirmar contraseña: 
                                   </td>
                                   <td height="30"><input name="password_nw_2" type="password"  id="password_nw_2" size="13"></td>
                           </tr>
                           <tr>
                               <td colspan="2" height="40"><input type="submit" name="btnIngresar" value="Ingresar" id="btnIngresar" class="<?php echo trim($_SESSION["style"]);?>_btnIngresar" >&nbsp;
                                           </td>
                           </tr>

                           </tbody>
                           </table>


                  </div></td>
  
        </tr></tbody></table>
       </td>
    <td width="50%">&nbsp;</td></tr></tbody></table> 
     
     <div></div>
    </body>
</html>