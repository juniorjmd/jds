<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<?php 
include 'db_conection.php';
$mysqli = cargarBD();

$tabla=$_GET["tabla"];
$dato=$_GET["dato"];
$columna=$_GET['col'];
$SUMATOTAL=0;
$total_iva = 0;
$html="";
$query="SELECT * FROM  `".$tabla."` 	WHERE  `".$tabla."`.`".$columna."` =".$dato." ";
$result = $mysqli->query($query);
//echo $query;
while ($row = $result->fetch_assoc()) {
$html=$html."<tr>
<td><img src='imagenes/equis_naranja.gif' height='15' class='listaInv' id='".$row["idLinea"]."'></td>
<td >".$row["idProducto"]." </td>
<td >".modificaCaracteres( $row["nombreProducto"] )."</td>
<td align='right' style'white-space: nowrap;'>$ ".number_format($row["presioCompra"], 2)."</td>
<td align='right'> ".$row["porcent_iva"]."%</td>
<td align='right' style'white-space: nowrap;'>$ ".number_format($row["iva"], 2)."</td>
<td align='right'> ".$row["cantidad"]."</td>
<td  align='right' style'white-space: nowrap;'>$ ".number_format($row["valorTotal"], 2)."&nbsp;&nbsp;</td> </tr>";
$SUMATOTAL=$SUMATOTAL+$row["valorsiva"];
$total_iva += $row["iva"];
}
$total_compra = $SUMATOTAL + $total_iva;
 
$result->free();
$mysqli->close();
?>
 
<input type="hidden" id="tabla_actual" value="<?php echo $tabla;?>"/>
<br>
<table class="table"><tr>
<td width="30px">&nbsp;</td>
<td width="120px" align="center" bgcolor="#FBFBFB"><span class="Estilo5">Codigo</span></td>
<td width="292px" align="center" bgcolor="#FBFBFB"><span class="Estilo5">Nombre/Descripci&oacute;n</span></td>
<td width="150px"align="center" bgcolor="#FBFBFB"><span class="Estilo5">Precio</span></td>
<td width="150px"align="center" bgcolor="#FBFBFB"><span class="Estilo5">%Iva</span></td>
<td width="150px"align="center" bgcolor="#FBFBFB"><span class="Estilo5">Iva</span></td>
<td width="150px" align="center" bgcolor="#FBFBFB"><span class="Estilo5">Cantidad</span></td>
<td width="150px" align="center" bgcolor="#FBFBFB"><span class="Estilo5">Total</span></td>
</tr>
<?php echo $html;?>
<tr>
<td colspan="6">&nbsp;</td>
</tr><tr>
<td height="37" colspan="7"align="right" >
  <span class="Estilo14">Sub Total </span></td>
<td align="right" bgcolor="#F8F8F8" style=" white-space: nowrap;" ><span class="Estilo15">
<input type='hidden' value='<?php echo $SUMATOTAL ;?>'  id='val_subtotal'/>
<?php echo "$ ".number_format($SUMATOTAL,2);?></span></td>
</tr>
<tr>
<td height="37" colspan="7"align="right" >
  <span class="Estilo14">IVA</span></td>
<td align="right" bgcolor="#F8F8F8" style=" white-space: nowrap;"><span class="Estilo15">
<input type='hidden' value='<?php echo $total_iva ;?>'  id='iva_total'/>
<?php echo "$ ".number_format($total_iva,2);?></span></td>
</tr>
<tr>
<td height="37" colspan="7"align="right" >
  <span class="Estilo14">Total</span></td>
<td align="right" bgcolor="#F8F8F8" style=" white-space: nowrap;"><span class="Estilo15">
<input type='hidden' value='<?php echo $total_compra ;?>'  id='total_compra'/>
<?php echo "$ ".number_format($total_compra,2);?></span></td>
</tr>
</table>

<link type="text/css" href="css/menuContextual.css" rel="stylesheet" />
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>

<script type="text/javascript" >
var menuId = "menu";  
 padre = $(window.parent.document);
 $(padre).find("#val_subtotal_compra").val($('#val_subtotal').val())
 $(padre).find("#rfventaBruta").val($('#total_compra').val())
 $(padre).find("#rfventaNeta").val($('#val_subtotal').val()) 
 $(padre).find("#rfiva").val($('#iva_total').val()) 
 
 
 $(padre).find("#rftotalRetenido").val((parseFloat($('#val_subtotal').val() || 0)*parseFloat($(padre).find("#rfporcent").val() || 0))/100)
 $(padre).find("#v_rftotalRetenido").val('$ '+parseFloat($(padre).find("#rftotalRetenido").val() || 0).toLocaleString())

 $(padre).find("#v_rfventaBruta").val('$ '+parseFloat($('#total_compra').val() || 0).toLocaleString())
 $(padre).find("#v_rfventaNeta").val('$ '+parseFloat($('#val_subtotal').val() || 0).toLocaleString()) 
 $(padre).find("#v_rfiva").val('$ '+parseFloat($('#iva_total').val() || 0).toLocaleString())
 
 //$(padre).find(".rftotalRetenido").val($('#val_subtotal').val())
var menu = $("#"+menuId);  
$(document).ready(function(){
$(".listaInv").click(function(){
elimina($(this).attr("id"))
});	
		
});
function elimina(dato){
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ARTICULO");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent($('#tabla_actual').val())
		  +"&columna="+encodeURIComponent('idLinea');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
			//alert(responseText)
			window.location.reload()
			}
					});
			
			
		}
	}

</script> 