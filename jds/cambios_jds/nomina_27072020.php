<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?><head>
<link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);

	
	$('#enviaDatos').click(function(e){
		
	var str="";
	 var h=0;
	 $(".gasto").each(function() {$(this).focus();
	    if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;$(this).focus();
			 return false;
			}
    }); 
	$(".pagosN").removeAttr('disabled');
	$(".pagosN").each(function() {$(this).focus();
	    if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;$(this).focus();
			 return false;
			}
    });
	if(h==1){e.preventDefault();
	$(".pagosN").attr('disabled','disabled');
	}
	
	});
	
	$("#pagadoA").change(function(){
	datos='empleadoId='+encodeURIComponent($(this).val());
	$.ajax({
			url: 'abonosRealizadosAEmpleados.php',  
			type: 'POST',
			async: false,
			data: datos,
			dataType: "json",
			success: function(DATA){
				//alert(DATA.total)
			if(Trim(DATA.total)!=""){
				$("#abonosRealizados").val(DATA.total)
				}else{$("#abonosRealizados").val(0)}
				
			if(Trim(DATA.monto_dia)!=""){
				$("#PagoDia").val(DATA.monto_dia)
				}else{$("#PagoDia").val(0)}
			}
		});
	if($("#diasTrabajo").val()!=0){$("#diasTrabajo").trigger("change")}
	});	
	
///
$("#diasTrabajo").change(function(){
	$("#totalParcial").val($(this).val()*$("#PagoDia").val())
	$("#totalPago").val($("#totalParcial").val()-$("#abonosRealizados").val());
	});	
	
	
$("#diasTrabajo").keyup(function(){
	$(this).trigger("change")
	})
///


$("#actualiza").click(function(){
	document.location.reload();  
	});
$("#buscarNominas").click(function(){
	var datos="";
	var aux=0;
	if(Trim($("#findUsuario").val())!="")
	{datos='empleadoId='+encodeURIComponent($("#findUsuario").val());aux=1}
	if(Trim($("#findFecha").val())!=""){
		if(aux==1){datos=datos+'&SI=TRUE&'}
		datos=datos+'fecha='+encodeURIComponent($("#findFecha").val())
		}

	if(datos!=""){
	$.ajax({
			url: 'nominasPagadas.php',  
			type: 'POST',
			async: false,
			data: datos,
			beforeSend: function(){$("#imgFind").css("display","inline")},
			success: function(DATA){
				$("#tablanomina").html(DATA);
				$("#imgFind").css("display","none")
			}
		});}
	})
   });			 
					

</script>
<style>
#TablaInicial td { font-size:20px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
#titulo{ font-size:30px; font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif}
.boton{ height:50px; width:80px}
.precarga {
    background:transparent url(imagenes/ajax-loader.gif) center no-repeat;
 }
.pagosN{ font-size:36px;}
</style></head>

<?php 
$auxfecha=date("Y-m-d");
//echo $auxfecha;
include 'db_conection.php';
 $conn= cargarBD();
 $conexion =\Class_php\DataBase::getInstance();
 $link = $conexion->getLink();  
 $descripcion='';
$auxfecha='';
$valorGasto=0;
$porConceptoDe = $pagadoA = $pagadoa='';
if(isset($_POST["pagadoA"])){
	
	/*fecha pagadoA diasTrabajo totalParcial abonosRealizados totalPago*/
	
$descripcion= $porConceptoDe="PAGO DE LOS ".$_POST["diasTrabajo"]." DIAS TRABAJADOS, MENOS LOS ANTICIPOS REALIZADOS";	
include 'php/funcionesMysql.php';
$stmt = $conn->stmt_init();
$fecha ="'".$_POST["fecha"]."'"; 
$ejecutar=revisaCierres($fecha,$conn);
if($ejecutar){
$query="INSERT INTO  `".$_POST["tabla"]."` VALUES (
NULL , '".$_SESSION["usuarioid"]."','".
$_SESSION["usuario"]."','".
$descripcion."',".
$fecha .",'".
$_POST["idSucursal"]."','".
$porConceptoDe."','".
$_POST["pagadoA"]."',CURTIME(),'activo','".
$_POST["diasTrabajo"]."','".
$_POST["totalParcial"]."','".
$_POST["abonosRealizados"]."','".
$_POST["totalPago"]."');";

//$stmt->prepare($query);
////echo $query;
//if(!$stmt->execute()){
$consulta = $link->prepare($query);
if(!$consulta->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error. $query);
}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!!!!!!!!!</div><br><br>';
$ultimoId=$stmt->insert_id;
$descripcion="ultimo anticipo del pago de la nomina numero ".$ultimoId;
$query2="INSERT INTO  `abonosnomina` 
		VALUES (
		NULL , '".$_SESSION['usuarioid']."','".
		$_SESSION['usuario']."','".
		$_POST["pagadoA"]."',  '".
		$_POST["totalPago"]."',".
		$fecha .",   'ACTIVO',  '".$ultimoId."','".
		$descripcion."', 'ACTIVO' ,'pagoNomina');";
//		echo $query2;
//		$stmt->prepare($query2);
//if(!$stmt->execute()){
$consulta = $link->prepare($query2);
if(!$consulta->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{
	$query3="UPDATE  `abonosnomina` SET  `estadoNomina` =  'INACTIVO',
`id_pago_nomina` =  '".$ultimoId."' WHERE `id_empleado`= ".$_POST["pagadoA"]." AND `estadoNomina` =  'ACTIVO' ";
//	echo $query2;
$result = $conn->query($query3);	
echo '<script>window.location="nomina.php"</script>';
	}
}}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO CIERRE, POR FAVOR CORRIJA </div><br><br>';
$descripcion=$_POST["descripcion"];
$auxfecha=$_POST["fecha"];
$valorGasto=$_POST["valorGasto"];
$porConceptoDe=$_POST["porConceptoDe"];
$pagadoA=$_POST["pagadoA"];	
}
}else {$fecha="CURDATE() ";}


