<?php
if(!isset($incluido)){ include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
                                        
}


class printerNPOSctr {
	protected $mysqli ;
	
	public function __construct(){
		try{
		$this->mysqli = cargarBD();
		}catch(Exception $e){
			////echo 'error de coneccion';
		}
	}
	
	public function getcontenido($VentaId, $idConfig )
		{	 try{
			$mysqli = $this->mysqli;
			$query = "SELECT a.* , ifnull(b.nombre1,'n/a')as nombre ,d.email, ifnull(b.apellido1,'n/a')as apellido , d.razonSocial , ".
                            "d.nit , d.direccion , d.telefono ,ifnull(a.fecha_entrega,a.fecha)as fecha_de_entrega  ,".
                            " ifnull(cr.abonoInicial,0) as abonoInicial , ifnull( oc.cod_orden_externa, '') as cod_orden_externa ".
                            "FROM ventas a left join usuarios b on b.id = a.usuario inner join ventacliente c on a.idVenta = c.idVenta ".
                            "inner join clientes d on d.nit = c.idCliente ".
                            "left join cartera cr on cr.refFact = a.idVenta ".
                            "left join remision_orden_de_compra oc on oc.id_orde = a.cod_orden_compra ".
                            " where a.idVenta =  '".$VentaId."';";
                                        
			$result = $mysqli->query($query); 
			if ($result->num_rows > 0)
			{
				$ARRAY = array();
			while ($row = $result->fetch_assoc()) {
						$tope = 10-strlen($row["orden"]);
						$ARRAY['factura_actual']='';
						for($i=0; $i<$tope ; $i++)
						{
							$ARRAY['factura_actual'].= '0';
						}
				$ARRAY['factura_actual']= PREFIJO.$ARRAY['factura_actual'].$row["orden"];
                                $row["valorTotal"]-=$row['abonoInicial'];
				$ARRAY['totalVenta']=	amoneda($row["valorTotal"], pesos);
				$ARRAY['totalIva']= amoneda($row["valorIVA"], pesos);
				$ARRAY['subTotal']= amoneda($row["valorParcial"], pesos);
				$ARRAY['retefuente']= amoneda($row["retefuente"], pesos);
				$ARRAY['descuento']= amoneda($row["descuento"], pesos);
				$ARRAY['fecha'] = $row["fecha"].' - '.$row['hora'];
				$ARRAY['vendedor'] = $row['nombre']." ".$row['apellido'];
				$ARRAY['cliente'] = $row['razonSocial'] ;
				$ARRAY['tipoDeVenta'] = $row['tipoDeVenta'] ;
				$ARRAY['nit'] = $row['nit'] ;
                                $ARRAY['fecha_entrega'] = $row['fecha_de_entrega'] ;
                                
                                $ARRAY['direccion'] = $row['direccion'] ;
                                $ARRAY['telefono'] = $row['telefono'] ; 
                                $ARRAY['email'] = $row['email'] ;
                                $ARRAY['abonoInicial'] = amoneda($row['abonoInicial'], pesos) ;
                                $ARRAY['abonoInicial'] = amoneda($row['abonoInicial'], pesos) ;
                                $ARRAY['cod_orden_externa'] = $row['cod_orden_externa'];
                                $ARRAY['remisiones']= $row['remisiones'];
                                
                                
			}
			
			} 
			$arr_respuesta['BH'] = $this->getmodelofact($idConfig, 'BH' , $ARRAY );
			$query = "select nombreProducto, presioSinIva, IVA ,cantidadVendida, valorTotal  from ventastemp  where idVenta =  '".$VentaId."';";
			$iterar = 0;
			$cont = 0;
			$fill = true;
			$A_OVERF['totalVenta']	= 0;
			$A_OVERF[ 'totalIva' ]	= 0;
			$A_OVERF[ 'subTotal' ]	= 0;
			$A_OVERF[ 'descuento']	= 0;
			$cont_arr = 0;
			$result2 = $mysqli->query($query);
			$arr_respuesta['BC'] = array();			
			$arr_respuesta['SPACIO'] = $this->getmodelofact($idConfig, 'BCS' , $row ,$fill);
			$maximo=27;
			while ($row = $result2->fetch_assoc()) {
				$cont++;
				$row['totalsiniva'] = $row['presioSinIva']*$row['cantidadVendida'];
				$A_OVERF['totalIva']	+=	$row["IVA"];
				$A_OVERF['subTotal']	+=	$row["totalsiniva"];
				$row['totalsiniva'] = amoneda($row['totalsiniva'], pesos);
				$row['presioSinIva']= amoneda($row['presioSinIva'], pesos);
				$fill = !$fill;
				$arr_respuesta['BC'] = $this->getmodelofact($idConfig, 'BC' , $row ,$fill,$arr_respuesta['BC']);
				$iterar +=4;
				IF ($cont == $maximo ){
					$A_OVERF['totalVenta']	= 	$A_OVERF['subTotal']+$A_OVERF['totalIva'];
					$A_OVERF['totalVenta']	= amoneda($A_OVERF['totalVenta'], pesos);	
					$A_OVERF['totalIva']	= amoneda($A_OVERF['totalIva'], pesos);
					$cont_arr ++ ;
					$arr_respuesta['BF_'.$cont_arr] = $this->getmodelofact($idConfig, 'BFS' , $ARRAY );
					$A_OVERF[ 'totalIva' ]	=	0;
					$A_OVERF[ 'subTotal' ]	=	0;
					$A_OVERF['totalVenta']	=	0;
					$cont = 0;
				}
			}
                        $query_creditos = '';
                        $row['totalsiniva'] = $row['nombreProducto'] = $row['presioSinIva']= $row['cantidadVendida'] = '';
                        $arr_respuesta['BC_spacio']  = array();
                        $arr_respuesta['BC_spacio'] = $this->getmodelofact($idConfig, 'BC' , $row ,$fill,$arr_respuesta['BC_spacio']);
                        $arr_respuesta['BF_num']=$cont_arr;
			$arr_respuesta['BF'] = $this->getmodelofact($idConfig, 'BF' , $ARRAY );
			$arr_respuesta['BCA'] = $this->getmodelofact($idConfig, 'BCA' , $ARRAY );
			
			return $arr_respuesta ;
			 }catch(Exception $e){
				////echo 'error';
				return -1 ;
			} 
		}
	public function getfooter($idConfig)
		{
		return $this->getmodelofact($idConfig,'F');
		}
	public function getheader($idConfig){
		return $this->getmodelofact($idConfig,'H');
	}
	
