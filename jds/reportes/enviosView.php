<?php
include '../php/inicioFunction.php'; 
verificaSession_2("../login/");
include '../db_conection.php';
$totalPrestamosIniciales = $totalAbonosAcumulado= $totalDeudaActual =0;
if($_GET['id']){$auxQ=" WHERE c.nombre LIKE'%".$_GET['id']."%' OR cl.razonSocial LIKE'%".$_GET['id']."%'";
$auxQ= $auxQ." or c.idCuenta LIKE'%".$_GET['id']."%' OR cl.nit LIKE'%".$_GET['id']."%' ";
}
$mysqli = cargarBD();
//ORDER BY  `producto`.`Grupo` ASC 
//$query=" SELECT * FROM allProductPlusTotalSales ".$auxQ." order by IDLINEA";

$query=" SELECT c.idCuenta ,c.refFact, c.nombre , c.fechaIngreso, c.descripcion,   c.TotalInicial , c.valorInicial , c.abonoInicial, c.valorCuota , c.TotalActual,
cl.nit , cl.razonSocial , cl.telefono , cl.direccion ,ab.Tabono FROM `cartera`c left join clientes cl on cl.idCliente = c.idCliente
left join (select sum(valorAbono) AS Tabono , idFactura as abidf from abonoscartera group by idFactura) ab
on ab.abidf = c.idCuenta".$auxQ." ORDER by 1,3";
//echo $query;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
?>
<table border="1" width="100%" style="border:thin #7DA2FF">
<tr bordercolor="#000033" class="titulos" >
<td  >Cuenta</td>
	<td  align="center" style='width:20%'>Descripcion</td>
	<td  >Fecha inicio</td>
    <td  align="center" style='width:6%'>Monto</td>
	<td  style='width:6%'>1er Abono</td>
	<td  style='width:6%'>Deuda inicial</td>
	<td style='width:6%' >valor X cuotas</td>
	<td style='width:6%' >T. abonos</td>
	<td  style='width:6%'>Deuda actual</td>
	<td align="center">Ra. Social</td>
	<td align="center">Nombre</td>
    <td  align="center">NIT</td>
	<td  >Telefono</td>
	<td  align="center" style='width:10%'>Direccion</td>
</tr>
<style>
.listaInv{ cursor:pointer;}
tr{font-size:12px;}
.titulos{font-size:14px; color: #333; background-color:#CCC}
</style>
<?php

if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$color="#7DA2FF";
	if($row['cantActual']<$row['stock']){
	$color="#FF9194";}
	//ALTER TABLE `cartera` ADD `refFact` VARCHAR(60) NOT NULL DEFAULT 'N/A' AFTER `TotalActual`;
	$listaInv='';
	//echo $row['refFact'];
	if (trim($row['refFact']) != 'N/A') {
		$envioDato = $row['refFact'];$listaInv='listaInv';}
	echo'<tr align="center" bgcolor="'.$color.'" id="'.$envioDato.'" class="'.$listaInv.'"  >';
	echo '<td>'.$row['idCuenta'].'</td>';
	echo '<td align="left">'.$row['descripcion'].'</td>';
	echo '<td>'.$row['fechaIngreso'].'</td>';
	echo '<td align="right">'.amoneda($row['TotalInicial'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['abonoInicial'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['valorInicial'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['valorCuota'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['Tabono'],"pesos").'</td>';
	echo '<td align="right">'.amoneda($row['TotalActual'],"pesos").'</td>';
	echo '<td align="left">'.$row['razonSocial'].'</td>';
	echo '<td align="left">'.$row['nombre'].'</td>';
	echo '<td>'.$row['nit'].'</td>';
	echo '<td>'.$row['telefono'].'</td>';
	echo '<td>'.$row['direccion'].'</td></tr>';
	$totalDeudaActual= $totalDeudaActual + ($row['TotalActual'] );
	$totalAbonosAcumulado=$totalAbonosAcumulado+$row['Tabono'];
	$totalPrestamosIniciales=$totalPrestamosIniciales + $row['valorInicial'];
	}

}else{echo'<tr><td align="center" colspan="14">NO POSEE NINGUN REGISTRO</td></tr>';}
?></table>
<div id="menu">
<ul>
	<li id="eliminar">Eliminar</li>
    <li id="editar">Editar</li>
     <li id="menu_recargar">Actualizar</li>
</ul>
</div>
<form action="reporteFactura.php" method="post">
<input type="hidden" id="dato" name="codigo">
<input type="submit" id="enviar" style="display:none">
</form>
<input type='hidden' value='<?php echo amoneda($totalAbonosAcumulado,"pesos");?>' id='totalAbonosAcumulado'/>
<input type='hidden' value='<?php echo amoneda($totalPrestamosIniciales,"pesos");?>' id='totalPrestamosIniciales'/>
<input type='hidden' value='<?php echo $datosNum;?>' id='totalPrestamos'/>
<input type='hidden' value='<?php echo amoneda($totalDeudaActual,"pesos");?>' id='totalDeudaActual'/>
<link type="text/css" href="../css/menuContextual.css" rel="stylesheet" />
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>

<script type="text/javascript" >
var menuId = "menu";  
var menu = $("#"+menuId);  
$(document).ready(function(){
	 padre = $(window.parent.document);
 $(padre).find("#sp_1").html($('#totalPrestamosIniciales').val())
 $(padre).find("#sp_2").html($('#totalPrestamos').val())
 $(padre).find("#sp_3").html($('#totalDeudaActual').val())
 $(padre).find("#sp_4").html($('#totalAbonosAcumulado').val())
	$(".listaInv").bind("contextmenu", function(e){  
	$('#dato').val($(this).attr("id"));
	//alert($('#dato').val())	
    menu.css({'display':'block', 'left':e.pageX, 'top':e.pageY});  
    return false;  
}); 
 $(document).unbind('click');
$(document).click(function(e){  
    if(e.button == 0 && e.target.parentNode.parentNode.id != menuId){  
        menu.css("display", "none");  
    }  
});  
//pulsacion tecla escape 
$(document).unbind('keydown')
$(document).keydown(function(e){  
    if(e.keyCode == 27){  
        menu.css("display", "none");  
    }  
});  
menu.unbind('click')
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
$(".listaInv").unbind('click');
		$(".listaInv").click(function(){
			$('#dato').val($(this).attr("id"));
			//alert('ahora tiene que enviar' + $('#dato').val())
			$('#enviar').trigger('click');
			});	
		
 });
function elimina(dato){
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ARTICULO");
		if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent("producto")
		  +"&columna="+encodeURIComponent('idProducto');
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