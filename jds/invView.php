<?php
include 'php/inicioFunction.php'; 
session_sin_ubicacion("login/");
include 'php/db_conection.php';
$total_unidades = $TOTALINVENTARIO= $TOTALINVENTARIOVENTA =0;
$busqueda = $_GET['id'];
$mysqli = cargarBD();
//ORDER BY  `producto`.`Grupo` ASC 
//$query=" SELECT * FROM allProductPlusTotalSales ".$auxQ." order by IDLINEA";

//$query="call busqueda_allproductplustotalsales('".$busqueda."')";

/*

	select COUNT(*) from allproductplustotalsales WHERE idProducto = _dato_busqueda  INTO @cantidad;
   if @cantidad = 0 then
    select COUNT(*) from allproductplustotalsales  WHERE barcode = _dato_busqueda INTO @cantBarcode;
		if @cantBarcode = 0 then
			set @w = ' where ';
            set @like_sh = concat('`nombre` LIKE ''%',_dato_busqueda,'%''  OR `Grupo`  LIKE  ''%',_dato_busqueda,'%''  OR `descripcion`  LIKE  ''%',_dato_busqueda,'%''  OR `nom_subgrupo_1`  LIKE  ''%',_dato_busqueda,'%''  OR `nom_subgrupo_2`  LIKE  ''%',_dato_busqueda,'%''  OR  `laboratorio` LIKE ''%',_dato_busqueda,'%''');
		else
			set @w = ' where ';
			set @id_sh = concat(' barcode = ''',_dato_busqueda ,'''');
		end if;
	else
		set @w = ' where ';
		set @id_sh = concat(' idProducto = ''',_dato_busqueda ,'''');
    end if;
    
    
    set @SQL =  concat( 'select * from allproductplustotalsales ' ,@w,@id_sh,@like_sh,'  order by IDLINEA'); */

