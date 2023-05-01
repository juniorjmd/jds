<?php include 'db_conection.php';
$mysqli = cargarBD();
include 'php/inicioFunction.php';
?>
<!doctype html>
<html>
<head>
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
			OcultaYMuestra(".divListas","#divListas1");
			$("#atrasDiv").click(function(){
				var anterior=$("#anterior").html();
				var actual=$("#actual").html();
				OcultaYMuestra("#divListas"+actual,"#divListas"+anterior);
				var NumDiv=parseInt($("#numeroDiv").val());
				switch(NumDiv){
				case  1:
				break;
				case  2:
					$("#anterior").html(actual);
					$("#actual").html(anterior);
					$("#siguiente1").html(actual);
					break;
					default:
					/////////////////////////
					$("#actual").html(anterior);
					var penultimo=$("#siguiente"+(NumDiv-2)).html();
					$("#anterior").html(penultimo);
					var ultimo=parseInt($("#siguiente"+(NumDiv-1)).html())
					for(i=2;i<NumDiv;i++){//inicio for
						var aux=parseInt($("#siguiente"+i).html())
						if(aux==1){aux=NumDiv;}else{aux--;}
						$("#siguiente"+i).html(aux);}//fin for
					$("#siguiente1").html(actual);
				break;
			}
		});
///////////////////////////////////////////////			
		$("#siguienteDiv").click(function(){
			var anterior=$("#anterior").html();
			var actual=$("#actual").html();
			var siguiente=$("#siguiente1").html();
			OcultaYMuestra("#divListas"+actual,"#divListas"+siguiente);
			var NumDiv=parseInt($("#numeroDiv").val());
			switch(NumDiv){
				case  1:
				break;
				case  2:
					$("#anterior").html(actual);
					$("#actual").html(anterior);
					$("#siguiente1").html(actual);
				break;
				default:
				/////////////////////////
					$("#actual").html(siguiente);
					var ultimo=parseInt($("#siguiente"+(NumDiv-1)).html())
					for(i=1;i<NumDiv;i++){//inicio for
						var aux=parseInt($("#siguiente"+i).html())
						if(aux==NumDiv){aux=1;}
						else{aux++;}
						$("#siguiente"+i).html(aux);}//fin for
					$("#anterior").html($("#siguiente"+(NumDiv-1)).html());
				break;
				}
		});
			
		$(".filasData").click(function(){
			 padre = $(window.parent.document);
 		    		 if ($(padre).find("#ayudame").html()=="SELECCIONE UNA MESA"){
							alert ("POR FAVOR SELECCIONE UNA MESA PARA FACTURAR")
							}else{var cantAct;
						$(padre).find("#cantidadVenta").val(0);
						enableDisable(".filasData")
						  $.ajax({
						url: 'verificaCantidad.php',  
						type: 'POST',
						
						data: "idProducto="+$(this).attr("id"),
						success: function(responseText){
						$(padre).find("#cantActualArt").val(Trim(responseText))
						//alert(responseText)
						}
					});
						cantAct=parseInt($(padre).find("#cantActualArt").val());
					 var stock=$("#stock_"+$(this).attr("id")).val()
						 if(cantAct<10)
						 {$(padre).find("#suma10").attr('disabled', 'disabled');
						 $(padre).find("#guardarliquidar").attr('disabled', 'disabled');
						  $(padre).find(".calculadora").each(function(index, element) {
						           cantida=parseInt($(this).val()) 
									  if(cantida>cantAct){
										  $(this).attr("disabled","disabled");
										  }
									  });
							 }
					 $(padre).find("#idProducto").val($(this).attr("id"))
					 $(padre).find("#nombreProducto").val( $("#NP_"+$(this).attr("id")).val())
					 $(padre).find("#presioVenta").val($("#PV_"+$(this).attr("id")).val())
					 $(padre).find("#PsIVA").val($("#PsinIva_"+$(this).attr("id")).val())
					 $(padre).find("#IVA").val($("#Iva_"+$(this).attr("id")).val())
					 $(padre).find("#porcent_iva").val($("#porcentIva_"+$(this).attr("id")).val())
					 $(padre).find("#liquidar").css("display","inline")
					}
					});
 });	
