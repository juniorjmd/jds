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

<link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<form name="form1" method="post" action="">

  <table width="563" border="0" align="center">
    <tr align="center">
      <td colspan="2"><span class="Estilo12">CONSULTAR MOVIMIENTO DE PROVEEDORES </span></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF"><span class="Estilo16">______________________________________________________________________</span></td>
    </tr>
    <tr>
      <td width="161" bgcolor="#FFFFFF"><span class="Estilo15">Consultar </span></td>
      <td width="386"><span class="Estilo9">
        <label>
        <select name="consulta" size="1" class="text" id="consulta" onchange="cambiar_consulta();">
          <option>--</option>
          <option value="CC O NIT">CC O NIT</option>
          <option value="NOMBRES">NOMBRES</option>
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

<?php 
if(isset($_POST['buscar_x'])) 
{
$consulta=$_POST['consulta'];
$datos=$_POST['datos'];
$fecha_ini=$_POST['fecha_ini'];
$fecha_fin=$_POST['fecha_fin'];

if($consulta=="CC O NIT"){
$query= "select   idCliente, nombre, sum( valorInicial) as t_valorInicial, sum(abonoInicial) as t_abonoInicial, sum(TotalInicial) as t_TotalInicial,
sum( TotalActual) as t_TotalActual  from credito where idCliente='$datos' group by idCliente , nombre" ;

} else if($consulta=="NOMBRES") {

$query= "select   idCliente, nombre, sum( valorInicial) as t_valorInicial, sum(abonoInicial) as t_abonoInicial, sum(TotalInicial) as t_TotalInicial,
sum( TotalActual) as t_TotalActual  from credito where nombre like '%$datos%' group by idCliente , nombre" ;
} else {

$query= "select   idCliente, nombre, sum( valorInicial) as t_valorInicial, sum(abonoInicial) as t_abonoInicial, sum(TotalInicial) as t_TotalInicial,
sum( TotalActual) as t_TotalActual  from credito  group by idCliente , nombre" ;
} 

$query .= ' HAVING sum( TotalActual) > 0 ';
$consulta_aux = mysqli_query($db, $query );
$consulta = mysqli_query($db, $query );
$TotalActual_aux=0;
while($row  = mysqli_fetch_array($consulta_aux)) 
{
    $TotalActual_aux +=$row['t_TotalActual'];
}
$id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaCuentasPorPagar';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
  <table id="tabla_resultados" width="787" border="0" align="center">
      <tr align="center">
    <td width="75" colspan="2" bgcolor="#F7F7F7" ><span class="Estilo6 Estilo16">Total causado : </span></td>
    <td colspan="4" width="143" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16"><?php echo  amoneda($TotalActual_aux);?></span></td>
	 <td width="32"></td>
  </tr>
  <tr align="center">
    <td width="75" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">idCliente</span></td>
    <td width="221" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">nombre</span></td>
    <td width="100" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">valorInicial</span></td>
    <td width="100" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">abonoInicial</span></td>
    <td width="86" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">TotalInicial</span></td>
    <td width="143" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">TotalActual</span></td>
	 <td width="32"></td>
  </tr>
<?php
while($rowc = mysqli_fetch_array($consulta)) 
{
   hlp_arrayReemplazaAcentos_utf8_encode($rowc);
$idCliente=$rowc['idCliente'];
$nombre=$rowc['nombre'];
$valorInicial=$rowc['t_valorInicial'];
$abonoInicial=$rowc['t_abonoInicial'];
$TotalInicial=$rowc['t_TotalInicial'];
$TotalActual=$rowc['t_TotalActual'];

?>
  <tr>
    <td><span class="Estilo3"><?php echo $idCliente; ?></span></td>
    <td><span class="Estilo3"><?php echo $nombre; ?></span></td>
    <td style=" text-align: right ;  white-space: nowrap;"  ><span class="Estilo3"><?php echo amoneda($valorInicial); ?></span></td>
    <td style=" text-align: right ;  white-space: nowrap;"><span class="Estilo3"><?php echo amoneda($abonoInicial); ?></span></td>
	 <td style=" text-align: right ;  white-space: nowrap;"><span class="Estilo3"><?php echo amoneda($TotalInicial); ?></span></td>
	 <td style=" text-align: right; white-space: nowrap;"><span class="Estilo3"><?php echo amoneda($TotalActual); ?></span></td>
	 
	   <td align="center">
     	 <a href="#" onclick="window.open('listadoCreditosProveedor.php?tabla1=<?php echo "proveedores"; ?>&idCliente=<?php echo $idCliente; ?>&tabla2=<?php echo "credito"; ?>&dir=<?php echo "estadoCredito.php"; ?>','popup','width=1200,height=500')"><img src="imagenes/verdetalles.jpeg" width="28" height="25" border="0" title="Ver detalles"></a>	</td> 
	 
	 
  </tr>
<?php } ?>
</table>



<?php
//echo $ruta;
//header('content-type: application/pdf');
//readfile($ruta);
?>
</form>


<?php } ?>