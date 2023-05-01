<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
$user = cargaDatosUsuarioActual();
include '../php/funcionesMysql.php';
$conn= cargarBD(); 
$alert = '';
 $ingreso = false ; 
 $INPRESION = '';
 if (isset($_POST['cerrar_remision']) && $_POST['cerrar_remision'] == 'cerrar_remision')
 {
    $error_1 =  cerrar_remision($_POST , $conn);
    //$num_remision, $dev_id_orden_compra
   $INPRESION = "<script type='text/javascript' >"
           ."window.open('".URL_BASE."/jds/printer_config/imprimir_remision.php?orden_de_compra={$dev_id_orden_compra}&codigo_remision={$num_remision}','popup','width=600,height=500')"
           ."</script>";
    
    //$orden_de_compra,$codigo_remision;
     
 }
    
if (!isset($_POST['dev_id_orden_compra']) && !isset($_GET['num_orden_compra_aux']) ){
     header('Location: crear_orden_compra.php');
}else{
     if ( isset($_GET['num_orden_compra_aux']) ){        
        $dev_id_orden_compra = $_POST['dev_id_orden_compra'] = $_GET['num_orden_compra_aux'];
   
     }
    $query_inicial = " select * from vw_remision_orden_de_compra where id_orde =  '{$_POST['dev_id_orden_compra']}'" ;
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
    
    $query_cod_remision = " SELECT ifnull(max(num_remision),0) as cod_remision_actual FROM ".
            " remision_cabeza where orden_de_compra =  '{$_POST['dev_id_orden_compra']}' " ;
    $result = $conn->query($query_cod_remision);
    $num_datos = $conn->affected_rows;
 
//echo "$query_orden_compra---$num_datos";
    $num_remision = 0;
if ($num_datos >= 1)
   {
    while ($row_2 = $result->fetch_assoc()) {
        $num_remision = $row_2['cod_remision_actual'];
        }

    }
 if(isset($_GET['dev_id_remision'])){
     $num_remision = $_GET['dev_id_remision'];
 }else{
     $num_remision = $_POST['dev_id_remision'];
 }
 if(isset($_GET['alert_1'])){
 $alert_1 = $_GET['alert_1'];}
 
}else{    
     header('Location: crear_orden_compra.php');
}
}
 
if (isset($_POST['ingreso_solicitud'])  )
{
  $alert =  ingresar_producto_remision($_POST , $conn);
  if ($alert == ''){
      header("Location: devolucion_remision.php?num_orden_compra_aux={$_POST['dev_id_orden_compra']}");
  }
}
/*SELECT id_registro_int , id_registro_dec FROM `aux_tabla_parametros`
where  `cod_duenio_registros` = 'REMISION' ;*/
$query_orden_compra = "select * from vw_remision_detalle where id_remision = '{$num_remision}' and id_orden_compra = '{$dev_id_orden_compra}'";
$result = $conn->query($query_orden_compra);
$num_datos = $conn->affected_rows;

$TABLA .= "<input type='hidden' name='num_remision'   value='{$num_remision}'    />";
$TABLA .= "<input type='hidden'   name='dev_id_orden_compra'   value='{$dev_id_orden_compra}'    />";
//echo "$query_orden_compra---$num_datos";

        $subTotal = $total = $IVA = 0;
