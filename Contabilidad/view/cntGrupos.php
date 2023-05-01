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
<link href="../../css/vistas.css" rel="stylesheet" type="text/css"/>
<script src="view/js/cntGrupos.js" type="text/javascript"></script> 
 
    
    <div class="panel panel-default" >  
         <div class="clearfix">
            <span class="float-left"><h3>&nbsp;&nbsp;&nbsp;Creación y edición Grupos contables</h3></span>
   
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
                        <div class="col-md-2 col-sm-12"><div class="form-group">
                            <label for="email">Cód. Grupo : </label>
                            <input type="text" class="form-control" id="cod_grupo" readonly="true">
                        </div></div>
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Clase</label> 
                            <select  class="form-control" id="PadreId">
                                <option value="">Ninguno</option>
                            </select>
                        </div></div>
                         <div class="col-md-1 col-sm-12"><div class="form-group">
                            <label for="email">Digito</label> 
                            <select  class="form-control" id="digito" > 
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
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
                     
                        <?php echo cargarTablaLIstar('vw_cnt_grupos',false,true);?>
                    </div>
                     
            </div>
                </td>
              
              
              </tr></tbody></table>                  
          </td></tr></tbody></table>
    
    
    </td></tr></tbody></table>
        </div>
    