</script>
<style>
.nombresProductos{ color: #333; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif
 }
</style>
<div id="listado" style="padding:10px" >
  <?php

if(!$_GET['dato']){$dato="1";}else{$dato=$_GET['dato'];}
if(!$_GET['columna']){$columna="idGrupo";}else{$columna=$_GET['columna'];}


$query="SELECT * FROM  `producto` WHERE `".$columna."`='".$dato."';";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
$filasNum=12;
if($datosNum>0){
			$contadorAux=0;					
$numeroDiv=verificaNumeroDeIntervalos($datosNum,$filasNum);
$contador=0;
		 echo '
		   <table border=1  style="border:thin; width:100%;cursor:pointer">
             <tr>
               <td width="40" align="center"  class="ui-widget-header" ><input width="40" type="image" id="atrasDiv" src="imagenes/flechaAtras.jpg" title="anterior"></td>
               <td width="100" align="center" class="ui-widget-content"><span id="anterior">'.$numeroDiv.'</span> </td>
               <td width="30" align="center" class="ui-widget-header" style="font-size:24px;color:#fffff; "><span name="number" id="actual"   />1</td>
               <td width="210" align="center" class="ui-widget-content">';
			  if($numeroDiv>=2){$aux=0;
			   for($i=2;$i<=$numeroDiv;$i++)
			   {$aux++;
			   echo '<span id="siguiente'.$aux.'">'.$i.' </span> ';	   
			   }}
			   else{echo '<span id="siguiente1">1</span>';}
			  echo '</td>
               <td width="40"  align="center" class="ui-widget-header" ><input width="40" type="image" id="siguienteDiv" src="imagenes/flechaAdelante.jpg" title="siguiente"></td>
             </tr></table>';
			}

if($datosNum>0){
$contadorAux=0;					
$numeroDiv=verificaNumeroDeIntervalos($datosNum,$filasNum);
$contador=0;
$cont2=0;
while ($row = $result->fetch_assoc()) {
		$cont2++;
		if($contador==0){
		$contadorAux++;
		echo'
		<div id="divListas'.$contadorAux.'"  class="divListas" style="border=1">
		<table   height="55"  border="0"   style="border:thin; width:100%;cursor:pointer" >
		<tr><td width="170" ></td><td width="170"></td><td width="170"></td><td width="170"></td></tr>
							';}
///////////////////////////////////////////////////////////////////////////////					
if($cont2==1){echo'<tr>';}
$BGcolor='bgcolor="#C0FA87"';
if(($row["cantActual"]>0)&&($row["cantActual"]<=$row["stock"])){
	$BGcolor='bgcolor="#FFB0B0"';
	}
if(($row["cantActual"]<=0)){$BGcolor='bgcolor="#D90444"';}

echo'<td width="170" '.$BGcolor.' align="center" valign="top"><input type="image" id="'.$row["idProducto"].'" name="pictSelct" src="'.$row["imagen"].'" height="150" width="98%" class="filasData"  ></br>
<span class="nombresProductos" >'.$row["nombre"].'</span>
<input type="hidden" value="'.$row["nombre"].'" id="NP_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["PsIVA"].'" id="PsinIva_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["IVA"].'" id="Iva_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["precioVenta"].'" id="PV_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["porcent_iva"].'" id="porcentIva_'.$row["idProducto"].'">

<input type="hidden" value="'.$row["stock"].'" id="stock_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["cantActual"].'" id="cantActual_'.$row["idProducto"].'">
</td>';

if($cont2==4){echo'</tr>';$cont2=0;}
$contador++;
if (($contador==$filasNum)&&($contadorAux<$numeroDiv))
{echo " </table></div>";$contador=0;}
}
echo '</table></div>
<input type="hidden" value="'.$numeroDiv.'" id="numeroDiv" />';
}
else{echo'<span>en este momento no se encuentra registrado ningun Articulo</span></div>';
}
?> 
</div>
</div>