<?php
require_once '../../php/helpers.php'; 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../'. str_replace('\\','/',$nombre_clase ).'.php' ;
    //ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
new Core\Config();
$user = cargaDatosUsuarioActual();
if ($_SESSION['access'] ==false){
    header('Location: ../');
}
  
?>
<link href="../../css/vistas.css" rel="stylesheet" type="text/css"/>
<script src="view/js/usuarios.js" type="text/javascript"></script> 
 
    <div class="panel panel-default" >
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody> 
  
  
  <tr> 
      <td >Creación y edición de usuarios</td></tr></tbody></table>
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
                        <div class="col-md-2 col-sm-12" style="display:none"><div class="form-group">
                            <label for="email">Cód. usuario : </label>
                            <input type="text" class="form-control" id="ID" readonly="true">
                        </div></div> 
                        
                         <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Pri. nombre: </label>
                            <input type="text" class="form-control" id="Nombre1"  >
                        </div></div>
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Seg. nombre:</label>
                            <input type="text" class="form-control" id="Nombre2">
                        </div></div> 
                        <div class="col-md-3 col-sm-12"> 
                            <div class="form-group">
                                    <label for="email">Pri. Apellido:</label>
                                    <input type="text" class="form-control" id="Apellido1">
                                  </div> 
                        </div>  
                        <div class="col-md-3 col-sm-12"> 
                            <div class="form-group">
                                    <label for="email">Seg. Apellido:</label>
                                    <input type="text" class="form-control" id="Apellido2">
                                  </div> 
                        </div> 
                        
                   
                    </div><div class="row" style="width:100%"> 
                     <div class="col-md-6 col-sm-12">
                       <label for='Nickname'>correo electronico :</label>
                            <input type="email" class="form-control" id="mail" autocomplete="off">
                </div>
                    
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for='Nickname'>Nickname :</label>
                            <input type="text" class="form-control" id="Login">
                        </div></div> 
               
                        <div class="col-md-3 col-sm-12"><div class="form-group">
                            <label for="email">Password :</label>
                             <div class="input-group">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button" title="restaurar contraseña" id='resetPass'>
                                   <!--<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>-->
                                   <i class="fas fa-sync-alt"></i>
                                  </button>
                                </span>
                                 <input type="password" class="form-control" id="pass"  readonly="true" >
                              </div>
                            
                        </div></div>  
                    </div>
                     <div class="row" style="width:100%"> 
                      
                         
                    <div class="col-md-2 col-sm-12 hidden">
                    <label for='Nickname'>cod. remis. :</label>
                    <input type="text" class="form-control" id="cod_remision" readonly="true">
                </div>
              <div class="col-md-4 col-sm-12"><div class="form-group">
                            <label for="email">Estado</label> 
                            <select  class="form-control" id="estado">
                                <option value="A">Activo</option>
                                <option value="I">Inactivo</option>
                                
                            </select>
                        </div></div>
            
            
                         <div class="col-md-6 col-sm-12"><label for='Nickname'>&nbsp;</label>
                        <div style="width:100%;text-align: center">
                             <input type="submit" name="btnIngresar" value="Ingresar" id="btnIngresar" class="btn badge-primary" >&nbsp;
                             <input type="submit" name="btnCancelar" value="Cancelar" id="btnCancelar" class="btn badge-primary" >
                        </div>
            </div>                         
            </div>
                    <hr><br>      
                <div class="row" style="width:100%" id="tablaResultado">
                    <?php echo cargarTablaLIstar('usuarios',true,true);?>
                </div>
                 
            </div>
          </td>
          </tr></tbody></table>                  
          </td></tr></tbody></table>
    </td>
  </tr>
</tbody></table></div>
 