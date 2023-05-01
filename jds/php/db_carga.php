<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php';
include 'funcionesMysql.php';
$yaSeHizo="1";
$conn= cargarBD();
 $conexion =\Class_php\DataBase::getInstance();
 
 $link = $conexion->getLink(); 
 $link2 = $conexion->getLink();   
 
$stmt = $conn->stmt_init();
$stmt2 = $conn->stmt_init();
$query=$_POST["query"];
$consulta = $link->prepare($query);
//$stmt->prepare($query);
//!$consulta->execute()
//$link2->errorCode()
//$link->errorCode()
$llamado=$_POST["respuesta"];
$i=0;
switch ($llamado) {

case "nuevaSuc":
$_uno =$_POST["IdSucursal"]; 
$_dos =$_POST["nombre_suc"]; 
$_cinco =$_POST["direccion"]; 
$_seis =$_POST["email"]; 
$_tres =$_POST["telefono"]; 
$_cuatro =$_POST["celular"]; 
$_siete=$_POST["ciudad"];
$_ocho =$_POST["observaciones"]; 
$_nueve =$_uno."inventario"; 
$_diez =$_uno."salidas"; 
$_once=$_uno."entradas";
$_doce =$_uno."ventas";
$_trece =$_uno."salidasimplicito";
$_catorce =$_uno."entradasimplicito";
$_quince =$_uno."ventasimplicito";
$_16 =$_uno."entradastemp";
$_17 =$_uno."salidastemp";
$_18 =$_uno."ventastemp";
//$stmt->bind_param('ssssssssssssssssss',$_uno,$_dos,$_tres,$_cuatro,$_cinco,$_seis,$_siete,$_ocho,$_nueve,$_diez,$_once,$_doce,$_trece,$_catorce,$_quince,$_16,$_17,$_18); // 'is' pues el primer dato es 'int' y el segundo es 'string'
$consulta->bindParam('ssssssssssssssssss',$_uno,$_dos,$_tres,$_cuatro,$_cinco,$_seis,$_siete,$_ocho,$_nueve,$_diez,$_once,$_doce,$_trece,$_catorce,$_quince,$_16,$_17,$_18); // 'is' pues el primer dato es 'int' y el segundo es 'string'

//entradas
$query1="CREATE TABLE `".$_once."`(
  `codEntrada` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `totalArticulos` int(11) NOT NULL,
  `codOrigen` varchar(150) NOT NULL,
  `origen` varchar(150) NOT NULL,
  `destino` varchar(150) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  PRIMARY KEY  (`codEntrada`),
  KEY `codOrigen` (`codOrigen`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

";
$consulta2 = $link2->prepare($query1); 
//$stmt2->prepare($query1);
//!$consulta->execute()
if(!$consulta2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de ingresos:' . $link2->errorCode());
break;
}
//salidas
$query1="CREATE TABLE `".$_diez."` (
  `codSalida` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `totalArticulos` int(11) NOT NULL,
  `codDestino` varchar(150) NOT NULL,
  `origen` varchar(150) NOT NULL,
  `destino` varchar(150) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  PRIMARY KEY  (`codSalida`),
  KEY `codDestino` (`codDestino`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de salidas:' . $conn->error);
break;
}	
//entradas implicito
$query1="CREATE TABLE `".$_catorce."`(
  `codEntrada` int(11) NOT NULL,
  `codProducto` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `cantidad` varchar(10) NOT NULL,
  `Pventa`  DOUBLE NOT NULL,
  `codOrigen` varchar(150) NOT NULL,
  `origen` varchar(150) NOT NULL,
  `destino` varchar(150) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  KEY `codProducto` (`codProducto`),
  KEY `codProducto_2` (`codProducto`),
  KEY `codProducto_3` (`codProducto`),
  KEY `codOrigen` (`codOrigen`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de ingresos:' . $conn->error);
break;
}

//entradas temp
$query1="CREATE TABLE `".$_16."` (
  `codEntrada` int(11) NOT NULL,
  `codProducto` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `cantidad` varchar(10) NOT NULL,
  `Pventa`  DOUBLE NOT NULL,
  `codOrigen` varchar(150) NOT NULL,
  `origen` varchar(150) NOT NULL,
  `destino` varchar(150) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  KEY `codOrigen` (`codOrigen`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de ingresos:' . $conn->error);
break;
}

//salidas implicito
$query1="CREATE TABLE `".$_trece."` (
  `codSalida` int(11) NOT NULL,
  `codProducto` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `cantidad` varchar(10) NOT NULL,
  `Pventa`  DOUBLE NOT NULL,
  `codDestino` varchar(150) NOT NULL,
  `origen` varchar(150) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `destino` varchar(150) NOT NULL,
  KEY `codDestino` (`codDestino`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de salidas implicito:' . $conn->error);
break;
}
//salidas temp
$query1="CREATE TABLE `".$_17."`(
  `codSalida` int(11) NOT NULL,
  `codProducto` varchar(10) NOT NULL,
  `fecha` date NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `cantidad` varchar(10) NOT NULL,
  `Pventa`  DOUBLE NOT NULL,
  `codDestino` varchar(150) NOT NULL,
  `origen` varchar(150) NOT NULL,
  `destino` varchar(150) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  KEY `codDestino` (`codDestino`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de salidas temp:' . $conn->error);
break;
}

//inventario
$query1="CREATE TABLE `".$_nueve."` (
  `idProducto` varchar(10) NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `salidas` int(11) NOT NULL,
  `entradas` int(11) NOT NULL,
  `ventas` int(11) NOT NULL,
  `totalCantidad` int(11) NOT NULL,
  `Pventa` double NOT NULL,
  `usuario` varchar(150) NOT NULL,
  PRIMARY KEY  (`idProducto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
  //echo $query1;
$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de ingresos:' . $conn->error);
break;
}

//ventas
$query1="CREATE TABLE `".$_doce."`(
  `idVenta` int(11) NOT NULL auto_increment,
  `cliente` varchar(100) NOT NULL default 'venta general del dia',
  `idCliente` varchar(100) NOT NULL,
  `cantidadVendida` varchar(50) NOT NULL,
  `valorParcial`  DOUBLE NOT NULL,
  `descuento`  DOUBLE NOT NULL,
  `valorTotal`  DOUBLE NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `estado` varchar(20) NOT NULL default 'activo',
  `idCierre` varchar(20) NOT NULL,
  PRIMARY KEY  (`idVenta`),
  KEY `idCliente` (`idCliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
  //echo $query1;
$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de ventas:' . $conn->error);
break;
}


//ventatemp
$query1="CREATE TABLE `".$_18."`(
  `idLinea` int(11) NOT NULL auto_increment,
  `idVenta` varchar(10) NOT NULL,
  `idProducto` varchar(10) NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `presioVenta` varchar(10) NOT NULL,
  `cantidadVendida` varchar(10) NOT NULL,
  `descuento` varchar(10) NOT NULL,
  `valorTotal` varchar(10) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  `idCliente` varchar(100) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  PRIMARY KEY  (`idLinea`),
  KEY `idCliente` (`idCliente`,`cliente`),
  KEY `idCliente_2` (`idCliente`,`cliente`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
  //echo $query1;
$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de ventas temp:' . $conn->error);
break;
}

//ventas impl
$query1="CREATE TABLE `".$_quince."`(
  `idLinea` int(11) NOT NULL auto_increment,
  `idVenta` varchar(10) NOT NULL,
  `idProducto` varchar(10) NOT NULL,
  `nombreProducto` varchar(100) NOT NULL,
  `presioVenta` varchar(10) NOT NULL,
  `cantidadVendida` varchar(10) NOT NULL,
  `descuento` varchar(10) NOT NULL,
  `valorTotal` varchar(10) NOT NULL,
  `usuario` varchar(150) NOT NULL,
  `fecha` date NOT NULL,
  `idCliente` varchar(100) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  PRIMARY KEY  (`idLinea`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
  //echo $query1;
$stmt2->prepare($query1);
if(!$stmt2->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de ventas implicito:' . $conn->error);
break;

}//sucursal nueva con todas sus tablas

break;	
case "nuevoArticulo" :
$_uno =$_POST["IdArticulo"]; 
$_dos =$_POST["nombre_Art"]; 
$_tres =$_POST["describe1"]; 
$_cuatro =$_POST["Describe2"]; 
$_cinco =$_POST["cantidad"]; 
$_seis =$_POST["presioVenta"]; 
$_siete=$_POST["presioCompra"];
$_ocho =$_POST["proveedor"]; 
$_nueve =$_POST["grupo"];
$_diez =$_POST["proveedor2"];
$_once=$_POST["present"];
$_doce =$_POST["color"];
$_trece =$_POST["forma"];
$_catorce =$_POST["Tamanio"];
//$stmt->bind_param('ssssssssssssss',$_uno,$_dos,$_tres,$_cuatro,$_cinco,$_seis,$_siete,$_ocho,$_nueve,$_diez,$_once,$_doce,$_trece,$_catorce); // 'is' pues el primer dato es 'int' y el segundo es 'string'
$consulta->bindParam('ssssssssssssss',$_uno,$_dos,$_tres,$_cuatro,$_cinco,$_seis,$_siete,$_ocho,$_nueve,$_diez,$_once,$_doce,$_trece,$_catorce); // 'is' pues el primer dato es 'int' y el segundo es 'string'
break;	

case "nuevoGrupo" :
$_uno =$_POST["idGrupo"]; 
$_dos =$_POST["NombreGrupo"]; 
$_tres =$_POST["descrip1"]; 
$_cuatro =$_POST["descrip2"]; 
//$stmt->bind_param('ssss',$_uno,$_dos,$_tres,$_cuatro); // 'is' pues el primer dato es 'int' y el segundo es 'string'
$consulta->bindParam('ssss',$_uno,$_dos,$_tres,$_cuatro); // 'is' pues el primer dato es 'int' y el segundo es 'string'
break;

case "nuevoForma" :
$_uno =$_POST["idArticulo"]; 
$_dos =$_POST["NombreArticulo"]; 
$_tres =$_POST["descrip1"]; 

$consulta->bindParam('sss',$_uno,$_dos,$_tres); // 'is' pues el primer dato es 'int' y el segundo es 'string'
break;

case "nuevoCli" :
    /*"idCliente=0028&Nnombre=jose%20dominguez&nit=84455110&NrazonSocial=jose%20dominguez&email=&telefono=&direccion=&respuesta=nuevoCli&query=INSERT%20INTO%20%60proveedores%60%20VALUES%20(%3F%2C%3F%2C%3F%2C%3F%2C%3F%2C%3F%2C%3F)&nocache=0.37491692392526144"*/
$_uno =$_POST["idCliente"]; 
$_dos = $_POST["nit"];
$_tres = $_POST["Nnombre"];
$_cuatro =$_POST["NrazonSocial"]; 
$_cinco = $_POST["direccion"];
$_seis =$_POST["telefono"]; 
$_siete=$_POST["email"];
$consulta->bindParam('sssssss',$_uno,$_dos,$_tres,$_cuatro,$_cinco,$_seis,$_siete); // 'is' pues el primer dato es 'int' y el segundo es 'string'
break;	
case 'nuevoCliente':
        /*"idCliente=0028&Nnombre=jose%20dominguez&nit=84455110&NrazonSocial=jose%20dominguez&email=&telefono=&direccion=&respuesta=nuevoCli&query=INSERT%20INTO%20%60proveedores%60%20VALUES%20(%3F%2C%3F%2C%3F%2C%3F%2C%3F%2C%3F%2C%3F)&nocache=0.37491692392526144"*/
$_uno =$_POST["idCliente"]; 
$_dos = $_POST["nit"];
$_tres = $_POST["Nnombre"];
$_cuatro =$_POST["NrazonSocial"]; 
$_cinco = $_POST["direccion"];
$_seis =$_POST["telefono"]; 
$_siete=$_POST["email"]; // 'is' pues el primer dato es 'int' y el segundo es 'string'

$query = "insert into clientes VALUES ( '$_uno','$_dos', '$_tres' ,"
        . "'$_cuatro' , '$_cinco' ,'$_seis','$_siete')";

$consulta = $link->prepare($query);
break;
case 'nuevoProvedor':
        /*"idCliente=0028&Nnombre=jose%20dominguez&nit=84455110&NrazonSocial=jose%20dominguez&email=&telefono=&direccion=&respuesta=nuevoCli&query=INSERT%20INTO%20%60proveedores%60%20VALUES%20(%3F%2C%3F%2C%3F%2C%3F%2C%3F%2C%3F%2C%3F)&nocache=0.37491692392526144"*/
$_uno =$_POST["idCliente"]; 
$_dos = $_POST["nit"];
$_tres = $_POST["Nnombre"];
$_cuatro =$_POST["NrazonSocial"]; 
$_cinco = $_POST["direccion"];
$_seis =$_POST["telefono"]; 
$_siete=$_POST["email"]; // 'is' pues el primer dato es 'int' y el segundo es 'string'

$query = "insert into proveedores VALUES ( '$_uno','$_dos', '$_tres' ,"
        . "'$_cuatro' , '$_cinco' ,'$_seis','$_siete')";

$consulta = $link->prepare($query);
break;
case "nuevoColores" :
$_uno =$_POST["idColores"]; 
$_dos =$_POST["NombreColores"]; 
$_tres =$_POST["descrip1"]; 
$consulta->bindParam('ssss',$_uno,$_dos,$_dos,$_tres); // 'is' pues el primer dato es 'int' y el segundo es 'string'
break;


case "nuevoAbonoCredito":
$date=$_POST["fecha"];
$fecha =normalize_date($date,"-"); 
$query="INSERT INTO  `abonoscredito` (
`idAbono` ,
`idCliente` ,
`idFactura` ,
`valorAbono` ,
`fecha`
)
VALUES ('".$_POST["idAbono"]."', '".$_POST["cliente"]."', '".$_POST["cuenta"]."', '".$_POST["valorAbono"]."', '".$fecha."');";

$query2="UPDATE  `credito` SET `TotalActual` = TotalActual - '".$_POST["valorAbono"]."' WHERE `credito`.`idCuenta` ='".$_POST["cuenta"]."' LIMIT 1 ;";


$mysqli = cargarBD();
$mysqli->query($query2);
//$stmt->prepare($query);


$consulta = $link->prepare($query);
break;	



case "nuevoAbono":
$date=$_POST["fecha"];
$fecha =normalize_date($date,"-"); 
$query="INSERT INTO  `abonoscartera` (
`idAbono` ,
`idCliente` ,
`idFactura` ,
`valorAbono` ,
`fecha`
)
VALUES ('".$_POST["idAbono"]."', '".$_POST["cliente"]."', '".$_POST["cuenta"]."', '".$_POST["valorAbono"]."', '".$fecha."');";
//echo $query;
$query2="UPDATE  `cartera` SET `TotalActual` = TotalActual - '".$_POST["valorAbono"]."' WHERE `cartera`.`idCuenta` = '".$_POST["cuenta"]."' LIMIT 1 ;";
$mysqli = cargarBD();
$mysqli->query($query2);
$consulta = $link->prepare($query);
break;	
case "nuevaCredito":
$date=$_POST["dataLabel"];
$fecha1 =normalize_date($date,"-"); 
if($_POST["DescripcionCredito"]==""){$auxObservacion="articulos varios";}else{$auxObservacion=$_POST["DescripcionCredito"];}

$_POST["codigoProveedor"] = trim($_POST["codigoProveedor"]);
$query="
INSERT INTO  `credito` (
`idCartera` ,
`idCuenta` ,
`descripcion` ,
`idCliente` ,
`nombre` ,
`fechaIngreso` ,
`valorInicial` ,
`abonoInicial` ,
`TotalInicial` ,
`numCuotas` ,
`intervalo` ,
`valorCuota` ,
`TotalActual`
)
VALUES ( '".$_POST["labeIDcartera"]."', '".$_POST["codigoProveedor"]."_".$_POST["labeIDcartera"]."', '".$auxObservacion."', '".$_POST["codigoProveedor"]."','".$_POST["razonSocial"]."', '".$fecha1."', '".$_POST["valCredito"]."', '".$_POST["abonoInicialCredito"]."', '".$_POST["totalDeudaCredito"]."', '".$_POST["numeroCuotasCredito"]."', '".$_POST["intervalosCredito"]."', '".$_POST["valCuotaCredito"]."', '".$_POST["totalDeudaCredito"]."' );";

$consulta = $link->prepare($query);
break;	
case "nuevaCartera":
$date=$_POST["dataLabel"];
$fecha1 =normalize_date($date,"-"); 
if($_POST["carteraDescripcion"]==""){$auxObservacion="Credito por Compra";}else{$auxObservacion=$_POST["carteraDescripcion"];}
$query="
INSERT INTO  `cartera` (
`idCartera` ,
`idCuenta` ,
`descripcion` ,
`idCliente` ,
`nombre` ,
`fechaIngreso` ,
`valorInicial` ,
`abonoInicial` ,
`TotalInicial` ,
`numCuotas` ,
`intervalo` ,
`valorCuota` ,
`TotalActual`
)
VALUES ( '".$_POST["labeIDcartera"]."', '".$_POST["codigoCliente"]."_".$_POST["labeIDcartera"]."', '".$auxObservacion."', '".$_POST["codigoCliente"]."','".$_POST["nombreYapellido"]."', '".$fecha1."', '".$_POST["valCartera"]."', '".$_POST["abonoInicial"]."', '".$_POST["totalDeuda"]."', '".$_POST["numeroCuotas"]."', '".$_POST["intervalos"]."', '".$_POST["valCuota"]."', '".$_POST["totalDeuda"]."' );";

$consulta = $link->prepare($query);
break;	
}


