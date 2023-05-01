<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); 
$_POST['datoHidden'] = trim($_POST['datoHidden'] );

$_pagina_retorno = $_POST['pagina_inicial'];

if (isset($_POST['paginaRetorno'])){
  $_pagina_retorno = $_POST['paginaRetorno']  ;
}
if (isset($_POST['retorno'])){
  //$_pagina_retorno .='?'. $_POST['retorno']  ;
  
   $amp = '';
 foreach ( $_POST['retorno'] as $key => $value) {
    $$key = $value;
 if (is_array($$key)){
     $miLlave = $key ;
     foreach ($$key as $llave => $valor) {
         $datosRetorno .= "{$amp}{$miLlave}[$llave]=$valor";
          $amp = '&';
        }
 
     }else{
        $datosRetorno .= "{$amp}{$key}=$value"; 
     }
     
     $amp = '&';
 }
 $_pagina_retorno .='?'.$datosRetorno;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalle de Credito</title>
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


<!-- <link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />-->
<!--<link rel="stylesheet" type="text/css" media="all" href="css/estilo.css" title="win2k-1" />-->
<link media="screen" rel="stylesheet" href="css/colorbox.css" />
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script> 
<script type="text/javascript" src="jsFiles/listas.js"></script> 
<!--<script type="text/javascript" src="jsFiles/boxover.js"></script>-->
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="js/json2.js"></script>

<script type="text/javascript" src="inicioJS/estadoCreditoIni.js"></script>
<script type="text/javascript" src="inicioJS/manejadorContenidos.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>
<!-- 
<link type="text/css" href="css/jquery.alerts.css" rel="stylesheet" />
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>-->
        <script type="text/javascript" src="js/jquery.alerts.js"></script>
<!-- 
        <script src="js/wp-nicescroll/jquery.easing.js"></script>
<link rel="stylesheet" href="js/Tipsy/tipsy.css" type="text/css" />
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="js/Tipsy/tipsy-docs.css" type="text/css" />
<script type="text/javascript" src="js/Tipsy/jquery.tipsy.js"></script>-->
<script type="text/javascript" src="js/wp-nicescroll/jquery.nicescroll.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
  <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
  <link href="../css/generales.css" rel="stylesheet" type="text/css"/>
  <style>
      .cartera{
          font-size: 11px;
      }
  </style>
   
</head>
 
<body>
    <div class="container" style="position: relative;">
   <div class="row ">
       <div class="col-md-3 col-sm-12">
           <span>Cuenta</span>
           <div><span id="IdCuenta" class="cartera" ><?php echo trim($_POST['datoHidden']);?></span></div>
       </div>
         
        <div class="col-md-3 col-sm-12">
           <span>Fecha</span>
           <div><span id="fechaIngreso" class="cartera"  ></span></div></div>
           
           <div class="col-md-1 col-sm-12">
              
           <div><button class="btn btn-primary"  title="Abonar" id="abonar" >Abonar</button></div></div>
           <div class="col-md-1 col-sm-12">
           
           <div> <button title="Liquidar" id="abonar2" class="btn btn-primary">Liquidar</button></div></div>
           
           <div class="col-md-1 col-sm-12"> 
           <div style="    padding: 5px;"> <a   href="<?php echo $_pagina_retorno;?>"><input type="image" src="imagenes/images (1).jpg" height="30" /></a></div></div>
           
        
    </div>     
        <hr>
    <div class="row ">
        
        <div class="col-md-3 col-sm-12">
           <span>Cliente</span>
           <div><span id="idCliente" class="cartera" ></span></div></div>
        <div class="col-md-7 col-sm-12">
           <span>Nombre / Razon social </span>
           <div><span id="nombre" class="cartera"  ></span></div></div>
           
           
           
           
        
    </div>    
        
    <div class="row ">
        
        
        <div class="col-md-9 col-sm-12">
           <span>Descipcion  </span>
           <div><span  class="cartera"  id="descripcion" ></span></div></div>
        
    </div>    
            <hr>
    <div class="row ">
        
        <div class="col-md-2 col-sm-12">
           <span>Valor Inicial</span>
           <div><span id="valorInicial" class="cartera" ></span></div></div>
        <div class="col-md-2 col-sm-12">
           <span>Abono Inicial</span>
           <div><span id="abonoInicial" class="cartera"  ></span></div></div>
           <div class="col-md-2 col-sm-12">
           <span>Cuota</span>
           <div><span id="valorCuota" class="cartera"  ></span></div></div>
           <div class="col-md-2 col-sm-12">
           <span>Num. Cuotas</span>
           <div><span id="numCuotas" class="cartera"  ></span></div></div>
           <div class="col-md-2 col-sm-12">
           <span>Tip. Pagos</span>
           <div><span id="intervalo" class="cartera"  ></span></div></div>
        
    </div>  
                <hr>   
                <div class="row ">
        
        <div class="col-md-3 col-sm-12">
           <span>Total Valor Inicial</span>
           <div><span id="TotalInicial" class="cartera" ></span></div></div>
        <div class="col-md-3 col-sm-12">
           <span>Total Actual</span>
           <div><span id="TotalActual" class="cartera"  ></span></div></div> 
        
    </div>    
    
<input type="hidden" value="<?php echo trim($_POST['datoHidden']);?>" id="IdCuentaHD"  />




 
 
    
    
    
    
<div id="nuevoAbono" style=" padding:10Px;color: #ffffff;  position:absolute; background-color:#006699;z-index: 5;left: 20%; top:100px; width:500px;  ">
<table border="0" width="100%">
<tr>
<td colspan="4"><div align="right">
  <label>
  <input type="image" width="20"  height="20"name="cerrarBoton" id="cerrarBoton"  title="cerrar" src="imagenes/close-panel-png-md.png" />
  </label>
</div></td>
</tr>
<tr>
<td width="28%">Id Abono</td>
<td width="22%">&nbsp;&nbsp;000<span id="idAbono" ></span></td>
<td width="24%">Fecha Abono</td>
<td width="26%">&nbsp;&nbsp;<span class="cartera" id="fecha"></span></td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td>Id Cliente</td><td>&nbsp;&nbsp;<span id="idClienteAbono"></span></td><td>Id Cuenta</td><td>&nbsp;&nbsp;<span id="idCuenta"></span></td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr><tr>
<td>Deuda Actual</td><td>&nbsp;&nbsp;<span id="deudaTotal"></span></td>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td>Valor del Abono</td><td><input id="valorAbono" type="text" /></td><td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr>

<td height="41" >&nbsp;</td>
<td colspan="2"><label></label>
  <div align="center">
    <label>
    <input type="image"  id="guardarAbono"  title="aceptar" height="50" width="50"  src="imagenes/accept (2).png"/>
    </label>
  </div></td><td>&nbsp;</td>
</tr>
</table>


</div>
<div id="liquidar"style=" padding: 10px;color: rgb(255, 255, 255); position: absolute;background-color: rgb(0, 102, 153);z-index: 5;left: 20%;top: 100px;width: 500px; ">
<table border="0" width="100%">
<tr>
<td colspan="4"><div align="right">
  <label>
  <input type="image" width="20"  height="20"name="cerrarBoton" id="cerrarliquidar"  title="cerrar" src="imagenes/close-panel-png-md.png" />
  </label>
</div></td>
</tr>
<tr>
<td width="28%">Id Abono</td>
<td width="22%">&nbsp;&nbsp;000<span id="idAbonoliquidar" ></span></td>
<td width="24%">Fecha Abono</td>
<td width="26%">&nbsp;&nbsp;<span class="cartera" id="fechaliquidar"></span></td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td>Id Cliente</td><td>&nbsp;&nbsp;<span id="idClienteAbonoliquidar"></span></td><td>Id Cuenta</td><td>&nbsp;&nbsp;<span id="idCuentaliquidar"></span></td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr><tr>
<td>Deuda Actual</td><td>&nbsp;&nbsp;<span id="deudaTotalliquidar"></span></td>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td>Valor del Abono</td><td> <span id="valorAbonoliquidar" ></span></td><td>&nbsp;</td><td>&nbsp;</td>
</tr>
<tr><td height="41" >&nbsp;</td>
<td colspan="2"><label></label>
  <div align="center">
    <label>
    <input type="image"  id="guardarliquidar"  title="aceptar" height="50" width="50"  src="imagenes/accept (2).png"/>
    </label>
  </div></td><td>&nbsp;</td>
</tr>
</table>
    
    
    
    
</div>
<div  id="abonos" style="position:absolute; z-index: 2;left: 10; top: 400px; width:800px; height:400px">
<table   id=" Tablacolor" width="100%"><tr><td>
             <table  border="0" id="listarTablaAbono"    width="100%"    >
  		<tr  id="cabPac" align="center"    >
      	           <td width="12%"  >IdAbono</td>
                   <td width="16%"  >idCliente</td>
                   <td   width="12%">idFactura</td>
                   <td   width="12%" class="moneda">valorAbono</td>
                   <td   width="12%">fecha</td>
      
      </tr> 
    </table> </td></tr><tr><td>
      <div align="center" id="tablasListaAbono"  ></div>    
     <div align="center" id="indiceListaAbono" ></div>
       </td></tr></table>
</div>
</div>
</body>
</html>
