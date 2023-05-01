<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
 $conn= cargarBD();
if($_POST['insertar']=="si"){
if(substr($_POST['imagenGuardar'], -8)=="edit.jpg"){	
if(unlink($_POST['archivo'])){
$nombreAux='galerias/'.$_POST['codigo']."_picture".substr($_POST['imagenGuardar'], -4);
rename($_POST['imagenGuardar'],$nombreAux);
}}else{$nombreAux=$_POST['archivo'];}
if($_POST['cantidadAct']!="")
  $aux="`cantActual` =".$_POST['cantidad']." -  `entradas` -  `ventas` ,";

$stmt = $conn->stmt_init();
	$query="UPDATE  `producto` SET  
	`idGrupo` =  '".$_POST['idGrupo']."',
`Grupo` =  '".$_POST['Grupo']."',
`nombre` =  '".$_POST['nombre']."',
`precioVenta` =  '".$_POST['Pventa']."',
`precioCompra` =  '".$_POST['Pcompra']."',
`cantInicial` =  '".$_POST['cantidad']."', ".$aux."
`stock` =  '".$_POST['stock']."',`imagen` =  '".$nombreAux."' WHERE CONVERT(  `producto`.`idProducto` USING utf8 ) =  '".$_POST['codigo']."' LIMIT 1 ;";
//echo $query;
		$stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo crear la tabla de ingresos:' . $conn->error);
		break;
		}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el producto fue editado con exito!!!!!!!!!!!   </div><br><br>';
		echo'<script>
		setTimeout(function() {
        $(".content").fadeOut(1500);
		location.href="inventario.php";
    },2000);
		</script>';
		}
		}
$query2="SELECT * FROM  `producto` WHERE  `idProducto` =  '".$_POST['codigo']."'";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {
	$codigo=$row["idProducto"];
	$idGrupo=$row["idGrupo"];
    $nombre=$row["nombre"];
    $Pventa=$row["precioVenta"];
    $Pcompra=$row["precioCompra"];
    $cantidad=$row["cantInicial"];
    $stock=$row["stock"];
    $imagenGuardar=$row["imagen"];
	$CantAct=$row["cantActual"];
} }
$result->free();


$query2="SELECT * FROM `grupo`";
//echo $query2;
$result = $conn->query($query2);
$nomGrupo="";
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) {$select='';
	if($idGrupo==$row["idGrupo"]){$select="selected";$nomGrupo=$row["GRUPO"];}
	$grupos=$grupos.'<option  value="'.$row["idGrupo"].'" '.$select.' >'.$row["GRUPO"].'</option>';}
} 
$conn->close();
?>
<title>EDICION DE PRODUCTOS</title>
<style>
.articulo{ font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
.boton{ height:50px;}
.precarga {
    background:transparent url(imagenes/ajax-loader.gif) center no-repeat;
 }
</style>
<form action="editar.php" method="post" autocomplete="off" class="formulario">
<div align="center" style="width:100%">
<input type="hidden" name="insertar" id="insertar" value="si">
<input type="hidden" name="Grupo" id="Grupo" value="<?php echo $nomGrupo; ?>">
	
<table width="950" height="443" border="0" >
  <tr>
    <td height="45" colspan="7" align="center"><p>CREAR NUEVO PRODUCTO&nbsp;</p></td>
    </tr>
  <tr>
    <td width="80" rowspan="6">&nbsp;</td>
    <td width="146" height="46" align="right">CODIGO&nbsp;</td>
    <td colspan="2"><input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo; ?>"><?php echo $codigo; ?></td>
    <td colspan="2" rowspan="4"><div style="height:170; width:170" class="precarga">
   <input type="image" id="pictSelct" name="pictSelct" src="<?php echo $imagenGuardar;?>" height="170" width="170" style="margin-left:60px" ><input type="file" name="archivos[]" style="display:none" id="archivosUp"/>
    <input type="hidden" name="imagenGuardar" id="imagenGuardar" class="articulo" value="<?php echo $imagenGuardar;?>" >
    <input type="hidden" name="archivo" id="archivo" class="articulo" value="<?php echo $imagenGuardar;?>" >
   </div></td>
    <td width="56" rowspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td height="50" align="right">NOMBRE&nbsp;</td>
    <td colspan="2"><input type="text" name="nombre" id="nombre" value="<?php echo  $nombre;?>" class="articulo" ></td>
    </tr>
  <tr>
    <td height="62" align="right">CANTIDAD INICIAL&nbsp;</td>
    <td colspan="2"><input type="number" name="cantidad" id="cantidad" value="<?php echo  $cantidad;?>" class="articulo"> <input type="hidden" name="cantidadAct" id="cantidadAct"  value="<?php echo $cantidad;?>" ></td>
    </tr><tr>
    <td height="60" align="right">ESTOCK MINIMO&nbsp;</td>
    <td colspan="2"><input type="number" name="stock" id="stock" class="articulo"  value="<?php echo $stock;?>"></td>
    </tr><tr>
    <td height="39" align="right">CATEGORIA / GRUPO</td>
    <td width="286"><select name="idGrupo" id="idGrupo" class="articulo"><?php echo $grupos; ?></select></td>
    <td colspan="2" align="right">CANTIDAD ACTUAL</td>
    <td ><input type="number" name="Pcompra" id="Pcompra" disabled class="articulo" value="<?php echo $CantAct;?>"></td>
    </tr>
    <tr>
    <td height="36" align="right">PRECIO COMPRA</td>
    <td colspan="2"><input type="number" name="Pcompra" id="Pcompra" class="articulo" value="<?php echo $Pventa;?>"></td>
    <td width="113">PRECIO VENTA</td>
    <td width="240"><input type="number" name="Pventa" id="Pventa" class="articulo"  value="<?php echo $Pventa;?>"></td>
    </tr><tr>
    <td height="87" colspan="7" align="right"><blockquote>
      <blockquote>
        <blockquote>
          <p>
            <input type="submit" id="enviar" value="Editar" class="boton" > 
            <input type="button" id="cancelar" value="Cancelar" class="boton">
          </p>
        </blockquote>
      </blockquote>
    </blockquote></td>
    </tr>
</table></div></form>

