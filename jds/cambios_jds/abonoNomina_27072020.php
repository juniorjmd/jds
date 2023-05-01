<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
 ?><head>
<link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);
	
$(".abonos").click(function(){
	var dato=$(this).attr("id");
	r = confirm("REALMENTE DESEA ELIMINAR ESTE ABONO REALIZADO");
	
		if(r==true){
			do {
var name = prompt ('POR FAVOR DIGITE SU CLAVE PARA ELIMINAR');
} while (name == null || Trim(name) == "");

		datos='password='+encodeURIComponent(name);
		  
$.ajax({
			url: 'convierteMD5.php',  
			type: 'POST',
			async: false,
			data: datos,
			success: function(responseText){
			name=responseText;
			}
		});
		if(Trim(name) !=$("#IEJAH12HASJKAÑSL").val())
{alert("CLAVE INVALIDA....");
r=false;}



if(r==true){
			datos='dato='+encodeURIComponent(dato)
		  +"&tabla="+encodeURIComponent("abonosnomina")
		  +"&columna="+encodeURIComponent('id_abono');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			async: false,
			data: datos,
			success: function(responseText){
			//alert(responseText)
		 document.location.reload();  
			}
		});
		}}
	
	});
	
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
	if(h==1){e.preventDefault();}
	
	});
	
