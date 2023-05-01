<?php include 'php/inicioFunction.php';
verificaSession_2("login/");   
$db = new mysqli(N_HOST,N_USUARIODB,N_CLAVEDB,N_DATABASE);
?> 


    <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>
<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/> 
<script language="javascript" type="text/javascript"> 
$(document).ready(function(){
    let aux_cod_consulta;
    try
    {  
        aux_cod_consulta = cod_consulta;  
    }
    catch(e){
       aux_cod_consulta =  ""; 
    }
    $('#consulta').change(function(){
        let consulta = $(this).val();
        switch(consulta ){
          case "":
                $('.div_fecha').hide();
              $('.cadenaChar').hide();
              break;
          case "CC O NIT": 
          case "NOMBRES": $('.div_fecha').hide();
              $('.cadenaChar').fadeIn('slow', function(){
                 
              });
              break;
          case "fecha":     $('.cadenaChar').hide();          
             $('.div_fecha').fadeIn('slow', function(){
                 
              })
              break;  
        }
    }).val(aux_cod_consulta).trigger('change');
    
   
});
 
</script>


<div  >
   <div class="row">
       <div class="col-md-12 col-sm-12">
           <h2>CONSULTAR CUENTAS POR COBRAR</h2>
           <hr>
       </div>
   </div> 
    <form name="form1" method="post" action="">
     <div class="row"> 
         <div class="col-md-2 col-sm-12">
             <span>Tipo Consulta</span>  
           <select name="consulta" size="1" class="text form-control" id="consulta"  >
           <option value="">------</option>
           <option value="CC O NIT">CC O NIT</option>
          <option value="NOMBRES">Nombres</option>
          <!-- <option value="fecha">Fecha</option>-->
        </select>
       </div>
         <div   class="col-md-3 col-sm-12 cadenaChar"  >
        <span class="Estilo10 Estilo16">Escriba el dato </span>
    <div  > 
        <input name="datos" type="text" value="<?=$_POST['datos'];?>" id="datos" class="text form-control"  > </div>
    </div> 
          
    <div class="col-md-3 col-sm-12 div_fecha"> <span >Fecha inicio</span>
    <div  > 
        <input name="fecha_ini" type="date" id="fecha_ini" class="text form-control"> </div> </div>
    <div class="col-md-3 col-sm-12 div_fecha"> <span  >Fecha final</span>
    <div  ><input name="fecha_fin" type="date" id="fecha_fin" class="text form-control"></div></div>
       
         
          <div  class="col-md-1 col-sm-12"><span>&nbsp;</span>  
             <button id="buscar" name="buscar" title="Consultar Datos" class="btn btn-primary">Consultar</button>
           </div>
     
    </form>  
        
            
</div> 
        <div class="row"><div  class="col-md-12 col-sm-12">
            <hr></div></div> 

<?php 

if(isset($_POST['buscar']) || ( (isset($_GET['auxPos'] ) && sizeof($_GET['auxPos'])>0)) )
    
{ $amp = ''; 
$auxEnvio = '';   
    $arrVariables = $_POST;
 if(isset($_GET['auxPos'] ) && sizeof($_GET['auxPos'])>0){
    
   $arrVariables = $_GET['auxPos'];
    
}

foreach ($arrVariables as $key => $value) {
        $auxEnvio .= "{$amp}auxPos[{$key}] = $value";
        $amp = '&';
    }
     
$consulta=$_POST['consulta'];
$datos=$_POST['datos'];
$fecha_ini=$_POST['fecha_ini'];
$fecha_fin=$_POST['fecha_fin'];
 
if($consulta=="CC O NIT"){
$query = "select   idCliente, nombre,sum( valorInicial) as t_valorInicial, sum(abonoInicial) as t_abonoInicial, sum(TotalInicial) as t_TotalInicial, 
sum( TotalActual) as t_TotalActual  from cartera where idCliente='$datos' group by idCliente , nombre" ;

} else if($consulta=="NOMBRES") {
$query = "select   idCliente, nombre,sum( valorInicial) as t_valorInicial, sum(abonoInicial) as t_abonoInicial, sum(TotalInicial) as t_TotalInicial, 
sum( TotalActual) as t_TotalActual  from cartera where nombre like '%$datos%' group by idCliente , nombre" ;
} else{
$query = "select   idCliente, nombre,sum( valorInicial) as t_valorInicial, sum(abonoInicial) as t_abonoInicial, sum(TotalInicial) as t_TotalInicial, 
sum( TotalActual) as t_TotalActual  from cartera  group by idCliente , nombre " ;
}

echo "<script>let cod_consulta = '$consulta';"
        . "</script>";

$query .= ' HAVING sum( TotalActual) > 0 ';
$TotalActual_aux=0;
$consulta_aux = mysqli_query($db, $query );
$consulta = mysqli_query($db, $query );
while($row  = mysqli_fetch_array($consulta_aux)) 
{
    $TotalActual_aux +=$row['t_TotalActual'];
}
$id_tabla= 'tabla_resultados';
                $nombreArchivo= 'listaCuentasPorCobrar';
                $tipoTabla = 1;
                
                
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 



    <br><br>
<div class="row"> 
    
         
        <div class="col-md-12 col-sm-12">
<table id="tabla_resultados" class="table" >
      <tr align="center">
          <td width="75" colspan="2" ><strong>Total causado : </strong></td>
    <td colspan="4" width="143" ><strong><?php echo amoneda($TotalActual_aux);?></strong></td>
	 <td width="32"></td>
  </tr>
  <tr align="center">
    <td width="81" ><strong>Nit</strong></td>
    <td width="271" nowrap ><strong>Nombre / Razon Social</strong></td>
    <td width="109" nowrap ><strong>Valor Inicial</strong></td>
    <td width="107" nowrap ><strong>Abono Inicial</strong></td>
    <td width="91" nowrap ><strong>Total Inicial</strong></td>
    <td width="91" nowrap ><strong>Total Actual</strong></td>
	 <td  ></td>
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
    <td nowrap> <?php echo $idCliente; ?> </td>
    <td > <?php echo $nombre; ?> </td>
    <td  nowrap > <?php echo amoneda($valorInicial); ?></td>
    <td nowrap><?php echo amoneda($abonoInicial); ?></td>
	 <td nowrap><?php echo amoneda($TotalInicial); ?></td>
	 <td nowrap><?php echo amoneda($TotalActual); ?></td>
	 <td><a href="resumenDeCuentasPersonas.php?<?=$auxEnvio;?>&tabla1=clientes&origen_peticion=ver_reporte_cxc.php&idCliente=<?php echo $idCliente; ?>&tabla2=cartera&dir=estadoCuenta.php" ><img src="imagenes/verdetalles.jpeg" width="28" height="25" border="0" title="Ver detalles"></a>
	 </td> 
  </tr<?php } ?>
</table>

</div>

</div>
</div>
    <?php } ?>