<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--

	

table.botonera {
    margin: auto;
    border-spacing: 0px;
    border-collapse: collapse;
    empty-cells: show;
    width: auto;
    background: url(imagenes/background-botoneragral.gif) repeat-x;
}

table.botonera table {
    border-spacing: 0px;
    border-collapse: collapse;
    empty-cells: show;
    width: 100%;
}

table.botonera td.puntos {
    height: 3px;
    background: url(imagenes/background-plkpuntos-hor.gif) repeat-x;
}

table.botonera td.frameTL {
    width: 6px;
    height: 6px;
    padding: 0;
    background: url(imagenes/esq-formato-interior-izq-sup.gif) no-repeat left top;
}

table.botonera td.frameTC {
    padding: 0;
    background: url(imagenes/background-formato-interior-sup.gif) repeat-x;
}

table.botonera td.frameTR {
    width: 6px;
    height: 6px;
    padding: 0;
    background: url(imagenes/esq-formato-interior-der-sup.gif) no-repeat right top;
}

table.botonera td.frameBL {
    width: 6px;
    height: 6px;
    padding: 0;
    background: url(imagenes/esq-formato-interior-izq-inf.gif) no-repeat left bottom;
}

table.botonera td.frameBC {
    padding: 0;
    background: url(imagenes/background-formato-interior-inf.gif) repeat-x;
}

table.botonera td.frameBR {
    width: 6px;
    height: 6px;
    padding: 0;
    background: url(imagenes/esq-formato-interior-der-inf.gif) no-repeat right bottom;
}

table.botonera td.frameCL {
    padding: 0;
    background: url(imagenes/background-formato-interior-izq.gif) repeat-y;
}


table.botonera td.frameC {
    padding: 0;
    text-align: center;
}

table.botonera td.frameCR {
    padding: 0;
    background: url(imagenes/background-formato-interior-der.gif) repeat-y;
}

table.botonera td.linkItem {
    height: 25px;
}

table.botonera a:link, table.botonera a:active, table.botonera a:visited {
    color: #3F4C69;
    text-decoration: none;
}

table.botonera a:hover { 
    color: #C82E28;
    text-decoration: underline;
}

</style>

</head>
<body >




<?php
include 'db_conection.php';
$mysqli =cargarBD();
$acentos = $mysqli->query("SET NAMES 'utf8'");

$tabla=$_GET["tabla"];
$columna=$_GET["columna"];
$dato=$_GET["dato"];


$query= "SELECT * FROM ".$tabla." WHERE `".$columna."` = '".$dato."'";
$result = $mysqli->query($query);
while ($row = $result->fetch_row()) {
		$codigoIngreso=$row[0]; 
				$ventaId=$row[1]; 
				$nombre=$row[2]; 
				
}


echo"<br><br>
<table  class='botonera'    border='0'>
 <tr ><td class='frameTL'></td><td class='frameTC'></td><td class='frameTR'></td></tr>
  <tr>
             <td class='frameCL'></td><td class='frameC'>
			 
<table border='0' >
             
  <tr>
    <td  colspan='3' width='450' align='left' >&nbsp;".$tabla." No.&nbsp;".$codigoIngreso." </td>
   	
  </tr>
   <tr>
    <td  class='puntos' colspan='3'></td>
   </tr>
  <tr>
    <td   colspan='2' align='left'>&nbsp;Proviene De :&nbsp;DeDondeViene&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destino:&nbsp; PaDondeVa</td>

	
  </tr>
   <tr>
    <td  class='puntos' colspan='3'></td>
   </tr>
   <tr>
    <td width='150' align='left' >&nbsp;Fecha&nbsp;&nbsp;&nbsp;".$ventaId."</td> 
    <td  align='left'>&nbsp;Numero de Articulos&nbsp;".$nombre."</td>
	
  </tr>
</table> 


  <td class='frameCR'></td></tr>
           <tr><td class='frameBL'></td><td class='frameBC'></td><td class='frameBR'></td></tr>
</table>


<br>
";


$result->free();


$tabla=$_GET["tabla2"];
$columna=$_GET["columna2"];

$query= "SELECT * FROM ".$tabla." WHERE `".$columna."` = '".$dato."'";

//$query="SELECT * FROM grupos";
$result = $mysqli->query($query);


$ventaId="";
$nombre="";
$presioVenta="";
$cantidad=""; 
$totalVentaParcial="";
$totalVentaTotal="";
echo"
<table  class='botonera'    border='0'>
 <tr ><td class='frameTL'></td><td class='frameTC'></td><td class='frameTR'></td></tr>
  <tr>
             <td class='frameCL'></td><td class='frameC'>




<table  class='botonera' width=''  border='0'>
  <tr  >
    <td >Codigo Producto</td>
   	<td >Descripcion </td>
	<td >Cantidad</td>
	</tr>
	
	 <tr>
    <td width='450' colspan='3'></td>
	</tr>

";

while ($row = $result->fetch_row()) {
if(strstr($row[3],'Ã')){ // donde pone ? pon el caracter a buscar
$row[3]=utf8_decode($row[3]);
}
echo"
  <tr>
    <td >".$row[1]."</td>
   	<td align='left'>".$row[3]."</td>
	<td >".$row[4]."</td>
	</tr>
	"; 
			
}
echo"</table>

 <td class='frameCR'></td></tr>
           <tr><td class='frameBL'></td><td class='frameBC'></td><td class='frameBR'></td></tr>
</table>




";
$mysqli->close();

?>


</body>
