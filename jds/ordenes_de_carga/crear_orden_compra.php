<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
$user = cargaDatosUsuarioActual();
include '../php/funcionesMysql.php';
//print_r($user);

$conn= cargarBD();
$alert = '';
 $ingreso = false ;

if (isset($_POST['id_orden_externa'])  )
{    
$continuar = true; 
 if (trim($_POST['id_clientes'])=='')  
 {$alert = 'Debe seleccionar el proveedor dueño de la orden';
 $continuar = false;
 }else if (trim($_POST['id_orden_externa'])=='')  
 {$alert = 'Debe ingresar el id de la orden externa';
 $continuar = false;
 }else if (trim($_POST['fecha_de_cargue'])=='')  
 {$alert = 'Debe seleccionar la fecha para posible cargue';
 $continuar = false;
 }
  if ($continuar){
      
       $conexion =\Class_php\DataBase::getInstance();
       $link = $conexion->getLink();    
$fecha ="'".normalize_date($_POST["fecha_de_cargue"],"-")."'"; 
 //$fecha = $_POST['fecha_de_cargue'];
$stmt = $conn->stmt_init();
$query = "INSERT INTO `remision_orden_de_compra`
( `nom_usuario`,`usuario`,`fecha_creacion`,`fecha_entrega`,`id_cliente`,`cod_orden_externa`,`detalle` )
VALUES 
('{$user->getFullname()}',
'{$user->getId()}',
curdate(),
{$fecha},
'{$_POST['id_clientes']}',
'{$_POST['id_orden_externa']}',
'{$_POST['descripcion_o_c']}' ); ";
  //echo $query;
//$stmt->prepare($query);

$consulta = $link->prepare($query);
//if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
if(!$consulta->execute()){
   // throw new Exception('No se pudo ingresar la orden de compra :' . $conn->error);
    $alert = 'No se pudo ingresar la orden de compra :' . $conn->error;
}else{
    $ingreso = true ;
}
}
}

