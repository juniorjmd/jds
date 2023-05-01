<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include '../php/db_conection.php';
if($_GET['id']){$auxQ="WHERE `nombre` LIKE'%".$_GET['id']."%' OR `Grupo` LIKE'%".$_GET['id']."%'";}
$mysqli = cargarBD();
?>
<table border="1" width="600px" style="border:thin #7DA2FF; ">
<tr bordercolor="#000033" style="color:#999; font-size:20px" >
<td width="71" ><strong>ID</strong></td>
	<td width="300"align="center"><strong>NOMBRE</strong></td>
	<td width="80"><strong>PRECIO VENTA</strong></td>
	<td width="80"><strong>CANT. ACTUAL</strong></td></tr>
</tr>
<?php 
//ORDER BY  `producto`.`Grupo` ASC 
$query="SELECT * 
FROM  `producto` ".$auxQ." ";
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$color="#7DA2FF";
	if($row['cantActual']<$row['stock']){
	$color="#FF9194";}
	echo'<tr align="center" bgcolor="'.$color.'" id="'.$row['idProducto'].'" class="listaInv" style="cursor:pointer" >';
	echo '<td>'.$row['idProducto'].'</td>';
	echo '<td>'.$row['nombre'].'</td>';
	echo '<td>'.$row['precioVenta'].'</td>';
	echo '<td>'.$row['cantActual'].'</td></tr>
	<input type="hidden" value="'.$row["nombre"].'" id="NP_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["stock"].'" id="stock_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["cantActual"].'" id="cantActual_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["tipo_producto"].'" id="tipo_producto_'.$row["idProducto"].'">

<input type="hidden" value="'.$row["nombre"].'" id="NP_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["PsIVA"].'" id="PsinIva_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["IVA"].'" id="Iva_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["precioVenta"].'" id="PV_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["porcent_iva"].'" id="porcentIva_'.$row["idProducto"].'">
<input type="hidden" value="'.$row["idGrupo"].'" id="id_grupo_'.$row["idProducto"].'">';

	}
}else{echo'<tr><td align="center" colspan="10">NO POSEE NINGUN REGISTRO</td></tr>';}
?></table>
<link type="text/css" href="../css/menuContextual.css" rel="stylesheet" />
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>

<script language="javascript1.1" src="../jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="../jsFiles/funciones.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorContenidos.js"></script>
<script type="text/javascript" >
var menuId = "menu";  
var menu = $("#"+menuId);  
$(document).ready(function(){
	$(".listaInv").bind("contextmenu", function(e){  
	$('#dato').val($(this).attr("id"));
	//alert($('#dato').val())	
    menu.css({'display':'block', 'left':e.pageX, 'top':e.pageY});  
    return false;  
}); 

 
 
$(".listaInv").unbind('click');
		$(".listaInv").click(function(){
			//$('#dato').val($(this).attr("id"));
			//alert('ahora tiene que enviar')
			//$('#enviar').trigger('click');
			
			
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
						var pv_iva ;
					var ps_iva ;
					var iva ;
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
					 pv_iva = formatNumber.new( $("#PV_"+$(this).attr("id")).val(), "$");
					 ps_iva = formatNumber.new( $("#PsinIva_"+$(this).attr("id")).val(), "$") ;
					 iva = formatNumber.new( $("#Iva_"+$(this).attr("id")).val(), "$") ;
                                         var id_preventa_aux = "#PV_"+$(this).attr("id")
                                         var id_PsIVA_aux = "#PsinIva_"+$(this).attr("id")
                                         var id_IVA_aux = "#Iva_"+$(this).attr("id")
                                         
                                         //console.log(id_preventa_aux +' : '+ $(id_preventa_aux).val() + id_PsIVA_aux +' : '+$(id_PsIVA_aux).val()  + id_IVA_aux +' : '+$(id_IVA_aux).val())
                                         
            
                                         window.parent.Global_preventa = $(id_preventa_aux).val()  ;
                                         window.parent.Global_PsIVA = $(id_PsIVA_aux).val()
                                         window.parent.Global_IVA = $(id_IVA_aux).val()
                                         
					 $(padre).find("#idProducto").val($(this).attr("id"))
					 $(padre).find("#nombreProducto").val( $("#NP_"+$(this).attr("id")).val())
					 $(padre).find("#presioVenta").val($("#PV_"+$(this).attr("id")).val())					
					 $(padre).find("#busquedaArticulo").css("display","none")
					 $(padre).find("#PsIVA").val($("#PsinIva_"+$(this).attr("id")).val())
					 $(padre).find("#IVA").val($("#Iva_"+$(this).attr("id")).val())
					 $(padre).find("#porcent_iva").val($("#porcentIva_"+$(this).attr("id")).val())
                                         var tipo = $("#tipo_producto_"+$(this).attr("id")).val()
                                         var padre_2;
                                        if (tipo == 'MT'){
                                             padre_2 = $(padre).find("#transformar");
                                             window.parent.id_grupo_producto = $("#id_grupo_"+$(this).attr("id")).val();
                                              //alert($("#id_grupo_"+$(this).attr("id")).val())
                                             $(padre).find('#generar_tipos_medidas').trigger('click')
                                         }else{ 
                                            padre_2 = $(padre).find("#liquidar");
                                         }
                                       
					 padre_2.find("#pVenta").html(pv_iva)
					 padre_2.find("#Ps_IVA").html(ps_iva )
					 padre_2.find("#_IVA").html(iva)
					  padre_2.css("display","inline")
					 $("#nomProducto").html( $("#NP_"+$(this).attr("id")).val())
					 	 }
					
			
			});	
		
 });


</script> 