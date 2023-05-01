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
include '../../jds/db_conection.php';
 $conn= cargarBD();  
?>
<link href="../../css/vistas.css" rel="stylesheet" type="text/css"/>
<script src="view/js/cntBalanceGeneral.js" type="text/javascript"></script> 

<form name="formularioBalance" id="formularioBalance" method="POST">
    <input type="hidden" value="EXTRAER_BALANCE_GENERAL"  name="action">
<div id='ContBusquedaPersonas'></div>
<div id="contenedor"class="panel panel-default" >  
    
   <div class="row" style="width:100%"> <br>
            <div class="col-md-12 col-sm-12 text-center">
                
                <label>Balance general</label>
            </div>   
        <div class="row" style="width:100%">  
                              
            <div class="col-md-1 col-sm-11"></div>
            <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">FECHA INICIAL:</label>
                                   <input id="fechaInicial" name="fechaInicial" class='fechaBusqueda form-control' readonly style='height: 25px;font-size: 9px;'/>
                            </div></div>
            <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">FECHA FINAL:</label>
                                <input id="fechaFinal" name="fechaFinal" class='fechaBusqueda form-control' readonly style='height: 25px;font-size: 9px;'/>
                            </div></div>
        </div>
        
    <div class="row" style="width:100%">  
                              
             
        <div class="col-md-12"><div style="width:100%;text-align: center">
                             <input type="submit" name="enviar_datos" value="Ingresar" id="enviar_datos" class="mcv_btnIngresar button">&nbsp;
                             <input type="submit" name="btnCancelar" value="Cancelar" id="btnCancelar" class="mcv_btnIngresar button">
                                     </div></div>
                
    </div>
   </div>
    <div class="center" id="div_tabla_reporte">
        
        
        <table style="width: 100%" border="1"  >
            <tr><td align="right" colspan="3" style="padding: 10px"><button id="enviarExcel">EXCEL</button></td></tr>
        
        </table>
        <table style="width: 100%" border="1" id="tabla_reporte">
        <tr><td align="center" colspan="3"><h1>BALANCE GENERAL</h1></td></tr>
        
                <tr><td rowspan="2" valign="TOP">
                        <table style="width: 100%" border="1">
                            <tr><td colspan="2" align="center"><H3>ACTIVO</H3></td></tr>
                            <tbody id="tbActivo"></tbody>
                            <tr><td><h3>total activo</h3></td>
                            <td   id="tActivo"> </td></tr>
                        </table>
                    </td><td rowspan="2" valign="TOP" style="width:20px">&nbsp;</td>
            <td> <table style="width: 100%" border="1">
                            <tr><td colspan="2" align="center"><H3>PASIVO</H3></td></tr>
                            <tbody id="tbPasivo"></tbody>
                            <tr><td><h3>total pasivo</h3></td>
                            <td   id="tPasivo"> </td></tr>
                        </table></td></tr>
        <tr><td><table style="width: 100%" border="1">
                            <tr><td colspan="2" align="center"><H3>PATRIMONIO</H3></td></tr>
                            <tbody id="tbPatrimonio"></tbody>
                            <tr><td><h3>total patrimonio</h3></td>
                            <td  id="tPatrimonio"> </td></tr>
                        </table></td></tr>
    </table></div>
        </div>

    </form>