$query_orden_compra = "select * from vw_remision_orden_de_compra";
$result = $conn->query($query_orden_compra);
$num_datos = $conn->affected_rows;
$TABLA = '';
//echo "$query_orden_compra---$num_datos";
if ($num_datos >= 1)
{
 while ($row = $result->fetch_assoc()) {
	$TABLA .= '<tr>' ;
        $TABLA .="<td>{$row["razonSocial"]}</td>";
        $TABLA .="<td>{$row["cod_orden_externa"]}</td>";
        $TABLA .="<td>{$row["fecha_creacion_aux"]}</td>";
        $TABLA .="<td>{$row["fecha_entrega_aux"]}</td>";
        $TABLA .="<td>{$row["detalle"]}</td>";
        $TABLA .="<td>{$row["nom_usuario"]}</td>";
        $TABLA .="<td>{$row["nom_estado"]}</td>";
        $disable = '';
        if ($row["estado_orden"] != '1'){
            $disable = 'disabled';
        }
        if ($row["cod_factura"] =='')
        { 
        $TABLA .="<td><button  class='crear_remision' {$disable} data-orden_compra='{$row["id_orde"]}'>R</button></td>";
        $TABLA .="<td><button class='facturar_remision' {$disable} data-orden_compra='{$row["id_orde"]}'>F</button></td>";
        
        }else{
            
            $onclick = "window.open('".URL_BASE."jds/printer_config/reimpresion_facturas.php?IdVenta={$row["cod_factura"]}','popup','width=600,height=500')"; 
            $TABLA .= '<td><a  onclick="'.$onclick.'" target="_blank" class="Estilo3">
            <img src="../imagenes/pdf.jpeg" width="23" height="23" border="0" title="Descargar factura"></a></td>';
             $TABLA .="<td></td>";
        }
        
            
        $TABLA .= '</tr>' ;
 }
 $result->free();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
     <meta charset="utf-8" /> 
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
<script type="text/javascript" src="../jsFiles/funciones.js"></script>
<script type="text/javascript" src="../jsFiles/fullScreen.js"></script>
<script type="text/javascript" src="../jsFiles/ajax.js"></script>
<script type="text/javascript" src="../jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorContenidos.js"></script>

<link href="../../vendor/jquery_/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="../../vendor/jquery_/jquery-ui.js" type="text/javascript"></script>
 <link href="../../vendor/font-awesome/css/fontawesome-all.css" rel="stylesheet" type="text/css"/>
<link href="../../css/vistas.css" rel="stylesheet" type="text/css"/>
<script src="js/crear_orden_compra.js" type="text/javascript"></script> 
<style>
    table{
        font-size: 12px;
    }
</style>
</head>

    <body>
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
        
        
        <div class="container">
           <div class="row" style="width:100%"> <br>
            <div class="col-md-12 col-sm-12 text-center">
                
                <label>Ordenes de Compra.</label>
            </div>  
        <form action="crear_orden_compra.php" method="post" >
        <div class="row" style="width:100%">  
                              
            <div class="col-md-2 col-sm-11">
                
            </div>
            <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%"  > 
                                <label for="email" style="font-size: 11px;">Empresa:</label>
                                <?php //print_r($datos['datos']);    
                                    GENERAR_SELECT_DINAMICO('id_clientes', 'Empresa' , 'vw_clientes' , 'nit' , 'razonSocial',
                                            [ "clase" => "ordenCompra" ,"name" => "id_clientes","style" => array("MAX-WIDTH" => "200px" )],$id_clientes);                                
                                ?>
                            </div>
                        </div>
                    
                        <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Orden Externa:</label>
                                <input name="id_orden_externa" id="id_orden_externa" type="text" value="<?php echo $id_orden_externa;?>" class=" form-control"/>
                            </div>
                        </div>
             <div class="col-md-3 col-sm-11">
                            <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Fecha entrega:</label>
                                <input name="fecha_de_cargue" id="fecha_de_cargue" value="<?php echo $fecha_de_cargue;?>" data-title='Fecha estimada de recogida' class='fechaBusqueda form-control' readonly  />
                            </div>
                        </div>
                         </div>
               
               <div class="row" style="width:100%"> 
                   <div class="col-md-2 col-sm-11">
                
            </div>
                        <div class="col-md-9 col-sm-11">
                            <div style=" width: 100%"  >
                                <label for="email" style="font-size: 11px;">Descripcion:</label> 
                                <textarea name="descripcion_o_c" class='form-control' id="descripcion_o_c">
                                    <?php echo $descripcion_o_c;?> 
                                </textarea>
                            </div>
                        </div>
               </div>
                   <input id="submit_envio_datos" type="submit" style="display: none">
           </form> 
                <div class="row" style="width:100% ; margin-top: 10px ;margin-bottom:  10px"> 
                   <div class="col-md-12 col-sm-11 text-center">
                       <button id="enviar_datos" type="button" class="btn btn-success">Ingresar</button>&nbsp;&nbsp;&nbsp;<button id="limpiar_campos" type="button" class="btn btn-danger">Limpiar</button>
                </div></div>
                <div class="row" style="width:100%"> 
                   <div class="col-md-12 col-sm-11">
                       <div style="display:none">
                           <form action="crear_remision.php" method="POST"  >
                               <input type="submit" value="enviar" id="crear_remision"/>
                               <input type="hidden" name="id_orden_compra" id="orden_compra_remision" value=""/>
                           </form>
                           <form action="facturar_remisiones.php" method="POST"  >
                               <input type="submit" value="enviar" id="faturar_remision"/>
                               <input type="hidden" name="id_orden_compra" id="orden_compra_remision_factura" value=""/>
                           </form>
                           
                       </div>
                       <table class="table">
                           <tr> 
                               <th>Cliente</th>
                               <th>Orden de Compra</th>
                               <th>F. Creacion</th>
                               <th>F. Entrega</th>
                              
                               <th>Detalle</th>
                               <th>Us. Creador</th>
                               
                               <th>Estado</th>
                               <th> </th>
                               <th> </th>
                               
                           </tr>
                           <?php echo utf8_encode($TABLA);?>
                       </table>
                </div></div>
               
               
            </div>
        </div>
    </body> 
</html>
