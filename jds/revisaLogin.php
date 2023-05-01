<?php
$nickname= $_POST["user"];
$password=md5($_POST['password']);
$sucursalNombre=$_POST["sucursalId"];
$auxNameDB="db_".trim($_POST["sucursalId"]);
$database=$_POST[$auxNameDB];
if(trim($nickname)!=""){
include '../db_conection.php';
$query2="SELECT * FROM `usuarios` WHERE `nickname` = '".$nickname."' AND `password`= '".$password."'";
$mysqli=cargarBD($database);
$result=$mysqli->query($query2);
$datosNum=$mysqli->affected_rows;
if($datosNum==0)
{header("location: ../login/?nickname=".$nickname);

}
else{
session_set_cookie_params(0,"/");
session_start();
while ($row = $result->fetch_assoc()) {
$idSucursal=$row["id"];
$_SESSION['access'] = true;  
$_SESSION["usuario"]=$row["nombre"]." ".$row["apellido"];
$_SESSION["nombreUsuario"]=$row["nombre"]." ".$row["apellido"];
$_SESSION["usertype"]=$row["usertype"];
$_SESSION["usuarioid"]=$row["id"];
$_SESSION["IJKLEM1934589"]=$row["password"];
$_SESSION["database"]=$database;

}
//sucursales modulo
$query="select sc.* ,  fr.fec_resolucion ,  fr.num_cod_resolucion ,  fr.num_fac_inicial ,  fr.num_fac_final from sucursales sc inner join 
fac_resolucion fr on sc.cod_resolucion = fr.cod_resolucion where id_suc = '".trim($_POST["sucursalId"])."'";
$result=$mysqli->query($query);
$row = $result->fetch_array(MYSQLI_ASSOC);
$_SESSION["id_suc"] =$row[ "id_suc" ];
$_SESSION["tip_regimen"] =$row[ "tip_regimen" ];
$_SESSION["fec_resolucion"] =$row[ "fec_resolucion" ];
$_SESSION["num_cod_resolucion"] =$row[ "num_cod_resolucion" ];
$_SESSION["sucursalNombre"]=$row[ "nombre_suc" ];
$_SESSION["num_fac_inicial"] =$row[ "num_fac_inicial" ];
$_SESSION["num_fac_final"] =$row[ "num_fac_final" ];
$_SESSION["nit_sucursal"] =$row[ "nit_sucursal" ];
$_SESSION["tel1"]=$row[ "tel1" ];
$_SESSION["tel2"] =$row[ "tel2" ];
$_SESSION["dir"] =$row[ "dir" ];
$_SESSION["mail"] =$row[ "mail" ];
$_SESSION["ciudad"] =$row[ "ciudad" ];
//fin modulo


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



/*$_SESSION["eliminarsucursal"] =$row[ "eliminarSucursal"]; 
$_SESSION["editarsucursal"] =$row[ "editarSucursal" ];
$_SESSION["crearCliente"] =$row[ "crearCliente" ];
$_SESSION["verCliente"] =$row[ "verCliente" ];
$_SESSION["eliminarCliente"] =$row[ "eliminarCliente"]; 
$_SESSION["editarCliente"] =$row[ "editarCliente" ];
*/
if(!$_POST["location"]){
header("location: ../"	);}
else{header("location: ".$_POST["location"]);}

}}else{header("location: ../login/?enBlanco=true");}
?>