$pagadoA='<option value=""
>SELECCIONE UN EMPLEADO</option>';
$query2="SELECT * FROM  `empleados`  ";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	if($row["id"]==$pagadoa){$selected="selected";}else{$selected="";}
$pagadoA=$pagadoA.'<option value="'.$row["id"].'"
'.$selected.'>'.$row["nombre"].' '.$row["apellido"].'</option>';
}

?>


<div align="center">
<form method="post" autocomplete="off" action="nomina.php">
<input type="hidden" name="idUsuario" id="idUsuario" value="1">
<input type="hidden" name="nombreUsuario" id="nombreUsuario" value="ADMINISTRADOR">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_GET["sucursalId"];?>">
<input type="hidden" name="tabla" id="tabla" value="nomina">
<input type="hidden" name="PagoDia" id="PagoDia" >



<table id="TablaInicial">
<tr>
<td colspan="6" align="center" class="titulo">NOMINA</td>
</tr>
<tr>
<td>&nbsp; </td>
<td>FECHA</td>
<td><input id="fecha" name="fecha" value="<?php echo $auxfecha; ?>" type="date" class="gasto"  ></td>
<td>PAGADO A</td>
<td><select id="pagadoA" name="pagadoA" class="gasto" placeholder="A Quien Se Pago" ><?php echo $pagadoA; ?>
</select></td>

<td>&nbsp;</td>
</tr><tr><td>&nbsp; </td>
<td>DIAS TRABAJADOS</td>
<td><input type="number" class="gasto" value="<?php echo $diasTrabajo; ?>" id="diasTrabajo" name="diasTrabajo" min="0"></td>
<td>TOTAL PARCIAL</td><td><input type="number" value="0" disabled  class="pagosN" id="totalParcial"  name="totalParcial"></td>
</tr>

<tr>
<td>&nbsp;</td>
<td>ABONOS REALIZADOS</td>
<td colspan="2"><input type="number" value="0" disabled  class="pagosN" id="abonosRealizados" name="abonosRealizados" ></td>

<td>&nbsp;</td><td align="left">&nbsp;</td>
</tr>


<tr>
<td>&nbsp;</td><td>TOTAL A PAGAR</td>

<td colspan="2"><input type="number" value="0" disabled  class="pagosN" id="totalPago" name="totalPago" ></td>

<td>&nbsp;<input type="submit" class="boton" id="enviaDatos"></td><td align="left"><a href="indexNomina.php">
  <img class="boton"type="image" src="imagenes/images (1).jpg">
</a></td>
</tr>
<tr>

</tr>

</table>
</form>



<div align="center">
<table width="522" height="43"  style="  border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >

<tr><td width="54" height="35"><strong>FECHA</strong></td><td width="168" ><input id="findFecha" name="fecha"  type="date"   ></td>
<td width="74" ><strong>USUARIO</strong></td><td width="84" ><select id="findUsuario"  ><?php echo $pagadoA; ?>
</select></td><td width="38" ><input title="buscar....." type="image" src="imagenes/16325437-lupa-buscar-en-la-base-de-datos-icono-aislado-en-blanco.jpg" width="36" height="30" id="buscarNominas" ></td>
<td width="38" ><input type="image" src="imagenes/actualizar.png" width="36" height="30" id="actualiza" title="actualizar la lista"></td>
<td width="22"><img src="imagenes/ajax-loader.gif" style="display:none" id="imgFind"></td>
</tr></table>

<?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaGastos';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
 
   
    <table border="1px" id="tabla_resultados"width="871" border="1px" style=" width:1000px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr><td width="36"><strong>MENU</strong></td>
<td width="178"><strong>USUARIO</strong></td>
<td width="111"><strong>FECHA</strong></td>
<td width="62"><strong>VALOR</strong></td>
<td width="102" colspan="2"><strong>PAGADO A</strong></td>
<td width="239"><strong>POR CONCEPTO</strong></td>
<td width="224"><strong>DESCRIPCION</strong></td>
</tr><tbody id="tablanomina">
<?php 
$query2="SELECT * FROM  `vwnomina` ";
//	echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {

echo "<tr><td><a href='desplegarNominas.php?idSF=".$row["idSF"]."'><img src='imagenes/libro.jpg'></a></td>
<td>".$row["nombreUsuario"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["totalParcial"]."</td>
<td>".$row["pagadoA"]."</td>
<td>".$row["nombre"].' '.$row["apellido"]."</td>
<td>".$row["porConceptoDe"]."</td>
<td>".$row["descripcion"]."</td>
</tr>";
}


 
$result->free();
$conn->close();

?>
</tbody></table></div>

</div>

