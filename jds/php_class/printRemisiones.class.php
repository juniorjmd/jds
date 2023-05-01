<?php 
require_once('../php/fpdf181/fpdf.php');
require_once('../printer_config/PrinterRemNPOSctr.php');
 
class printFactura extends FPDF {
	private $footer ;
	private $header  ;
	private $body ;
	private $css ;
	private $cod_tip_impresion ;	
	private $ventaId ;
	private $nombreArchivo ;
        public $ruta;
        private $nomFileDB;
	protected $factCRT;
	protected $salida;
	private $ordenDeCompra;
	public function __construct ($cod_tip_impresion, $ordenDeCompra ,$VentaId , $salida = null ){
		date_default_timezone_set("America/Bogota"); 
		parent::__construct();
		$salida = is_null($salida) ? 'F' : $salida; 
		$this->salida = $salida;
		$this->ordenDeCompra =  $ordenDeCompra;
		$this->setTipImpresion($cod_tip_impresion);
		$this->setVentaId($VentaId,$ordenDeCompra) ;
		$this->confuguracion();
                        
	}
	public function confuguracion($cod_tip_impresion = NULL){
		if (!is_null($cod_tip_impresion))
		{
			$this->setTipImpresion($cod_tip_impresion);
		} 
		$this->factCRT = new printerNPOSctr($this->getTipImpresion());
	}
	
