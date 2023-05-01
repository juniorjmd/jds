<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<?php
 include 'db_conection.php';
 $conn= cargarBD();
  $formDir="grupos3.php";
 if($_GET['llamado']){
	 $formDir="grupos3.php?llamado=".$_GET['llamado'];
		if($_GET['llamado']=="4532ffj"){
			if($_GET['Aux']){$dir="CreaProductos.php?llamado=4532ffj&Aux=1";}else{
			$dir="CreaProductos.php";}
		}
		else{
			if ($_GET['llamado']=='98765hjkhg'){$dir="ventas/nFacturacion.php";}
			else{$dir="inventario.php";}
 }}else{$dir="ventas";}
 
if($_POST["nombreGrupo"] && $_POST["nombreGrupo"]!=''){
	
$stmt = $conn->stmt_init();
$query="INSERT INTO `grupo3` VALUES (NULL, UCASE('".$_POST['nombreGrupo']."'));";
//echo $query;
$stmt->prepare($query);
if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);

		if($_SESSION["database"]!='db_djose'){
		$connAux= cargarBD('db_djose');	
		$connAux->query($query);
		$connAux->close();}
		if($_SESSION["database"]!='db_bodega1_djose'){
		$connAux= cargarBD('db_bodega1_djose');	
		$connAux->query($query);
		$connAux->close();}
		if($_SESSION["database"]!='db_bodega2_djose'){
		$connAux= cargarBD('db_bodega2_djose');	
		$connAux->query($query);
		$connAux->close();}
}else{echo '<script>setTimeout(function() {
        window.location="grupos3.php"
    },3500);</script>';}
$_POST["nombreGrupo"] = '';}
?>

<div align="center">
<input type="hidden" value="<?php echo $dir;?>" id="dir">
<form method="post" autocomplete="off" action="<?php echo $formDir;?>">
<table>
<tr>
<td width="195"><input type="hidden" name="crear" value="si">
<span>CREAR SUBGRUPO 2</span></td>
<td width="169"><input type="text" name="nombreGrupo"  id="nombre" placeholder="nombre del grupo" ></td>

<td colspan="6" align="center" style=" font:15px Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
<input type="submit" value="Nuevo Grupo" id="Nuevo" >
</td>

<td width="51" colspan="6" align="center" style=" font:15px Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
<input type="image" src="imagenes/images (1).jpg" id="regresarVentas" height="40" width="50"></td>

</tr>

</table></form>

<br/>


<div align="center">
<table width="400px" height="36" border="1px" style=" border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr align="center">
<td><strong>&nbsp;</strong></td>
<td><strong>CODIGO</strong></td>
<td><strong>NOMBRE DEL GRUPO</strong></td>
</tr>
<?php 
$query2="SELECT * 
FROM  `grupo3` ORDER BY   `idGrupo` ASC ";
//echo $query2;
$result = $conn->query($query2);
$ULTIMAMESA=0;
 $filas=$result->num_rows;
 if ($filas>0){
while ($row = $result->fetch_assoc()) {
echo "<tr><td align='center'><img src='imagenes/b_drop.png' class='eliminar' id='".$row["idGrupo"]."'></td>
<td>".$row["idGrupo"]."</td>
<td>".$row["GRUPO"]."</td>
</tr>";
 }
$result->free();}
$conn->close();

?></table></div>


</div>
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);
	
$("#Nuevo").click(function(e){
	if(Trim($("#nombre").val())==""){
		alert("EL NOMBRE NO DEBE ESTAR VACIO")
		e.preventDefault();
		$("#nombre").focus();
	}
	});
	
	$("#regresarVentas").click(function(e){
	e.preventDefault();
	var dir=$("#dir").val()
	location.href=dir;
	});
	
	$(".eliminar").click(function(e){
		var elem = $(this)
	dato='dato='+encodeURIComponent($(this).attr('id'))
		  +"&tabla="+encodeURIComponent("grupo3")
		  +"&columna="+encodeURIComponent('idGrupo');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: dato,
			success: function(responseText){
			//alert(responseText)
			elem.parent().parent().remove()
			}
					});e.preventDefault();
	});
	
 });			 
					

</script>