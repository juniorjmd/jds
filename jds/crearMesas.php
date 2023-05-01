<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<?php 
 include 'db_conection.php';
 $conn= cargarBD();
if($_POST["ultimaMesa"]){
$stmt = $conn->stmt_init();
$query="INSERT INTO `mesas` VALUES ('M".$_POST["ultimaMesa"]."', '".$_POST["ultimaMesa"]."', 'ADMINISTRADOR', 'inactivo');";
//echo $query;
$stmt->prepare($query);
if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);
}}
?>

<div align="center">
<form method="post" autocomplete="off" action="crearMesas.php">
<table>
<tr>
<td><input type="hidden" name="crear" value="si"><span>CREAR UNA NUEVA MESA</span></td>

<td colspan="6" align="center" style=" font:15px Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
<input type="submit" value="Nueva Mesa" >
</td>

<td colspan="6" align="center" style=" font:15px Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
<input type="image" src="imagenes/images (1).jpg" id="regresarVentas" height="40" width="50"></td>

</tr>

</table>




<div align="center">
<table width="400px" height="36" border="1px" style=" border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr align="center">
<td><strong>&nbsp;</strong></td>
<td><strong>CODIGO</strong></td>
<td><strong>NUMERO</strong></td>
<td><strong>ESTADO DE LA MESA</strong></td>
</tr>
<?php 
$query2="SELECT * 
FROM  `mesas` ORDER BY  `mesas`.`numero` ASC ";
//echo $query2;
$result = $conn->query($query2);
$ULTIMAMESA=0;
while ($row = $result->fetch_assoc()) {
echo "<tr><td align='center'><img src='imagenes/b_drop.png' class='eliminar' id='".$row["codMesa"]."'></td>
<td>".$row["codMesa"]."</td>
<td>".$row["numero"]."</td>
<td>".$row["estado"]."</td>
</tr>";
$ULTIMAMESA=$row["numero"];
}
$ULTIMAMESA++;
echo '<input type="hidden" value="'.$ULTIMAMESA.'" name="ultimaMesa">';
$result->free();
$conn->close();

?></table></div></form>


</div>
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
<script>
$(document).ready(function(){
	setTimeout(function() {
        $(".content").fadeOut(1500);
    },3000);
$("#regresarVentas").click(function(e){
	e.preventDefault();
	window.location.href="ventas.php";
	});
	
	$(".eliminar").click(function(e){
	dato='dato='+encodeURIComponent($(this).attr('id'))
		  +"&tabla="+encodeURIComponent("mesas")
		  +"&columna="+encodeURIComponent('codMesa');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: dato,
			success: function(responseText){
			//alert(responseText)
			window.location.reload()
			}
					});
	});
	
 });			 
					

</script>