	private function setTipImpresion($cod_tip_impresion){
		$this->cod_tip_impresion = $cod_tip_impresion;
	}
	public function getTipImpresion(){
		return $this->cod_tip_impresion;
	}
	private function setVentaId($ventaId = null ,$ordenDeCompra = null){
		
		$this->ordenDeCompra = is_null($ordenDeCompra) ? $this->ordenDeCompra : $ordenDeCompra;
		$this->ordenDeCompra = is_null($this->ordenDeCompra) ? '1' : $this->ordenDeCompra;
		$ventaId = is_null($ventaId) ? '1' : $ventaId  ; 
                $this->ventaId = $ventaId;
                        
		 
	}
	private function getVentaId(){
		return $this->ordenDeCompra.'_'.$this->ventaId ;
	}
	
        
	private function setNArchivo (){ 
                $this->ruta = '../remisiones/'.date('Y').'/'.date('m').'/';
		$this->nombreArchivo = '../remisiones/'.date('Y').'/'.date('m').'/rem'.$this->getVentaId().'.pdf';
                //$this->nomFileDB='facturas/fac'.$this->getVentaId().'_'.date('Ymd').'.pdf';
                $this->nomFileDB = 'remisiones/'.date('Y').'/'.date('m').'/rem'.$this->getVentaId().'.pdf';
	} 
	public function getNArchivo (){
		return $this->nombreArchivo;
	}
        public function getDBNameArchivo (){
		return  $this->nomFileDB;
	}
	public function generar( $salida = null, $VentaId = NULL  ){//se pueden generar con la misma configuracion diferentes números de factura.
		IF (!is_null($VentaId)){
			$this->setVentaId = $VentaId;
		}
		IF (!is_null($salida)){
			$this->salida = $salida;
		}
		//echo $this->getNArchivo(); 
		$this->setNArchivo();
		$this->AddPage();
		$this->Fheader();		
		$this->Fbody();		
		$this->Ffooter();		
		if (file_exists ($this->getNArchivo())){
			unlink($this->getNArchivo());
		} 
                if (!file_exists($this->ruta)) {
                    mkdir($this->ruta, 0777, true);
                }
		if (is_null($this->salida)){
                    $this->salida = 'F';
				//$this->Output('F',$this->getNArchivo());
		} 
			switch($this->salida)
			{case 'F': 
				$this->Output('F',$this->getNArchivo());
                                $fecha_venta=date('Y-m-d');
                                //aqui insertar
                                $mysqli12 = cargarBD();
                                $arr_id_remision = explode("_", $this->getVentaId());
                              //  echo $arr_id_remision[0]; // orden de compra
                              //  echo $arr_id_remision[1]; // cod remision
                                
                                $query="SELECT  ifnull(dir_factura,'N/A') AS dir_factura FROM  `remision_cabeza`  WHERE ".
                                        "orden_de_compra='{$arr_id_remision[0]}' and id_remision = '{ $arr_id_remision[1]}'";
                                $result = $mysqli12->query($query);
                                if ($row = $result->fetch_assoc()) 
                                {     $dir_factura = $row["dir_factura"]; 
                        
                                        IF ($dir_factura == 'N/A'){
                                            $query_ingreso_factura = "UPDATE remision_cabeza SET dir_factura = "
                                                    . "'{$this->getDBNameArchivo()}' WHERE "
                                                    . "orden_de_compra='{$arr_id_remision[0]}' and id_remision = '{$arr_id_remision[1]}';";
                                                    $mysqli12->query($query_ingreso_factura);
                                        }
                                    
                        
                                }
                            
                            
			break;
			default:
				$this->Output($this->salida);
			
			break;
                    }
		
	}
	//////////////genera el cuerpo de la factura
	function Fbody(){
		$hAnsw = $this->factCRT->getcontenido($this->getVentaId(),$this->getTipImpresion());
		$this->despliegaModelo($hAnsw['BH']);
		$this->despliegaModelo($hAnsw['BCA']);
		$this->despliegaModelo($hAnsw['SPACIO']);
		
		if($hAnsw['BF_num']>0){
			$arr_cont = 0;
		}
		else{
			$this->despliegaModelo($hAnsw['BC']);
		}
		
		$this->despliegaModelo($hAnsw['SPACIO']);
		$this->despliegaModelo($hAnsw['BF']);
	}
	///////////////genera footer
	function Ffooter()
	{
		
	   $hAnsw = $this->factCRT->getfooter($this->getTipImpresion());
	   $this->despliegaModelo( $hAnsw );
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
	//////////////genera el header
	 function Fheader()
   {
	   $hAnsw = $this->factCRT->getheader($this->getTipImpresion());
	   //$solucion = getheader(1);
	   $this->SetLineWidth(.3);
		$this->SetFont('Arial','I',6);
			$ini_ant = 0;		
			foreach($hAnsw as $val){
				$x = $val['x'];
				$y = $val['y'];
				$inicio =$val['ini'];
				if (($ini_ant > 0 && $inicio == 120 )&& ($ini_ant < 120)){
					$inicio = $inicio - $ini_ant;
				}
				$ini_ant = $val['ini'];
				if ($inicio > 0){
					$this->Cell($inicio);
				}
				switch($val['tipo']){
					case 'file':
					break;
					case 'img':
						$this->Image($val['valor'], $x ,$y, $val['ancho'] , $val['alto']  );
					break;
					default :
						$aux_valor=trim($val['valor']);
						$this->Cell(60,$val['alto'],$aux_valor,2,0,$val['aling']);
					break;
				}
				if ($val['salto'] == 'S') {
					$this->Ln(4);
				}
			}
						
						
   }
	////
	
	private function despliegaModelo($hAnsw , $limit = null)
   {    $limit = is_null($limit) ? 0 : $limit;
	   	$ini_ant = $run = 0;
		$go = true;	
			foreach($hAnsw as $val){
				if ($limit>0){$run++;if($run===$limit){$go = false;}}
				if ($go)
				{
					$x = $val['x'];
					$y = $val['y'];
					$inicio =$val['ini'];
					if (($ini_ant > 0 && $inicio == 120 )&& ($ini_ant < 120)){
						$inicio = $inicio - $ini_ant;
					}
					$ini_ant = $val['ini'];
					if ($inicio > 0){
						$this->Cell($inicio);
					}
					//echo 'tipo: '.$val['tipo'].' dato '.trim($val['valor']).'<br>';
					if ($val['Cfsize']){
						$this->SetFont('Arial','I',$val['fsize']);
					}
					switch($val['tipo']){
						case 'file':
						break;
						case 'img':
							$this->Image($val['valor'], $x ,$y, $val['ancho'] , $val['alto']  );
						break;
						case 'lnsp':
							$this->Ln();
							$this->Cell(0,0,'',$val['mod_celda']);
						break;
						case 'clp':
							$aux_valor=trim($val['valor']);
							$this->Cell($val['ancho'],$val['alto'],$aux_valor,$val['mod_celda'],0,$val['aling']);
							//$this->Cell($val['ancho']);
						break;
						case 'mln' :
							$aux_valor=utf8_decode(trim($val['valor']));
							$tamanioStr = strlen($aux_valor) ;
							$aux_valor.=' ';
							$anchoAux = $val['ancho'] -  28 ;
							$modCelda =$val['mod_celda'];
							if ($modCelda =='LRfB'){
								$modCelda = 'LTR';
								$this->Ln(8);
								$this->Cell($val['ancho'],0,'',$modCelda,0,$val['aling']);
								$this->Ln();
								$modCelda = 'LR';
							}
							if ($tamanioStr > $anchoAux){
								$continua = true;
								while ($continua){
									$sigPoss =$anchoAux+1;
									if (substr($aux_valor,$anchoAux,1)==' '){
										$cadena = substr($aux_valor,0,$val['ancho']);
										
										
									}
									else if(substr($aux_valor,$anchoAux,1)!=' ' and substr($aux_valor,$anchoAux-1,1)==' '){
										$cadena = substr($aux_valor,0,$anchoAux);
									}else {
										$cadena = substr($aux_valor,0,$anchoAux);
										$cadena = substr($cadena,0,strripos($cadena, ' ')+1);
										$sigPoss = strripos($cadena, ' ')+1 ;
									}					
									$aux_valor = substr($aux_valor,$sigPoss);
									$this->Cell($val['ancho'],$val['alto'],$cadena,$modCelda,0,$val['aling']);
									$this->Ln(4);
									if (trim($aux_valor) == ''){
										$continua = false;
									}
								}
								if ($val['mod_celda']=='LRfB'){
									$modCelda = 'LBR';
									$this->Cell($val['ancho'],4,'',$modCelda,0,$val['aling']);}
							}else{
								$this->Cell($val['ancho'],$val['alto'],$aux_valor,$val['mod_celda'],0,$val['aling']);
							}
						break;
						default :
							$aux_valor=utf8_decode(trim($val['valor']));
							$tamanioStr = strlen($aux_valor) ;
							$aux_valor.=' ';
							$anchoAux = $val['ancho'] ;
							if ($tamanioStr > $anchoAux){
								$continua = true;
								while ($continua){
									$sigPoss =$anchoAux+1;
									if (substr($aux_valor,$anchoAux,1)==' '){
										$cadena = substr($aux_valor,0,$val['ancho']);
										
										
									}
									else if(substr($aux_valor,$anchoAux,1)!=' ' and substr($aux_valor,$anchoAux-1,1)==' '){
										$cadena = substr($aux_valor,0,$anchoAux);
									}else {
										$cadena = substr($aux_valor,0,$anchoAux);
										$cadena = substr($cadena,0,strripos($cadena, ' ')+1);
										$sigPoss = strripos($cadena, ' ')+1 ;
									}					
									$aux_valor = substr($aux_valor,$sigPoss);
									$this->Cell($val['ancho'],$val['alto'],$cadena,$val['mod_celda'],0,$val['aling']);
									$this->Ln(4);
									if (trim($aux_valor) == ''){
										$continua = false;
									}
								}
							}else{
								$this->Cell($val['ancho'],$val['alto'],$aux_valor,$val['mod_celda'],0,$val['aling']);
							}
						break;
					}
					if ($val['salto'] == 'S') {
						$this->Ln(4);
						IF ($val['alto'] > 8)
						$this->Ln(4);
					}
				}
   
   }
						
						
   }
}
?>
