<?php 
include 'php/inicioFunction.php';
verificaSession_2("login/"); 
include 'db_conection.php';
$conn= cargarBD();
$tabla="";
if($_POST["id"]){
	$stmt = $conn->stmt_init();
		$query="INSERT INTO `empleados` ( `id` ,`nombre` ,`apellido` , `monto_dia`  ) VALUES ( '".$_POST['id']."', '".$_POST['nombre']."',  '".$_POST['apellido']."',  '".$_POST['val_por_dia']."' );";
		echo $query;
                $stmt->prepare($query);
		if(!$stmt->execute()){//Si no se puede insertar mandamos una excepcion
		throw new Exception('No se pudo insertar los datos en la tabla :' . $conn->error);
		 
		}else{echo '<script>window.location="empleado.php"</script>';}
	
	}
	
	$query2="SELECT * FROM `empleados`";
//echo $query2;
$result = $conn->query($query2);
if($result->num_rows!=0){
while ($row = $result->fetch_assoc()) { 
	$tabla=$tabla.'<tr class="listaInv" id="'.$row["id"].'">
	<td>'.$row["id"].'</td>
	<td>'.$row["nombre"].' '.$row["apellido"].'</td>
	<td>'.$row["monto_dia"].'</td>
	</tr>';
} 
}

if($tabla==""){$tabla="<tr><td colspan='4'>No posee ningun empleado registrado</td>
</tr>";} ?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Empleados</title>
</head>

<body>
<div id="menu">
<ul>
	<li id="eliminar">Eliminar</li>
    <li id="editar">Editar</li>
     <li id="menu_recargar">Actualizar</li>
</ul>
</div>


<div align="center"><br>CREACION DE EMPLEADOS<input style="margin-left:100px" id="cancelar" type="image" title="volver al menu anterior" src="imagenes/cancelar.jpg" height="50" width="60">
<form action="empleado.php" method="post">
<table>

<tr> <td height="40" colspan="4"align="center"></td></tr>
<tr>
<td height="41" align="right">Id</td><td><input type="number" name="id"></td>
</tr>
<tr>
<td height="45" align="right">Nombre</td><td><input type="text" name="nombre"></td><td align="right">Apellido</td><td><input type="text" name="apellido"></td>
</tr>
<tr>
<td align="right">Valor por dia</td><td><input type="number" name="val_por_dia"></td><td><input type="image" src="imagenes/accept (2).png" height="50" width="60"></td><td></td>
</tr>
</table>
</form></div>
<div id="listadoEmpleados" align="center">
<table width="609" height="55">
<tr style="font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif">
<td width="142" height="48">IDENTIFICACION</td>
<td width="334" align="center"> NOMBRE/APELLIDO </td>
<td width="170">PAGO POR DIA ($)</td>
</tr>
<?php echo $tabla; ?>
</table>
</div>
<form action="editarEmpleado.php" method="post">
<input type="hidden" id="dato" name="codigo">
<input type="submit" id="enviar" style="display:none">
</form>
</body>
</html>

<style >
.listaInv{ cursor:pointer; color:#039; font-family:Comic Sans MS,arial,verdana; font-size:18px}
.listaInv:hover{ background-color: #06C;color: #9C0}
</style>

<link type="text/css" href="css/menuContextual.css" rel="stylesheet" />
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>


<script type="text/javascript" language="javascript">
var menuId = "menu";  
var menu = $("#"+menuId); 
$(document).ready(function(){

	$("#cancelar").click(function(){
	location.href="index.php";
	});
	
	$(".listaInv").bind("contextmenu", function(e){  
	$('#dato').val($(this).attr("id"));
	//alert($('#dato').val())
	menu.css({'display':'block', 'left':e.pageX, 'top':e.pageY});  
    return false;  
}); 
	$(document).click(function(e){  
    if(e.button == 0 && e.target.parentNode.parentNode.id != menuId){  
        menu.css("display", "none");  
    }  
});  
//pulsacion tecla escape  
$(document).keydown(function(e){  
    if(e.keyCode == 27){  
        menu.css("display", "none");  
    }  
});  

menu.click(function(e){  
    //si la opcion esta desactivado, no pasa nada  
    if(e.target.className == "disabled"){  
        return false;  
    }  
    //si esta activada, gestionamos cada una y sus acciones  
    else{  
        switch(e.target.id){  
            case "menu_anterior":  
                history.back(-1);  
                break;  
            case "menu_siguiente":  
                //alert("ha seleccionado siguiente");  
                break;  
				case "editar":  
               $('#enviar').trigger('click');
                break;  
            case "eliminar":  
                elimina($('#dato').val())
                break;  
			case "menu_recargar":  
                document.location.reload();  
                break;  
            }  
        menu.css("display", "none");  
    }  
});  
		$(".listaInv").click(function(){
			$('#dato').val($(this).attr("id"));
			//alert('ahora tiene que enviar')
			$('#enviar').trigger('click');
			});	
	
})

</script>