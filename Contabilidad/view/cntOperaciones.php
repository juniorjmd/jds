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
<script src="view/js/cntOperaciones.js" type="text/javascript"></script> 

<form name="formularioOperaciones" id="formularioOperaciones" method="POST">
    <input type="hidden" value="GUARDAR_DATOS_OPERACIONES"  name="action">
<div id='ContBusquedaPersonas'></div>
<div id='ContBusquedaCuentas'></div>

<div id="contenedor"class="panel panel-default" >  
    
   <div class="row" style="width:100%"> <br>
            <div class="col-md-12 col-sm-12 text-center">
                
                <label>Operaciones Contables</label>
            </div>   
        <div class="row" style="width:100%">  
                              
            <div class="col-md-1 col-sm-11"></div>
            <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">Nit:</label>
                                <?php agregarBusquedaPersonas('pagadoA','contenedor',[
    "clase" => "form-control" 
]);?>
                            </div></div>
            <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">Razon social:</label>
                                       <input id="pagadoA" name="pagadoA" type="text" value="" class="form-control" placeholder="A Quien Se Pago" readonly="" ="">
                            </div></div>
            
                <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">nombre oper :</label>
                                       <input id="nombreOperacion" name="nombreOperacion" type="text" value="" class="form-control" placeholder="nombre de la operacion"  >
                            
                            </div></div></div>
       
    <div class="row" style="width:100%">  
            <div class="col-md-1 col-sm-11"></div>
          <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">numero de cuenta :</label>
                              <?php agregarBusquedaCuentas('codCuenta','nombreSubCuenta','contenedor',[
                                    "clase" => "form-control" 
                                ]);?>
                            </div></div>
         <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">nombre oper :</label>
                                <input id="nombreSubCuenta" readonly="" name="nombreSubCuenta" type="text" value="" class="form-control" placeholder="nombre de la operacion"  ="">
                             
                            </div></div>
             <div class="col-md-2 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">Debito :</label>
                                       <input id="debito" name="debito" type="text" value="" class="form-control" placeholder="$ 000,000,00" >
                            
                            </div></div>
            <div class="col-md-2 col-sm-11">
                            <div style=" width: 100%">
                                <label for="email" style="font-size: 11px;">Credito :</label>
                                       <input id="credito" name="credito" type="text" value="" class="form-control" placeholder="$ 000,000,00"  >
                            
                            </div></div>
            
    </div>
        <div class="row" style="width:100%">
            <div class="col-md-12 col-sm-12">
                <hr>   
            </div></div>
        
       <div class="row" style="width:100%">
            <div class="col-md-3 col-sm-12">
                </div>
           <div class="col-md-2 col-sm-12">
               <button id="crearRegistro" type="button" class="btn btn-info">+Crear_Registro</button>
                </div>
            <div class="col-md-2 col-sm-12">
                <button id="enviar_datos" type="button" class="btn btn-success">Finalizar</button>
                            </div>
            <div class="col-md-2 col-sm-12">
                
                                <button id="btnCancelar" type="button" class="btn btn-danger">Cancelar</button>
                            </div> 
       </div>
       <div class="col-md-12 col-sm-11">
            <div style="width:100%;text-align: center"> 
                <br>    <br>    <br>                
           <table style="width:100%;">
               <tr>
                   <td colspan="5"> <h3>Tabla de Transacciones</h3></td>
               </tr>
               <tr>
                   <td> <label for="email" style="font-size: 11px;">Num. Cuenta</label></td>
                   <td> <label for="email" style="font-size: 11px;">Cuenta</label></td>
                   <td> <label for="email" style="font-size: 11px;">Debito</label></td>
                   <td> <label for="email" style="font-size: 11px;">Credito :</label></td>
                   <td> <label for="email" style="font-size: 11px;">-º-</label></td>
               </tr>
               <tbody id="tbTablaTransacciones"></tbody>
           </table>
                <br>    <br>  
       </div></div>
 
   </div>
        </div>
    </form>