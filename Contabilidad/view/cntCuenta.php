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
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<script src="view/js/cntCuenta.js" type="text/javascript"></script> 


<div class="panel panel-default" >  
    <div class="clearfix">
    <span class="float-left"><h3>&nbsp;&nbsp;&nbsp;Creación y edición Cuentas contables</h3></span>
</div>
       <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody> 
  <tr>
    <td class="moduloCuerpo_1">
        
      <table width="100%" border="0" cellspacing="0" cellpadding="30">
        <tbody>
        <tr>
          <td>
              <table width="100%"   id="tablaDeDatos" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0">
              <tbody>
              <tr>
                <td width="100%" height="350" valign="top">
                <div width="100%" align="center">
                    <div class="row" style="width:100%">
                        <div class="col-md-1 col-sm-12">&nbsp;</div> 
                         <div class="col-md-1 col-sm-12"><div class="form-group">
                            <label for="email">id cuenta</label> 
                             
                            <input type="text" class="form-control" id="id_cuenta" readonly="true" >
                        </div></div>
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Clase</label> 
                            <select  class="form-control" id="PadreId">
                                <option value="">Ninguno</option>
                            </select>
                        </div></div>
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Grupo : </label> 
                            <select  class="form-control" id="cod_grupo">
                                <option value="">Ninguno</option>
                            </select>
                            
                        </div></div>
                         <div class="col-md-1 col-sm-12"><div class="form-group">
                            <label for="email">Digito</label> 
                             
                            <input type="text" class="form-control" id="digito">
                        </div></div>
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Nombre corto :</label>
                            <input type="text" class="form-control" id="Nombre">
                        </div></div>
                        
                        <div class="col-md-12"><div style="width:100%;text-align: center">
                             <input type="submit" name="btnIngresar" value="Ingresar" id="btnIngresar" class="mcv_btnIngresar button">&nbsp;
                             <input type="submit" name="btnCancelar" value="Cancelar" id="btnCancelar" class="mcv_btnIngresar button">
                                     </div></div>
                         
                    </div> 
                    
                    
                    
                    <div class="row" style="width:100%" id="tablaResultado">
                     
                        <?php echo cargarTablaLIstar('vw_cnt_cuenta',false,true);?>
                    </div>
                     
            </div>
                </td>
              
              
              </tr></tbody></table>                  
          </td></tr></tbody></table>
    
    
    </td></tr></tbody></table>
        </div>
    