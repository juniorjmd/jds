<?php
include 'db_conection.php';
if($_POST['id']){$auxQ="WHERE `nombre` LIKE'%".$_POST['id']."%'";}
$mysqli = cargarBD();
$query="SELECT * 
FROM  `combos` ".$auxQ;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$color="#7DA2FF";
	$queryCant="SELECT * FROM `relacioncombo` INNER JOIN producto on (relacioncombo.idProducto = producto.idProducto) WHERE `id`= '".$row['idCombo']."'";
$resultCant = $mysqli->query($queryCant);
$datosNum=$mysqli->affected_rows;
while ($rowAux = $resultCant->fetch_assoc()) {
	if($rowAux['cantActual']<$rowAux['stock']){
	$color="#FF9194";}
	
}
	
	echo'<tr align="center" bgcolor="'.$color.'" id="'.$row['idCombo'].'" class="listaInv" style="cursor:pointer" >';
	echo '<td>'.$row['idCombo'].'</td>';
	echo '<td>'.$row['nombre'].'</td>';
	echo '<td>'.$row['precioVenta'].'</td></tr>';
	}
}else{echo'<tr><td align="center" colspan="3">NO POSEE NINGUN REGISTRO</td></tr>';}
?>
<div id="menu">
<ul>
	<li id="eliminar">Eliminar</li>
    <li id="editar">Editar</li>
     <li id="menu_recargar">Actualizar</li>
</ul>
</div>
<form action="editarCombo.php" method="post">
<input type="hidden" id="dato" name="codigo">
<input type="submit" id="enviar" style="display:none">
</form>

<link type="text/css" href="css/menuContextual.css" rel="stylesheet" />
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>

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
                alert("ha seleccionado siguiente");  
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
		
 });
function elimina(dato){
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ARTICULO");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent("combos")
		  +"&columna="+encodeURIComponent('idCombo');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: datos,
			success: function(responseText){
					datos='dato='+encodeURIComponent(dato)
		  			+"&tabla="+encodeURIComponent("relacioncombo")
		  			+"&columna="+encodeURIComponent('id');
					$.ajax({
							url: 'EliminaX.php',  
							type: 'POST',
							
							data: datos,
							success: function(responseText){
							}
									});
			window.location.reload()
			}
					});
			
			
		}
	}

</script> 