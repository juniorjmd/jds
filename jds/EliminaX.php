<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<?php 
include 'db_conection.php';
$conn= cargarBD();
if(isset($_POST['action'])){
	$action = $_POST['action'];
}else {$action ='-1';}
switch($action){
	case 'compras':
		$query='CALL `eliminarCompras`( '.$_POST['dato'].' );';
		$result = $conn->query($query);
		$error =	$result->fetch_assoc();
		echo $error['_error'];
		
	break;
        case'editarCompras':
            $_POST['dato'] = trim($_POST['dato']);
            $query="update listacompraedicion set estado = 'D' where idLinea = '{$_POST['dato']}' ";
		$result = $conn->query($query);
		$error =	$result->fetch_assoc();
		echo $error['_error'];
         break;   
	default :
		if($_POST['restablecer']){
		$query="SELECT * FROM `".$_POST['tabla']."` WHERE `".$_POST['columna']."`='".$_POST['dato']."'";
		$result = $conn->query($query);
		while ($row = $result->fetch_assoc()) {
		$idProducto =$row['idProducto'];
		$cantVent =$row['cantidadVendida'];
		}
		$auxQuery="UPDATE  `producto` SET  `cantActual` = `cantActual`+".$cantVent.",`ventas`=`ventas`-".$cantVent." WHERE CONVERT(`idProducto` USING utf8 ) =  '".$idProducto."' LIMIT 1 ;";		
		$result = $conn->query($auxQuery);
		}
                
                if($_POST['rest_remision']){
		$query="SELECT * FROM `".$_POST['tabla']."` WHERE `".$_POST['columna']."`='".$_POST['dato']."'";
		$result = $conn->query($query);
                echo $query;
		while ($row = $result->fetch_assoc()) {
		$idProducto =$row['id_producto'];
		$cantVent =$row['cant_real_descontada'];
		}
		$auxQuery="UPDATE  `producto` SET  `cantActual` = `cantActual`+".$cantVent.",`remisionada`=`remisionada`-".$cantVent." WHERE CONVERT(`idProducto` USING utf8 ) =  '".$idProducto."' LIMIT 1 ;";		
		$result = $conn->query($auxQuery);
		}
                
		$query="DELETE FROM `".$_POST['tabla']."` WHERE `".$_POST['columna']."`='".$_POST['dato']."'";
		$result = $conn->query($query);
	break;
}

?>