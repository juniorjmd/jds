<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<head>
<link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script>
function eliminarRegistro(elemento){
	
		//eliminaMov_y_transaccion($idInsertado,$_POST["tabla"],'idGasto');
	//alert(elemento.data('mod'));
	r = confirm("REALMENTE DESEA ELIMINAR ESTE REGISTRO");
		if(r==true){
		$.ajax({
			url: 'php/eliminaMovimientos.php',
			type: 'POST',
			async: true,
			data: 'dato='+elemento.data('mod')+'&tabla=gastos&columna=idGasto&fecha='+$('#fecha').val(),
			dataType:"html",
			success: function(responseText){
			alert(responseText);
			window.location.reload()
			},
			error: function(){alert("nos se pudo")}
		});}
}
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1000);	
if($("#exe").val()=='exe'){ //window.location="gastos.php";
}		
    },3000);
	
$('#fecha').datepicker({selectOtherMonths: true,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
					'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
						 onSelect: function (date) {
							 //alert(date)
									$.ajax({
									  url: 'saveGastSalEfect.php',
									  type: 'POST',
									  async: true,
									  data: 'fecha='+date+'&tabla=gastos&columna=idGasto&eliminar=ok',
									  dataType:"html",
									  success: function(responseText){
									  $("#tablaGastos").html(responseText);
									  },
									  error: function(){alert("nos se pudo")}
									});

							}
			});		
	
	$('#enviaDatos').click(function(e){
	var str="";
	 var h=0;
	 var dato;
	 $(".gasto").each(function() {
	    if(Trim($(this).val())==""){$(this).focus();
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;
			dato = $(this);
			 return false;
			}
    });
	if(h==1){
		//dato.focus();
		e.preventDefault();}
	
	});

   });			 
					

</script>
<style>
#TablaInicial td { font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
#titulo{ font-size:30px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
.boton{ height:50px; width:80px}
.precarga {
    background:transparent url(imagenes/ajax-loader.gif) center no-repeat;
 }
</style></head>

<?php 
include 'db_conection.php';
 $conn= cargarBD();
if($_POST["idUsuario"]){
include 'php/funcionesMysql.php';
$stmt = $conn->stmt_init();
$fecha = normalize_date($_POST["fecha"],"-") ; 
$ejecutar=revisaCierres($fecha,$conn);
if($ejecutar){
	
$query="INSERT INTO  `".$_POST["tabla"]."` VALUES (
NULL , '".$_POST["idUsuario"]."','".
$_POST["nombreUsuario"]."','".
$_POST["descripcion"]."','".
$fecha ."','".
$_POST["valorGasto"]."','".
$_SESSION["id_suc"]."','".
$_POST["porConceptoDe"]."','".
$_POST["pagadoA"]."',CURTIME(),'activo','".$_POST["nitBusqueda"]."');";

$stmt->prepare($query);
if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{ 
$idInsertado =  $stmt->insert_id;
$respuesta = guardarTransacciones($_POST["valorGasto"],$_POST["cuentaOrigen"],$_POST["afectacionOrigen"],  $_POST["cuentaDestino"], $_POST["afectacionDestino"], normalize_date($_POST["fecha"],"-"),  $_SESSION["idModulo"],$_SESSION["nameModulo"],$idInsertado);
	
switch ($respuesta) {
    case 'ok':	
		echo '<input id="exe" value="exe" type="hidden"/><div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!!!!!!!!!</div><br><br>';
	break;
	case '01':
		echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">SE PRESENTO UN ERROR AL INTENTAR INSERTAR LOS MOVIMIENTOS CONTABLES, POR FAVOR INTENTE DE NUEVO </div><br><br>';
		$descripcion=$_POST["descripcion"];
		$auxfecha=normalize_date($_POST["fecha"],'/');
		$valorGasto=$_POST["valorGasto"];
		$porConceptoDe=$_POST["porConceptoDe"];
		$pagadoA=$_POST["pagadoA"];	
		eliminaMov_y_transaccion($idInsertado,$_POST["tabla"],'idGasto');
	break;
	case '02':
		echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">SE PRESENTO UN ERROR AL INTENTAR INSERTAR LOS MOVIMIENTOS CONTABLES, POR FAVOR INTENTE DE NUEVO </div><br><br>';
	 	$descripcion=$_POST["descripcion"];
		$auxfecha=normalize_date($_POST["fecha"],'/');
		$valorGasto=$_POST["valorGasto"];
		$porConceptoDe=$_POST["porConceptoDe"];
		$pagadoA=$_POST["pagadoA"];	
		eliminaMov_y_transaccion($idInsertado,$_POST["tabla"],'idGasto');
	break;
		}
	}
}else{
	echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO CIERRE, POR FAVOR CORRIJA </div><br><br>';
$descripcion=$_POST["descripcion"];
$auxfecha=normalize_date($_POST["fecha"],'/');
$valorGasto=$_POST["valorGasto"];
$porConceptoDe=$_POST["porConceptoDe"];
$pagadoA=$_POST["pagadoA"];	
}}else {$fecha="CURDATE() ";}

