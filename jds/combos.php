<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<div id="cuerpoTotal" align="center">
<table width="1200px">
<tr>
<td colspan="10" align="right"><br><a href="inventario.php">
<input type="image"  src="imagenes/proveedores.jpg" height="60" title="visualizar, modificar y eliminar los productos del inventario"></a><a href="actuProductos.php">
<input type="image" src="imagenes/actualizar.png" height="50" title="actualizar los presios de todos los productos"></a>
<a href="grupos.php?llamado=4502ffj"><input type="image" src="imagenes/icono_grupo.jpg" height="50" title="VISTA Y CREACION DE GRUPOS"></a>
<a href="CreaProductos.php"><input type="image" src="imagenes/nuevo.jpg" height="50" title="nuevo producto"></a><a href="crearCombos.php">
  <input type="image" src="imagenes/crearCombo.jpg" height="50" title="nuevo Combo de productos">
</a>  <a href="cierreCaja.php"><input type="image" src="imagenes/images (6).jpg" height="50" title="cierre de caja"></a> &nbsp;<a href="index.php"><input type="image" src="imagenes/home_w.png" height="50" title="regresar a menu de inicio"></a> &nbsp;<a href="index.php"><input type="image" src="imagenes/close-panel-png-md.png" height="50" title="salir"></a> </td>
</tr>

<tr><td align="center" colspan="10">BUSCAR <input type="text" id="busqueda" size="80px"></td>
</tr></table>
<table border="1" width="700px" style="border:thin #7DA2FF">
<tr bordercolor="#000033" >
<td width="71" >ID</td>
	<td width="301"align="center">NOMBRE</td>
	<td width="75">PRESIO VENTA</td>
</tr><tbody id="cuerpo"><?php 
include 'combosView.php';
?></tbody></table></div>

<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
		$("#busqueda").keyup(function(){//alert($(this).val())
		var datosAjax='id='+encodeURIComponent($(this).val())+"&nocache=" + Math.random();
			$.ajax({
            url: 'combosView.php',
            type: 'POST',
         	async: true,
            data: datosAjax,
            beforeSend: function(){
                //$(".filasData").attr("disabled","disabled")
			 },
            //una vez finalizado correctamente
            success: function(responseText){//alert(responseText)
				$("#cuerpo").html(responseText);
			  },//si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                alert(message);
            }});
		});	
		
 });

</script> 