<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
$user = cargaDatosUsuarioActual();
include '../php/funcionesMysql.php';
$conn= cargarBD();
$alert = '';
 $ingreso = false ; 
 if (isset($_POST['cerrar_remision']) && $_POST['cerrar_remision'] == 'cerrar_remision')
 {
    $error_1 =  cerrar_remision($_POST , $conn);
     
 }
     
if (!isset($_POST['id_orden_compra']) && !isset($_GET['num_orden_compra_aux']) ){
     header('Location: crear_orden_compra.php');
}else{
     if ( isset($_GET['num_orden_compra_aux']) ){        
        $id_orden_compra = $_POST['id_orden_compra'] = $_GET['num_orden_compra_aux'];
        $ingreso = $_GET['ingreso'];
        
     }
    $query_inicial = " select * from vw_remision_orden_de_compra where id_orde =  '{$_POST['id_orden_compra']}'" ;
    $result = $conn->query($query_inicial);
$num_datos = $conn->affected_rows;
$TABLA = '';
 //echo "$query_inicial---$num_datos";
if ($num_datos >= 1)
{
    while ($row = $result->fetch_assoc()) {
        $nit = $row['nit'];
        $razonSocial = $row['razonSocial'];
        $cod_orden_externa =  $row['cod_orden_externa'];
    }
    
     
}else{    
     header('Location: crear_orden_compra.php');
}
}
 
 

$query_orden_compra = "select * from remision_cabeza where  orden_de_compra = '{$id_orden_compra}'";
$result = $conn->query($query_orden_compra);
$num_datos = $conn->affected_rows;
$TABLA = '';
 //echo "$query_orden_compra---$num_datos";

        $subTotal = $total = $IVA = 0;
