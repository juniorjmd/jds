<?php 
include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'db_conection.php';
$conn= cargarBD();

if(isset($_POST["VALOR_PARCIAL"])){
	$stmt = $conn->stmt_init();//VALOR_IVA_TOTAL $VALOR_IVA_VENTA  $VALOR_TOTAL_COMPRA
        /*$query="INSERT INTO  `pagosiva` (`id_usuario`,`IVA` ,`FECHA`,`total_venta_bruta`,`total_venta_neta`
                    , iva_venta   ,iva_compra, exedente_anterior  )VALUES (
		'".$_SESSION["usuarioid"]."','".$_POST['VALOR_IVA_TOTAL']."','".date("Y-m-d")."','".$_POST['VALOR_PARCIAL']."','".$_POST['VALOR_TOTAL']."'"
               . ",'{$_POST['VALOR_IVA_VENTA']}','{$_POST['VALOR_IVA_COMPRA']}','{$_POST['VALOR_IVA_COMPRA']}');";*/
		$query="INSERT INTO  `pagosiva` (`id_usuario`,`IVA` ,`FECHA`,`total_venta_bruta`,`total_venta_neta`"
                        .", iva_venta   ,iva_compra, exedente_anterior  )VALUES ('".$_SESSION["usuarioid"]."',"
                        . "'".$_POST['VALOR_IVA_TOTAL']."','".date("Y-m-d")."','".$_POST['VALOR_PARCIAL']."','".$_POST['VALOR_TOTAL']."'"
                        . ",'{$_POST['VALOR_IVA_VENTA']}','{$_POST['VALOR_IVA_COMPRA']}','{$_POST['VALOR_TOTAL_EXCEDENTE']}');";	
		//echo $query;
		$stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo ingresar el pago del iva :' . $conn->error);		 
		}else{	
		$query2="UPDATE `ventas` SET  `pago_iva` ='PAGADO'  WHERE `pago_iva`='NINGUNO'";
		$result = $conn->query($query2);
		echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el pago de iva fue insertado con exito!!!!!!!!!!!</div><br><br>';
		   echo '<script>setTimeout(function() {
        window.location="pagoIVA.php"
    },3500);</script>';
		}	
	}


$query2="SELECT ifnull((SELECT sum(valor_exedente) FROM  excedente_iva where pago_iva = 'none'),0) as acumuladoIva , "
        . "ifnull(SUM(`valorParcial`),0) AS VALOR_PARCIAL, ifnull(SUM(`valorIVA`),0) AS VALOR_IVA, "
        . "ifnull(SUM(`valorTotal`),0) AS VALOR_TOTAL FROM `ventas` WHERE `pago_iva`='NINGUNO'";
 
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
    $acumuladoIva = $row['acumuladoIva'];
	$VALOR_PARCIAL=$row["VALOR_PARCIAL"];
	$VALOR_IVA=$row["VALOR_IVA"];
	$VALOR_TOTAL=$row["VALOR_TOTAL"];
}$result->free();
$query2="SELECT ifnull(SUM(`valorParcial`),0) AS VALOR_PARCIAL, ifnull(SUM(`t_iva`),0) AS VALOR_IVA, "
        . "ifnull(SUM(`valorTotal`),0) AS VALOR_TOTAL FROM `compras` WHERE `ivacausado`='none'";
// echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	$VALOR_PARCIAL_COMPRA=$row["VALOR_PARCIAL"];
	$VALOR_IVA_COMPRA=$row["VALOR_IVA"];
	$VALOR_TOTAL_COMPRA=$row["VALOR_TOTAL"];
}$result->free();

$iva_a_pagar = $VALOR_IVA  - $VALOR_IVA_COMPRA - $acumuladoIva;
$html = '';
$CABECERA_TABLA = "<tr>"
        . "<td>TOTAL IVA</td>"
        . "<td>TOTAL VENTA BRUTA</td>"
        . "<td>TOTAL VENTA NETA</td>"
        . "<td>IVA EN VENTA</td>"
        . "<td>IVA EN COMPRA</td>"
        . "<td>EXEDENTE ANTERIOR</td>"
        . "<td>EXEDENTE ACTUAL</td>"
        . "<td>USUARIO</td>"
        . "<td>FECHA</td>"
        . "</tr>";
