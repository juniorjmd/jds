<?phpinclude_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
?>
<br /><br /><br />
<table width="100%"  class="ui-widget-header" style="padding:20px">
  <tr ><td>
<style type="text/css">
#listado li{ cursor:pointer; margin-left:10%}
#listado li:hover{ background-color: #80CDF7;cursor:pointer; }
</style>


<?php 
$primer_dia = mktime();
$ultimo_dia = mktime();
while(date("w",$primer_dia)!=1){
$primer_dia -= 3600;
}
while(date("w",$ultimo_dia)!=0){
$ultimo_dia += 3600;
}



echo "Semana del Lunes ".date("m/d/Y",$primer_dia)  ." al Domingo ". date("m/d/Y",$ultimo_dia);?>
</td></tr>
 <tr ><td  id="listado" >
<br />
<ul>
<?php


include 'db_conection.php';
$mysqli = cargarBD();



$query=" SELECT * FROM  movimiento  WHERE  fecha BETWEEN '".date("Y-m-d",$primer_dia)."' AND '".date("Y-m-d",$ultimo_dia)."';";

$result = $mysqli->query($query);
$filas=$mysqli->affected_rows;
$recibido=0;
$pagado=0;
if ($filas > 0){
while ($row = $result->fetch_assoc()) {

if(strstr($row['origen'],'�')){ // donde pone ? pon el caracter a buscar
$row['origen']=utf8_decode($row['origen']);
}

if(strstr($row['destino'],'�')){ // donde pone ? pon el caracter a buscar
$row['destino']=utf8_decode($row['destino']);
}

echo"<li> ".$row['fecha']."    movimiento tipo  ".$row['tipoMovimiento']." , originado por ".$row['origen']." dirigido a".$row['destino']."</li>";
$recibido=$recibido+$row['valorAbono'];

}}else{echo"<li>no se ha realizado ningun movimiento esta semana</li>";}
$datos["datos"]=$data;
$result->free();
$mysqli->close();

?></ul></td></tr></table><br /><br /><br />