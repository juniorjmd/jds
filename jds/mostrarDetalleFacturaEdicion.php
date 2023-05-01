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

if($tabla == 'listacompraedicion'){
 $query.= " AND estado <> 'D' ;";   
    
}

$result = $mysqli->query($query);
//echo $query;
while ($row = $result->fetch_assoc()) {
    $row["cantidad"] = $row["cantidad_edicion"];
    $row["valorTotal"] = $row["presioCompra"] * $row["cantidad"] ;
   $row["iva"] = $row["valorTotal"] * $row["porcent_iva"] / 100 ;
    $row["valorsiva"] =  $row["valorTotal"] -  $row["iva"] ;
$html=$html."<tr>
<td><img src='imagenes/equis_naranja.gif' height='15' class='listaInv' id='".$row["idLinea"]."'>"
. "</td> <td >".$row["idProducto"]." </td>
<td >".modificaCaracteres( $row["nombreProducto"] )."</td>
<td align='right' style'white-space: nowrap;'>$ ".number_format($row["presioCompra"], 2)."</td>
<td align='right'> ".$row["porcent_iva"]."%</td>
<td align='right' style'white-space: nowrap;'>$ ".number_format($row["iva"], 2)."</td>
<td > <input type='text' style='width:76%' value='{$row["cantidad"]}' id='nwCNT'   >"
                ."<button style='width:23%' src='imagenes/Save_37110.png' type'image'   data-idcompra = '{$dato}' data-cantact = '{$row["cantidad"]}' data-idlinea='{$row["idLinea"]}' class='enviarCantidadNueva'/>"
                ."ok</button> </td>
<td  align='right' style'white-space: nowrap;'>$ ".number_format($row["valorTotal"], 2)."&nbsp;&nbsp;</td> </tr>";
$SUMATOTAL=$SUMATOTAL+$row["valorsiva"];
$total_iva += $row["iva"];
}
$total_compra = $SUMATOTAL + $total_iva;
$datos["datos"]=$data;
$result->free();
$mysqli->close();
?>
<style type="text/css">
<!--
.Estilo5 {font-family: "Arial Narrow"; font-size: 17px; color: #993300; }
.Estilo14 {font-family: "Arial Narrow"; font-weight: bold; font-size: 30px; color: #993300; }
.Estilo15 {
	color: #996600;
	font-weight: bold;
}
-->
</style>
<input type="hidden" id="tabla_actual" value="<?php echo $tabla;?>"/>
<table width="100%" ><tr>
        <td width="30px">&nbsp;</td> 
<td width="120px" align="center" bgcolor="#FBFBFB"><span class="Estilo5">Codigo</span></td>
<td width="282px" align="center" bgcolor="#FBFBFB"><span class="Estilo5">Nombre/Descripci&oacute;n</span></td>
<td width="150px"align="center" bgcolor="#FBFBFB"><span class="Estilo5">Precio</span></td>
<td width="150px"align="center" bgcolor="#FBFBFB"><span class="Estilo5">%Iva</span></td>
<td width="150px"align="center" bgcolor="#FBFBFB"><span class="Estilo5">Iva</span></td>
<td width="160px" align="center" bgcolor="#FBFBFB" ><span class="Estilo5">Cantidad</span></td>
<td width="150px" align="center" bgcolor="#FBFBFB"><span class="Estilo5">Total</span></td>
</tr>
<?php echo $html;?>
<tr>
<td colspan="6">&nbsp;</td>
</tr><tr>
<td height="37" colspan="7"align="right" style="font-size:40px; color:#03C; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif">
  <span class="Estilo14">Sub Total </span></td>
<td align="right" bgcolor="#F8F8F8" style="color:#FFF; font-size:20px;white-space: nowrap;" ><span class="Estilo15">
<input type='hidden' value='<?php echo $SUMATOTAL ;?>'  id='val_subtotal'/>
<?php echo "$ ".number_format($SUMATOTAL,2);?></span></td>
</tr>
<tr>
<td height="37" colspan="7"align="right" style="font-size:40px; color:#03C; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif">
  <span class="Estilo14">IVA</span></td>
<td align="right" bgcolor="#F8F8F8" style="color:#FFF; font-size:20px;white-space: nowrap;"><span class="Estilo15">
<input type='hidden' value='<?php echo $total_iva ;?>'  id='iva_total'/>
<?php echo "$ ".number_format($total_iva,2);?></span></td>
</tr>
<tr>
<td height="37" colspan="7"align="right" style="font-size:40px; color:#03C; font-family:Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', serif">
  <span class="Estilo14">Total</span></td>
<td align="right" bgcolor="#F8F8F8" style="color:#FFF; font-size:20px;white-space: nowrap;"><span class="Estilo15">
<input type='hidden' value='<?php echo $total_compra ;?>'  id='total_compra'/>
<?php echo "$ ".number_format($total_compra,2);?></span></td>
</tr>
</table>
<div style="display:none">
<form method="POST" id="FORM_EDIT_CNT_PRD"  action="saveCompra.php"> 
     
     <input type="hidden" value="ok" id="edit" name="edit">
     <input type="hidden" value="ok" id="editExistente" name="editExistente">
     <input type="hidden"  id="idLinea" name="idLinea">
     <input type="hidden"  id="idCompra" name="idCompra">
      <input type="hidden"  id="Cantidad_a_comprar" name="Cantidad_a_comprar">
      <input type="submit" id="envioEditarLinea">
    
</form></div>
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

$('.enviarCantidadNueva').click(function(){ 
   var cantACT =  $(this).data('cantact') 
   cantACT = parseFloat(cantACT)
   var idCompra =  $(this).data('idcompra')
   var idLinea =  $(this).data('idlinea')
   try{
    var nwCNT =  $(this).parent().find('#nwCNT').val().replace(',','.')
    
     if (/^([0-9])*[.]?[0-9]*$/.test(nwCNT)){}else{
        $(this).parent().find('#nwCNT').val(cantACT);
            alert('error : La cantidad a enviar mayor a la cantidad actual'  );
        return false;}
    
    
    var repetir = 0;
    for (i = 0 ; i< nwCNT.length;i++)
    {  if(nwCNT[i] == '.'){
         repetir++;   
    } 
    } 
    
    nwCNT =  parseFloat(nwCNT)
    
    if (cantACT == nwCNT )
    {alert('error : La cantidad a enviar es la misma que tenia el producto'  );
        return false;}
    
   if (Number.isNaN(nwCNT) || repetir>0)
     throw "exite un error en la nueva cantidad "  
    }   
   catch(err){
       alert('error : ' + err );
       return false;
   } 
   
     $('#idLinea').val(idLinea) 
     $('#idCompra').val(idCompra) 
     $('#Cantidad_a_comprar').val(nwCNT) 
     $('#envioEditarLinea').trigger('click');            
})
		
});
function elimina(dato){
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ARTICULO");
		if(r==true){
			 
          
          var datos={
              dato     :  encodeURIComponent(dato),
              tabla    :  encodeURIComponent($('#tabla_actual').val()),
              columna  :  encodeURIComponent('idLinea'),
              action   :  'editarCompras'
          }
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