$query2="SELECT pagosiva.*, nombreCompleto FROM  pagosiva left join usuarios on id_usuario = ID LIMIT 100;";
// echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
    //id_cierre_de_caja, 
     	 
        $html .=$CABECERA_TABLA. "<tr>"
                . "<td>{$row['IVA']}</td>"
                . "<td>{$row['total_venta_bruta']}</td>"
                . "<td>{$row['total_venta_neta']}</td>"
                . "<td>{$row['iva_venta']}</td>"
                . "<td>{$row['iva_compra']}</td>"
                . "<td>{$row['exedente_anterior']}</td>"
                . "<td>{$row['exedente']}</td>"
                . "<td>{$row['nombreCompleto']}</td>"
                . "<td>{$row['FECHA']}</td>"
                . "</tr>";
       $CABECERA_TABLA ='';
	 
}$result->free();


?>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> 
<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<form action="pagoIVA.php" autocomplete="on" method="post">
<?php
echo'<input type="hidden" name="VALOR_PARCIAL" id="venta" value="'.$VALOR_PARCIAL.'" >';
echo'<input type="hidden" name="VALOR_IVA_TOTAL" id="venta" value="'.$iva_a_pagar.'" >';
echo'<input type="hidden" name="VALOR_TOTAL" id="venta" value="'.$VALOR_TOTAL.'" >';
echo'<input type="hidden" name="VALOR_PARCIAL_COMPRA" id="venta" value="'.$VALOR_PARCIAL_COMPRA.'" >';
echo'<input type="hidden" name="VALOR_IVA_VENTA" id="venta" value="'.$VALOR_IVA.'" >';
echo'<input type="hidden" name="VALOR_IVA_COMPRA" id="venta" value="'.$VALOR_IVA_COMPRA.'" >';
echo'<input type="hidden" name="VALOR_TOTAL_COMPRA" id="venta" value="'.$VALOR_TOTAL_COMPRA.'" >';
echo'<input type="hidden" name="VALOR_TOTAL_EXCEDENTE" id="venta" value="'.$acumuladoIva.'" >';
 ?> 
<div align="center">
<table width="617" border="0">
  <tr>
  <td colspan="4"align="center"><h2>REGISTRO DEL IVA</h2></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Valor de los Articulos vendidos</td>
    <td width="166">&nbsp;<?php echo amoneda($VALOR_PARCIAL, pesos);?></td>
    <td width="149">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Valor total de la Venta </td>
    <td>&nbsp;<?php echo amoneda($VALOR_TOTAL, pesos);?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Valor de los Articulos comprados</td>
    <td width="166">&nbsp;<?php echo amoneda($VALOR_PARCIAL_COMPRA, pesos);?></td>
    <td width="149">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;Valor total de la compra </td>
    <td>&nbsp;<?php echo amoneda($VALOR_TOTAL_COMPRA, pesos);?></td>
    <td>&nbsp;</td>
  </tr>
   <tr>
       <td  colspan="4" >&nbsp;IVA ventas :<span style="color:white;background-color: #4f54e2;">&nbsp;<?php echo amoneda($VALOR_IVA, pesos);?>&nbsp;</span> 
           | &nbsp;IVA compras : <span style=" color:white;   background-color: #C69;">&nbsp;<?php echo amoneda($VALOR_IVA_COMPRA, pesos);?>&nbsp;</span> 
            | &nbsp;IVA excedente : <span style=" color:white;   background-color: #C69;">&nbsp;<?php echo amoneda($acumuladoIva, pesos);?>&nbsp;</span> 
       
 
       </td>
     
  </tr>
  <tr>
    <td width="200">&nbsp;Total Impuesto a pagar</td>
    <td colspan="3" style="font-size:56px; background-color:#C69">&nbsp;<?php echo amoneda($iva_a_pagar, pesos);?></td>
    
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="image" class="botonIVA" id="registarPago" 
                                          title="Regista el pago del impuesto"  
                                          src="imagenes/accept (2).png"></form>
 
    </td>
   
  </tr>
</table>
    <table class="table" style="font-size: 10px">
        <?php echo $html;?>
    </table>
</div>

<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>

<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);

	$('#volverAtras').click(function(e){
		e.preventDefault();
		location.href='menuTrans.php'
			});	
   });			 
					

</script>
