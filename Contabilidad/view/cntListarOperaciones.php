<?php
require_once '../../php/helpers.php'; 
spl_autoload_register(function ($nombre_clase) {
    $nomClass =  '../../'. str_replace('\\','/',$nombre_clase ).'.php' ;
    //ECHO $nomClass.'<BR>';
    require_once $nomClass;
 });
new Core\Config();
$user = cargaDatosUsuarioActual();
//
//print_r($_SESSION);
if ($_SESSION['access']==false){ 
    header('Location: ../');
}
  
?>
<link href="../../css/vistas.css" rel="stylesheet" type="text/css"/>
<script src="view/js/cntListarOperaciones.js" type="text/javascript"></script> 
 
    
    <div class="panel panel-default" >  
         <div class="clearfix">
            <span class="float-left"><h3>&nbsp;&nbsp;&nbsp;Listado de Operaciones Realizadas</h3></span>
   
</div>  <div class="row" style="width:100%" id="tablaResultado">
                     
                        <?php echo cargarTablaLIstar('vw_cnt_listar_operaciones',true,false);?>
                    </div>
                     
            </div> 
        </div>
   
        
        <!-- Button trigger modal -->
        <div class="hidden">       
<button type="button" id="btnModal" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button></div> 

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">volante de operacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div id='printarea'>
           
           <center><span><?=$_SESSION['sucursalNombre']?></span></center>
           <center><span><?=$_SESSION['sucursalNombre_2']?></span></center>
           <center><span><?=$_SESSION['nit_sucursal']?></span></center>
           
           <hr>
           <span> Volante # </span><span class="elmtPrint" id="numVolante"></span>
           <span> Fecha: </span> <span class="elmtPrint" id="fechaCreacion"></span><br>
           <span> Descripción: </span> <span class="elmtPrint" id="descripcion"></span><br>
           <span> Usuario: </span> <span class="elmtPrint" id="nombreUsuario"></span>
           
           
           <table class="table">
               <tr><td>Cuenta</td>
                   <td colspan="2"><center>Descripción</center></td>
               <td>Debito</td>
               <td>Credito</td>
               <td>Nit</td></tr>
               <tbody id="cuerpoTabla"></tbody>
           </table>
           <hr>
            </div> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="btn" class="btn btn-primary">imprimir</button>
      </div>
    </div>
  </div>
</div>

