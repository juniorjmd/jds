<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 
include 'db_conection.php';
$mysqli = cargarBD();
$query="SELECT * FROM  `grupo` ;";
$result = $mysqli->query($query);	
echo'</br></br>';
while ($row = $result->fetch_assoc()) {
	echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="'.$GrupoInicial[$i].'" class="gruposBT" value=" '.$row['GRUPO'].' ">';
		}
?>
<div id="listado" style="padding:3%" >
 <?php 
if($_POST['idGrupo']){$grupo=$_POST['idGrupo'];
}else{$grupo="1";}

$mysqli12 = cargarBD();
$query="SELECT * 
FROM  `producto` WHERE `idGrupo`='".$grupo."';";
$result = $mysqli12->query($query);
$datosNum=$mysqli12->affected_rows;
if($datosNum>0){
			$contadorAux=0;					
$filasNum=12;
$numeroDiv=verificaNumeroDeIntervalos($datosNum,$filasNum);
$contador=0;
$cont2=0;	
		   echo " <table> <tr>
               <td width='40' align='center'  valign='middle'  class='ui-widget-content' ><input width='40' type='image' id='atrasDiv' src='imagenes/flechaAtras.jpg' title='anterior'></td>
               <td width='100' align='center' class='ui-widget-content'id='anterior'>".$numeroDiv."</td>
               <td width='30' align='center' id='actual' class='ui-widget-header' style='font-size:24px;color:#fffff; '>1</td>
               <td width='210' align='center' class='ui-widget-content'>";
			  if($numeroDiv>=2){$aux=0;
			   for($i=2;$i<=$numeroDiv;$i++)
			   {$aux++;
			   echo "<span id='siguiente".$aux."'>".$i." </span> ";	   
			   }}
			   else{echo "<span id='siguiente1'>1</span>";}
			  echo "</td>
               <td width='40'  align='center' valign='middle'  class='ui-widget-content' ><input width='40' type='image' id='siguienteDiv' src='imagenes/flechaAdelante.jpg' title='siguiente'></td>
             </tr></table>";
while ($row = $result->fetch_assoc()) {
$cont2++;
if($contador==0){
$contadorAux++;
echo"<div id='divListas".$contadorAux."'  class='divListas' style='border=1'>
		<table border=1 height='55'  border='0'   style='border:thin; width:100%;cursor:pointer' >
							";}
///////////////////////////////////////////////////////////////////////////////					
if($cont2==1){$htmlCuerpo=$htmlCuerpo."<tr>";}
///////////////////////////////////////////////////////////////////////////////	
$BGcolor="bgcolor='#C0FA87'";
if(($row['cantActual']>0)&&($row['cantActual']<=$row['stock'])){
	$BGcolor="bgcolor='#FFB0B0'";
	}
if(($row['cantActual']<=0)){$BGcolor="bgcolor='#D90444'";}
				
echo"<td width='170' ".$BGcolor." align='center'></br><input type='image' id='".$row['idProducto']."' name='pictSelct' src='".$row['imagen']."' height='120' width='150' class='filasData'  ></br>".$row['nombre']."
<input type='hidden' value='".$row['nombre']."' id='NP_".$row['idProducto']."'>
<input type='hidden' value='".$row['precioVenta']."' id='PV_".$row['idProducto']."'>
<input type='hidden' value='".$row['stock']."' id='stock_".$row['idProducto']."'>
</td>";

if($cont2==4){echo "</tr>";$cont2=0;}
$contador++;
if (($contador==$filasNum)&&($contadorAux<$numeroDiv))
{echo " </table></div>";$contador=0;}
}
echo "</table></div>
<input type='hidden' value='".$numeroDiv."' id='numeroDiv' />";
}
else{echo "<span>en este momento no se encuentra registrado ningun Articulo</span><input name='button' type='button' class='button small blue'  id='bt1' value='Crear Nueva'/></div>
<script type='application/javascript' language='javascript'>
iniciarListas();
</script>
";

}
?> 
<input type="hidden" value="" id="" />
</div></div>

<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>
<script type='application/javascript' language='javascript'>
iniciarListas();
</script>
<style>
.gruposBT{ height:50px}
</style>