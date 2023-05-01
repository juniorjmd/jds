<?php
class citasMedicas{
	public static $DBconection;
	public $idCita;
	public $IdCliente;
	public $telefono;
	public $fecha;
	public $hora;
	public $estadoCita;
	public $ubicacionGrid;
	public $idProfesional;
	public $rangoCita;
	public $obsevaciones;
	public $datosRetorno;
	public function __construct($link,$idCita,$IdCliente,$nombreCompPaciente,$telefono,$fecha,$hora,$idProfesional, $estadoCita, $ubicacionGrid,$rangoCita,$obsevaciones) {
	//	$this->datosRetorno['anda c']="anda cachaco".$this->idCita." asdf";
	$this->idCita=$idCita;
	$this->IdCliente=$IdCliente ;
	$this->telefono=$telefono ;
	$this->fecha=$fecha ;
	$this->hora=$hora ;
	$this->estadoCita=$estadoCita ;
	$this->ubicacionGrid=$ubicacionGrid ;
	$this->idProfesional=$idProfesional ;
	$this->rangoCita=$rangoCita ;
	$this->obsevaciones=$obsevaciones ;
	$this->nombreCompPaciente=$nombreCompPaciente;
	self::$DBconection =$link;
  }
   	public function select($parametros,$orderBy){
		$mysqli=self::$DBconection;
		$orderBy=$parametrosDeBusqueda="";
		if(is_null($parametros)){$parametrosDeBusqueda="";}
		if(is_null($orderBy)){$orderBy="";}
		$query='SELECT * FROM `agenda`'.$parametrosDeBusqueda.$orderBy;
		$result = $mysqli->query($query);
		$this->datosRetorno['numFilas']=$mysqli->affected_rows;
		$i=0;
			while ($row = $result->fetch_assoc()) {
			$data[$i] =$row;
			$i++;
			}
		$result->free();
		$this->datosRetorno['datos']=$data;
		return $this->datosRetorno;
		}
	public function insert(){
		$mysqli=self::$DBconection;
		if(is_null($mysqli)){
			$this->datosRetorno['estadoRespuesta']='error';
			$this->datosRetorno['mensajeResultado']=$this->error(1);
			return $this->datosRetorno;
			}else{
				if($this->idProfesional==''||$this->IdCliente==''||$this->estadoCita==''||$this->fecha==''||$this->nombreCompPaciente==''||$this->hora==''||$this->ubicacionGrid==''){$this->datosRetorno['estadoRespuesta']='error';
			$this->datosRetorno['mensajeResultado']=$this->error(3);
			$this->datosRetorno['idProfesional']=$this->idProfesional;$this->datosRetorno['IdCliente']=$this->IdCliente;$this->datosRetorno['estadoCita']=$this->estadoCita;$this->datosRetorno['fecha']=$this->fecha;$this->datosRetorno['nombreCompPaciente']=$this->nombreCompPaciente;$this->datosRetorno['hora']=$this->hora;$this->datosRetorno['ubicacionGrid']=$this->ubicacionGrid;
			return $this->datosRetorno;}else{
				
		$stmt = $mysqli->stmt_init();
		$query="INSERT INTO  `agenda` (`idCita` ,`idDoc` ,`IdCliente` ,`nombrePaciente` ,`telefono` ,`fecha` ,`hora` ,`estadoCita` ,`ubicacionGrid` ,`obsevaciones`,`rangoCita`)VALUES (NULL , '".$this->idProfesional."', '".$this->IdCliente."', '".$this->nombreCompPaciente."', '".$this->telefono."', '".$this->fecha."', '".$this->hora."', '".$this->estadoCita."', '".$this->ubicacionGrid."', '".$this->obsevaciones."','".$this->rangoCita."');";
		$stmt->prepare($query);
		if(!$stmt->execute()){
			$this->datosRetorno['estadoRespuesta']='error';
			$this->datosRetorno['mensajeResultado']=$this->error(2).' '. $stmt->error;
			return $this->datosRetorno;;
		}else{
			$this->datosRetorno['datosSelect']=$this->listarSemana($this->fecha);
			$this->datosRetorno['estadoRespuesta']='ok';
			$this->datosRetorno['mensajeResultado']='los datos fueron ingresados con exito';
			return $this->datosRetorno;}
	
	}}
			}
		
