<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/"); 
?>

<style type="text/css">
#listado li{ cursor:pointer; margin-left:10%}
#listado li:hover{ background-color: #80CDF7;cursor:pointer; }
</style>
<br /><br /><br />
<table width="100%"  class="ui-widget-header" style="padding:20px">
<tbody>
  <tr><td>
  
<?php  
echo "Fecha ".date("D m/d/Y");?>
</td></tr></tbody>
 <tr ><td  id="listado" >
<br />
<ul>
<?php

include 'db_conection.php';
$mysqli = cargarBD();
$query=" SELECT * FROM  movimiento  WHERE  fecha = '".date("Y-m-d")."'";
$result = $mysqli->query($query);
$filas=$mysqli->affected_rows;
$recibido=0;
$pagado=0;
if ($filas	>0){
while ($row = $result->fetch_assoc()) {

if(strstr($row['origen'],'�')){ // donde pone ? pon el caracter a buscar
$row['origen']=utf8_decode($row['origen']);
}

if(strstr($row['destino'],'�')){ // donde pone ? pon el caracter a buscar
$row['destino']=utf8_decode($row['destino']);
}

echo"<li> ".$row['fecha']."    movimiento tipo  ".$row['tipoMovimiento']." , originado por ".$row['origen']." dirigido a".$row['destino']."</li>";
$recibido=$recibido+$row['valorAbono'];

}}else{echo"<li>no se ha realizado ningun movimiento en el dia de hoy</li>";}
$datos["datos"]=$data;
$result->free();

?></ul></td></tr></table><br /><br /><br />


