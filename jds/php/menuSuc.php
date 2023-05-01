<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/"); ?>
<li ><a  title="pagina principal"  class="menu1"     >Articulos<img src="imagenes/nav-arrow-down.png" /></a>
 		<ul> <li ><a  title="pagina principal"    class="menu1" target="framePrincipal"  href="articulos.php"  >Listado y Creacion</a></li>
		        <li ><a  title="pagina principal"   class="menu1"   target="framePrincipal"  href="grupos.php"  >Grupos</a></li>
        <li ><a  title="pagina principal"   class="menu1"   target="framePrincipal"  href="colores.php"s >Colores</a></li>
		  <li ><a  title="formas"   class="menu1"   target="framePrincipal"  href="formas.php" >Formas</a></li>
		</ul>
 
 </li>
 <li><a   class="menu1"   >Sucursales<img src="imagenes/nav-arrow-down.png"  /></a>
 <ul>	<li ><a  title="listado de sucursales y Creacion de nuevas"    class="menu1"   target="framePrincipal"  href="sucursales.php" >Nueva/Listado</a></li>
		<li ><a  title="movimientos"    class="menu1"   target="framePrincipal"  href="movimientos.php" >Movimientos</a></li>
<?php
include 'db_conection.php';
$mysqli = cargarBD();


$query="SELECT relacionusersuc.`id` , relacionusersuc.`idusuario` , relacionusersuc.`idsucursal` , relacionusersuc.`tiporelacion` , sucursales.`id_suc` , sucursales.`nombre_suc` , sucursales.`tel1` , sucursales.`tel2` , sucursales.`dir` , sucursales.`mail` , sucursales.`ciudad` , sucursales.`descripcion` , sucursales.`inventario` , sucursales.`salidas` , sucursales.`entradas` , sucursales.`ventas` , sucursales.`salidasimplicito` , sucursales.`entradasimplicito` , sucursales.`ventasimplicito` , sucursales.`entradastemp` , sucursales.`salidastemp` , sucursales.`ventastemp` 
FROM (
`relacionusersuc` ,  `sucursales`
)
WHERE relacionusersuc.idsucursal = sucursales.id_suc
AND relacionusersuc.`idusuario` =  '".$_SESSION["usuarioid"]."'";

$result = $mysqli->query($query);
$filas=$mysqli->affected_rows;
$recibido=0;
$pagado=0;


$result2 = $mysqli->query($query);
if ($filas	>0){
while ($row = $result->fetch_assoc()) {

if(strstr($row['nombre_suc'],'�')){ // donde pone ? pon el caracter a buscar
$row['nombre_suc']=utf8_decode($row['nombre_suc']);
}

echo"<li><a> ".$row['nombre_suc']."&nbsp;&nbsp;<img src='imagenes/nav-arrow-right' align='right'/></a>
<ul>	<li><a target='framePrincipal'  href='php/totalizarInv.php?sucId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."'   class='menu1'>Iventario</a></li>
		<li><a target='framePrincipal'  href='ManejoInventario/entrada.php?sucursalId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."' class='menu1' >Entradas</a></li>
		<li><a target='framePrincipal'  href='ManejoInventario/salida.php?sucursalId=".$row['id_suc']."&nombreSuc=".$row['nombre_suc']."' class='menu1' >Salidas</a></li>
			</ul>		
</li>";
}}
echo "</ul>";
$result->free();

?>
 <li ><a  title="Creacion y listado de proveedores"  class="menu1"   target='framePrincipal'  href="proveedores.php"  >Proveedores</a></li>
 <li ><a  title="pagina principal"         >Facturacion y Ventas</a>
 
 <?php echo "<ul>";
while ($row = $result2->fetch_assoc()) {
echo"<li><a target='framePrincipal'  href='ManejoInventario/facturacion.php?sucursalId=".$row['id_suc']."&ventaTemp=".$row['ventastemp']."&ventas=".$row['ventas']."&sucursal=".$row['nombre_suc']."' class='menu1' > ".$row['nombre_suc']."&nbsp;&nbsp;</a></li>";
}
echo "<ul>";

?> 


 </li>

		 