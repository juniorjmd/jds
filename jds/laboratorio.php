<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<?php
 include 'db_conection.php';
 $conn= cargarBD();
  $formDir="laboratorio.php";
 
 if($_GET['llamado']){
	 $formDir="laboratorio.php?llamado=".$_GET['llamado'];
		if($_GET['llamado']=="4532ffj"){
			if($_GET['Aux']){$dir="CreaProductos.php?llamado=4532ffj&Aux=1";}else{
			$dir="CreaProductos.php";}
		}
		else{
			if ($_GET['llamado']=='98765hjkhg'){$dir="ventas/nFacturacion.php";}
			else{$dir="inventario.php";}
 }}else{$dir="ventas";}
if($_POST["nombreGrupo"]){
$stmt = $conn->stmt_init();
$query="INSERT INTO `marcas` VALUES (NULL, UCASE(  '".$_POST['nombreGrupo']."' ));";
//echo $query;
$stmt->prepare($query);
if(!$stmt->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo insertar:' . $stmt->error);

}else{echo '<script>setTimeout(function() {
        window.location="laboratorio.php"
    },3500);</script>';}}
?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: "Arial Narrow";
	font-size: 17px;
	color: #993300;
}

input.text {   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.Estilo4 {color: #CCCCCC}
.Estilo5 {font-size: 15px; font-family: "Arial Narrow"}
-->
</style>


<div align="center">
<input type="hidden" value="<?php echo $dir;?>" id="dir">
<form method="post" autocomplete="off" action="<?php echo $formDir;?>">
<table width="497">
<tr>
<td width="160" align="center"><input type="hidden" name="crear" value="si">
<span class="Estilo1">Nombre  </span></td>
<td width="163" align="center"><input name="nombreGrupo" type="text" class="text"  id="nombre" placeholder="nombre marca" ></td>

<td colspan="6" align="center" style=" font:15px Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
<input type="submit" value="Crear nuevo" id="Nuevo" >
</td>

<td width="51" colspan="6" align="center" style=" font:15px Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif">
<input type="image" src="imagenes/images (1).jpg" id="regresarVentas" height="40" width="50" onclick="algo();"></td>

</tr>

</table></form>

<br/>


<div align="center">
<table width="400px" height="36" border="0" bordercolor="#F7F7F7" style=" border:thin #069; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace" >
<tr align="center">
<td width="49"><strong>&nbsp;</strong></td>
<td width="91" bgcolor="#F9F9F9"><span class="Estilo1">Codigo</span></td>
<td width="320" bgcolor="#F9F9F9"><span class="Estilo1">Nombre de Marca</span></td>
</tr>

<?php 
$query2="SELECT * 
FROM  `marcas` ORDER BY  `marcas`.`idlab` ASC ";
//echo $query2;
$result = $conn->query($query2);
$ULTIMAMESA=0;
while ($row = $result->fetch_assoc()) {
	if($row["idlab"]==1){$clase="";}else{$clase="class='eliminar'";}
echo "<tr><td align='center'><img src='imagenes/b_drop.png' ".$clase." id='".$row["idlab"]."'></td>
<td><span class='Estilo5'>".$row["idlab"]."</span></td>
<td><span class='Estilo5'>".$row["laboratorio"]."</span></td>
</tr>";
?>
<tr>
    <td colspan="3" align="center"><span class="Estilo4">____________________________________________________</span></td>
  </tr>
<?php
}
$result->free();
$conn->close();

?></table>
</div>


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
	
	/*$("#regresarVentas").click(function(e){
	
	e.preventDefault();
	var dir=$("#dir").val()
	location.href=dir;
	
	});*/
	
	
	
	$(".eliminar").click(function(e){
		var elem = $(this)
	dato='dato='+encodeURIComponent($(this).attr('id'))
		  +"&tabla="+encodeURIComponent("marcas")
		  +"&columna="+encodeURIComponent('idlab');
	$.ajax({
			url: 'EliminaX.php',  
			type: 'POST',
			
			data: dato,
			success: function(responseText){
			//alert(responseText)
			elem.parent().parent().remove()
			}
					});
	});
	
 });			 
					
	function algo(){ 
opener.location.reload(); 
window.close(); 
} 


</script>