$('#btnListar').click(function(){ 
    
    $.ajax({
        url: 'saveGastSalEfect.php',
        type: 'POST',
        async: true,
        data: 'fecha='+ $('#fInicio').val()+'&fechaHasta='+ $('#fFin').val()+'&estadoNomina='+ $('#estadoNomina').val()+'&tabla=vwabonosnomina',
        dataType:"html",
        success: function(responseText){
        //    alert(responseText)
        $("#tablanomina").html(responseText);
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
 $conexion =\Class_php\DataBase::getInstance(); 
 $link = $conexion->getLink();   
 $auxfecha='';
 $pagadoa="";	
		$descripcion='';
 $auxfecha=date('Y-m-d');
 $valorGasto=0;
if(isset($_POST["idUsuario"])){
include 'php/funcionesMysql.php';
$stmt = $conn->stmt_init();
$fecha =$_POST["fecha"]; 
$execute=revisaPagos($fecha,$conn);
$ejecutar=revisaCierres($fecha,$conn);
if($ejecutar){//echo "entro al primero";
	if($execute){//echo "entro al segundo";
		$query="INSERT INTO  `abonosnomina`(id_usuario, nombreUsuario, id_empleado, cantidad, fecha, estado, id_pago_nomina, descripcion, estadoNomina )  
		VALUES ('".$_SESSION['usuarioid']."','".
		$_SESSION['usuario']."','".
		$_POST["pagadoA"]."',  '".
		$_POST["valorGasto"]."','".
		$fecha ."',   'ACTIVO',  '','".
		$_POST["descripcion"]."','ACTIVO');";
		
              //  echo $query;
		//$stmt->prepare($query);
                $consulta = $link->prepare($query);
			if(!$consulta->execute()){
			//Si no se puede insertar mandamos una excepcion
			throw new Exception('No se pudo insertar:' . $stmt->error);
			}else{
                          echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">el gasto fue insertado con exito!!!!!!!!!!!</div><br><br>';
			echo '<script>window.location="abonoNomina.php"</script>';
                         
                        }

		}else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO EL PAGO DE NOMINA, POR FAVOR CORRIJA </div><br><br>';
		$auxfecha=$_POST["fecha"];
		$valorGasto=$_POST["valorGasto"];
		$pagadoa=$_POST["pagadoA"];	
		$descripcion=$_POST['descripcion'];
		echo 'entro 1';
		}
	}
	else{echo '<div align="center" class="content" style="font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif; font-size:40px; color:#003">ESTA INTENTANDO INGRESAR EN UNA FECHA DE LA CUAL YA SE HIZO CIERRE, POR FAVOR CORRIJA </div><br><br>';
	$auxfecha=$_POST["fecha"];
	$valorGasto=$_POST["valorGasto"];
	$pagadoa=$_POST["pagadoA"];	
	$descripcion=$_POST['descripcion'];
	echo 'entro 2';
}

}
else {$fecha="CURDATE() ";}
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
 
$result->free();



?>
<div align="center">
<input type="hidden" name="1234ASDF79A65SDF" id="IEJAH12HASJKAÑSL" value="<?php echo $_SESSION["IJKLEM1934589"];?>">
<form method="post" autocomplete="off" action="abonoNomina.php">
<input type="hidden" name="idUsuario" id="idUsuario" value="1">
<input type="hidden" name="nombreUsuario" id="nombreUsuario" value="ADMINISTRADOR">
<input type="hidden" name="idSucursal" id="idSucursal" value="<?php echo $_GET["sucursalId"];?>">
<input type="hidden" name="tabla" id="tabla" value="nomina">



<table id="TablaInicial">
<tr>
<td colspan="6" align="center" class="titulo">ADELANTO NOMINA</td>
</tr>
<tr>
<td>&nbsp; </td>
<td>FECHA</td>
<td><input id="fecha" name="fecha" value="<?php echo $auxfecha; ?>" type="date" class="gasto" placeholder="Escoja la fecha" > </td>
<td>VALOR</td>
<td><input type="number" width="" id="valorGasto" name="valorGasto" value="<?php echo $valorGasto; ?>"  class="gasto"></td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp; </td>
<td>PAGADO A</td>
<td>
<select id="pagadoA" name="pagadoA" class="gasto" placeholder="A Quien Se Pago" ><?php echo $pagadoA; ?>
</select>

</td>
<td>&nbsp;</td>
</tr>

<tr>
<td>&nbsp;</td>
<td>DESCRIPCION</td>
<td colspan="2"><textarea  cols="42" id="descripcion" name="descripcion" rows="3"><?php echo $descripcion; ?> </textarea></td>

<td>&nbsp;<input type="submit" class="boton" id="enviaDatos"></td><td align="left"><a href="indexNomina.php">
  <img class="boton"type="image" src="imagenes/images (1).jpg">
</a></td>
</tr>
<tr>

</tr>

</table>
</form>



<?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaAbonosNomina';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
<div align="center">
    <table border="1px"  style=" width:1000px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
        <tr><td>Desde</td> <td><input type="text" id="fInicio"></td> <td>Hasta</td><td><input type="text" id="fFin"></td><td>Estado</td>
            <td><select id="estadoNomina">
                    <option value=''>TODOS</option>
                    <option value="ACTIVO">ACTIVO</option><option value="INACTIVO">PAGADO</option>
                </select></td> <td><button id="btnListar">Buscar</button></td></tr>
    </table>
   
    <table border="1px" id="tabla_resultados" border="1px" style=" width:1000px; border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr align="center"  >
<td><strong>&nbsp;</strong></td>
<td><strong>USUARIO</strong></td>
<td><strong>FECHA</strong></td>
<td><strong>VALOR</strong></td>
<td colspan="2"><strong>PAGADO A</strong></td>
<td><strong>ESTADO</strong></td>
<td><strong>DESCRIPCION</strong></td>
</tr><tbody id="tablanomina">
<?php 
$query2="SELECT * FROM  `vwabonosnomina`  where `estadoNomina`= 'ACTIVO' ORDER BY   `fecha` DESC ";
//echo $query2;
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {

echo "<tr>
<td><img src='imagenes/b_drop.png' id='".$row["id_abono"]."' class='abonos' style='cursor:pointer'></td>
<td>".$row["nombreUsuario"]."</td>
<td>".$row["fecha"]."</td>
<td>".$row["cantidad"]."</td>
<td>".$row["id_empleado"]."</td>
<td>".$row["nombre"]." ".$row["apellido"]."</td>
<td>".$row["estadoNomina"]."</td><td>".$row["descripcion"]."</td>
</tr>";


}
 
$result->free();
$conn->close();

?>
</tbody></table></div>

</div>

