<?php 
include '../db_conection.php';
$mysqli= cargarBD();
$cadAux = '';
if (isset($_POST['usuarioid'])){$cadAux = " and u.id = '".$_POST['usuarioid']."'";}
$query='SELECT CONCAT_WS(" ",u.nombre,u.apellido) as nombre , p.* FROM `usuarios` u '.
' INNER JOIN ultposiciones p ON u.id = p.idUsuario'.
' WHERE p.time_registro = (SELECT MAX(time_registro) FROM ultposiciones WHERE idUsuario = u.id )'.$cadAux;
$data['query'] = $query;
		$result = $mysqli->query($query);
		$mysqli->affected_rows;
		$i=0;
		$aux=new ArrayObject;
		
			while ($row = $result->fetch_assoc()) {
			
			
			if($data[$row['idRegistro']]['count']==''){
				$data[$row['idRegistro']]['count']=0;
				}
			$data[$row['idRegistro']]['count']=$data[$row['idRegistro']]['count']+1;	
			$data[$row['idRegistro']][$data[$row['idRegistro']]['count']] =$row;
			
			}
echo json_encode($data);

?>