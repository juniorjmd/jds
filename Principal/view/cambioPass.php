<?php
require_once '../../php/helpers.php'; 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../'. str_replace('\\','/',$nombre_clase ).'.php' ;
    //ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
new Core\Config();
$user = cargaDatosUsuarioActual();
if ($_SESSION['access']==false){ 
    header('Location: ../');
}
  
?>
<script src="view/js/cambioPass.js" type="text/javascript"></script> 

          
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      <tr><td colspan="2" class='moduloTitle_principal'> Cambio de Contraseña</td></tr></tbody></table>
  
<div class="<?php echo trim($_SESSION["style"]);?>_vistaContainer" >  
    <div class="<?php echo trim($_SESSION["style"]);?>_moduloTitle_secundario">  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody> 
  
  
  <tr> 
      <td >Creación y edición de la relacion entre perfiles y recursos</td></tr></tbody></table>
  </div>
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody> 
      <tr>
    <td class="moduloCuerpo_1">
      <table width="100%" border="0" cellspacing="0" cellpadding="30">
        <tbody>
        <tr>
          <td>
              
            <table width="100%" id="Table7" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0">
              <tbody>
              <tr>
                <td width="100%" height="350" valign="top">
                    <table>
                        <tr>
                     <td width="50%" class="mini-gray" valign="middle">
                   
                   <div align="center"><img width="390" height="320" alt="Portal Nutrimon" class="img-responsive" id='<?php echo trim($_SESSION["style"]);?>_logoPrincipal' border="0"></div>
               </td>        
                            
               <td width="50%" class="mini-gray" valign="middle">
                 <div align="center">
                     <table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
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
            
            
            </div>
               
               </td>
                            
                        </tr>
                        
                    </table></td>
              
              
              </tr></tbody>
            
            
            </table>
          
          </td></tr></tbody></table></td>
          
          
          
          
              </tr></tbody></table>
        </div>
    