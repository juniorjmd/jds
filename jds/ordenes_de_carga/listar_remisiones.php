<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
$user = cargaDatosUsuarioActual();
include '../php/funcionesMysql.php';
$conn= cargarBD();
$alert = '';
 $ingreso = false ; 
   
 
    $query_inicial = "select a.* , ifnull(b.nombre1,'n/a')as nombre ,d.email, ifnull(b.apellido1,'n/a')as apellido , d.razonSocial , ".
	"d.nit , d.direccion , d.telefono ,ifnull(c.fecha_entrega,a.fecha)as fecha_de_entrega, ".
	" ifnull( c.cod_orden_externa, '') as cod_orden_externa ".
	"from remision_cabeza a ".
	"left join usuarios b on b.id = a.usuario ".
	"inner join remision_orden_de_compra c on a.orden_de_compra = c.id_orde ".
	"inner join clientes d on  d.nit COLLATE utf8_general_ci = c.id_cliente COLLATE utf8_general_ci order by 1" ;
    
    $result = $conn->query($query_inicial);
$num_datos = $conn->affected_rows;
$TABLA = '';
 //echo "$query_inicial---$num_datos";
if ($num_datos >= 1)
{
    while ($row = $result->fetch_assoc()) {
        /*
         * id_remision, orden_de_compra, cantidadVendida, valorParcial, descuento, valorIVA, valorTotal, 
         * fecha, hora, usuario, estado_remision, idVenta, fecha_entrega, dir_factura, nombre, email, apellido, 
         * razonSocial, nit, direccion, telefono, fecha_de_entrega, cod_orden_externa
         */
        $id_orden_compra =  $row["orden_de_compra"];
        $num_remision =  $row["num_remision"];
        $TABLA .= '<tr>' ; 
        $TABLA .="<td style = 'white-space: nowrap;'>{$row["id_remision"]}</td>"; 
        $TABLA .="<td style = 'white-space: nowrap;'>{$row["orden_de_compra"]}</td>"; 
        $TABLA .="<td style = 'white-space: nowrap;'>{$row["cod_orden_externa"]}</td>"; 
        $TABLA .="<td style = 'white-space: nowrap;'>{$row["razonSocial"]}</td>";  
        $TABLA .="<td style = 'white-space: nowrap;'>{$row["fecha"]}</td>";  
       /* $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["valorParcial"], 2)."</td>"; 
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["valorIVA"], 2)."</td>";
        $TABLA .="<td align='right' style'white-space: nowrap;'>$ ".number_format($row["descuento"], 2)."</td>";*/
        $TABLA .="<td align='right'  style = 'white-space: nowrap;'> ".$row["cantidadVendida"]."</td>";
        $TABLA .="<td align='right' style='white-space: nowrap;'>$ ".number_format($row["valorTotal"], 2)."&nbsp;&nbsp;</td>"; 
        $TABLA .="<td style = 'white-space: nowrap;'>{$row["fecha_entrega"]}</td>"; 
        $onclick = "window.open('".URL_BASE."/jds/printer_config/imprimir_remision.php?orden_de_compra={$id_orden_compra}&codigo_remision={$num_remision}','popup','width=600,height=500')";
        $TABLA .='<td align="right" ><a  onclick="'.$onclick.'" target="_blank" class="Estilo3" style="cursor:pointer">
            <img src="../imagenes/pdf.jpeg" width="23" height="23" border="0" title="Descargar factura"></a></td>';
        
        $TABLA .= '</tr>' ; 
    }
    
     
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
                
                <label>Listado de Remisiones.</label>
            </div></div>   
               
                <div class="row" style="width:100%"> 
                   <div class="col-md-12 col-sm-11">
                       
                       <table class="table">
                           <tr> 
                               <th  align='center' style = 'white-space: nowrap;'># remision</th>
                               <th   align='center' style = 'white-space: nowrap;'># Orden de compra</th>
                               <th   align='center' style = 'white-space: nowrap;'>Orden externa</th>                               
                               <th   align='center' style = 'white-space: nowrap;'>Razon social</th>                             
                               <th   align='center' style = 'white-space: nowrap;'>Fecha creacion</th> 
                               <th   align='center' style = 'white-space: nowrap;'>Cantidad</th>
                               <th   align='center' style = 'white-space: nowrap;'>Total</th>                                                         
                               <th   align='center' style = 'white-space: nowrap;'>Fecha entrega</th>
                               <th   align='center'></th>
                               
                           </tr>
                           <?php echo $TABLA;?>
                           
                           
                          
                       </table>
                </div></div>
               
               
            </div>
            
 

<input id='tabla_actual' value='remision_detalle' data-columna='id_remision_detalle' type='hidden'>
<input id='caption' value='remisiones' type='hidden'>
<input id="url_base_aplicacion"  type='hidden' value="<?php echo URL_BASE; ?>jds/" />
 
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