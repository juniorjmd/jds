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
  $conexion =  Class_php\DataBase::getInstance();
 $link = $conexion->getLink();
$query= $link->prepare('select * from vw_gastos_operacionales order by cod_grupo  , cod_cuenta ,digito;');
$query->execute();  
$OPTION_TIPO_RECURSO =  "<ul class='list-group'>" ;
$cuenta = '';
$chec = '';
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    if($cuenta != $row['cod_cuenta']){
        $cuenta = $row['cod_cuenta'];
        
        
        $OPTION_TIPO_RECURSO .="<li class= 'cuenta list-group-item active' id='cuenta_$cuenta' data-cuenta='$cuenta'data-ncuenta='{$row['nombre_cuenta']}' ><input type='hidden' value='true'  class='swiche'>{$row['nombre_grupo']}-{$row['nombre_cuenta']}</li>";
    }
    $chec = '';
    if ($row['id_seleccion'] > 0 ) $chec = 'checked';
        
    $OPTION_TIPO_RECURSO .= "<li class= 'subcuentas list-group-item' data-subcuenta=' {$row['nro_scuenta']}'  data-nsubcuenta='{$row['nombre_scuenta']}' data-cuenta='$cuenta' data-ncuenta='{$row['nombre_cuenta']}' > <input type='checkbox' data-chcuenta='$cuenta' $chec name='cuentas[]' value='{$row['nro_scuenta']}'>  {$row['nro_scuenta']} - {$row['nombre_scuenta']}</li>" ;			
}
$OPTION_TIPO_RECURSO .=  " </ul>" ;
$conexion = null; 
?> 
<style>
    .cuenta{
        cursor: pointer;
    }
</style>
<script src="view/js/selectGastosOper.js" type="text/javascript"></script> 
 
    
    <div class="panel panel-default" >  
         <div class="clearfix">
            <span class="float-left"><h3>&nbsp;&nbsp;&nbsp;Seleccion de gastos operacionales</h3></span>
   
</div>
        <nav class="navbar navbar-light bg-light">
  <div class="form-inline">
      <select id="tipobusqueda"class="form-control mr-sm-2" id="tipo_busqueda"   >
          <option value="cuenta">por cuenta</option> 
          <option value="subcuenta">por subcuenta</option>
      </select> 
      <input class="form-control mr-sm-2" id="busqueda_cuenta" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0"  id="enviar_seleccion">Guardar</button>
  </div>
</nav>
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
                        <div class="col-md-9 col-sm-12"><div class="form-group">
                                <form name="ingresoDatos" id="ingresoDatos" method="POST">
                                    <?php echo $OPTION_TIPO_RECURSO; ?>
                                </form>
                            
                        </div></div>
                         
                         
                    </div> 
                    
                     
                     
            </div>
                </td>
              
              
              </tr></tbody></table>                  
          </td></tr></tbody></table>
    
    
    </td></tr></tbody></table>
        </div>
    