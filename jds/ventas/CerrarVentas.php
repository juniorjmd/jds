<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
include_once '../php/funcionesMysql.php';
include_once '../printer_config/printerManager.php';
session_sin_ubicacion("login/");
$incluido=true;
//
// $json ='{"IdVenta":"M1_1118","codCiente":"1","tipoVenta":"EFECTIVO","VAUCHE":"","codModulo":"M1","cantidadVendida":"19","valorParcial":"475000","descuento":"0","valorIVA":"0","valorTotal":"475000","nombreCliente":"cliente generico","t_ingresado":"475000","t_devolucion":"0","abono_inicia":"","intervalo_pagos":"","num_cuotas":"","paga_retefuente":"S"}';
//  var_dump(json_decode($json, true));echo '<br>';
// $_POST = json_decode($json, true); echo '<br>';
//


$ventaId=$_POST['IdVenta'];
$tipoVenta=$_POST['tipoVenta'];
$VAUCHE=$_POST['VAUCHE'];
$conn= cargarBD();
$stmt = $conn->stmt_init();
 $conexion =\Class_php\DataBase::getInstance();
 
 $link = $conexion->getLink();    
/* 
$_POST = array(
 "IdVenta"=>"pr1_414",
"codCiente"=>"002",
"tipoVenta"=>"CREDITO",
"codModulo"=>"M1",
"cantidadVendida"=>"27",
"valorParcial"=>"14689.64",
"descuento"=>"1560",
"valorIVA"=>"910.35",
"valorTotal"=>"15600" );
"abono_inicia" = abono_inicia,
"intervalo_pagos" = intervalo_pagos,
"num_cuotas" = num_cuotas

*/
$datos['error']='';
$valorTotal = $_POST['valorTotal'] - $_POST['descuento'] ;
$datos['inicio']='inicio';
if (isset($_SESSION["fechaVentas"])&&$_SESSION["fechaVentas"]!=''){
	$fechaActual =  trim($_SESSION["fechaVentas"]);
}else{
	$fechaActual = date("Y-m-d");
}
/*
IdVenta: v_id_venta_actual,
		codCiente : v_cliente_hidden,
		tipoVenta: v_tipoVenta,
		VAUCHE : VAUCHE,
		codModulo:v_modulo,
		cantidadVendida :v_cantVendida,
		valorParcial : v_subtotal,
		descuento :   v_descuento,
		valorIVA : v_ivaVendido ,
		valorTotal : v_total_venta,
		nombreCliente : v_nombreCliente, 
		t_ingresado:  v_t_ingresado,
		t_devolucion:  v_t_devolucion,
                 abono_inicia: abono_inicia,
                intervalo_pagos: intervalo_pagos,
                num_cuotas: num_cuotas,
 *  */
$porcRetefuente = $retefuente = 0;
if( trim($_SESSION["retefuente_aplica_ventas"]) == 'S' && TRIM($_POST['paga_retefuente'])=='S' ){
    $porcRefuente = $_SESSION['porcent_retefuente_venta'] ;
    if (TIPO_RETEFUENTE_VENTAS != 'F'){
        $porcRefuente = $_POST['retefuente_nueva'];
        if (trim($porcRefuente)==''){$porcRefuente = $_SESSION['porcent_retefuente_venta'] ;}
    }
    $retefuente = ($_POST['valorParcial'] - $_POST['descuento'] ) * $porcRefuente / 100 ;
    
    $_POST['valorTotal'] -= $retefuente;
    $valorTotal-= $retefuente;
    $porcRetefuente = $porcRefuente ;
}
$orden_venta =  str_replace($_POST['codModulo'].'_','',$_POST['IdVenta']);
$query="ALTER TABLE `ventas` DISABLE KEYS;";
 $result = $conn->query($query);
$query = "INSERT INTO `ventas` ( `orden` ,`idVenta` ,`codMesa` ,`cantidadVendida` ,`valorParcial` ,`descuento` , `valorIVA`,`valorTotal` ,`fecha` ,`hora` ,`usuario` ,`estado` ,`idCierre`,`tipoDeVenta` ,porc_retefuente ,retefuente,`remisiones`,`cod_orden_compra`) ".
        "VALUES ('{$orden_venta}','".$_POST['IdVenta']."',  '".$_POST['codModulo']."',  '".$_POST['cantidadVendida']."',  '".$_POST['valorParcial']."', '".$_POST['descuento']."', '".$_POST['valorIVA']."',  '".$valorTotal."',  '".$fechaActual."',  '".date("G:i:s")."',  '".$_SESSION["usuarioid"]."',  'activo',  '','".$tipoVenta."',{$porcRetefuente},{$retefuente},'',0 );";
