	<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<?php
include 'php/db_conection.php';
 $conn= cargarBD();
 error_reporting(0);
 $_arr_parametros = array();
 if (sizeof($_GET) > 0){
   $_arr_parametros =   $_GET;
 }
 if (sizeof($_POST) > 0){
     $_arr_parametros =   $_POST;
 } 
 $amp = '';
 foreach ( $_arr_parametros as $key => $value) {
    $$key = $value;
 if (is_array($$key)){
     $miLlave = $key ;
     foreach ($$key as $llave => $valor) {
        $llave = str_replace("'", '', $llave);
         //echo $llave;
         $datosRetorno .= "<input type='hidden' name='retorno[{$miLlave}][$llave]' value='$valor' />";
         
        }
 
     }else{
         $datosRetorno .= "<input type='hidden' name='retorno[{$key}]' value='$value' />";
     }
     
     
 }

 
 

$auxEnvio = '?';
if (isset($auxPos)){
    foreach ($auxPos as $key => $value) {
        $auxEnvio .= "{$amp}auxPos['{$key}'] = $value";
        $amp = '&';
    } 
}
 
if(!isset($origen_peticion)){
    $origen_peticion = '';
}else{
    $origen_peticion.= $auxEnvio;
}
 $query2="SELECT * FROM  `$tabla1`  where  `nit` = '$idCliente' ";
 
 
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
	
    hlp_utf8_string_array_encode($row);
$idCliente=$row["idCliente"];
$nit =$row["nit"];
$nombre =$row["nombre"];
$razonSocial =$row["razonSocial"];
$direccion =$row["direccion"];
$telefono =$row["telefono"];
$email =$row["email"];
}
$query2="SELECT SUM(  `TotalActual` ) AS total
FROM  `$tabla2` WHERE `idCliente`  ='$idCliente'";
$result = $conn->query($query2);
while ($row = $result->fetch_assoc()) {
$totalCredito=$row["total"];
}
$result->free();
$conn->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JDS soluciones</title> 
  
 
        

<!-- se agregan nuevos estilos con bootstrap --> 
<script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>

<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/> 
<!-- se agregan nuevos estilos con bootstrap -->  
<link media="screen" rel="stylesheet" href="css/colorbox.css" />
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script> 
<script type="text/javascript" src="jsFiles/listas.js"></script>  
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" src="inicioJS/manejadorContenidos.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script> 
<script type="text/javascript" src="inicioJS/resumenDeCuentasPersonas.js"></script> 
        <script type="text/javascript" src="js/jquery.alerts.js"></script> 
<script type="text/javascript" src="js/wp-nicescroll/jquery.nicescroll.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
  <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
  <link href="../css/generales.css" rel="stylesheet" type="text/css"/>

</head>

<body><input type="hidden" value="<?php echo $tabla2 ;?>" id="tabla2" />
    
 
    <div>
        <div class="row">
        <div class="col-md-12 col-sm-12">
            <h2>Resumen De Credito.</h2>
            <hr>
        </div>  
        </div>  
         <div class="row">
        <div class="col-md-2 col-sm-12">
            <span>Cedula o Nit</span> 
            <div><span id="IdProveedor"><?php echo $nit;?></span></div>
        </div>  
             
         <div class="col-md-2 col-sm-12"> 
             <span>&nbsp;</span> 
             <div> <a href="<?=$origen_peticion;?>"><input type="image" src="imagenes/images (1).jpg" height="30"></a></div>
        </div>      
             
        </div>  
        <div class="row">
        <div class="col-md-7 col-sm-12">
           <span>Nombre / Razon social </span>
           <div><span id="razonSocial"><?php echo $razonSocial;?></span></div></div>
        </div>
        
    </div>    
    
    
    
<div id="container" >


</div>
<form action="<?php echo $dir ?>"  method="post" autocomplete="off" >
<input id="datoHidden" value="" name="datoHidden" type="hidden" />
<input id="paginaRetorno" value="resumenDeCuentasPersonas.php" name="paginaRetorno" type="hidden" />
<?=$datosRetorno?> 
<input type="submit" id="enviar" style="display:none" />
</form><br />
<div id="listadoCreditos" >
    <?php  $id_tabla= 'tablasListaProveedor';
                $nombreArchivo= "lista_{$tabla2}";$tipoTabla = 2;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?>  
 <table border="0" id="Tablacolor" width="100%"><tr><td>
      <table  border="0" id="listarTablaProveedor"   width="100%"    >
    <tr  id="cabPac" align="center"   >
      <td width="100"  >CUENTA</td>
	   <td width="300"  >DESCRIPCION</td>
		<td   width="100">FECHA</td>		
        <td   width="70" class="moneda">VALOR</td>
        <td   width="70" class="moneda">ABONOS</td>
        <td   width="70">CUOTAS</td>
        <td   width="70" class="moneda">VALOR CUOTA</td>
        <td   width="70" class="moneda">TOTAL ACTUAL</td> 
      </tr>
      <tr>
        <td colspan="8"></td>
      </tr>
    </table> </td></tr><tr><td> <div align="center" id="tablasListaProveedor" ></div>    
     <div align="center" id="indiceListaProveedor" ></div>
       </td></tr></table>

</div>


</div>
</body>
</html>