if ($num_datos >= 1)
{$i=0;
 while ($row = $result->fetch_assoc()) {
     $row["nombreProducto"] =  modificaCaracteres( $row["nombreProducto"] );
         
	$TABLA .= '<tr>' ; 
        
        $TABLA .="<td></td>";
        $TABLA .="<td>{$row["id_producto"]}</td>";
        $TABLA .="<td>{$row["nombreProducto"]}</td>";
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["presioSinIVa"], 2)."</td>";
        $TABLA .="<td align='right'> ".$row["porcent_iva"]."%</td>";
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["IVA"], 2)."</td>";
        $TABLA .="<td align='right'> ".$row["cantidadVendida"]."</td>";
        
        $TABLA .="<td align='right'> ".$row["cant_max_devol"]."</td>";
        $TABLA .="<td align='right'> <input type='text' onkeypress='' name='PRO_REMISION[$i][newcnt]' class='inp_dev' value='0'  data-max='".$row["cant_max_devol"]."' /></td>";
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["valorTotal"], 2)."&nbsp;&nbsp;</td>";     
        $TABLA .= "<input type='hidden'   name='PRO_REMISION[$i][id_rem_det]'   value='{$row["id_remision_detalle"]}'    />";
        $TABLA .= '</tr>' ;
        //return NumCheck(event, this)
        $subTotal=  $subTotal + $row["valorTotal"];
        $IVA += $row["iva"];
        $i++;
}
$total = $subTotal + $IVA;
  
 $result->free(); 
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
<script src="js/devolucion_remision.js" type="text/javascript"></script> 
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
               <form action="finalizar_devolucion_remision.php" method="post" >
        <div class="row" style="width:100%">  
                              
            <div class="col-md-2 col-sm-11">
                 <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Orden Compra :</label>
                                <?php //print_r($datos['datos']);   
                                   echo $dev_id_orden_compra;                               
                                ?>
                                <input type="hidden" value="<?php  echo $dev_id_orden_compra; ?>" name="id_orden_compra" />
                            </div>
            </div>
                    
                        <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Orden Externa:</label>
                            <?php echo  $cod_orden_externa;?> </div>
                        </div>
            <div class="col-md-2 col-sm-11">
                       <label for="email" style="font-size: 11px;">Numero Remision:</label>
                                <?php //print_r($datos['datos']);   
                                   echo "$num_remision"      ;                         
                                ?>
                                <input type="hidden" value="<?php  echo $num_remision; ?>" name="num_remision" />
            </div>
            <div class="col-md-4 col-sm-11">
                            <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Empresa:</label>
                                <?php //print_r($datos['datos']);   
                                   echo "$nit / $razonSocial"      ;                         
                                ?>
                            </div>
                        </div>
             
                         </div>  
                   <div style="display: none"><input id="submit_envio_datos" type="submit" ></div>
                   
       
               
                <div class="row" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                   <div class="col-md-12 col-sm-11 text-center">
                       <button id="enviar_devolucion" type="button" class="btn btn-success">Ingresar</button>&nbsp;&nbsp;&nbsp; 
                       <a href="crear_orden_compra.php">
                       <button  type="button" class="btn btn-primary" id="">Regresar</button></a> 
                </div></div>
                <div class="row" style="width:100%"> 
                   <div class="col-md-12 col-sm-11">
                       
                       <table class="table">
                           <tr> 
                               <th></th>
                               <th  align='center'>Codigo</th>
                               <th   align='center'>Nombre/Descripción</th>
                               <th   align='center'>Precio</th>
                               <th   align='center'>%Iva</th>
                               <th   align='center'>Iva</th>
                               <th   align='center'>Cantidad</th>
                               <th   align='center'>Cant max devolver</th>
                               <th   align='center'>Total</th>
                               
                           </tr>
                           <?php echo $TABLA;?>
                           
                           
                           <tr> 
                               <td colspan="6"> </td>
                               <td>Sub Total</td>
                               <td  style=" text-align: right"><?php echo "$ ".number_format($subTotal,2);?></td>
                               
                           </tr>
                           <tr> 
                               <td colspan="6"> </td>
                               <td>IVA</td>
                               <td  style=" text-align: right"><?php echo "$ ".number_format($IVA,2);?></td>
                               
                           </tr>
                           <tr> 
                               <td colspan="6"> </td>
                               <td>Total</td>
                               <td style=" text-align: right"><?php echo "$ ".number_format($total,2);?></td>
                               
                           </tr>
                           
                           
                           
                       </table>
                </div></div>
                   </form> 
               
            </div>
            