if ($num_datos >= 1)
{
 while ($row = $result->fetch_assoc()) {
     $row["nombreProducto"] =  modificaCaracteres( $row["nombreProducto"] );
         $total += $row["valorTotal"];
         
         $onclick = "window.open('".URL_BASE."jds/printer_config/imprimir_remision.php?orden_de_compra={$id_orden_compra}&codigo_remision={$row["num_remision"]}','popup','width=600,height=500')"; 
           
	$TABLA .= '<tr>' ; 
        $TABLA .="<td>{$row["id_remision"]}</td>"; 
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["valorParcial"], 2)."</td>"; 
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["valorIVA"], 2)."</td>";
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["descuento"], 2)."</td>";
        $TABLA .="<td align='right'> ".$row["cantidadVendida"]."</td>";
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["valorTotal"], 2)."&nbsp;&nbsp;</td>"; 
        $TABLA .='<td align="right" ><a  onclick="'.$onclick.'" target="_blank" class="Estilo3">
            <img src="../imagenes/pdf.jpeg" width="23" height="23" border="0" title="Descargar factura"></a> ';
        $TABLA .=" <button class='devolucion' data-orden_de_compra='{$id_orden_compra}' data-codigo_remision='{$row["num_remision"]}'  >D</button></td>";
        
        $TABLA .= '</tr>' ; 
} 
  
 $result->free();
}
if(isset($_GET['error'])){
    $alert = $_GET['error'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
     <meta charset="utf-8" /> 

<link href="../ayuda/jquery-ui.css" rel="stylesheet">
<link media="screen" rel="stylesheet" href="../css/colorbox.css" />
<link rel="stylesheet" href="../css/loadingStile.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/json2.js"></script>
<script type="text/javascript" src="../js/wp-nicescroll/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="../jsFiles/trim.js" language="javascript1.1" ></script> 
<script type="text/javascript" src="../jsFiles/fullScreen.js"></script>
<script type="text/javascript" src="../jsFiles/ajax.js"></script>
<script type="text/javascript" src="../jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery.colorbox.js"></script>

<script type="text/javascript" src="../jsFiles/listas.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script> 

<!--<link href="../../vendor/jquery_/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="../../vendor/jquery_/jquery-ui.js" type="text/javascript"></script>-->
 <link href="../../vendor/font-awesome/css/fontawesome-all.css" rel="stylesheet" type="text/css"/>
<link href="../../css/vistas.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript" src="../jsFiles/funciones.js"></script>
<script src="js/facturar_remisiones.js" type="text/javascript"></script> 
</head>

    <body>
        <?php if (trim($error_1)!= ''){?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_1;?>
        </div>
        <?php }?>
        <?php if (trim($alert)!= ''){?>
        <div class="alert alert-danger" role="alert">
            <?php echo $alert;?>
        </div>
        <?php }?>
        <?php if ($ingreso){?>
        <div class="alert alert-success" role="alert">
           Datos ingresados con exitos
        </div>
        <?php 
         $descripcion_o_c = $fecha_de_cargue =$id_orden_externa = $id_clientes = null;
        }?>
        
        
        <div class="container" id="creacion">
           <div class="row" style="width:100%"> <br>
            <div class="col-md-12 col-sm-12 text-center">
                
                <label>Creaciòn de Remisiones.</label>
            </div></div>  
               <form action="crear_remision.php" method="post" >
        <div class="row" style="width:100%">  
                              
            <div class="col-md-2 col-sm-11">
                 <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Orden Compra :</label>
                                <?php //print_r($datos['datos']);   
                                   echo $id_orden_compra;                               
                                ?>
                                <input type="hidden" value="<?php  echo $id_orden_compra; ?>" name="id_orden_compra" />
                            </div>
            </div>
                    
                        <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Orden Externa:</label>
                            <?php echo  $cod_orden_externa;?> </div>
                        </div>
            
            <div class="col-md-5 col-sm-11">
                            <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Empresa:</label>
                                <?php //print_r($datos['datos']);   
                                   echo "$nit / $razonSocial"      ;                         
                                ?>
                            </div>
                        </div>
            <div class="col-md-2 col-sm-11">
                            <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Total:</label>
                                <?php //print_r($datos['datos']);   
                                   echo number_format($total, 2)      ;                         
                                ?>
                            </div>
                        </div>
             
                         </div>  
                   <div style="display: none"><input id="submit_envio_datos" type="submit" ></div>
                   
           </form> 
               
                <div class="row" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                   <div class="col-md-12 col-sm-11 text-center">
                       <button id="facturar_orden_compra" type="button" class="btn btn-success"  data-toggle="modal" data-target="#exampleModal">
                           Facturar</button>
                       
                       
                       
                       &nbsp;&nbsp;&nbsp;
                       <a href="crear_orden_compra.php"><button id="limpiar_campos" type="button" class="btn btn-danger">Regresar</button></a>
                         
                </div></div>
                <div class="row" style="width:100%"> 
                   <div class="col-md-12 col-sm-11">
                       
                       <table class="table">
                           <tr>  
                               
                               
                               
                               <th  align='center'># remision</th>
                               <th   align='center'>Valor Parcial</th>
                               <th   align='center'>Iva</th>
                               <th   align='center'>Descuento</th> 
                               <th   align='center'>Cantidad</th>
                               <th   align='center'>Total</th>
                               <th   align='center'></th>
                               
                           </tr>
                           <?php echo $TABLA;?>
                           
                           
                          
                       </table>
                </div></div>
               
               
            </div>
            
 

<input id='tabla_actual' value='remision_detalle' data-columna='id_remision_detalle' type='hidden'>
<input id='caption' value='remisiones' type='hidden'>
<input id="url_base_aplicacion"  type='hidden' value="<?php echo URL_BASE; ?>jds/" />

<div class="modal" id="exampleModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Generacion de Factura</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<form action="cerrar_orden_compra.php" method="post" >
                                <input type="hidden" value="<?php  echo $id_orden_compra; ?>" name="_id_orden_compra" /> 
                                
                                <div class="row" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                                    <div class="col-md-3 col-sm-11 text-center">
                                       tipo de venta : 
                                    </div>
                                         
                                    <div class="col-md-3 col-sm-11 text-center"> 
                                        <select id="tipo_venta" class="form-control" name="_tipo_venta">
                                        <option value="EFECTIVO">De contado</option>
                                        <option value="CREDITO">A credito</option>
                                        <option value="ELECTRONICA">Con datafono</option>
                                </select>
                                    </div></div>
                                
                                 <div class="row venta_credito" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                                    <div class="col-md-3 col-sm-11 text-center">
                                       abono inicial : 
                                    </div>
                                         
                                    <div class="col-md-3 col-sm-11 text-center"> 
                                        <input type="text" value="" id="_abonoInicial" class="form-control" name="_abonoInicial"/>
                                    </div></div>
                                
                                 <div class="row venta_credito" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                                    <div class="col-md-3 col-sm-11 text-center">
                                       numero de cuota : 
                                    </div>
                                  <div class="col-md-3 col-sm-11 text-center"> 
                                      <input type="text" value="" class="form-control" id="_numCuotas" name="_numCuotas"/>
                                    </div></div>
                                
                                 <div class="row venta_credito" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                                    <div class="col-md-3 col-sm-11 text-center">
                                       tipos de pago : 
                                    </div>
                                    <div class="col-md-3 col-sm-11 text-center">  
                                        <select class="form-control" id="_intervalo" name="_intervalo" >
                                            <option value="">--</option>
                                            <option value="8">semanal(8 dias)</option>
                                            <option value="15">Quincenal(15 dias)</option>
                                            <option value="30">Mensual(30 dias)</option>
                                            <option value="45">mes y medio(45 dias)</option>
                                            <option value="60">Bimestral</option>
                                            <option value="90">Timestral</option>
                                            <option value="180">Semestral</option>
                                            <option value="365">Anual</option>
                                        </select>
                                    </div>
                                 </div>
                                
                                     <div class="row venta_datafono" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                                    <div class="col-md-3 col-sm-11 text-center">
                                       numero de vauche : 
                                    </div>
                                  <div class="col-md-3 col-sm-11 text-center"> 
                                      <input type="text" value="" class="form-control" id="_num_vauche" name="_num_vauche"/>
                                    </div></div>
                                <div class="row" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                                    <div class="col-md-3 col-sm-11 text-center">
                                        Genera Retefuente ? 
                                    </div>
                                         
                                    <div class="col-md-3 col-sm-11 text-center">  
                                        <select class="form-control" name="_pago_retefuente" id="_pago_retefuente"> 
                                            <option value="N">No</option>
                                     <option  value="S">Si</option>   
                                        </select></div>
                                </div>
                                   <div class="row" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                                    <div class="col-md-3 col-sm-11 text-center">
                                        Porcentaje Retefuente 
                                    </div>
                                         
                                    <div class="col-md-3 col-sm-11 text-center">  
                                        <input class="form-control" name="_porc_retefuente" id="_porc_retefuente" value=""/>
                                        <input type="hidden" id="aux_porc_retefuente" value="<?php echo $_SESSION['porcent_retefuente_venta'];?>"
                                        </div>
                                </div></div>
                                <div style="display:none">
                                    <input type="submit" class="btn bg-success" id="enviar_orden_compra" value="Generar Factura" ></div>
</form>
      <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="generar_facturacion">Enviar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div></div></div></div>

<div style="display:none">
    <form id="frm_devolucion" action="devolucion_remision.php" method="post" >
              <input type="hidden" id="dev_id_orden_compra" name="dev_id_orden_compra" />
              <input type="hidden" id="dev_id_remision" name="dev_id_remision" />
              <input type="submit" id="enviar_devolucion"/>
          </form></div>
</div>
</body> 
</html>
<style>
    table{
        font-size: 12px;
    }
    table th{
        text-align: center
    }
</style>