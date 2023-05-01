<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'db_conection.php';
include 'php/funcionesMysql.php';
$conn= cargarBD();
$fecha =normalize_date($_POST["fecha"],"-"); 
$wFecha = "where `{$_POST["tabla"]}`.`fecha`= '$fecha' ";
if (isset($_POST["fechaHasta"])&& trim($_POST["fechaHasta"]) != '' ){
   
$wFecha = "where `{$_POST["tabla"]}`.`fecha` >= '$fecha' "; 
$fecha =normalize_date($_POST["fechaHasta"],"-");  
    $wFecha.=" and `{$_POST["tabla"]}`.`fecha` <= '$fecha' "; 
   
}

if (isset($_POST["estadoNomina"])&& trim($_POST["estadoNomina"]) != '' ){
    
    $wFecha.=" and  `estadoNomina` = '{$_POST["estadoNomina"]}' "; 
   
}


$query2="SELECT  * FROM  `".$_POST["tabla"]."` $wFecha";
 //echo $query2;

$result = $conn->query($query2);
//echo $query2;
switch ($_POST["tabla"]) {
    case 'bancos':

while ($row = $result->fetch_assoc()) {
	echo "<tr>
<td class= 'ui-widget-content'>".$row["id_deposito"]."</td>
<td class= 'ui-widget-content'>".$row["provieneDe"]."</td>
<td class= 'ui-widget-content'>".$row["FECHA"]."</td>
<td class= 'ui-widget-content'>".$row["VAUCHE"]."</td>
<td class= 'ui-widget-content'>".amoneda($row["VALOR"])."</td>
<td class= 'ui-widget-content'>".$row["DESCRIPCION"]."</td>
<td class='descImg ui-widget-content'><img  src='".trim($row["IMANGEN"])."' ></td>
</tr>";
}

        break;
        case 'vwabonosnomina':

while ($row = $result->fetch_assoc()) {
echo "<tr>
<td class= 'ui-widget-content'><img src='imagenes/b_drop.png' id='".$row["id_abono"]."' class='abonos ' style='cursor:pointer'></td>
<td class= 'ui-widget-content'>".$row["nombreUsuario"]."</td>
<td class= 'ui-widget-content'>".$row["fecha"]."</td>
<td class= 'ui-widget-content'>".amoneda($row["cantidad"])."</td>
<td class= 'ui-widget-content'>".$row["id_empleado"]."</td>
<td class= 'ui-widget-content'>".$row["nombre"]." ".$row["apellido"]."</td>
<td class= 'ui-widget-content'>".$row["estadoNomina"]."</td><td>".$row["descripcion"]."</td>
</tr>";
}

        break;

    default:
        while ($row = $result->fetch_assoc()) {
echo "<tr>
<td class= 'ui-widget-content'>".$row["nombreUsuario"]."</td>
<td class= 'ui-widget-content'>".$row["fecha"]."</td>
<td class= 'ui-widget-content'>".amoneda($row["valorGasto"])."</td>
<td class= 'ui-widget-content'>".$row["pagadoA"]."</td>
<td class= 'ui-widget-content'>".$row["porConceptoDe"]."</td>
<td class= 'ui-widget-content'>".$row["descripcion"]."</td>
</tr>";

}
        break;
}

$result->free();
$conn->close();

?>