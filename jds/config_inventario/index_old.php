<?php
include_once '../php/inicioFunction.php';
include_once '../php/db_conection.php';
session_sin_ubicacion("login/");
$mysqli = cargarBD();
$stmt = $mysqli->stmt_init();
$aux=''; 


//print_r($_POST );

foreach($_POST as $key => $value )
{
	$$key = $value;
}
if(isset($array_poductos)){
print_r($array_poductos);
		
set_time_limit(600);
	foreach($array_poductos as $key => $value )
		{   
			$cantidad_nueva = $value['cantidad'];
			$id_producto = $value['id_producto'];
			$cantInicial = $value['cantInicial'];
			if(  intval($cantidad_nueva) != intval($cantInicial)){
			$query = "update producto set cantActual = ('$cantidad_nueva' + compras - ventas + devoluciones) , cantInicial = $cantidad_nueva where idProducto = '$id_producto'";
			//echo "<br> $query ";
			$stmt->prepare($query);
				if(!$stmt->execute()){
				//Si no se puede insertar mandamos una excepcion
				throw new Exception("<br> cantidad= {$value['cantidad'] } producto = {$value['id_producto'] }  ". 'No se pudo insertar:' . $stmt->error);
				} 
			} 
		}
}


/////////////////////////
$query="SELECT * FROM producto;";
$result = $mysqli->query($query);


?>
<link rel="stylesheet" href="../css/loadingStile.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" src="../js/json2.js"></script>
<script type="text/javascript" src="../js/wp-nicescroll/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="../jsFiles/trim.js" language="javascript1.1" ></script>
<script type="text/javascript" src="../jsFiles/funciones.js"></script>
<script type="text/javascript" src="../jsFiles/fullScreen.js"></script>
<script type="text/javascript" src="../jsFiles/ajax.js"></script>
<script type="text/javascript" src="../jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorContenidos.js"></script>
<script>
 
$(document).ready(function(){
	
$(document).keydown(function(e){
		var tecla=e.keyCode;
		if(tecla==13){
			$('#btn_busqueda').trigger('click')
		}
	});
	$('#btn_busqueda').click(function(){
		var cadena = Trim($('#busqueda').val());
		console.log( cadena);
		if ( cadena!=''){ 
		var barcode ; 
		var nombre;
		$('.lineas').hide();
		$('.lineas').each(function(){
				
			 barcode = $(this).find('#barcode').val()
			 nombre =$(this).find('#nombre').val()
			 
			if (barcode.indexOf(cadena) > -1){
				 $(this).show()
			}else if ((nombre.indexOf(cadena) > -1)||( nombre.indexOf(cadena.toUpperCase()) > -1   )){ $(this).show()} 
		 
		
	})
	}else{$('.lineas').show();}
	})
	
	$('.nuevo_campo').keyup(function(){
		actual = Trim($(this).val());
		 
		if(actual == '' || actual == '-'  || actual == '+' ){
			actual = 0;
		}else {actual =parseInt(actual);}
		$(this).val(actual);
		var tr = $(this).parent().parent();
		console.log()
		var compras = parseInt(tr.find('#compras').val());
		var ventas = parseInt(tr.find('#ventas').val());
		var devoluciones = parseInt(tr.find('#devoluciones').val());
		var total = actual+compras-ventas+devoluciones;
		tr.find('#total_nuevo').html(total)
		 
	})
})
</script>


<script>
function valida(e){
    tecla = (document.all) ? e.keyCode : e.which;

    //Tecla de retroceso para borrar, siempre la permite
    if (tecla==8){
        return true;
    }
        
    // Patron de entrada, en este caso solo acepta numeros
    patron =/[0-9]/;
    tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
}
</script>


<style>
.flotante {
    display:scroll;
        position:fixed;
        top:30px;
        right:0px;
}
.flotante2 {
	
    display:scroll;
        position:fixed;
        top:30px;
        left:0px;
}
.lineas:hover {
    background-color: yellow;
} 
</style>
<table class='flotante2' style="background-color:powderblue;">
<tr>
  <td colspan='9'>busqueda : <input type='text' id='busqueda'></td><td><button id='btn_busqueda'>buscar</button></td>
  <td><a href='VALORES_INICIALES_DEL_PROGRAMA/'><button>REINICIAR INVENTARIOS</button></a></td>
  
  <td><a href='EXPORTAR_EXCEL/'><button>EXPORTAR_EXCEL</button></a></td></tr>
  
</table>
<form action="../inventario/" method="post">
  <input type="submit" value="Submit"  class='flotante'>
  <table border='1' id='tabla_1' style='margin-top:70px;'>
  
  <tr>
  <td>codigo de barra</td>
  <td style='max-width:250px'>nombre</td>
  <td>cantidad inicial</td>
  <td>compra</td>
  <td>ventas</td>
  <td>devolucion</td>
  <td>cantidad actual</td>
  <td>nueva_cant_inicial</td>
  <td>total_nuevo</td>
  
  </tr>
<?php
if($result->num_rows>0){
	$cont=0;
while ($row = $result->fetch_assoc()) {
	$row['nombre'] = trim($row['nombre']);
	echo"<tr class='lineas'>
	<input type='hidden' id='barcode' value='{$row['barcode']}'/>
	<input type='hidden' id='nombre' value='{$row['nombre']}'/>
	
	<input type='hidden' id='compras' value='{$row['compras']}'/>
	<input type='hidden' id='ventas' value='{$row['ventas']}'/>
	<input type='hidden' id='devoluciones' value='{$row['devoluciones']}'/>
	<input type='hidden' id='cantInicial' value='{$row['cantInicial']}' name='array_poductos[{$cont}][cantInicial]' />
	
	<td>{$row['barcode']}</td><td>{$row['nombre']}</td>
	<td>{$row['cantInicial']}</td> 
	<td>{$row['compras']}</td>
	<td>{$row['ventas']}</td>
	<td>{$row['devoluciones']}</td>
	<td>{$row['cantActual']}</td>
	<td><input type='text' value='{$row['cantInicial']}' name='array_poductos[{$cont}][cantidad]' class='nuevo_campo'onkeypress='return valida(event)'/>
		<input type='hidden' value='{$row['idProducto']}' name='array_poductos[{$cont}][id_producto]' />
	</td>
	<td><span id='total_nuevo'></span></td></tr>"; 
	$cont++;
}

$result->free();
}
?>
</table>
</form>