if(!$consulta->execute()){
//Si no se puede insertar mandamos una excepcion
if($llamado=="nuevaSuc"){
	$query="DROP TABLE `".$_uno."entradas` ,
`".$_uno."entradasimplicito` ,
`".$_uno."entradastemp` ,
`".$_uno."salidas` ,
`".$_uno."salidasimplicito` ,
`".$_uno."salidastemp` ,
`".$_uno."ventas` ,
`".$_uno."ventasimplicito` ,
`".$_uno."ventastemp` ,;";

	 $mysqli->query($query);
	// echo "<br><br>".$query;
	}
throw new Exception('No se pudo insertar:' . $link->errorCode());
}
else{echo("los datos han sido ingresado con exito");
		if($llamado=="nuevoArticulo")
			{	if ($_POST["invSuc"]!="none")
					{$query2="INSERT INTO `".$_POST["invSuc"]."inventario` ( `idProducto` ,`nombreProducto` ,`cantidad` ,`salidas` ,`entradas` ,`ventas` ,`totalCantidad` ,`Pventa`
)VALUES ('".$_POST["IdArticulo"]."','".$_POST["nombre_Art"]."', '".$_POST["cantidad"]."', '0','0',  '0', '".$_POST["cantidad"]."','".$_POST["presioVenta"]."');";
					//$stmt->prepare($query2);
                                        $linkAuxN = $conexion->getLink();  
                                        $consultaaux = $linkAuxN->prepare($query);


						if(!$consultaaux->execute()){							
							//Si no se puede insertar mandamos una excepcion
							throw new Exception('no se pudo insertar en inventario:' . $linkAuxN->errorCode());

							}
					}
			}
                 if(($llamado == 'nuevoAbonoCredito' || $llamado == 'nuevoAbono') && isset($_POST['vauche_abono'])  && trim($_POST['vauche_abono'])!='' && trim($_POST['tipo_pago_abono'])=='BANCOS'   ){
                      $SIGNO = '';
                         $ORIGEN = "CUENTAS_POR_COBRAR";
                         $DETALLE = "TRASLADO - DEPOSITO POR PAGO DE ABONO";
                     if($llamado == 'nuevoAbonoCredito' ){
                         $SIGNO = '-';
                         $ORIGEN = "CUENTAS_POR_PAGAR";
                         $DETALLE = "RETIRO POR PAGO DE ABONO";
                     }
                     $query="INSERT INTO  `bancos` (
                                                `VALOR` ,
                                                `VAUCHE` ,
                                                `FECHA` ,
                                                `HORA` ,
                                                `IMANGEN`,DESCRIPCION , mod_origen
                                               )
                                               VALUES (  '$SIGNO".$_POST['valorAbono']."',  '".$_POST["vauche_abono"]."',  CURDATE(),  CURTIME(),  'imagenes/Sin_imagen.png','$DETALLE # {$_POST['idAbono']} A FACTURA {$_POST['cuenta']}','$ORIGEN');";
                                               //echo $query;
                                               
                                               
                                               
                                               
 $linkAuxN = $conexion->getLink();  
 $consultaaux = $linkAuxN->prepare($query);


						if(!$consultaaux->execute()){
							//Si no se puede insertar mandamos una excepcion
							throw new Exception('no se pudo insertar en bancos:' . $linkAuxN->errorCode());

							}
                 }
                 
                 
	}

//$stmt->close();

?>
