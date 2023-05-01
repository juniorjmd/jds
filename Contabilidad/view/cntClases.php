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
<script src="view/js/cntClases.js" type="text/javascript"></script> 
 
    
    <div class="panel panel-default" >  
        <div class="clearfix">
            <span class="float-left"><h3>&nbsp;&nbsp;&nbsp;Creación y edición Clases contables</h3></span>
   
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
                        <div class="col-md-3 col-sm-12 hidden" ><div class="form-group">
                            <label for="email">Id Clase : </label>
                            <input type="text" class="form-control" id="idClase" readonly="true">
                        </div></div>
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Cód. Clase : </label>
                            <input type="text" class="form-control" id="codClase" readonly="true">
                        </div></div>
                        <div class="col-md-4 col-sm-12"><div class="form-group">
                            <label for="email">Denominaciòn :</label>
                            <input type="text" class="form-control" id="Nombre">
                        </div></div> 
                        <div class="col-md-12"><div style="width:100%;text-align: center">
                             <input type="submit" name="btnIngresar" value="Ingresar" id="btnIngresar" class="mcv_btnIngresar button">&nbsp;
                             <input type="submit" name="btnCancelar" value="Cancelar" id="btnCancelar" class="mcv_btnIngresar button">
                                     </div></div>
                    </div> 
                    <div class="row" style="width:100%" id="tablaResultado">
                     
                        <?php echo cargarTablaLIstar('cnt_clase',false,true);?>
                    </div>
                     
            </div>
                </td>
              
              
              </tr></tbody></table>                  
          </td></tr></tbody></table>
    
    
    </td></tr></tbody></table>
        </div>
    