$where = '';
if (trim($busqueda)!= ''){
    
 //`nombre` LIKE ''%',_dato_busqueda,'%''  OR `Grupo`  LIKE  ''%',_dato_busqueda,'%''  OR `descripcion`  
 //LIKE  ''%',_dato_busqueda,'%''  OR `nom_subgrupo_1`  LIKE  ''%',_dato_busqueda,'%''  OR `nom_subgrupo_2`  
 //LIKE  ''%',_dato_busqueda,'%''  OR  `laboratorio` LIKE ''%',_dato_busqueda,'%''');
$query="select * from allproductplustotalsales WHERE idProducto = '$busqueda'";
//echo '<br>'.$query;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
if($datosNum == 0){
   $query="select * from allproductplustotalsales WHERE barcode = '$busqueda'";
   $result = $mysqli->query($query);
    $datosNum=$mysqli->affected_rows;
    if($datosNum == 0){
        $query="select * from allproductplustotalsales WHERE "
                . "`nombre` LIKE '%$busqueda%' "
                . "OR `Grupo` LIKE '%$busqueda%' "
                . "OR `descripcion` LIKE '%$busqueda%' "
                . "OR `nom_subgrupo_1` LIKE '%$busqueda%' "
                . "OR `nom_subgrupo_2` LIKE '%$busqueda%' "
                . "OR `laboratorio` LIKE '%$busqueda%' ;";
        $result = $mysqli->query($query);
        $datosNum=$mysqli->affected_rows;
    }
}
}else{
    $query="select * from allproductplustotalsales ";
//echo '<br>'.$query;
$result = $mysqli->query($query);
$datosNum=$mysqli->affected_rows;
}
?>
<style type="text/css">
<!--
.Estilo5 {font-family: "Arial Narrow"; font-size: 14px; color: #993300; }
-->
</style>

<?php
$tabla = 'busqueda_allproductplustotalsales';
$nombreArchivo = 'listaInventario';
$tipoTabla=2;
$datos_cabecera = array(
        "idProducto" => 'ID',
    "Grupo" => 'GRUPO',
    "laboratorio" => 'MARCA',
    "nombre" => 'NOMBRE',
    "PsIVA" => 'PRECIO VENTA',
    "IVA" => 'IVA',
    "precioVenta" => 'PRECIO + IVA',
    "precioCompra" => 'PRECIO COMPRA',
    "cantInicial" => 'CANT. INICIAL',
    "cantActual" => 'CANT. ACTUAL',
    "totalInventario" => 'T. COST. EXIST.',
    "compras" => 'COMPRAS',
    "ventas" => 'VENTAS',
    "stock" => 'STOCK',
) ;
$parametros[0]="'$busqueda'";
agregarExcelDinamico($tabla,$nombreArchivo,$tipoTabla,   $datos_cabecera , $parametros ) ;?>
<table class="table"  >
<tr     >
<td width="41"  ><strong>ID</strong></td>
	<td width="93" ><strong>GRUPO</strong></td>
	<td width="91" ><strong>MARCA</strong></td>
	<td  ><strong>NOMBRE</strong></td>
	<td width="82"  ><strong>PRECIO VENTA</strong></td>
    <td width="53" ><strong>IVA</strong></td>
	<td width="78" ><strong>PRECIO + IVA</strong></td>
	<td width="72" ><strong>PRECIO COMPRA</strong></td>
	<td width="62" ><strong>CANT. INICIAL</strong></td>
	<td width="64" ><strong>CANT. ACTUAL</strong></td>
    <td width="86" ><strong>T. COST. EXIST.</strong></td>
	<td width="76" ><strong>COMPRAS</strong></td>
	<td width="61" ><strong>VENTAS</strong></td>
	<td width="87" ><strong>STOCK</strong></td>
</tr>
<style>
.listaInv{ cursor:pointer; } 
</style>
<?php

if($datosNum>0){
while ($row = $result->fetch_assoc()) {
	$color="#D7EBFF";
	if($row['cantActual']<$row['stock']){
	$color="#ce0409 ; font-weight: bold;color: #fcfdfd !important;";} 
        
	echo'<tr align="center"   id="'.$row['idProducto'].'" class="listaInv"  >';
	echo '<td class= "ui-widget-content2 " style="background : '.$color.'">'.$row['idProducto'].'</td>';
	echo '<td class= "ui-widget-content2" style="background : '.$color.'">'.$row['Grupo'].'</td>';
	echo '<td class= "ui-widget-content2" style="background : '.$color.'">'.$row['laboratorio'].'</td>';
	echo '<td class= "ui-widget-content2" style="background : '.$color.'" nowrap>'.$row['nombre'].'</td>';
	echo '<td class= "ui-widget-content2" style="background : '.$color.'" nowrap align="right">'.amoneda($row['PsIVA'],"pesos").'</td>';
	echo '<td  class= "ui-widget-content2" style="background : '.$color.'" nowrap align="right">'.amoneda($row['IVA'],"pesos").'</td>';
	echo '<td  class= "ui-widget-content2" style="background : '.$color.'" nowrap align="right">'.amoneda($row['precioVenta'],"pesos").'</td>';
	echo '<td   class= "ui-widget-content2" style="background : '.$color.'" nowrap align="right">'.amoneda($row['precioCompra'],"pesos").'</td>';
	echo '<td  class= "ui-widget-content2" style="background : '.$color.'" >'.$row['cantInicial'].'</td>';
	echo '<td  class= "ui-widget-content2" style="background : '.$color.'">'.$row['cantActual'].'</td>';
	echo '<td  class= "ui-widget-content2" style="background : '.$color.'" nowrap align="right">'.amoneda($row['totalInventario'],"pesos").'</td>'; 
	echo '<td  class= "ui-widget-content2" style="background : '.$color.'">'.$row['compras'].'</td>';
	echo '<td  class= "ui-widget-content2" style="background : '.$color.'">'.$row['ventas'].'</td>';
	echo '<td  class= "ui-widget-content2" style="background : '.$color.'">'.$row['stock'].'</td></tr>';
	$TOTALINVENTARIOVENTA= $TOTALINVENTARIOVENTA + ($row['PsIVA'] * $row['cantActual']);
	$TOTALINVENTARIO=$TOTALINVENTARIO+$row['totalInventario'];
	$total_unidades=$total_unidades + $row['cantActual'];
	}

}else{echo'<tr><td  class= "ui-widget-content2" align="center" colspan="10">NO POSEE NINGUN REGISTRO</td></tr>';}
?></table>
<div id="menu">
<ul>
	<li id="eliminar">Eliminar</li>
    <li id="editar">Editar</li>
     <li id="menu_recargar">Actualizar</li>
</ul>
</div>
<form action="editar.php" method="post">
<input type="hidden" id="dato" name="codigo">
<input type="submit" id="enviar" style="display:none">
</form>
<input type='hidden' value='<?php echo "$ ".number_format($TOTALINVENTARIO,2);?>' id='total_pre_compra'/>
<input type='hidden' value='<?php echo $total_unidades;?>' id='t_unidades'/>
<input type='hidden' value='<?php echo $datosNum;?>' id='tip_productos'/>
<input type='hidden' value='<?php echo "$ ".number_format($TOTALINVENTARIOVENTA,2);?>' id='total_pre_venta'/>
 <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/>
  <link href="../css/generales.css" rel="stylesheet" type="text/css"/> 
  <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
  
<link type="text/css" href="css/menuContextual.css" rel="stylesheet" />

<script type="text/javascript" >
var menuId = "menu";  
var menu = $("#"+menuId);  
$(document).ready(function(){
	 padre = $(window.parent.document);
 $(padre).find("#sp_1").html($('#t_unidades').val())
 $(padre).find("#sp_2").html($('#tip_productos').val())
 $(padre).find("#sp_3").html($('#total_pre_venta').val())
 $(padre).find("#sp_4").html($('#total_pre_compra').val())
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
			//alert('ahora tiene que enviar')
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