		private function error($tipoError) {
			$this->datosRetorno['tipoError']=$tipoError;
			switch($tipoError){
				case 1:
				$topic ="No existe conección con la base de datos";
				break;
				case 2:
				$topic ="No se pudo realizar la insercion en la base de datos";
				break;
				case 3:
				$topic ="No se realizo la insercion por falta de datos importantes para el registro";
				break;
				case 4:
				$topic ="No existen registros relacionado con la busqueda en esta semana";
				break;
				case 5:
				$topic ="No existen registros relacionado con la busqueda";
				break;
				
				}
			return $topic;
   			}
			
public function listarSemana($diaDeLaSemana,$datosBusqueda,$llamadoDirecto){
				$date= new DateTime($diaDeLaSemana);
				$dia=$date->format('l');
				$busquedaAdicional='';
				if(isset($datosBusqueda)){
					/*for(  $i=0;$i<$datosBusqueda.length;$i++){
						$datosAux=$datosBusqueda[$i];
					$busquedaAdicional=$busquedaAdicional."  ".$datosAux['conjuncion']." `".$datosAux['tabla']."`='".$datosAux['dato']."'";
						}*/
					foreach ($datosBusqueda as $datosAux ) {
    					$busquedaAdicional=$busquedaAdicional."  ".$datosAux['conjuncion']." `".$datosAux['tabla']."`='".$datosAux['dato']."'";}						
					}
				switch ($dia){
					case "Monday":
					$datosGenerales["DiaSenalado"]='flechaD2';
					break;
					case "Tuesday":
					$datosGenerales["DiaSenalado"]='flechaD3';
					break;
					case "Wednesday":
					$datosGenerales["DiaSenalado"]='flechaD4';
					break;
					case "Thursday":
					$datosGenerales["DiaSenalado"]='flechaD5';
					break;
					case "Friday":
					$datosGenerales["DiaSenalado"]='flechaD6';
					
					break;
					case "Saturday":
					$datosGenerales["DiaSenalado"]='flechaD7';
					break;
					case "Sunday":
					$datosGenerales["DiaSenalado"]='flechaD1';
					break;
					}
				if($date->format('l') != 'Sunday'){
					$date->modify('Last Sunday');
				}
				$primerDia=$date->format('Y-m-d');
				$auxDias= new DateTime($date->format('Y-m-d'));	
				$FechasDias['dia1']=$auxDias->format('Y-m-d');
				$auxDias->modify('+1 day');
				$FechasDias['dia2']=$auxDias->format('Y-m-d');
				$auxDias->modify('+1 day');
				$FechasDias['dia3']=$auxDias->format('Y-m-d');
				$auxDias->modify('+1 day');
				$FechasDias['dia4']=$auxDias->format('Y-m-d');
				$auxDias->modify('+1 day');
				$FechasDias['dia5']=$auxDias->format('Y-m-d');
				$auxDias->modify('+1 day');
				$FechasDias['dia6']=$auxDias->format('Y-m-d');
				$auxDias->modify('+1 day');
				$FechasDias['dia7']=$auxDias->format('Y-m-d');
				$primerDiaTitulo=$date->format('d')." de ".$date->format('M')." del ".$date->format('Y');	
				if($date->format('l') != 'Saturday'){
					$date->modify('Next Saturday');
				}
				$ultimoDia=$date->format('Y-m-d');	
				$mysqli=self::$DBconection;
				$ultimoDiaTitulo=$date->format('d')." de ".$date->format('M')." del ".$date->format('Y');	
				$datosGenerales["titulo"]="Semana del ".$primerDiaTitulo." asta el ".$ultimoDiaTitulo; // 2011-10-10
				$query="SELECT * FROM  agenda where `fecha` BETWEEN '".$primerDia."' AND '".$ultimoDia."'".$busquedaAdicional."; ";
				$result = $mysqli->query($query);
				//echo $query.'<br>';
				$datosNum=$mysqli->affected_rows;
				$cancelado=$diferidos=$citas=0;
				$datosGenerales["fechaDias"]=$FechasDias;
				$datosGenerales["numeroFilas"]=$datosNum;
				$datosGenerales["diaDeLaSemana"]=$diaDeLaSemana;
				if($datosNum>0){
				while ($row = $result->fetch_assoc()) {//echo $row['estadoCita'];
				if(strstr($row['nombrePaciente'],'Ã')){
				$row['nombrePaciente']=utf8_decode($row['nombrePaciente']);}
				switch(trim($row['estadoCita'])){
												case 'sin confirmacion':
												$row['color']="#FAAC36";
												break;
												case 'confirmada':
												$row['color']='#2F7ED7';
												break;
												case 'cancelada':
												$row['color']='#FA6136';
												break;
												case 'asistido':
												$row['color']='#5c9ccc';
												break;
												case 'no asistido':
												$row['color']='#CD233C';
												break;
												case 'diferido':
												$row['color']='#48BC36';
												break;
												
												} 
				if($row['estadoCita']=='diferido'){$datosGenerales["diferidos"][$diferidos]=$row;$diferidos++;}
				elseif($row['estadoCita']=='cancelada'){$datosGenerales["cancelados"][$cancelado]=$row;$cancelado++;}
				else{
				$datosGenerales["citas"][$citas]=$row;$citas++;
				}
				}
				$datosGenerales["numeroCitas"]=$citas;
				$datosGenerales["numeroDiferidos"]=$diferidos;
				$datosGenerales["numeroCancelados"]=$cancelado;
				$this->datosRetorno['estadoRespuesta']='ok';
				$this->datosRetorno['mensajeResultado']='existen '.$citas.' citas, ademas diferidas se encuentran '.$diferidos.' citas, y canceladas hay '.$cancelado.' citas.';
				}else{
					$this->datosRetorno['estadoRespuesta']='error';
			$this->datosRetorno['mensajeResultado']=$this->error(4);
					}
					
					if($llamadoDirecto){
				$this->datosRetorno['datosSelect']=$datosGenerales;
				return $this->datosRetorno;
				}else{
				return $datosGenerales;}
	
	}
		public function editarCita(){
			$mysqli=self::$DBconection;
		if(is_null($mysqli)){
			$this->datosRetorno['estadoRespuesta']='error';
			$this->datosRetorno['mensajeResultado']=$this->error(1);
			return $this->datosRetorno;
			}else{
				$columnas=$datosColumns="";
				$tbl=0;
				$coma='';
				if($this->idProfesional!=''){
					if($tbl>0){$coma=',';}
					$columnas=$columnas.$coma.'`idDoc`='."'".$this->idProfesional."'";
					$tbl++;
					}               
				if($this->IdCliente!=''){
					if($tbl>0){$coma=',';}
					$columnas=$columnas.$coma.'`IdCliente`='."'".$this->IdCliente."'";
					$tbl++;}               
				if($this->estadoCita!=''){
					if($tbl>0){$coma=',';}
					$columnas=$columnas.$coma.'`estadoCita`='."'".$this->estadoCita."'";
					$tbl++;}               
				if($this->fecha!=''){
					if($tbl>0){$coma=',';}
					$columnas=$columnas.$coma.'`fecha`='."'".$this->fecha."'";
					$tbl++;}               
				if($this->nombreCompPaciente!=''){
					if($tbl>0){$coma=',';}
					$columnas=$columnas.$coma.'`nombrePaciente+ ='."'".$this->nombreCompPaciente."'";
					$tbl++;}               
				if($this->hora!=''){
					if($tbl>0){$coma=',';}
					$columnas=$columnas.$coma.'`hora`='."'".$this->hora."'";
					$tbl++;}               
				if($this->ubicacionGrid!=''){
					if($tbl>0){$coma=',';}
					$columnas=$columnas.$coma.'`ubicacionGrid`='."'".$this->ubicacionGrid."'";
					$tbl++;}	
		$stmt = $mysqli->stmt_init();
		$query="UPDATE `agenda` SET ".$columnas." WHERE `agenda`.`idCita` =".$this->idCita.";";
		$stmt->prepare($query);
		if(!$stmt->execute()){
			$this->datosRetorno['estadoRespuesta']='error';
			$this->datosRetorno['mensajeResultado']=$this->error(2).' '. $stmt->error;
			return $this->datosRetorno;;
		}else{
			$this->datosRetorno['datosSelect']=$this->listarSemana($this->fecha);
			$this->datosRetorno['estadoRespuesta']='ok';
			$this->datosRetorno['mensajeResultado']='los datos fueron ingresados con exito';
			return $this->datosRetorno;}
				
	}
	}
 		public function __destruct() {
			self::$DBconection->close();
   			}
	}