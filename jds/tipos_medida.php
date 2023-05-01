<?php include 'php/inicioFunction.php';
verificaSession_2("login/");   
$db = new mysqli(N_HOST,N_USUARIODB,N_CLAVEDB,N_DATABASE);
?>
<style type="text/css">
<!--
.Estilo8 {
	font-family: "Arial Narrow";
	font-size: 18px;
	color: #993300;
	font-weight: bold;
}

input.text, select.text, textarea.text {
   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.Estilo12 {font-size: 17px; color: #993300; font-family: "Arial Narrow";}
input.text1 {   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
select.text1 {   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
textarea.text1 {   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.Estilo15 {
	font-size: 14px;
	font-family: "Arial Narrow";
	color: #993300;
}
.Estilo16 {color: #FFFFFF}
-->
</style>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript"> 
function A(e,t)
{
var k=null;
(e.keyCode) ? k=e.keyCode : k=e.which;
if(k==13) (!t) ? B() : t.focus();
}
function B()
{
document.forms[0].submit();
return true;
}

function stopRKey(evt) {
   var evt = (evt) ? evt : ((event) ? event : null);
   var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
   if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}
document.onkeypress = stopRKey;

</script>

<form name="form1" method="post" action="">
  <table width="516" border="0" align="center">
    <tr align="center">
      <td colspan="2" bgcolor="#FDFDFD"><span class="Estilo8">MEDIDAS DE LA MADERA <BR />
      ________________________________________________________________ </span></td>
    </tr>
    <tr>
      <td width="113" bgcolor="#FFFFFF"><span class="Estilo12">Codigo</span></td>
      <td width="393"><label>
	  
<?php
$rel=mysqli_query($db,"SELECT id FROM tipos_medidas ORDER BY id DESC");     
if ($row = mysqli_fetch_array ($rel))   
{  
    $y="$row[id]";
    $b='1'; 
    $c=$y+$b; 
    while(strlen($c)<3)$c='0'.$c; 
}
?>
      <input name="codigo" type="text" class="text" id="codigo" value="<? echo $c; ?>" size="5" readonly="readonly">
      <a href="#" class="Estilo43" onClick="window.open('ver_medidas.php','popup','width=600,height=500')"><img src="buscar.png" width="20" height="20" border="0" title="Ver Unidades de Vacunaci&oacute;n"/></a></label></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="Estilo12">Medida</span></td>
      <td><label>
        <input name="m1" type="text" class="text" id="m1" size="1" autofocus="autofocus" />
        <span class="Estilo16">-</span>        <span class="Estilo15">X<span class="Estilo16">-</span></span>
        <input name="m2" type="text" class="text" id="m2" size="1" />
        <span class="Estilo16">-</span>
        <span class="Estilo15">X<span class="Estilo16">-</span></span>
        <input name="m3" type="text" id="m3" size="1" class="text">
      </label></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="Estilo12">Descripci&oacute;n</span></td>
      <td><textarea name="descripcion" cols="42" class="text1" id="descripcion"></textarea></td>
    </tr>
    <tr align="center">
      <td colspan="2" bgcolor="#FDFDFD"><span class="Estilo8">________________________________________________________________</span>
      <input type="image" src="guardar1.png" width="38" height="36" id="guardar" name="guardar" title="Guardar Datos" border="0" tabindex="7"/></td>
    </tr>
  </table>
</form>
<?php
if(isset($_POST['guardar_x'])) 
{
$codigo=$_POST['codigo'];
$m1=$_POST['m1'];
$m2=$_POST['m2'];
$m3=$_POST['m3'];
$total_pulgadas=$m1*$m2*$m3;
$pie=3.6;
$total_pies=$total_pulgadas/$pie;
$medida=$m1."X".$m2."X".$m3;

$total_pies = number_format($total_pies, 2, '.', '');


//echo $codigo; echo "<br>"; echo $total_pulgadas; echo "<br>"; echo $total_pies;  echo "<br>"; echo $medida; 

$ciclos = mysqli_query($db,"SELECT * FROM tipos_medidas where medida='$medida'");
if ($rowc = mysqli_fetch_assoc($ciclos))
{ 
?>
<script language="javascript">
alert("YA LA MEDIDA SE ENCUENTRA REGISTRADA!!");
window.location =("tipos_de_medidas.php");
</script>
<?php 
//$consulta=mysqli_query($db,"UPDATE insumos SET nombre_insumo='$nombre_insumo',lote='$lote' WHERE id='$id'");
} else {
    $query = "insert into tipos_medidas (  m1,m2,m3,total_pulgadas,total_pies,medida) values (  '$m1','$m2','$m3','$total_pulgadas','$total_pies','$medida')";
    //echo $query;
$consulta=mysqli_query($db,$query);
?>
<script language="javascript">
 alert("REGISTRO EXITOSO!!");
//window.location =("tipos_de_medidas.php");
</script>
<?php
}


}

?>