$datos['q2']=$query;
//$stmt->prepare($query);
$consulta = $link->prepare($query);
//$consulta->execute();
$query="ALTER TABLE `ventas` ENABLE KEYS;";
//echo $query;
                    if(!$consulta->execute()){
                    //Si no se puede insertar mandamos una excepcion
                    $datos['error']='No se pudo insertar venta: ' . $link->errorCode();    
                            
      /*                              
                $consulta->execute(); 
       * $array =  $consulta->fetchAll() ;*/
                    }else{
                        
                        
                         $result = $link->query($query);
                            //$queryListado = "call updateFechaVentas('".$_POST['IdVenta']."')";
                            //$conn->query($queryListado);
                            switch($tipoVenta){
                                    case "CREDITO":
                                    $query="SELECT * FROM `cartera` WHERE `idCliente` = '".$_POST['codCiente']."'";
                    $result = $conn->query($query);
                            while ($row = $result->fetch_row()) {
                        $filas=  $row[0];
                             }
                    $filas++;
                    /*"abono_inicia" = abono_inicia,
                    "intervalo_pagos" = intervalo_pagos,
                    "num_cuotas" = num_cuotas*/

                    $abonoInicial = $_POST['abono_inicia'];
                    $intervalo_pagos = $_POST['intervalo_pagos'];
                    $num_cuotas = $_POST['num_cuotas'];
                    $valorInicial = $valorTotal - $abonoInicial  ;
                    $valorCuota = number_format(($valorInicial / $num_cuotas),2);
                    $query2="INSERT INTO `cartera` (`idCartera`, `idCuenta`, `descripcion`, `idCliente`, `nombre`, `fechaIngreso`, `valorInicial`, `abonoInicial`, `TotalInicial`, `numCuotas`, `intervalo`, `valorCuota`, `TotalActual`,`refFact`,origen)". 
                            " VALUES (NULL, '".$_POST['codCiente']."_".$filas."', "
                            . "'CUENTA CREADA A PARTIR DE LA FACTURA # ".$_POST['IdVenta']." GENERADA EL DIA ".date("d-M-Y")."', "
                            . "'".$_POST['codCiente']."', "
                            . "'".$_POST['nombreCliente']."', CURDATE(), '".str_replace(',','',number_format($valorInicial, 2))."',"
                            . " '".str_replace(',','',number_format($abonoInicial, 2))."', '".str_replace(',','',number_format($valorTotal, 2))."',"
                            . " '".$num_cuotas."', '".$intervalo_pagos."', '".str_replace(',','',$valorCuota )."', "
                            . " '".str_replace(',','',number_format($valorInicial, 2))."','".$_POST['IdVenta']."','VENTA');";
                   $datos['query_ventas']=$query2;
                    //$stmt2 = $conn->stmt_init();
                      //      $stmt2->prepare($query2);
                     //echo $query2;
                     //str_replace("%body%", "black", "<body text='%body%'>");
                    //if(!$stmt2->execute()){
                        
                    $consulta = $link->prepare($query2);                                    
                    if(!$consulta->execute()){    
                    //Si no se puede insertar mandamos una excepcion
                    $datos['error']='No se pudo insertar la cartera :' . $stmt2->error ;   
                    $query="delete FROM `ventas` WHERE `orden` = '{$orden_venta}' ";
                    $result = $conn->query($query);
                    
                    }else{ 
                                    
                        inactivar_consecutivo($orden_venta,$conn);
                            $datos['print']=imprFacturaVenta( $_POST['IdVenta'] ,$_POST['tipoVenta'],$_POST['moduloActual'] , $_POST['t_ingresado'],$_POST['t_devolucion']);
                            //include_once '../printer_config/printer2.php?mIngresado='.$_POST['t_ingresado'].'&tDevolucion='.$_POST['t_devolucion'];
                    }
		break;
		case "ELECTRONICA":
					
					$query2="INSERT INTO `bancos` (`id_deposito`,
			`provieneDe` ,
			`VALOR` ,
			`VAUCHE` ,
			`FECHA` ,
			`HORA` ,
			`DESCRIPCION` ,
			`IMANGEN`,mod_origen
			)
			VALUES (NULL ,  'VENTA # ".$_POST['IdVenta']." ',  '".$valorTotal."',  '".$VAUCHE."',  CURDATE(),  CURTIME(),  'VENTA PAGADA POR DATAFONO  GENERADA EL DIA ".date("d-M-Y")."',  'imagenes/Sin_imagen.png' , 'VENTAS'
			);";
				
                            //$stmt2 = $conn->stmt_init();
                      //      $stmt2->prepare($query2);
                     //echo $query2;
                    //if(!$stmt2->execute()){
                        
                    $consulta = $link->prepare($query2);                                    
                    if(!$consulta->execute()){   
                            
			$datos['error']='No se pudo insertar el movimiento en bancos :' . $stmt2->error ;
                        $query="delete FROM `ventas` WHERE `orden` = '{$orden_venta}' ";
                        $result = $conn->query($query);
			}else{
                            inactivar_consecutivo($orden_venta,$conn);
				$datos['print']=imprFacturaVenta( $_POST['IdVenta'] ,$_POST['tipoVenta'],$_POST['moduloActual'] , $_POST['t_ingresado'],$_POST['t_devolucion']);
			//include_once '../printer_config/printer2.php?mIngresado='.$_POST['t_ingresado'].'&tDevolucion='.$_POST['t_devolucion'];
			}
			break;
		default:
                    inactivar_consecutivo($orden_venta,$conn);
		$datos['print']=imprFacturaVenta( $_POST['IdVenta'] ,$_POST['tipoVenta'],$_POST['moduloActual'] , $_POST['t_ingresado'],$_POST['t_devolucion']);
		
		}
}
//print_r($datos);
echo json_encode($datos);
?>