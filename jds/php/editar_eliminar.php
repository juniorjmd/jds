<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php'; 

$conn= cargarBD();
$tabla=$_POST["tabla"];
$columna=$_POST["columna"];
$dato=$_POST["dato"];
//echo $_POST["llamado"];
//4208254
$llamado=$_POST["respuesta"];
switch ($llamado) {

case "cambioCliente":
$idColumna=$_POST["idColumna"];
$dato=$_POST["dato"];
$tabla=$_POST["tabla"];
$columna1=$_POST["columna1"];
$identificador=$_POST["identificador"];
$nombreCambiar=$_POST["nombreCambiar"];
$query="UPDATE `".$tabla."` SET  `".$columna1."` =  '".$identificador."',`".$columna2."` =  '".$nombreCambiar."' WHERE  `".$idColumna."` =".$dato." ;";//echo $query;	 
break;

case "edicionProveedor":
 $query=" UPDATE `".$tabla."` SET
`razonSocial` =' ".$_POST["razonSocial"]."',
`email` =' ".$_POST["email"]."',
`telefono` = '".$_POST["telefono"]."',
`telefonoCelular` = '".$_POST["celular"]."',
`observaciones` = '".$_POST["observacion"]."' 
WHERE CONVERT( `".$tabla."`.`".$columna."` USING utf8 ) = '".$_POST["cedula"]."' LIMIT 1 ";
break;	

case "sucursales":
 $query=" UPDATE `".$tabla."` SET
`nombre_suc` ='".$_POST["nombre_suc"]."',
`tel1` ='".$_POST["telefono"]."',
`tel2` = '".$_POST["celular"]."',
`dir` ='".$_POST["direccion"]."',
`mail` = '".$_POST["email"]."',
`ciudad` = '".$_POST["ciudad"]."',
`descripcion` = '".$_POST["observaciones"]."'
WHERE CONVERT( `".$tabla."`.`".$columna."` USING utf8 ) = '".$_POST["IdSucursalM"]."' LIMIT 1 ";
break;	

case "articulo":
 $query=" UPDATE `".$tabla."` SET
`nombre` ='".$_POST["nombre_ArtEd"]."',
`descripcion1` ='".$_POST["describe1Ed"]."',
`descripcion2` ='".$_POST["Describe2Ed"]."',
`presioVenta` = '".$_POST["presioVentaEd"]."',
`presioCompra` ='".$_POST["presioCompraEd"]."',
`proveedor` = '".$_POST["proveedorEd"]."',
`proveedor2` = '".$_POST["proveedor2Ed"]."',
`presentacion` = '".$_POST["presentacionEd"]."'
WHERE CONVERT( `".$tabla."`.`".$columna."` USING utf8 ) = '".$_POST["IdArticu"]."' LIMIT 1 ";

break;	

case "cliente":
 $query=" UPDATE `".$tabla."` SET
`nit` ='".$_POST["Nit"]."',
`nombre` ='".$_POST["nombre"]."',
`razonSocial` ='".$_POST["Rsocial"]."',
`direccion` ='".$_POST["direccion"]."',
`telefono` = '".$_POST["telefono"]."',
`email` ='".$_POST["email"]."'
WHERE CONVERT( `".$tabla."`.`".$columna."` USING utf8 ) = '".$_POST["IdClienteM"]."' LIMIT 1 ";

break;	

case "EliminaSucursal":
/////////////////////////////////////////////////////////////////
$mysqli = cargarBD();
 
$mysqli->close();
/////////////////////////////////////////////////////////////////
$query= "DELETE  FROM ".$tabla." WHERE `".$columna."` = '".$dato."'";
break;	

case "EliminaCliente":
/////////////////////////////////////////////////////////////////
$mysqli = cargarBD();
 
$mysqli->close();
/////////////////////////////////////////////////////////////////
$query= "DELETE  FROM ".$tabla." WHERE `".$columna."` = '".$dato."'";
break;	

case "EliminaArt":
/////////////////////////////////////////////////////////////////
$mysqli = cargarBD();
 
$mysqli->close();
/////////////////////////////////////////////////////////////////
$query= "DELETE  FROM ".$tabla." WHERE `".$columna."` = '".$dato."'";
break;	
}
//echo $query;
	if(!$conn->query($query)){
		//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo editar:' . $conn->error);
	}
	else{echo("los datos han sido modificados con exito");
	
	if ($llamado=="EliminaSucursal"){
	$query="DROP TABLE `".$dato."entradas` ,
`".$dato."entradasimplicito` ,
`".$dato."entradastemp` ,
`".$dato."inventario` ,
`".$dato."salidas` ,
`".$dato."salidasimplicito` ,
`".$dato."salidastemp` ,
`".$dato."ventas` ,
`".$dato."ventasimplicito` ,
`".$dato."ventastemp` ;";
//echo $query;
$query2= "DELETE  FROM relacionusersuc WHERE `idsucursal` = '".$dato."'";

if(!$conn->query($query)){
		//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo eliminar:' . $conn->error);
	}
	else{echo("las tablas han sido eliminadas con exito");
	$conn->query($query2);
	}
	
	}
	
	}

$conn->close();
?>
