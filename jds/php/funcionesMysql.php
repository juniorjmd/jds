<?php

	function normalize_date($date,$separa){
 
		 if(!empty($date)){
			 $var = explode('/',str_replace('-','/',$date));
			//echo $var['0'];
			 if($separa=='-')
			{ return "$var[2]".$separa."$var[0]".$separa."$var[1]";}
				else{return "$var[0]".$separa."$var[1]".$separa."$var[2]";}//09/16/2014 2014/09/16
		 }
 
	}		 
	function normalize_date_html5($date,$separa){
 
		 if(!empty($date)){
			 $var = explode('/',str_replace('-','/',$date));
			 if($separa=='-')
			{ return "$var[2]".$separa."$var[1]".$separa."$var[0]";}
				else{return "$var[0]".$separa."$var[1]".$separa."$var[2]";}//09/16/2014 2014/09/16
		 }
 
	}		 
	
	function revisaCierres($fecha,$conn){
	$query="SELECT * FROM  `cierrediario` where `fecha`>'".$fecha."'";
	//echo $query;
	$result = $conn->query($query);
	if($result->num_rows > 0){
		return false;
		}else{ return true;	}	 		 
	}	
	
	function revisaPagos($fecha,$conn){
	$query="SELECT * FROM  `nomina`  WHERE  `fecha` >'".$fecha."'";
	//echo $query;
	$result = $conn->query($query);
	if($result->num_rows > 0){
		return false;
	}else{ return true;	}	  		 
	}	
	
						 
function igualaTablaInOut($tabla1,$tabla2,$columna,$codEntrada,$colInventario,$signo) 
{
$conn= cargarBD();
$connAux=cargarBD();
$query="SELECT * FROM `".$tabla1."` ;";
		$result = $conn->query($query);
		$codigoIngreso="";
				$ventaId="";
				$nombre="";
				$presioVenta="";
				$cantidad=""; 
				$totalVentaParcial="";
		$totalVentaTotal=0;
		while ($row = $result->fetch_row()) {
				$i=$i+1;
				$codigoIngreso=$row[0]; 
				$ventaId=$row[1]; 
				$nombre=$row[2]; 
				$presioVenta=$row[3]; 
				$cantidad=$row[4];	 
				$query="INSERT INTO `".$tabla2."` VALUES ('".$codigoIngreso."', '".$ventaId."', '".$nombre."', '".$presioVenta."', '".$cantidad."');";

				$connAux->query($query);
				
				$queryInvaux="UPDATE `inventario` SET `".$colInventario."` = (`".$colInventario."`+".$cantidad."),`totalCantidad` = (`totalCantidad`".$signo.$cantidad.") WHERE `idProducto` =".$ventaId." LIMIT 1";
				$connAux->query($queryInvaux);	
		
				}
				
				
				$query2="TRUNCATE TABLE `".$colInventario."temp`;";
		$conn->query($query2);	
		
				return $i;
				}
				
				
				
	
	
function igualaTablaVentas($tabla1,$tabla2,$columna,$codEntrada,$colInventario,$signo) 
{


$conn= cargarBD();
$connAux=cargarBD();
$query="SELECT * FROM `".$tabla1."` ;";
		$result = $conn->query($query);
		$codigoIngreso="";
				$codProducto=""; 
				$nombreProducto=""; 
				$presioVenta=""; 
				$cantidad="";
				$totalVentaParcial="";
				$valorTotal=0;
		while ($row = $result->fetch_row()) {
				$i=$i+1;
				$codigoIngreso=$row[0];
				$codProducto=$row[1]; 
				$nombreProducto=$row[2]; 
				$presioVenta=$row[3]; 
				$cantidad=$row[4];
				$subTotal=$row[5];
				$Descuento=$row[6];
				$totalVentaParcial=$row[7];
				$valorTotal=$valorTotal+$totalVentaParcial;
				
				$query="INSERT INTO `".$tabla2."`VALUES ('".$codigoIngreso."', '".$codProducto."', '".$nombreProducto."', '".$presioVenta."', '".$cantidad."','".$subTotal."','".$Descuento."','".$totalVentaParcial."',now());";
				//echo $query;
				$connAux->query($query);
				
	$queryInvaux="UPDATE `inventario` SET `".$colInventario."` = (`".$colInventario."`+".$cantidad."),`totalCantidad` = (`totalCantidad`".$signo.$cantidad.") WHERE `idProducto` =".$codProducto." LIMIT 1";
						
						 $conn->query($queryInvaux);	
		
				}
				
				
				$query2="TRUNCATE TABLE `".$colInventario."temp`;";
		$conn->query($query2);	
		
				return $valorTotal;
				}
                                
