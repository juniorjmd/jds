<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/"); 
?>
<link href="../css/dropdown/themes/default/helper.css" media="screen" rel="stylesheet" type="text/css" />
<link media="screen" rel="stylesheet" href="../css/container.css" />
<style type="text/css">
#listado li{ cursor:pointer; margin-left:10%}
#listado li:hover{ background-color: #80CDF7;cursor:pointer; }
.td-shadow{margin:-8px 0 0 -8px;padding:8px;background:#aaa url(http://v2es.sftcdn.net/shared/img/jqueryui/ui-bg_flat_0_aaaaaa_40x100.png) 50% 50% repeat-x;opacity:.30;filter:Alpha(Opacity=30);-moz-border-radius:8px;-webkit-border-radius:8px}

.td-shadow-blue{margin:-8px 0 0 -8px;padding:8px;background: #06C url(http://v2es.sftcdn.net/shared/img/jqueryui/ui-bg_flat_0_aaaaaa_40x100.png) 50% 50% repeat-x;opacity:.50;-moz-border-radius:8px;-webkit-border-radius:8px; color: #006}
</style>

<br /><br /><br />
<div align="center" style="width:100%; ">
<div  align="right" style="width:100%; " >

           <a href="javascript:window.history.back();"  style="margin-left:100px; " >atras</a>   </div>

<table    style="padding:20px; min-width:950px; width:70%;" >
<?php  


include 'db_conection.php';
$mysqli = cargarBD();
$query="SELECT  `idProducto` ,  `nombreProducto` ,  `totalCantidad` ,  `Pventa` , (".$_GET['sucId']."inventario.Pventa * ".$_GET['sucId']."inventario.totalCantidad) AS total FROM  `".$_GET['sucId']."inventario` ";
$result = $mysqli->query($query);
$result2=$mysqli->query($query);
$filas=$mysqli->affected_rows;
$tProductos=0;
$tUnidad=0;
$total=0;
if ($filas	>0){
while ($row = $result2->fetch_assoc()) {
$total=$total+$row['total'];
$tProductos=$tProductos+1;
$tUnidad=$tUnidad+$row['totalCantidad'];
}
setlocale(LC_MONETARY, 'en_US');
echo'
<tr ><td width="13%" class="">&nbsp;Fecha</td><td width="33%" class="td-shadow-blue" > '.date("D m/d/Y").'</td><td width="16%">&nbsp;Sucursal</td><td width="38%" class="td-shadow-blue"  >'.$_GET['nombreSuc'].'</td></tr><tr><td>&nbsp;</td></tr>
<tr ><td>&nbsp;T. productos</td><td  class="ui-widget-content"> '. $tProductos.'</td><td >&nbsp;T. unidades</td><td class="ui-widget-content">'. $tUnidad.'</td></tr><tr><td>&nbsp;</td></tr>
<tr ><td>&nbsp;Total P. venta</td><td class="ui-widget-content">'. $total.'</td><td>&nbsp;Total P. compra</td><td class="ui-widget-content">'. ($total/2).'</td></tr><tr><td>&nbsp;</td></tr>
</table>	';
}

if ($filas	>0){

echo "
<div align='center' style='width:100%'>
<table    class='ui-widget-header' cellpadding='10px' style='padding:20px; min-width:950px; width:70%;  '>
<tr  align='center'  ><td class='ui-widget-content'>idProducto</td><td>&nbsp;</td><td class='ui-widget-content'>NombreProducto</td><td>&nbsp;</td><td class='ui-widget-content'>Cantidad</td><td>&nbsp;</td><td class='ui-widget-content'>Pventa</td><td>&nbsp;</td><td class='ui-widget-content'>Total</td></tr><tr><td colspan='9'>&nbsp;</td></tr>";
while ($row = $result->fetch_assoc()) {

if(strstr($row['nombreProducto'],'Ã')){ // donde pone ? pon el caracter a buscar
$row['nombreProducto']=utf8_decode($row['nombreProducto']);
}
$total=$total+$row['total'];
echo "<tr><td >&nbsp;".$row['idProducto']."</td><td>&nbsp;</td><td>&nbsp;".$row['nombreProducto']."</td><td>&nbsp;</td><td>&nbsp;".$row['totalCantidad']."</td><td>&nbsp;</td><td>&nbsp;".$row['Pventa']."</td> <td>&nbsp;</td><td align='left'>&nbsp;".$row['total']."</td></tr>";
}
$result->free();
}else{echo"<li style='font-size:15px'>No se ha ingresado ningun articulo en el inventario asta la fecha... para ingresar presione aqui <a href='../ManejoInventario/entrada.php?sucursalId=".$_GET['sucId']."&nombreSuc=".$_GET['nombreSuc']."'>New Ingreso</a></li>";}
$datos["datos"]=$data;


?></table><br /><br /><br /></div></div>