	private function getmodelofact($idConfig,$tip_configuracion , $_ARREGLO = NULL , $fill = false , $headerAux = array())
		{	//'D' - derecho - 'M' -'medio'- 'I' -izquierdo- 'IM' - 'DM' - 'IMD'
			$iterar = 0 ;
			$mysqli = $this->mysqli;
			$query = "select * FROM modelo_factura where tip_configuracion = '".$tip_configuracion."' and cod_configuracion = '".trim($idConfig)."'  order by cod_registro ;";
			 //echo '<br>'.$query;
                        $result = $mysqli->query($query);
                        
                        //echo "<br>$tip_configuracion";
                        //print_r($result);
			$dato = '';
			$ancholibre = 0; 
			while ($row = $result->fetch_assoc()) {
				$ant = $row ; 
				$inicio = 0;
				$alto = 0;
				$salto_antes = false;
				switch($row["seccion"]){
					case 'I':
						$ancho = 60;
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'N';
					break;
					case 'M':
						$ancho = 60;
						if ($ant["seccion"] != 'I' ){$inicio = 60;} 
						$alto = $row["altura"];
						$salto = 'N';
					break;
					case 'D':
						$ancho = 60;
						if ($salto_ant == 'S'){$inicio = 120;}else{
                                                   switch($inicio_ant){
                                                    
							case  0   : 
							
							if ($ancho_ant > 120 )
									{$inicio = 120;
									 $salto_antes = true;
								}else {$inicio = 120 - $ancho_ant ;}
							break;
							case  60  : 
								$inicio = 0;
							break;
							
						}}
						//$inicio = 120;
                                                $alto = $row["altura"];
						$salto = 'S';
					break;
					case 'IM':
						$ancho = 120;
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'N';
					break;
                                        case 'IMS':
						$ancho = 120;
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'S';
					break;
					case 'DM':
						$ancho = 120;
						if ($ant["seccion"] != 'I' ){$inicio = 60;} 
						$alto = $row["altura"];
						$salto = 'S';
					break;
                                        case 'D-M':
						$ancho = 90;
						if ($ant["seccion"] != 'I' ){$inicio = 90;} 
						$alto = $row["altura"];
						$salto = 'S';
					break;
                                        case 'I-MS':
						$ancho = 90;
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'S';
					break;
                                    case 'I-M':
						$ancho = 90;
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'N';
					break;
					case 'IMD':
						$ancho = 180;
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'S';
					break;
                                        case 'IMDx':
                                                if ($row["posx"] >= 180){$row["posx"]=0;} 
						$ancho = 180 - $row["posx"];
						$inicio = $row["posx"];
						$alto = $row["altura"];
						$salto = 'S';
					break;
                                    
                                    case 'IMDS':
						$ancho = 180;
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'S_';
					break;
					case 'L':
						$ancholibre += $row["posx"];
						$ancho = $row["posx"];
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'N';
					break;
					case 'LCS':
						$ancho = $row["posx"];
						$inicio = 0;
						$alto = $row["altura"];
						$salto = 'S';
					break;
					
				}
				IF ($row['tipo_elemento'] === 'clp'){
					$salto  = 'S';
				}
				$salto_ant = $salto;
				if ($salto == 'S'){
					$inicio_ant = 0;
					$ancholibre = 0;
					}
				else{$inicio_ant = $inicio;}
				$ancho_ant = $ancho;
				$Cfsize = false;
				if($row["cambio_fsize"] === 'S')
					{$Cfsize = true;}
				switch ($row["ubi_info"]){
					case 'img':	
						$dato = $row["nomb_dato_ubi"];
					break;
					case 'file':
						$dato = $row["nomb_dato_ubi"];
					break;
					case 'varS':
                                                if(trim($_SESSION[$row["nomb_dato_ubi"]]) != '') 
						$dato .= $row["valorFijo"].' '.trim($_SESSION[$row["nomb_dato_ubi"]]);
                                                else $dato .= '';
					break;
					case 'varI':
						$dato .= $row["valorFijo"].' '.trim($_ARREGLO[$row["nomb_dato_ubi"]]);
					break;
					case 'valorFijo':
						$dato .= $row["valorFijo"] ;
					break;
				}
				if ($row["num_concatenados"] == 0 ){
				array_push($headerAux, array('ini'=>$inicio,
										'ancho'=>$ancho,
										'alto'=>$alto,
										'valor'=>trim($dato),
										'tipo'=>$row["tipo_elemento"],
										'salto'=>$salto,
										'x'=>$row["posx"],
										'y'=>$row["posy"],
									'aling'=>$row["aling"],
									'fsize'=>$row['posy'],
									'Cfsize'=>$Cfsize,
									'$salto_ant'=>$salto_antes,
									'mod_celda'=>$row['mod_celda'],
									'fill'=> $fill
									));
					$dato = '';				
									}
				$iterar++; 
				
			}
			return $headerAux;
		
		}

}
?>