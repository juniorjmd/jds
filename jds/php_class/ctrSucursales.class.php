<?php



class ctrSucursales {
	private $mysqli ;
	protected $id_select_suc;
	protected $id_select_per;
	protected $id_select_acc;
	
	public function __construct(){
		$this->id_select_suc = 0;
		$this->id_select_per = 0;
		$this->id_select_acc = 0;
		$id_select_per;
		$id_select_acc;
		try{
		$this->mysqli = cargarBD('jkou_124569piokmd');
		}catch(Exception $e){
			 echo 'error de coneccion';
		}
	}
	private function getNewConection($database){
		try{
			return cargarBD($database);
		}catch(Exception $e){
			 echo 'error de coneccion';
		}
	}
		
	
	public function getSelectSucursales(){
		$this->id_select_suc++ ;
		$query = 'select * from sucursales';
		while ($row = $result->fetch_assoc()) {
			
		}
		return $selectSucursal;
	}
	public function getSelectPermisos($sucursal=null , $accesoActual = null){
		$mysqli=$this->mysqli;
		$query = 'select * from permisos ';
		//echo 'enpezo';
		if ($result = $mysqli->query($query)){			
			if(is_null($sucursal)){$this->id_select_per++;$id = $this->id_select_per; }else{$id = $sucursal;}
		}else{echo 'error al obtener los datos';return '-2';}
		$selectPermisos='<select id="selPermiso_'.$id.'" name="selPermiso_'.$id.'"  class="form-control" >';		
		$datosNum=$mysqli->affected_rows;
		$selected ='';
		//echo $datosNum;$i=1;
		$selectOption='<option value="-1" >Seleccione Permiso</option> ';
		if ($datosNum>0){
			while ($row = $result->fetch_assoc()) {
				if (!is_null($accesoActual)){
						if ($row['idPermiso'] === $accesoActual){ $selected='selected';}
					}
				//echo $i++;
				$selectOption.='<option value="'.$row['idPermiso'].'" '.$selected.' >'.$row['typoUsuario'].'</option>' ;
			}
		}
		$selectPermisos .=$selectOption.'</select>';
		return $selectPermisos;
	}
	
