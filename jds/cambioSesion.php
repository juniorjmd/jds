<?php 

$nickname= $_POST["user"];

if(trim($nickname)!=""){
	if(trim($_POST['pass'])!=""){
		$pass=md5($_POST['pass']);
		include 'php/db_conection.php';
		$query2="SELECT * FROM `usuarios` WHERE `nickname` = '".$nickname."' AND `password`= '".$pass."'";
		$mysqli=cargarBD();
		$result=$mysqli->query($query2);
		$cant_query=$mysqli->affected_rows;
		$datos["query"]= $query2;
		if($cant_query > 0){
			session_start();
		if($_SESSION['access'] !=false) 
			{ 	unset($_SESSION["IJKLEM1934589"]);
				unset($_SESSION["Facturacion"]);
				unset($_SESSION["Inventarios"]);
				unset($_SESSION["Transacciones"]);
				unset($_SESSION["Usuarios"]);
				unset($_SESSION["Empleados"]);
				unset($_SESSION["Proveedores"]);
				unset($_SESSION["Clientes"]);
				unset($_SESSION["usuarioid"]);
				unset($_SESSION["usertype"]);
				unset($_SESSION["usuario"]); 
				$_SESSION['access'] = false;
				unset($_SESSION["nombreUsuario"]); 
				unset($_SESSION["Transacciones"]);    
			}
			while ($row = $result->fetch_assoc()) {
				$idSucursal=$row["id"];
				$_SESSION['access'] = true;
				$_SESSION["usuario"]=$row["nombre"]." ".$row["apellido"];
				$_SESSION["nombreUsuario"]=$row["nombre"]." ".$row["apellido"];
				$_SESSION["usertype"]=$row["usertype"];
				$_SESSION["usuarioid"]=$row["id"];
				$_SESSION["IJKLEM1934589"]=$row["pass"];}
			$query="SELECT * FROM `permisos` WHERE `idPermiso`= '".$_SESSION["usertype"]."'";
			$result=$mysqli->query($query);
			$datosNum=$mysqli->affected_rows;
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$_SESSION["Facturacion"] =$row[ "Facturacion" ];
			$_SESSION["Inventarios"] =$row[ "Inventarios" ];
			$_SESSION["Transacciones"] =$row[ "Transacciones" ];
			$_SESSION["Usuarios"] =$row[ "Usuarios" ];
			$_SESSION["Empleados"] =$row[ "Empleados" ];
			$_SESSION["Proveedores"] =$row[ "Proveedores" ];
			$_SESSION["Clientes"] =$row[ "Clientes" ];
			$datos["nombre_cajero"]=$_SESSION["nombreUsuario"];
			$datos["error"]="Cambio de usuario realizado con exito";
			$datos["result"]='ok';	
		}
		else{$datos["error"]="usuario o contraseña no se encuentra registrado en la base de datos";
			$datos["result"]='notok';}
		}else{$datos["error"]="el password no debe estar en blanco";
				$datos["result"]='notok';
				}
}else{$datos["error"]="El usuario no debe estar en blanco";
					  $datos["result"]='notok';}

echo json_encode($datos);
?>