<?php include 'php/inicioFunction.php';
verificaSession_2("login/");?>
<title>Compras realizadas</title>
<?php 
date_default_timezone_set("America/Bogota"); 
include 'db_conection.php';
$color="#F0F8FF";
$mysqli = cargarBD();
$conn= cargarBD();
//edicion de compras final
if(isset($edicionCompra)&&count($_POST)>0)
{
	
	$usuarioID=$_SESSION["usuarioid"];
	$query2="SELECT * FROM  `listacompraedicion` WHERE `idCompra` =  ".$vtlme;
	//echo $query2;
$result = $mysqli->query($query2);
if($result->num_rows >0){
while ($row = $result->fetch_assoc()) { 
	$valorParcial=$valorParcial+$row['valorsiva'];        
        $total_iva += $row["iva"];
	$CantVendida=$CantVendida+$row['cantidad'];
}
$result->free();

}

$queryCompra="update   `compras` set  `codPov` = '".$_POST['provedor']."' ,`cantidadVendida` = '$CantVendida', "
    ."`valorParcial` =  '".$valorParcial."', t_iva = $total_iva , `valorTotal` =  ($valorParcial + $total_iva ),`usuario` = '".$usuarioID."' where idCompra = ".$vtlme.";";


 foreach($_POST as $key => $valor){
     $$key = $valor;
 }

 $conexion =\Class_php\DataBase::getInstance();
 
 $link = $conexion->getLink(); 
$consulta = $link->prepare($queryCompra);
//$stmt->prepare($queryCompra);
if(!$consulta->execute()){   
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo actualizar la compra por favopr reintente mas tarde:' .  $link->errorCode());
 
}else{
	$queryLista = 'CALL `editarListaCompra`('.$vtlme.'); ' ;
	$result =$mysqli->query($queryLista);
	$row = $result->fetch_assoc();
	if($row['_error']=='100'){	
			if ($tipo_de_compra == '2')
			{
				if($tipo_de_compra_aux =='2'){
					$queryCredito= "update credito set `idCliente` = ".$_POST['provedor']." ,`nombre` = ".$_POST['nombreprovedor']." ,`valorInicial` = ".$valorParcial." ,`abonoInicial` = ".$_POST["abono"]." ,`TotalInicial` = ".$_POST["TotalInicial"]." ,`valorCuota` = ".$_POST["valCuota"]." ,`TotalActual` =".$_POST["TotalInicial"]-$diferencia ;
					$result = $conn->query($queryCredito);
				}else{
					$query2="SELECT * FROM  `credito` ";
					$result = $conn->query($query2);
					$cantCartera=$result->num_rows+1;
					$creditoNum=$_POST["provedor"]."_".$cantCartera;
					$auxObservacion="Credito por Compra con codigo 000".$_POST['id_de_Compra'];

					$query="INSERT INTO  `credito` (`idCartera` ,`idCuenta` ,`descripcion` ,`idCliente` ,`nombre` ,`fechaIngreso` ,`valorInicial` ,`abonoInicial` ,`TotalInicial` ,`numCuotas` ,`intervalo` ,`valorCuota` ,`TotalActual`)
					VALUES ( NULL, '".$creditoNum."', '".$auxObservacion."', '".$_POST['provedor']."','".$_POST['nombreprovedor']."', '".$_POST['fechaIngreso']."', '".$valorParcial."', '".$_POST["abono"]."', '".$_POST["TotalInicial"]."', '".$_POST["numeroCuotas"]."', '{$_POST["intervalo_pagos"]}', '".$_POST["valCuota"]."', '".$_POST["TotalInicial"]."' );";
					
                                        $consulta = $link->prepare($query);
//$stmt->prepare($queryCompra);
if(!$consulta->execute()){   
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear el credito # :'.$_POST['id_de_Compra'] . $link->errorCode());
 
                                         
					 
					}else{$queryCredito="UPDATE  `compras` SET  `referencia` =  '".$creditoNum."' WHERE  `compras`.`idCompra` ='".$vtlme."' ;";
					$result = $conn->query($queryCredito);
					}
				}
			}
		}
	
	}
	
}
$fecha1=$fecha2=date('Y-m-d');
if($_POST['dateInicial']!=''){
	$fecha1=$_POST['dateInicial'];
if($_POST['dateFinal']!=''){$fecha2=$_POST['dateFinal'];}else{$fecha2=$fecha1;}
if($_POST['timeInicial']!=''){$time1=$_POST['timeInicial'];}
if($_POST['timeFinal']!=''){$time2=$_POST['timeFinal'];}}
$VENTA =0;
if($_GET["vtlme"]){
$html="";	
  $query= "SELECT * 
FROM  `listacompra` WHERE `idCompra`='".$_GET["vtlme"]."' ORDER BY  `listacompra`.`nombreProducto` ASC ";
$resultQ = $conn->query($query);
$datosNum=$mysqli->affected_rows;
$html="";
while ($row = $resultQ->fetch_assoc()) {$html=$html."<tr bgcolor='".$color."'>
  <td width='77'  align='center' ><span class='Estilochar'>".$row['idProducto']."</span></td>
  <td width='328' align='center'><span class='Estilochar'>".$row['nombreProducto']."</span></td>
  <td width='72' align='center'><span class='Estilochar'>".$row['presioCompra']."</span></td>
  <td width='72' align='center'><span class='Estilochar'>".$row['cantidad']."</span></td>
  <td width='50' align='center'><span class='Estilochar'>".$row['valorTotal']."</span></td></tr>
  ";}}else{

$query= "SELECT `compras`.*, `proveedores`.razonSocial   FROM  `compras` INNER JOIN `proveedores`  ON `compras`.codPov=`proveedores`.nit WHERE  `fecha` >=  '".$fecha1."' AND  `fecha` <='".$fecha2."'  ORDER BY  `compras`.`fecha` ASC";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
while ($row = $result->fetch_assoc()) {
	if($row['referencia']=="ninguno"){
	$Tcompra="CONTADO";
	$color="";}else{$Tcompra="CREDITO";$color="#F0F8FF";}
	$html=$html."<tr bgcolor='".$color."'>
 <td align='center' >
 <input type='image' id='' src='imagenes/edit.png' width='22' height='22' class ='procesar' data-value = '".$row['idCompra']."' data-action = 'editar' ></a></td>
 <td align='center' >
 <input type='image'  class ='procesar' data-value = '".$row['idCompra']."' data-action = 'eliminar' src='imagenes/Delete.ico' width='22' height='22' ></a></td>
 <td align='center' ><input type='image' id='".$row['idCompra']."' class='ventas procesar' src='imagenes/texto.png' width='22' height='22' ></a></td>
 
  <td align='center'> <span class='Estilochar'>".$row['idCompra']."</span></td>
  <td align='center' ><span class='Estilochar'>".$row['razonSocial']."</span></td>
  <td align='center' ><span class='Estilochar'>".$row['cantidadVendida']."</span></td>
  <td align='right'><span class='Estilochar'>".$row['fecha']."</span></td>
  <td align='right'  style='padding-right:10px'><span class='Estilochar'>".amoneda($row['valorTotal'], pesos)."</span></td>
  <td align='right' style='padding-right:10px'><span class='Estilochar'>".$Tcompra."</span></td>
 </tr>";
 $VENTA+=$row['valorTotal'];}
}
 ?>
 <style>
  .procesar{ width:40px;  }
  td{padding:5px;}
 .Estilo1 {
	font-family: "Arial Narrow";
	font-size: 18px;
	color: #993300;
}
 .Estilo2 {
	font-family: "Arial Narrow";
	font-size: 17px;
	color: #993300;
}

 .Estilochar {
	font-family: "Arial Narrow";
	font-size: 15px;
	color: #000000;
}

input.text {   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
 .Estilo4 {font-family: "Arial Narrow"; font-size: 17px; color: #993300; font-weight: bold; }
 .Estilo5 {
	font-family: "Arial Narrow";
	font-size: 17px;
	color: #996600;
}
 .Estilo6 {color: #993300}
 </style>
 <link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>

 <div align="center">
 <h1 class="Estilo1">LISTADO DE COMPRAS<br />
   __________________________________________________________________________</h1>
 <form action="listadoCompras.php" method="post" autocomplete="off" id="formularioEvio">
 <table width="540" >
   <tr>
     <td width="49"><span class="Estilo2">Desde</span></td>
     <td width="156"><input name="dateInicial" type="date" class="text"  value="<?php echo $fecha1; ?>"></td>
     
     <td width="44"><span class="Estilo2">Hasta</span></td>
     <td width="164"><input name="dateFinal" type="date" class="text" value="<?php echo $fecha2;  ?>"></td> 
     
     <td width="103" align="center"><input type="submit" value="PROCESAR" id="enviar"></td>
   </tr>
 </table></form>
 <span class="Estilo6">___________________________________________________________________________</span>
 <table width="275" border="0">
   <tr>
     <td width="137"><span class="Estilo4">Total Comprado:</span></td>
     <td width="186"><span class="Estilo5"><?PHP echo $VENTA; ?></span></td>
   </tr>
 </table>
 <?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaCompras';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
 <table id="tabla_resultados" width="900" >

 <tr>
<?php if($_GET["vtlme"]){
	echo"
 <td width='77'  align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Id</span></td>
  <td width='328' align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Producto</span></td>
  <td width='72' align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Precio</span></td>
  <td width='118' align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Cant</span></td>
  <td width='87' align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Total</span></td>
  ";
	
	}else{echo"
 <td width='50'  align='center' ></td>
 <td width='50'  align='center' ></td>
 <td width='50'  align='center' ></td>
 <td width='77'  align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Id</span></td>
  <td width='328' align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Proveedor</span></td>
  <td width='72' align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Cant</span></td>
  <td width='118' align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Fecha</span></td>
  <td width='120' align='center' bgcolor='#FBFBFB'><span class='Estilo2'>Total Compra</span></td>
  <td width='89' align='center' style='padding-left:10px' bgcolor='#FBFBFB'><span class='Estilo2'>Tipo Compra</span></td>";} ?>
 </tr>
 <?php echo $html;?>
 </table>
 </div>
 <div id='editar'></div>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){

		$('.ventas').click(function(){
		var direccion ='listadoCompras.php?vtlme='+$(this).attr('id')
		$('#formularioEvio').attr('action',direccion);
		$('#enviar').trigger('click');
	});
	
	
	$('.procesar').click(function(){
		var invoker = $(this).data('invoker')
		var action = $(this).data('action')
		var dato = $(this).data('value');
		switch(action){
			case 'eliminar':
		r = confirm("REALMENTE DESEA CANCELAR LA COMPRA\n\rEsto borrara completamente la compra del sistema y reversara los productos ingresados.");
		//r = false;
		if(r==true){
						datos='dato='+encodeURIComponent(dato)
					  +"&action="+encodeURIComponent('compras');
					  console.log(datos);
				$.ajax({
						url: 'EliminaX.php',  
						type: 'POST',
						async: false,
						data: datos,
						success: function(responseText){
							console.log(responseText)
							switch(responseText){
							case '100' :
								alert('la compra fue eliminada con exito');
								location.reload();
							break;
							case '-2' :
								alert('se presento un error en la base de datos al intertar eliminar la compra, por favor comuniquese con su administrador.');
							break;
							case '-44' :
								alert('La compra que intenta eliminar ya fue registrada en un cierre');
							break;
							case '-33' :
								alert('La compra que intenta eliminar registro una cuenta por pagar al momento de ser creada, y este credito ya cuenta con abonos totales o parciales.');
							break;
							}
						//alert(responseText)
						}
					});
				} 
			break;
			case 'editar':
				window.location= 'comprasEdit.php?jk567='+dato;
			break;
			
		}
		
	})
	
	});
</script>