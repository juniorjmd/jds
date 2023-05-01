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
$html = $_html ="";
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
  <td width='77' style = 'text-aling : center' ><span class='Estilochar'>".$row['idProducto']."</span></td>
  <td width='328' style = 'text-aling : center'><span class='Estilochar'>".$row['nombreProducto']."</span></td>
  <td width='72' style = 'text-aling : center'><span class='Estilochar'>".$row['presioCompra']."</span></td>
  <td width='72' style = 'text-aling : center'><span class='Estilochar'>".$row['cantidad']."</span></td>
  <td width='50' style = 'text-aling : center'><span class='Estilochar'>".$row['valorTotal']."</span></td></tr>
  ";

}
$query= "SELECT `compras`.*, `proveedores`.razonSocial   "
        . "FROM  `compras` "
        . "INNER JOIN `proveedores`  "
        . "ON `compras`.codPov=`proveedores`.nit  "
        . "WHERE  `idCompra`  ='".$_GET["vtlme"]."'   ";
$result = $mysqli->query($query); 
while ($row = $result->fetch_assoc()) {

$VENTA+=$row['valorTotal'];

	if($row['referencia']=="ninguno"){
	$Tcompra="CONTADO";
	}else{$Tcompra="CREDITO";}
 $_html .= "<div class='row'>"
         . "<div class='col-md-3 col-sm-12 div_fecha'> <span  >Proveedor</span><div><span  >{$row['razonSocial']}</span></div></div>"
         . "<div class='col-md-2 col-sm-12 div_fecha'> <span  >Fecha</span><div><span  >{$row['fecha']}</span></div></div>"
         . "<div class='col-md-2 col-sm-12 div_fecha'> <span  >Tipo de compra</span><div><span  >{$Tcompra}</span></div></div>"
         . "</div>";    
}
}else{

$query= "SELECT `compras`.*, `proveedores`.razonSocial   FROM  `compras` INNER JOIN `proveedores`  ON `compras`.codPov=`proveedores`.nit WHERE  `fecha` >=  '".$fecha1."' AND  `fecha` <='".$fecha2."'  ORDER BY  `compras`.`fecha` ASC";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
while ($row = $result->fetch_assoc()) {
	if($row['referencia']=="ninguno"){
	$Tcompra="CONTADO";
	$color="";}else{$Tcompra="CREDITO";$color="#F0F8FF";}
	$html=$html."<tr bgcolor='".$color."'>
 <td style = 'text-aling : center' >
 <input type='image' id='' src='imagenes/edit.png' width='22' height='22' class ='procesar' data-value = '".$row['idCompra']."' data-action = 'editar' ></a>
 <input type='image'  class ='procesar' data-value = '".$row['idCompra']."' data-action = 'eliminar' src='imagenes/Delete.ico' width='22' height='22' ></a>
  <input type='image' id='".$row['idCompra']."' class='ventas procesar' src='imagenes/texto.png' width='22' height='22' ></a></td>
 
  <td style = 'text-aling : center'> <span class='Estilochar'>".$row['idCompra']."</span></td>
  <td style = 'text-aling : center' ><span class='Estilochar'>".$row['razonSocial']."</span></td>
  <td style = 'text-aling : center' ><span class='Estilochar'>".$row['cantidadVendida']."</span></td>
  <td align='right'><span class='Estilochar'>".$row['fecha']."</span></td>
  <td align='right'  style='padding-right:10px'><span class='Estilochar'>".amoneda($row['valorTotal'], pesos)."</span></td>
  <td align='right' style='padding-right:10px'><span class='Estilochar'>".$Tcompra."</span></td>
 </tr>";
 $VENTA+=$row['valorTotal'];}
}
 ?>


    <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/> 


<div  >
   <div class="row">
       <div class="col-md-12 col-sm-12">
           <h2>CONSULTAR COMPRAS</h2>
           <hr>
       </div>
   </div>
    
 <form action="listadoCompras.php" method="post" autocomplete="off" id="formularioEvio">
      <div class="row">
      <div class="col-md-3 col-sm-12 div_fecha"> <span >Fecha inicio</span>
    <div  > 
        <input name="dateInicial" type="date" id="dateInicial" value="<?php echo $fecha1; ?>" class="text form-control"> </div> </div>
    <div class="col-md-3 col-sm-12 div_fecha"> <span  >Fecha final</span>
    <div  ><input name="dateFinal" value="<?php echo $fecha2;  ?>" type="date"  id="dateFinal" class="text form-control"></div></div>
       
         
          <div  class="col-md-1 col-sm-12"><span>&nbsp;</span>  
             <button id="enviar" name="buscar" title="Consultar Datos" class="btn btn-primary">Consultar</button>
           </div> 
      </div></form>
    <hr>
   <?= $_html;?>
    <div class="row">
        <div class="col-md-2 col-sm-12 div_fecha"> <span >Total Comprado : </span> </div>
        <div class="col-md-3 col-sm-12 div_fecha"> <span ><?PHP echo $VENTA; ?></span> </div>
        <div class="col-md-3 col-sm-12 div_fecha"> <?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaCompras';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> </div>
    </div>
 
</div>
 <div align="center">
 
 
 <table id="tabla_resultados" width="900" >

 <tr>
<?php if($_GET["vtlme"]){
	echo"
 <th width='77' style = 'text-aling : center' ><span>Id</span></th>
  <th width='328' style = 'text-aling : center' ><span>Producto</span></th>
  <th width='72' style = 'text-aling : center' ><span>Precio</span></t>
  <th width='118' style = 'text-aling : center' ><span>Cant</span></th>
  <td width='87' style = 'text-aling : center' ><span>Total</span></th>
  ";	}
  else
      {
      echo" <th width='50' style = 'text-aling : center' ><span>Accion</span></th> 
 <th width='77' style = 'text-aling : center' ><span>Id</span></th>
  <th width='328' style = 'text-aling : center' ><span>Proveedor</span></th>
  <th width='72' style = 'text-aling : center' ><span>Cant</span></th>
  <th width='118' style = 'text-aling : center' ><span>Fecha</span></th>
  <th width='120' style = 'text-aling : center' ><span>Total Compra</span></th>
  <th width='89' style = 'text-aling : center' style='padding-left:10px' ><span>Tipo Compra</span></th>";} ?>
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
		if(r === true){
						datos='dato='+encodeURIComponent(dato)
					  +"&action="+encodeURIComponent('compras');
					  console.log(datos);
				$.ajax({
						url: 'EliminaX.php',  
						type: 'POST',
						
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
		
	});
	
	});
</script>