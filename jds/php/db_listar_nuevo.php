<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include 'db_conection.php'; 
                        

// $json ='{"tabla":"cartera","inicio":"","where":true,"igual":true,"columna1":"idCliente","dato":"85155788","datosRequeridos":""}';
//  var_dump(json_decode($json, true));echo '<br>';
// $_POST = json_decode($json, true);   
// 
// print_r($_POST);
try{
if( isset($_POST["dataBase"])){
$mysqli = cargarBD(trim($_POST["dataBase"]),trim($_POST["host"]),trim($_POST["c14562jk"]),trim($_POST["er2345"]));}else{
	$mysqli = cargarBD();}
	

                        
        
        
if (!isset($_POST["proced"])){ 
	if( isset($_POST["tabla"])&& $_POST["tabla"]!=''){
	$tabla=$_POST["tabla"];}
	$limit="";
	$inicial=$_POST['inicio'];
	$columnasRequeridas='';

	$auxDR=$_POST["datosRequeridos"];
	if (!isset($_POST["datosRequeridos"]))
	{
		$auxDR = array(
			1 => 'concat',
			2 => 'nombre',
			3 => 'apellido',
			4 => 'fconcat',
			5 => 'id' 		
		);
	}

	if(is_null($auxDR) || $auxDR == ''){
	$columnasRequeridas='*';}else{
		$cout=0;
		$swcont = 0;
		//CONCAT_WS(" ",u.nombre,u.apellido) as nombre 
		foreach ($auxDR as $value) {
			$cout++;
			if($cout>1){$coma=" , ";}else{$coma=" ";}
			if ($value == 'concat'){ 
			$columnasRequeridas=$columnasRequeridas.' CONCAT_WS(" "';
			}
			else{
				if($value == 'fconcat')
			{$swcont++;
				$columnasRequeridas=$columnasRequeridas.') as concat'.$swcont;}
				else{$columnasRequeridas=$columnasRequeridas.$coma.$value;}}
		
		}
		}
		
	//echo $columnasRequeridas;
	$datos["where"]=$_POST['where'];
	if(isset($_POST['where'])&& $_POST['where'] !='' && !is_null($_POST['where']) ){
			if(isset($_POST["igual"])){
				$asignar="=";
				$porcent="";
				}else{$asignar="LIKE ";
				$porcent="%";}
			$primeBusqueda =" WHERE ".$_POST["columna1"].$asignar."'".$porcent.$_POST["dato"].$porcent."'";
			if(isset($_POST["tabla2"])){$segundaBusqueda=$_POST['conector'].' '.$_POST["tabla2"].$asignar."'".$porcent.$_POST["dato"].$porcent."'";}
			if(isset($_POST["tabla3"])){$terceraBusqueda=$_POST['conector'].' '.$_POST["tabla3"].$asignar."'".$porcent.$_POST["dato"].$porcent."'";}
	}

	if($inicial!="")
	{	if($_POST['tamanioBloque']){$bloquePmetro=$_POST['tamanioBloque'];}
								else{$bloquePmetro='30';}
		$limit='LIMIT '.$inicial.' ,'.$bloquePmetro;
		$queryaux="select * from `".$tabla."`".$primeBusqueda.$segundaBusqueda.$terceraBusqueda.' ;';
	echo $query;
	$result2 = $mysqli->query($queryaux);
	$totalRegistrosDB=$mysqli->affected_rows;
	$siguiente=$inicial+$bloquePmetro;
	$anterior=$inicial-$bloquePmetro;
	$ultimo=(verificaNumeroDeIntervalos($totalRegistrosDB,$bloquePmetro,NULL)-1)*$bloquePmetro;
	if($anterior<0){$anterior=$ultimo;}
	if($siguiente>$totalRegistrosDB){$siguiente=0;}
			$datos['anterior']=$anterior;
			$datos['siguiente']=$siguiente;
			$datos['ultimo']=$ultimo;
	}

	$datos["filasTotales"]=$totalRegistrosDB;
	$order = $tipoOrder = '';
	if (isset($_POST["orderBy"]) && $_POST["orderBy"] != '' && !is_null($_POST["orderBy"])){
		'ORDER BY `compras`.`idCompra` ASC';
		$order =' ORDER BY `'.$tabla.'`.`'.trim($_POST["orderBy"]).'` ';
		if (isset($_POST["tipoOrder"]) && $_POST["tipoOrder"] != '' && !is_null($_POST["tipoOrder"])){
		$tipoOrder = ' '.$_POST["tipoOrder"].' ';}
	}
	$query="select ".$columnasRequeridas." from `".$tabla."`".$primeBusqueda.$segundaBusqueda.$terceraBusqueda.$order.$tipoOrder.$limit.' ;';
	}
        else{
		switch($_POST["proced"]){
			case 'GET_PRODUC_BARCODE':
				$query="call buscaProducto(".encadenaDatosEnviar($_POST['datosProce']).");";
			break;
		}
	}
	// echo $query;
	$result = $mysqli->query($query);
	$datos["filas"]=$mysqli->affected_rows;

	$i=0;

	if ($datos["filas"]>0){ 
	while ($row = $result->fetch_assoc()) {
	$data[$i] =$row;
	$i++;}
	}
	$datos["query"]=$query;
	  $datos["datos"]=$data;
	$mysqli->close(); 
        
        hlp_utf8_string_array_encode($datos);
	echo json_encode($datos);

	}catch (Exception $e) {
		echo 'Excepción capturada: ',  $e->getMessage(), "\n";
}


function encadenaDatosEnviar($arrayDatos){
	$coma=$cadenaEnvio = '';
	foreach ($arrayDatos as $value) {
		$cadenaEnvio.="'".$value."'".$coma;
		$coma = ' , ';	
	}
	return $cadenaEnvio;
}
?>
