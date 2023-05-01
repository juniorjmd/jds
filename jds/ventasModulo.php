<title>MODULO VENTAS-<?php echo $_SESSION["sucursalNombre"];?>-</title>
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="jsFiles/fullScreen.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>
<link media="screen" rel="stylesheet" href="css/menuDesplegable.css" />
<style>
.calculadora{ height:50px; width:50px}
#suma10{ height:50px; width:50px}
#cantidadVenta{height:50px; width:220px; 
}
#liquidar{padding: 10Px; color: #ffffff; font-weight: bold; position: absolute; background-color: #006699; z-index: 5; left: 50%; top: 200px; width: 250px; height: 339px; display:none}

#busquedaArticulo{padding: 10Px; color: #ffffff; font-weight: bold; position: absolute; background-color: #065; z-index: 5; left: 25%; top: 80px;  display:none}
 
a{ text-decoration:none; color:#006699}
#tabConf td{ background-color:#7DA2FF}
#tabConf #nop{ background-color: #006699;}
input[type="text"] {
    font-family: Arial, san-serif;  font-size:24px
}
span{font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
.busqueda{font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif }
</style>
<div id="container" align="center" style="display:none"> 
<div id="cabeza" align="left"><span>
Descripcion Producto</span> <span id="nombreProducto"></span><span > Fecha: <?php echo date("d/m/Y")?></span>
<br>
</div>

<div id="central">
<iframe align="bottom" class="frame1" name="frame1" id="frame1" src="listaPedidoAux.php" height="500px" width="600px" style="overflow:auto"></iframe>
</div>

<div id="fotter"  width="600px"  align="center" >
<span>Codigo del producto </span><input type="text" id="idProducto">
</div></div>
<div id="divCliente" align="center" style="margin-top:400"><span>Codigo del cliente </span><input type="text" id="nombreCliente"><input type="image" id="enterCliente" src="imagenes/accept (3).png" width="50" height="35"></div>
<script type="text/javascript" >
$("#nombreCliente").keydown(function(e){
		alert(String.fromCharCode(e.which))
		var tecla=String.fromCharCode(e.which);
		
		if (tecla==13){alert("enter")}
if($(this).val()!=""){
	OcultaYMuestra("#nombreCliente","#container")
	$(document).unbind('keydown');
$(document).keydown(function(e){
		//alert(e.keyCode)
		var tecla=e.keyCode;
		if(tecla==27){$("#cerrarBuscar").trigger("click");
		$("#cerrarConf").trigger("click");
	}
	if(tecla==113){$('#inicioBuscar').trigger("click");
	}
	if(tecla==115){$("#config").trigger("click");
	}
	});
	}
	});


$("#nombreCliente").focus()
$("#nombreCliente").focusout(function() {$("#idProducto").focus()})

</script>