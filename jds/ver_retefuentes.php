<?php include 'php/inicioFunction.php';
verificaSession_2("login/");  
$db = new mysqli(N_HOST,N_USUARIODB,N_CLAVEDB,N_DATABASE);
 
 
$mes = date('m');
$anio = date('Y');
if(isset($_POST['mes']))  
$mes =$_POST['mes'];
if(isset($_POST['anio'])) 
$anio =$_POST['anio'];

$fecha_ini="$anio-$mes-01";
$findia=date("d", mktime(0,0,0, $mes+1, 0, $anio));
$nameMes = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
$meses.=' <select name="mes" size="1" class="text" id="mes"><option value="0">TODOS</option>'; 
for($i=1; $i<=12;$i++){
    if($i <= 9 ) $cero = '0';
    if(($mes - $i) == 0 )$check = ' selected';
    $meses .="<option $check value='$cero$i'>{$nameMes[$i-1]}</option>";
    $cero = '';
    $check = '';
}

$check = ' selected';

$years.='<select  name="anio" size="1" class="text" id="anio">'; 
for($i=$anio; $i>=$anio-5;$i--){
    if($i <= 9 ) $cero = '0';
    
    $years .="<option $check value='$i'>{$i}</option>";
    $cero = '';
    $check = '';
}
  $years.='</select>'; 
  $meses.='</select>'; 
 
$fecha_fin="$anio-$mes-$findia";
$mes =$_POST['mes'];
if(isset($_POST['anio'])) 
$anio =$_POST['anio'];
IF ($mes == '0'){
   $fecha_ini="$anio-01-01";
   $fecha_fin ="$anio-12-31";
}

$query =   "select * from vw_venta_soporte ".
        "where  fecha between '$fecha_ini' and '$fecha_fin' and retefuente > 0 order by fecha_venta asc";
 //ECHO $query;
$consulta_cliente = mysqli_query($db,$query);
 while($rowc = mysqli_fetch_array($consulta_cliente)) 
{
   //$total_retefuente +=   $rowc['retefuente']; 
}

$query =   "select distinct v.*,  s.ruta , s.nom_cliente ,s.fecha_venta,s.id_cliente from ventas v left join soportes s on v.idVenta = s.idventa ".
        "where v.fecha between '$fecha_ini' and '$fecha_fin' and retefuente > 0 order by fecha_venta asc";
//echo $query;
$total_retefuente = 0;
$consulta = mysqli_query($db,$query);
$consulta_2 = mysqli_query($db,$query);
 while($rowc = mysqli_fetch_array($consulta_2)) 
{
   $total_retefuente +=   $rowc['retefuente']; 
}
?>
<style type="text/css">
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
      <td colspan="2"><span class="Estilo12">CONSULTA RETEFUENTE APLICADA EN VENTA </span></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#FFFFFF"><span class="Estilo16">______________________________________________________________________</span></td>
    </tr>
     
    

    <tr>
      <td colspan="2">  
	  
        <div id="div_fecha"  >
		<table width="540" border="0">
        <tr>
          <td bgcolor="#FFFFFF"><span class="Estilo15">Año </span></td>
          <td><label>
            <?php echo $years;?>
          </label></td>
          <td bgcolor="#FFFFFF"><span class="Estilo15">Mes</span></td>
          <td><?php echo $meses;?></td><td> <input type="image" src="buscar.png" width="24" height="20" id="buscar" name="buscar" title="Consultar Datos" border="0" /></td>
         
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
 <link href="ayuda/jquery-ui.css" rel="stylesheet">
<script src="ayuda/external/jquery/jquery.js"></script>
<script src="ayuda/jquery-ui.js"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<?php  $id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaRetefuenteVenta';$tipoTabla = 1;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
 
  <table id="tabla_resultados" width="776" border="0" align="center">
      <tr align="center">
    <td width="104" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Total retefuente : </span></td>
    <td width="112" bgcolor="#F7F7F7" colspan="3"><span class="Estilo6 Estilo16"><?php echo  amoneda($total_retefuente);?></span></td>
     <td width="25"><span class="Estilo16"></span></td>
  </tr>
  <tr align="center">
    <td width="104" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Id venta</span></td>
    <td width="112" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Fecha venta</span></td>
    <td width="130" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Cc o Nit</span></td>
    <td width="371" bgcolor="#F7F7F7"><span class="Estilo6 Estilo16">Nombres</span></td>
    <td width="25"><span class="Estilo16"></span></td>
  </tr>
<?php

while($rowc = mysqli_fetch_array($consulta)) 
{
$nom_cliente=$rowc['nom_cliente'];
$ruta=$rowc['ruta'];
$idventa=$rowc['idVenta'];
$fecha_venta=$rowc['fecha_venta'];
$id_cliente=$rowc['id_cliente'];
?>
  <tr>
    <td><span class="Estilo3"><?php echo $idventa; ?></span></td>
    <td><span class="Estilo3"><?php echo $fecha_venta; ?></span></td>
    <td><span class="Estilo3"><?php echo $id_cliente; ?></span></td>
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


 