	public function getSelectAccesos($sucursal = null ,$accesoActual = null){
		$mysqli=$this->mysqli;
		$query = 'select * from permisosporsucursal';
		$result = $mysqli->query($query);
		if(is_null($sucursal)){$this->id_select_acc++;$id =$this->id_select_acc; }else{$id = $sucursal;}		
		$selectAccesos = '<select id = "selAccesos'.$this->id_select_acc.'" name = "selAccesos'.$id.'" class="form-control" >'.
		'<option value="-1" >Seleccione tipo de accesos</option> ';
		$datosNum=$mysqli->affected_rows;
		$selected ='';
		if ($datosNum>0){
				while ($row = $result->fetch_assoc()) {
					if (!is_null($accesoActual)){
						if ($row['idPermiso'] === $accesoActual){ $selected='selected';}
					}
					$selectAccesos.='<option value="'.$row['idPermiso'].'" '.$selected.' >'.$row['nombre'].'</option>' ;
				}
		}
		return $selectAccesos.'</select>';
	
	}
	public function getSucPermisos($sucursal){
		return '<div class="col-md-4 text-center">
            <div class="form-group">
			<label for="sel1">Permisos a Modulos</label>'.
				$this->getSelectPermisos($sucursal)   
			.'
			</div>
        </div>'.
		'<div class="col-md-4 text-center">
            <div class="form-group">
			<label for="sel1">Tipos de Accesos</label>'.
				$this->getSelectAccesos($sucursal)  
			.'
			</div>
        </div></div>';		
	}
	public function getListadoSucPermisos(){
		$mysqli=$this->mysqli;
		$query = 'select * from sucursales';
		$result = $mysqli->query($query);
		$listadoSucPerm='';
		$datosNum=$mysqli->affected_rows;
		//$selected ='';
		if ($datosNum>0){
			while ($row = $result->fetch_assoc()) {
				$this->id_select_suc++ ;
				$listadoSucPerm.='<div data-sec="170" id="Despachar_item_solicitudes" class="tab-lvl-2 col-md-9 ">'.
				'<div class="col-md-4 text-left">'. 
				'<div class="checkbox">'.
				'<label><input type="checkbox" value="'.$row['id_suc'].'" id="'.$this->id_select_suc.'" name="sucursales[]" >'.$row['nombre_suc'].'</label>'.
				'</div></div>'.$this->getSucPermisos($row['id_suc']);
			}
		}else{$listadoSucPerm='No existe ninguna sucursal creada.';}
		
		return $listadoSucPerm;		
	}
	public function insertarUsuario($_arrPost){
		$error['error']=0;
		$error['msg']='los datos fueron creados correctamente';
		$numero2 = count($_arrPost);
		$tags2 = array_keys($_arrPost); // obtiene los nombres de las varibles
		$valores2 = array_values($_arrPost);// obtiene los valores de las varibles
		for($i=0;$i<$numero2;$i++){ 
		$nombre_campo = $tags2[$i]; 
		$valor = $valores2[$i];
		$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
		   eval($asignacion); }
		$activaPoss = " " ;
		$casillaActivaPoss = '';
		$sucursales = array();
		if(isset($_arrPost['sucursales'])){
			$sucursales=$_arrPost['sucursales'];
			$mysqli= $this->mysqli;
			//print_r($sucursales);print_r($_arrPost['sucursales']);
			$count = count($sucursales);
			//print_r($sucursales);
			for ($i = 0; $i < $count; $i++) {
				$idSucAux = $sucursales[$i];
			$getSucursal = "select `nom_database` from sucursales where id_suc = '".$idSucAux."'; ";
			$result = $mysqli->query($getSucursal);
			$listadoSucPerm='';
			$datosNum=$mysqli->affected_rows;
			//$selected ='';
			if ($datosNum>0){
			while ($row = $result->fetch_assoc()) {
				$database= $row['nom_database'];
			}}			
		if (isset($poss)){
			$activaPoss = " ,'S' " ;
			$casillaActivaPoss = ' ,`posicion` ';
		}
		echo 'obteniendo base de datos '.$database;
		$mysqli=$this->getNewConection($database);
		$password=md5($password);		
		$query="INSERT INTO `usuarios` ( `id` ,`nombre` ,`apellido` ,`usertype` ,`nickname` ,`password`, `direccion` ,`correo`,`telefono`" . $casillaActivaPoss .") ".
		"VALUES ( NULL ,  '".$nombre."',  '".$apellido."',  '".$_arrPost['selPermiso_'.$idSucAux]."',  '".$nickname."',  '".$password."' , '".$dir."','".$mail." ','".$telefono."' ".$activaPoss.");";
		$mysqli= $this->mysqli;
		$mysqli->autocommit(FALSE);
		$stmt = $mysqli->stmt_init();
		$stmt->prepare($query);
		if(!$stmt->execute()){
		//Si no se puede insertar mandamos una excepcion
		throw new Exception();
			$mysqli->rollback();
			$error['error']=1;
			$error['msg']='No se pudo realizar la insercion :' . $conn->error;
		}else{
			$queryIdIns='SELECT @@identity AS id';
			$result = $mysqli->query($queryIdIns);
			while ($row = $result->fetch_assoc()) {
				$idInsert = $row[id];
			}
				//echo $sucursales[2].'<br>'.$idSucAux.'<br>';
				if(!isset($_arrPost['selPermiso_'.$idSucAux])){$error['error']=1;$error['focus']='selPermiso_'.$idSucAux;$error['msg']='no Existe tipos de permisos para la sucursal que intenta registrar';return $error;}
				if(!isset($_arrPost['selAccesos'.$idSucAux])){$error['error']=1;$error['focus']='selAccesos'.$idSucAux;$error['msg']='no Existe tipos de  accesos para la sucursal que intenta registrar';return $error;}
				$queryPermiso = "INSERT INTO `relacionusersuc` ( `id` ,`idusuario` ,`idsucursal` ,`tiporelacion` ,
				`tipoAccesos`)".
				" VALUES ( NULL ,  '".$idInsert."',  '".$idSucAux."',  '".$_arrPost['selPermiso_'.$idSucAux]."' , '".$_arrPost['selAccesos'.$idSucAux]."');";
				echo '<br>'.$queryPermiso;
				if(!$mysqli->query($queryPermiso)){
					$error['error']=1;
					$error['msg']='No se pudo realizar la inserccion de los datos';
					$mysqli->rollback();
					return $error;
				}
		} 
		}
		$mysqli->commit();
		$mysqli->close();
		}else{
			$error['error']=1;
			$error['msg']='No existe relacion con ninguna sucursal';
		}
		return $error;
	}
	
}

?>