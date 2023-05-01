<?php include 'php/inicioFunction.php';
verificaSession_2("login/");  
$db = new mysqli(N_HOST,N_USUARIODB,N_CLAVEDB,N_DATABASE);
?><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.Estilo3 {font-family: "Arial Narrow"; font-size: 15px; }
.Estilo6 {font-family: "Arial Narrow"; font-size: 15px; font-weight: bold; }
.Estilo9 {font-family: "Arial Narrow"; font-size: 16px; }
.Estilo10 {
	font-family: "Arial Narrow";
	font-size: 17px;
}
.Estilo12 {
	font-family: "Arial Narrow";
	font-size: 18px;
	font-weight: bold;
	color: #993300;
}
input.text, select.text, textarea.text {
   background: #F5F5F5;
   border: 1.5px solid #999999;
   border-radius: 5px 5px 5px 5px;
   color: #000000;
   font-size: 13px;
   padding: 5px;
}
.Estilo15 {font-family: "Arial Narrow"; font-size: 17px; color: #993300; }
.Estilo16 {color: #993300}
-->
</style>
<script language="javascript" type="text/javascript"> 


function cambiar_consulta(){
var obj1=document.getElementById("consulta");

if(obj1.options[obj1.selectedIndex].text == "CC O NIT"){//si no escogi� casado
 document.getElementById('div_datos').style.display='block'
 document.getElementById('div_fecha').style.display='none'

} else if (obj1.options[obj1.selectedIndex].text == "NOMBRES"){
 document.getElementById('div_datos').style.display='block'
 document.getElementById('div_fecha').style.display='none'


} else if (obj1.options[obj1.selectedIndex].text == "FECHA"){
 document.getElementById('div_datos').style.display='none'
 document.getElementById('div_fecha').style.display='block'
 
}  


}
</script>

<form name="form1" method="post" action="">

  <table width="563" border="0" align="center">
    <tr align="center">
      <td colspan="2"><span class="Estilo12">CONSULTAR FACTURAS DE VENTA </span></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF"><span class="Estilo16">______________________________________________________________________</span></td>
    </tr>
    <tr>
      <td width="161" bgcolor="#FFFFFF"><span class="Estilo15">Consultar facturas por </span></td>
      <td width="386"><span class="Estilo9">
        <label>
        <select name="consulta" size="1" class="text" id="consulta" onchange="cambiar_consulta();">
          <option>--</option>
          <option value="CC O NIT">CC O NIT</option>
          <option value="NOMBRES">NOMBRES</option>
          <option value="FECHA">FECHA</option>
        </select>
        <input type="image" src="buscar.png" width="24" height="20" id="buscar" name="buscar" title="Consultar Datos" border="0" />
        </label>
      </span></td>
    </tr>
    

    <tr>
      <td colspan="2"> <div id="div_datos" style="display:none;">	  
<table width="540" border="0">
        <tr>
          <td width="113" bgcolor="#FFFFFF"><span class="Estilo10 Estilo16">Escriba el dato </span></td>
          <td width="411"><input name="datos" type="text" id="datos" class="text" size="50"></td>
        </tr>
      </table>
	  </div>
	  
        <div id="div_fecha" style="display:none;">
		<table width="540" border="0">
        <tr>
          <td bgcolor="#FFFFFF"><span class="Estilo15">Fecha ini </span></td>
          <td><label>
            <input name="fecha_ini" type="date" id="fecha_ini" class="text">
          </label></td>
          <td bgcolor="#FFFFFF"><span class="Estilo15">Fecha fin </span></td>
          <td><input name="fecha_fin" type="date" id="fecha_fin" class="text"></td>
        </tr>
      </table>
	  </div>	  </td>
    </tr>
    
	<tr>
      <td colspan="2" bgcolor="#FFFFFF"><span class="Estilo16">______________________________________________________________________</span></td>
    </tr>
	
    <tr>
      <td colspan="2"></td>
    </tr>
  </table>
  <br>

</form>
<?php 
if(isset($_POST['buscar_x'])) 
{
$consulta=$_POST['consulta'];
$datos=$_POST['datos'];
$fecha_ini=$_POST['fecha_ini'];
$fecha_fin=$_POST['fecha_fin'];


$tabla = 'vw_soporte';
$nombreArchivo = 'listaVentas';
$tipoTabla='1';
$datos_cabecera = array(
         
) ;

 $QUERY ="SELECT * FROM vw_soporte  order by fecha_venta asc";
 $parametros = array();
if($consulta=="CC O NIT"){
 $QUERY ="SELECT * FROM vw_soporte where id_cliente='$datos' order by fecha_venta asc";
 $parametros  = array(
        1 => array("columna" => 'id_cliente',"dato" => "$datos","relacion" => '=',)  
) ;

} else if($consulta=="FECHA") {
$QUERY = "SELECT * FROM vw_soporte where fecha_venta BETWEEN '$fecha_ini' AND '$fecha_fin' order by fecha_venta asc";
$parametros  = array(
        1 => array("columna" => 'fecha_venta',"dato" => "$fecha_ini","relacion" => '>=',) ,
        2 => array("columna" => 'fecha_venta',"dato" => "$fecha_fin","relacion" => '<=',) 
) ;
} else if($consulta=="NOMBRES") {
$QUERY=  "SELECT * FROM vw_soporte where nom_cliente like '%$datos%' order by fecha_venta asc";
$parametros  = array(
        1 => array("columna" => 'nom_cliente',"dato" => "%$datos%","relacion" => 'like',)  
) ;
} 

$consulta = mysqli_query($db, $QUERY);
 



agregarExcelDinamico($tabla,$nombreArchivo,$tipoTabla,   ['*'] , $parametros ) ;?>
 
 
  <table width="776" border="0" align="center">
  <tr align="center">
    <td width="104" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Id venta</span></td>
    <td width="112" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Fecha venta</span></td>
    <td width="130" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Cc o Nit</span></td>
    <td width="130" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Estado</span></td>
    <td width="371" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Nombres</span></td>
    <td width="25"><span class="Estilo16"></span></td>
  </tr>
<?php

while($rowc = mysqli_fetch_array($consulta)) 
{
    hlp_utf8_string_array_encode($rowc);
$nom_cliente=$rowc['nom_cliente'];
$ruta=$rowc['ruta'];
$idventa=$rowc['idventa'];
$fecha_venta=$rowc['fecha_venta'];
$id_cliente=$rowc['id_cliente'];

$estado = 'Activo';
if ($rowc['estadoFactura'] != 'A'){
 $estado = 'Anulado';   
}
?>
  <tr>
    <td><span class="Estilo3"><?php echo $idventa; ?></span></td>
    <td><span class="Estilo3"><?php echo $fecha_venta; ?></span></td>
    <td><span class="Estilo3"><?php echo $id_cliente; ?></span></td>
    <td><span class="Estilo3"><?php echo $estado; ?></span></td>
    <td><span class="Estilo3"><?php echo $nom_cliente; ?></span></td>
    <td><a href="<?php echo $ruta; ?>" target="_blank" class="Estilo3"><img src="imagenes/pdf.jpeg" width="23" height="23" border="0" title="Descargar factura"></a></td>
  </tr>
<?php } ?>
</table>



<?php
//echo $ruta;
//header('content-type: application/pdf');
//readfile($ruta);
?>


<?php } ?>