genera('GASTOS');
?>
<!--necesario para agregar la busqueda de personas -->
<div id='ContBusquedaPersonas'></div>
<div id='contenedor'  align="center">
<form method="post" autocomplete="off" action="gastos.php">
<input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION["usuarioid"];?>">
<input type="hidden" name="nombreUsuario" id="nombreUsuario" value="<?php echo $_SESSION["nombreUsuario"];?>">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_SESSION["id_suc"];?>">
<input type="hidden" name="tabla" id="tabla" value="gastos">



<table id="TablaInicial">
<tr>
<td colspan="6" align="center" class=" "><H1>REGISTRO DE GASTOS</H1></td>
</tr>
<tr>
<td>&nbsp; </td>
<td>FECHA</td>
<td><input id="fecha" name="fecha" value="<?php echo $auxfecha; ?>" type="text" class="gasto" placeholder="Escoja la fecha" ></td>
<td>VALOR</td>
<td><input type="number" width="" id="valorGasto" name="valorGasto" value="<?php echo $valorGasto; ?>"  placeholder="Ingrese el valor" class="gasto"></td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp; </td>
<td>NIT/CEDULA</td>
<td><?php agregarBusquedaPersonas('pagadoA','contenedor');?></td>
</tr>
<tr>
<td>&nbsp; </td>
<td>PAGADO A</td>
<td><input id="pagadoA" name="pagadoA" type="text"  value="<?php echo $pagadoA; ?>"  class="gasto" placeholder="A Quien Se Pago" readonly required ></td>
<td>POR CONCEPTO DE </td>
<td><input type="text" id="porConceptoDe" name="porConceptoDe" placeholder="Porque Se Pago" value="<?php echo $porConceptoDe; ?>"  class="gasto"></td>
<td>&nbsp;</td>
</tr>


<tr>
<td>&nbsp; </td>
<td>TIPO DE GASTO</td>
<td><?php echo $destino;?> </td>
<td>FORMA DE PAGO </td>
<td><?php echo $origen;?> </td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>DESCRIPCION</td>
<td colspan="2"><textarea  cols="42" id="descripcion" name="descripcion"  rows="3"> </textarea></td>

<td>&nbsp;<input type="submit" class="boton" id="enviaDatos"></td><td align="left"><a href="menuTrans.php">
  <img class="boton"type="image" src="imagenes/images (1).jpg">
</a></td>
</tr>
<tr>

</tr>

</table>
</form>



<div align="center">
<table border="1px" style=" width:1000px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
<td><strong>USUARIO</strong></td>
<td><strong>FECHA</strong></td>
<td><strong>VALOR</strong></td>
<td><strong>PAGADO A</strong></td>
<td><strong>POR CONCEPTO</strong></td>
<td><strong>DESCRIPCION</strong></td>
</tr><tbody id="tablaGastos">
<?php 
$query2="SELECT * FROM `gastos` order by fecha desc limit 0,30 ";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	echo "<tr>
<td>".$row["nombreUsuario"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["valorGasto"]."</td>
<td>".$row["pagadoA"]."</td>
<td>".$row["porConceptoDe"]."</td>
<td>".$row["descripcion"]."</td>
    <td style='text-align: center;' data-mod='".$row["idGasto"]."'> <img class='editCC' data-mod ='".$row["idGasto"]."' style='width:25px;cursor:pointer'   src='imagenes/basureroNEGRO.jpg' title='eliminar registro' onclick='eliminarRegistro($(this))'> </td>
 </tr>";
 


}

$datos["datos"]=$data;
$result->free();
$conn->close();

?>
</tbody></table></div>

</div>

</div>
<div id='modComprobante'></div>

