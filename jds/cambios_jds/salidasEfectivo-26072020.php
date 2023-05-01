<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<head>
<link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);
$('#fecha').datepicker({selectOtherMonths: true,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
					'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
						 onSelect: function (date) {}
			});		
	
        ////////////////////////
        $('#btnListar').click(function(){ 
    
    $.ajax({
        url: 'saveGastSalEfect.php',
        type: 'POST',
        async: true,
        data: 'fecha='+ $('#fInicio').val()+'&fechaHasta='+ $('#fFin').val()+'&tabla=salidasefectivo',
        dataType:"html",
        success: function(responseText){
        //    alert(responseText)
        $("#tablaGastos").html(responseText);
        },
        error: function(){alert("nos se pudo")}
    });
})     	 
$('#fInicio').datepicker({selectOtherMonths: true,maxDate:new Date() ,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
					'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
						 onSelect: function (date) {}
			});	
$('#fFin').datepicker({selectOtherMonths: true,maxDate:new Date() ,
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
					'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',
				'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
					   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
						 dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"], 
						 onSelect: function (date) {$('#fInicio').datepicker("option", "maxDate", date )}     }); 
                                             
$('.hasDatepicker').datepicker('setDate', new Date());
      /////////////////////////////////  
        
        
	$('#enviaDatos').click(function(e){
	var str="";
	 var h=0;
	 $(".gasto").each(function() {$(this).focus();
	    if(Trim($(this).val())==""){
			if ($(this).attr("type")=="number")
			{str=" solo admite numeros y ";}
			alert ("el "+$(this).attr("name")+str+" no debe estar en blanco");
			h=1;
			 return false;
			}
    });
	if(h==1){e.preventDefault();}
	
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
 $pagadoA=''; 
 $porConceptoDe = '';
if(isset($_POST["idUsuario"])){
include 'php/funcionesMysql.php';
$stmt = $conn->stmt_init();
//sis01jdp -- cambio para utilizar PDO en lugar de mysqli
$conexion =\Class_php\DataBase::getInstance();
 $link = $conexion->getLink(); 
//sis01jdp -- fin cambio 
$fecha ="'".normalize_date($_POST["fecha"],"-")."'"; 
$ejecutar=revisaCierres($fecha,$conn);
if($ejecutar){
$query="INSERT INTO  `".$_POST["tabla"]."` VALUES (
NULL , '".$_POST["idUsuario"]."','".
$_POST["nombreUsuario"]."','".
$_POST["descripcion"]."',".
$fecha .",'".
$_POST["valorGasto"]."','".
$_SESSION["id_suc"]."','".
$_POST["porConceptoDe"]."','".
$_POST["pagadoA"]."',CURTIME(),'activo');";
//sis01jdp -- se modifica la ejecucion de la consulta.
/*
$stmt->prepare($query);
if(!$stmt->execute()){*/
$consulta = $link->prepare($query);
if(!$consulta->execute()){
//sis01jdp -- fin del cambio
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}else{
	echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!</div><br><br>';
	echo '<script>window.location="salidasEfectivo.php"</script>';
	}
}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO CIERRE, POR FAVOR CORRIJA </div><br><br>';
$descripcion=$_POST["descripcion"];
$auxfecha=normalize_date($_POST["fecha"],'/');
$valorGasto=$_POST["valorGasto"];
$porConceptoDe=$_POST["porConceptoDe"];
$pagadoA=$_POST["pagadoA"];	
}}else {$fecha="CURDATE() ";}
?>

<div align="center">
<form method="post" autocomplete="off" action="salidasEfectivo.php">
<input type="hidden" name="idUsuario" id="idUsuario" value="1">
<input type="hidden" name="nombreUsuario" id="nombreUsuario" value="ADMINISTRADOR">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_GET["sucursalId"];?>">
<input type="hidden" name="tabla" id="tabla" value="salidasefectivo">



<table id="TablaInicial">
<tr>
<td colspan="6" align="center" class="titulo">PAGOS A ACCIONISTAS</td>
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
<td>PAGADO A</td>
<td><input id="pagadoA" name="pagadoA" type="text" width="" class="gasto" value="<?php echo $pagadoA; ?>"  placeholder="A Quien Se Pago" ></td>
<td>POR CONCEPTO DE</td>
<td><input type="text" id="porConceptoDe" name="porConceptoDe" placeholder="Porque Se Pago" value="<?php echo $porConceptoDe; ?>"  class="gasto"></td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>DESCRIPCION</td>
<td colspan="2"><textarea  cols="42" id="descripcion" name="descripcion"  rows="3"> </textarea></td>

<td>&nbsp;<input type="submit" id="enviaDatos" class="boton"></td><td align="left"> </td>
</tr>
<tr>
<td colspan="6" align="center" >

</td>

</tr>

</table>
</form>



<?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaPagosAccionistas';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
<div align="center">
    <table border="1px"  style=" width:1000px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
        <tr><td>Desde</td> <td><input type="text" id="fInicio"></td> <td>Hasta</td><td><input type="text" id="fFin"></td> <td><button id="btnListar">Buscar</button></td></tr>
    </table>
   
    <table border="1px" id="tabla_resultados" border="1px" 
           style=" width:1000px; border:thin #069; 
           font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr>
<td><strong>USUARIO</strong></td>
<td><strong>FECHA</strong></td>
<td><strong>VALOR</strong></td>
<td><strong>PAGADO A</strong></td>

<td><strong>POR CONCEPTO</strong></td>
<td><strong>DESCRIPCION</strong></td>
</tr><tbody id="tablaGastos">
<?php 
$query2="SELECT * FROM  `salidasefectivo`  where `fecha`= ".$fecha;
//	echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {

echo "<tr>
<td>".$row["nombreUsuario"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["valorGasto"]."</td>
<td>".$row["pagadoA"]."</td>
<td>".$row["porConceptoDe"]."</td>
<td>".$row["descripcion"]."</td>
</tr>";


}
 
$result->free();
$conn->close();

?>
</tbody></table></div>

</div>

