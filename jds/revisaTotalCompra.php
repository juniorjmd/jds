<?php 
include 'php/inicioFunction.php';
include 'db_conection.php';
verificaSession_2("login/"); 
$conn = cargarBD();
$valorParcial=0;
$query2="SELECT * FROM  `listacompra` WHERE `idCompra` =  ".$_POST['id_de_Compra'];
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows>0){
while ($row = $result->fetch_assoc()) {
	$valorParcial=$valorParcial+$row['valorTotal'];
	$CantVendida=$CantVendida+$row['cantidad'];
}
}
echo  $valorParcial;
 ?>