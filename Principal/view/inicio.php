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
<script src="js/inicio.js" type="text/javascript"></script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: "Arial Narrow";
	color: #993300;
	font-size: 15px;
}
.Estilo2 {
	font-family: "Arial Narrow";
	font-size: 14px;
	color: #993300;
}
.Estilo4 {
	font-size: 15px;
	font-style: italic;
	font-family: "Arial Narrow";
	font-weight: bold;
	color: #993300;
}
-->
</style>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      <tr>
        <td colspan="2" class='moduloTitle_principal Estilo1'>CHARDOM - Sistema Integral de Gestión Administrativa</td>
      </tr>
  </tbody></table>
  
<div class=" vistaContainer" >  
    <div class="moduloTitle_secundario">  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody> 
  
  
  <tr> 
      <td class="Estilo4" ><br />Descripción de Servicio</td>
  </tr>
  </tbody></table>
  </div>
    
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody> 
  
  
      <td class="moduloCuerpo_1">
      <table width="100%" border="0" cellspacing="0" cellpadding="30">
        <tbody>
        <tr>
          <td>
            <table width="100%" id="Table7" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0">
              <tbody>
              <tr>
                <td width="100%" height="350" valign="top">
                    
                                    
                    <p align="justify" class="parrafo Estilo2"> El													Área de 
                  Sistema de ventas y manejo de inventario <span class="moduloTitle_principal">CHARDOM</span></p>
                    <span class="Estilo2">
                    <?php  echo $user->getDescripcionMenuUsuario('principal');?>   							 
                    </li>
                    </ul>
                    
                    <br>
                    </span></td>
              </tr>
              </tbody></table></td></tr></tbody></table></td></tr></tbody></table>
        </div>
    