function ingresar_producto_remision(array $v_POST, $conn)
{
    if (count($v_POST)>0){
$numero2 = count($v_POST);
$tags2 = array_keys($v_POST); // obtiene los nombres de las varibles
$valores2 = array_values($v_POST);}// obtiene los valores de las varibles

for($i=0;$i<$numero2;$i++){ 
$nombre_campo = $tags2[$i]; 
$valor = $valores2[$i];
$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
//$$tags2[$i]=$valores2[$i]; 
}
$query= "INSERT INTO `remision_detalle` (`id_remision`,`id_orden_compra`,`id_producto`,`nombreProducto`,`presioVenta`,`porcent_iva`,".
        "`presioSinIVa`,`IVA`,`cantidadVendida`,`valorTotal`,`usuario`, `time`,  `cant_real_descontada`)VALUES('{$num_remision}','{$id_orden_compra}',".
        "'{$codigo_del_producto}','{$nombre_producto}','$presio_producto','$porcent_iva','{$Presio_sin_iva_producto}', $iva_producto,'{$cantidad_producto}',".
        "'$total_remision','{$_SESSION["usuarioid"]}',curdate() ,  '{$cantidad_producto_real}');";
        $stmt = $conn->stmt_init()
                ;$stmt->prepare($query);
$alert = '';
if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion 
    $alert = 'No se pudo ingresar el producto a la remision :' . $conn->error;
}else{ 
    $auxQuery="UPDATE  `producto` SET  `cantActual` = (`cantActual`-".$cantidad_producto_real." ),`remisionada`=`remisionada`+".$cantidad_producto_real." WHERE CONVERT(`idProducto` USING utf8 ) =  '".$codigo_del_producto."' LIMIT 1 ;";		
    $stmt->prepare($auxQuery);
    $alert = '';
    if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion 
            $alert = 'No se pudo actualizar el producto en el inventario :' . $conn->error;
            $Query_delete="delete from `ventastemp` WHERE CONVERT(`idLinea` USING utf8 ) =  '".$idLinea."' LIMIT 1 ;";		
            $result = $mysqli->query($Query_delete);
        } 
}
   
return $alert;
}

function cerrar_remision(array $v_POST, $conn)
{
    if (count($v_POST)>0){
$numero2 = count($v_POST);
$tags2 = array_keys($v_POST); // obtiene los nombres de las varibles
$valores2 = array_values($v_POST);}// obtiene los valores de las varibles

for($i=0;$i<$numero2;$i++){ 
$nombre_campo = $tags2[$i]; 
$valor = $valores2[$i];
$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
//$$tags2[$i]=$valores2[$i]; 
}
$query= "call sp_cerrar_remision($num_remision, $id_orden_compra , '$usuario');";
$stmt = $conn->stmt_init()
                ;$stmt->prepare($query);
$alert = '';
if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion 
    $alert = 'No se pudo ingresar el cierre de la remision :' . $conn->error;
}else{  
    $stmt->bind_result($resultado);
    // Obtenemos los valores
    while ($stmt->fetch()) {
        //printf("%s \n", $resultado);
    }
    // Cerramos la sentencia preparada
    $stmt->close();
    if ($resultado != '100'){
        $alert = 'se presento un error al ingresar los datos en el cierre de la operaciòn. '.$resultado;
    }
}
   
return $alert;
}

function inactivar_consecutivo($orden_venta , $conn){
    $query =  "UPDATE consecutivos_factura SET ESTADO = 'INACTIVA' WHERE cod_factura = {$orden_venta};";
    $result2 = $conn->query($query);
    $datosNum=$conn2->affected_rows; 
  
return $datosNum ;
}
function genear_consecutivo($id_usuario ,$modulo , $conn)
{
    //call sp_asignar_consecutivo_factura(2, 'M1')
$query= "call  sp_asignar_consecutivo_factura($id_usuario, '$modulo' ,@s_id_venta , @_id_venta);";
//echo "call  sp_asignar_consecutivo_factura($id_usuario, '$modulo' ,@s_id_venta , @_id_venta);";
$result2 = $conn->query($query);
$query= "select @s_id_venta  AS cod_factura , @_id_venta AS id_venta_generado ;";
/*id_venta_generado'];
        $cod_factura=$row['cod_factura*/
$result2 = $conn->query($query);
$datosNum=$conn2->affected_rows;
  $row = $result2->fetch_assoc();
  
return $row ;
}
?>