<!--busqueda de productos-->

<div style="display:none" width="100%">
    <div id="busquedaArticulo"  width="100%" style="height:100%" >Buscar<input name="text" type="text" class="busquedas" width="400" 
                                                                               data-url_php="<?php echo URL_BASE."jds/php/db_listar.php"; ?>" 
                                                                               data-invoker='articulos' />
 <input type="hidden" id="respuestaArticulo" />
 <input type="hidden" id="gridID" />
            <table border="0" id="Tablacolor" width="695"><tr><td>
             <table  border="0" id="listarTablaproducto" bordercolor="#71D8E3"  width="100%"    >
		  <tr  id="cabPac" align="center"   class="ui-widget-header">
	        <td width="70"  >CODIGO</td>
		    <td width="400"  >NOMBRE/DESCRIPCION</td>
			<td   width="70">PRECIO</td>		
      </tr><tr><td colspan="3">
      <span id=""></span>
      </td></tr>
    </table> </td></tr><tr><td>
		
      <div align="center" id="tablasListaproducto" ></div>    
     <div align="center" id="indiceListaproducto" ></div>
       </td></tr></table>
     </div>
</div>
<!--busqueda de productos-->
<!--listas de medidas por producto-->
<div class="container" id="medidas">
      <div class="row" style="width:100%">  
                <div class="col-md-12 col-sm-12 text-center">
                
                <label>listado de medidas por producto.</label>
            </div></div> 
    
       <div class="row" style="width:100%"> 
           <div class="col-md-2 col-sm-12 text-center">
                        <label for="email" style="font-size: 11px;">Cantidad :</label>
                        <input type="text" id="cantTranformada" class="form-control" name="cantTranformada"    >
           </div>
            <div class="col-md-2 col-sm-12 text-center">
                        <label for="email" style="font-size: 11px;">nombre :</label>
                        <input type="text" id="aux_nombre_venta" class="form-control" readonly="" name="aux_nombre_venta"    >
           </div>
           <div class="col-md-2 col-sm-12 text-center">
               <button class="btn btn-success" id="ingreso_medidas">Ingresar</button>
            </div>
           <div class="col-md-2 col-sm-12 text-center">
               <button class="btn btn-warning" id="cancelar_ing_transf">Cancelar</button>
            </div>
       </div>
     <div class="row" style="width:100%"  >
                <table style="width:100%"><tr>
                         <td style="    text-align: left;"><button class="flechas_medidas" data-movimiento="atras" data-numero="1">&lt;&lt;</button></td>
                         <td style="    text-align: -webkit-center;"><span class="contador_contenedores">1</span></td>
                         <td style=" text-align: right; "><button class="flechas_medidas" data-movimiento="adelante" data-numero="1">&gt;&gt;</button></td>
                     </tr></table>
            </div> 
           <div class="row" style="width:100%" id="cont_lista_medidas">
                
            </div>  
            
    
</div>

<!--listas de medidas por producto-->


<input id='tabla_actual' value='remision_detalle' data-columna='id_remision_detalle' type='hidden'>
<input id='caption' value='remisiones' type='hidden'>
<input id="url_base_aplicacion"  type='hidden' value="<?php echo URL_BASE; ?>jds/" />
<div style="display:none">
<form action="devolucion_remision.php" method="post" >
                                <input type="hidden" value="<?php  echo $dev_id_orden_compra; ?>" name="id_orden_compra" />
                                <input type="hidden" value="cerrar_remision" name="cerrar_remision" />
                                 <input type="hidden" value="<?php  echo $num_remision; ?>" name="num_remision" />
                                 <input type="hidden" value="<?php  echo $user->getId(); ?>" name="usuario" />
                                 
                                 <input type="submit" id="enviar_cierre_remision">
</form>
</div>
<?php echo $INPRESION; ?>
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