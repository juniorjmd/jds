<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
$mysqli = cargarBD();
$query="SELECT relacionusersuc.`id` , relacionusersuc.`idusuario` , relacionusersuc.`idsucursal` , relacionusersuc.`tiporelacion` , sucursales.`id_suc` , sucursales.`nombre_suc` , sucursales.`tel1` , sucursales.`tel2` , sucursales.`dir` , sucursales.`mail` , sucursales.`ciudad` , sucursales.`descripcion` , sucursales.`inventario` , sucursales.`salidas` , sucursales.`entradas` , sucursales.`ventas` , sucursales.`salidasimplicito` , sucursales.`entradasimplicito` , sucursales.`ventasimplicito` , sucursales.`entradastemp` , sucursales.`salidastemp` , sucursales.`ventastemp` , permisosporsucursal.*
FROM (
`relacionusersuc` ,  `sucursales` ,  `permisosporsucursal`
)
WHERE relacionusersuc.idsucursal = sucursales.id_suc
AND permisosporsucursal.`idPermiso` = relacionusersuc.`tiporelacion` 
AND relacionusersuc.`idusuario` =  '".$_SESSION["usuarioid"]."'";

$result = $mysqli->query($query);
$filas=$mysqli->affected_rows;
if ($filas	>0){
while ($row = $result->fetch_assoc()) {

if(strstr($row['nombre_suc'],'�')){ // donde pone ? pon el caracter a buscar
$row['nombre_suc']=utf8_decode($row['nombre_suc']);
}

if(trim($row['entradas'])=="si"){
$entradas=$entradas."<li><a target='framePrincipal'  href='ManejoInventario/entrada.php?sucursalId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."' class='menu1' >".$row['nombre_suc']."</a></li>";
$auxcrearentradas++;
$entradasAux="<li><a target='framePrincipal'  href='ManejoInventario/entrada.php?sucursalId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."' class='menu1' >Entradas</a></li>";
}

if($row['salidas']=="si"){$salidas=$salidas."<li><a target='framePrincipal'  href='ManejoInventario/salida.php?sucursalId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."' class='menu1' >".$row['nombre_suc']."</a></li>";

$salidasAux="<li><a target='framePrincipal'  href='ManejoInventario/salida.php?sucursalId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."' class='menu1' >Salidas</a></li>";

$auxcrearsalidas++;
}

if($row['inventario']=="si"){$inventario=$inventario."<li><a target='framePrincipal'  href='php/totalizarInv.php?sucId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."'class='menu1'>".$row['nombre_suc']."</a></li>";
$auxcrearinventario++;
$inventarioAux=$inventarioAux."<li><a target='framePrincipal'  href='php/totalizarInv.php?sucId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."'class='menu1'>Inventario</a></li>";

}
if($row['crearfactura']=="si"){$crearfactura=$crearfactura."<li><a target='framePrincipal'  href='ManejoInventario/facturacion.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' > ".$row['nombre_suc']."&nbsp;&nbsp;</a></li>";
$auxcrearfactura++;
$crearfacturaAux="<li><a target='framePrincipal' title='realizacion de ventas y facturas' href='ManejoInventario/facturacion.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' >Nueva factura</a></li>";

}

if($row['verfacturas']=="si"){$verfacturas=$verfacturas."<li><a target='framePrincipal'  href='listarFacturas.php?sucursalId=".$row['id_suc']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' > ".$row['nombre_suc']."&nbsp;&nbsp;</a></li>";
$auxverfacturas++;
$verfacturasAux="<li><a target='framePrincipal' title='listado de ventas y facturas de ".$row['nombre_suc']."' href='listarFacturas?sucursalId=".$row['id_suc']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' >Listar Ventas</a></li>";

}

if($row['cierreCaja']=="si"){$cierreCaja=$cierreCaja."<li><a target='framePrincipal'  href='cierreCaja.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' > ".$row['nombre_suc']."&nbsp;&nbsp;</a></li>";
$auxcierreCaja++;
$cierreCajaAux="<li><a target='framePrincipal'  href='cierreCaja.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' >Cierre de caja</a></li>";
}

if($row['gastos']=="si"){$gastos=$gastos."<li><a target='framePrincipal'  href='gastos.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' > ".$row['nombre_suc']."&nbsp;&nbsp;</a></li>";
$auxgastos++;
$gastosAux="<li><a target='framePrincipal'  href='gastos.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' >Gastos</a></li>";
}

if($row['salidasEfectivo']=="si"){$salidasEfectivo=$salidasEfectivo."<li><a target='framePrincipal'  href='salidasEfectivo.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' > ".$row['nombre_suc']."&nbsp;&nbsp;</a></li>";
$auxsalidasEfectivo++;
$salidasEfectivoAux="<li><a target='framePrincipal'  href='salidasEfectivo.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' >Salidas de Efectivo</a></li>";
	}
}}
if($auxcrearentradas==1){$entradas=$entradasAux;}else{$entradas='<li ><a  title="Entradas de mercancias a cada sucursal por separado"  class="menu1" >Entradas</a> <ul>'.$entradas."</ul></li>";}


if($auxcrearsalidas==1){$salidas=$salidasAux;}else{$salidas='<li ><a  title="Salidas de mercancias a cada sucursal por separado" class="menu1" >Salidas</a> <ul>'.$salidas."</ul></li>";}

if($auxcrearinventario==1){$inventario=$inventarioAux;}else{$inventario='<li ><a  title="Inventarios de mercancias a cada sucursal por separado" class="menu1" >Inventarios</a> <ul>'.$inventario."</ul></li>";}


if($auxcierreCaja==1){$cierreCaja=$cierreCajaAux;}else{$cierreCaja='<li ><a  title="Toda la informacion concerniente a los cierre de caja diario"  class="menu1" >Cierres de caja</a> <ul>'.$cierreCaja."</ul></li>";}
if($auxgastos==1){$gastos=$gastosAux;}
else
{$gastos='<li ><a  title="gastos propios de la sucursal, como pago de servicios, nomina, ect... "   class="menu1"   target="framePrincipal"  href="gastos.php" >Gastos</a>
		  
		  <ul>'.$gastos.'</ul></li>';}

if($auxsalidasEfectivo==1){$salidasEfectivo=$salidasEfectivoAux;}else{$salidasEfectivo='<li ><a  title="salidas de dinero de cualquier tipo, consignacion, entregas de dinero, etc..."   class="menu1"  >Sal.en efectivo</a> <ul>'.$salidasEfectivo."</ul></li>";}

if($auxcrearfactura==1){$crearfactura=$crearfacturaAux;}else{
$crearfactura='<li ><a  title="realizacion de ventas y facturas"  class="menu1"      >Facturar</a><ul>'.$crearfactura."</ul></li>";}


if($auxverfacturas==1){$verfacturas=$verfacturasAux;}else{
$verfacturas='<li ><a  title="listado de ventas y facturas"  class="menu1"      >Listar Ventas</a><ul>'.$verfacturas."</ul></li>";}

if(trim($_SESSION["versucursal"])=="si"){
$sucursales='  <li ><a  title="listado de sucursales "    class="menu1"   target="framePrincipal"  href="listarSucursales.php" >Listado de sucursales</a></li>';
}
$result->free();
?>
 		 