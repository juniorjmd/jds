<?php include_once 'php/inicioFunction.php';
verificaSession_2("login/"); 
$_POST['datoHidden'] = trim($_POST['datoHidden'] );?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>JDS soluciones</title>
<link rel="stylesheet" type="text/css" media="all" href="css/estilo.css" title="win2k-1" />
<link media="screen" rel="stylesheet" href="css/colorbox.css" />
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/listas.js"></script>
<script language="javascript1.1" src="jsFiles/f_s_n_motrar.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/boxover.js"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
	<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>

<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="inicioJS/estadoCuentaIni.js"></script>
<script type="text/javascript" src="inicioJS/manejadorContenidos.js"></script>

<link type="text/css" href="css/jquery.alerts.css" rel="stylesheet" />
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery.colorbox.js"></script>
        <script type="text/javascript" src="js/jquery.alerts.js"></script>
        <script src="js/wp-nicescroll/jquery.easing.js"></script>

<link rel="stylesheet" href="js/Tipsy/tipsy.css" type="text/css" />

<link rel="stylesheet" href="js/Tipsy/tipsy-docs.css" type="text/css" />
<script type="text/javascript" src="js/Tipsy/jquery.tipsy.js"></script>
<script type="text/javascript" src="js/wp-nicescroll/jquery.nicescroll.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
<style>
body{ font: 75.5%  "Trebuchet MS", sans-serif; margin: 50px;}
.cartera { font-size:14px; }
 	
</style>
</head>

<body>
<input type="hidden" value="<?php echo trim($_POST['datoHidden']);?>" id="IdCuentaHD"  />
<div id="cuerpoCuenta"   style="position: relative; left: 15%; top:3px;"  >
<div id="cabecera" style=" width:800px;position: absolute; z-index: 1; left: 10; top:2px;">
<table width="100%" height="292" border="0">
  <tr>
    <td width="17%"><div align="right">Id Cuenta</div></td>
    <td width="19%"><div align="left">&nbsp;&nbsp;<span id="IdCuenta" class="cartera" ><?php echo trim($_POST['datoHidden']);?></span></div></td>
    <td width="18%"><div align="right">Id Cliente</div></td>
    <td width="11%"><div align="left">&nbsp;&nbsp;<span id="idCliente" class="cartera" ></span></div></td>
   <td width="13%"><div align="right">Fecha Ingreso</div></td>
    <td width="22%"><div align="left">&nbsp;&nbsp;<span id="fechaIngreso" class="cartera"  ></span></div></td>
  </tr>
  <tr>
    <td colspan="6" align="right">
	<?php if ( $_POST['pagina_inicial']== '' || !isset($_POST['pagina_inicial'])){?>
	<a id="atras"><input type="image" src="imagenes/images (1).jpg" height="30" /></a>
	<?php }else{?>
	<a   href="<?php echo $_POST['pagina_inicial'];?>"><input type="image" src="imagenes/images (1).jpg" height="30" /></a>
	<?php }?>
	</td>
  </tr>
  <tr>
    <td height="20"><div align="right">descripcion</div></td>
    <td colspan="3"><div align="left">&nbsp;<span  class="cartera"  id="descripcion" ></span></div></td> <td colspan="2" rowspan="3" >
	
	

	<input title="Abonar" id="abonar" type="image" height="40" width="120"     src="imagenes/abonarBoton.png"/>      <input title="Liquidar" id="abonar2" type="image" height="40" width="120"   src="imagenes/liquidarBoton.png"/>
	
	
	
	</td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>  
  </tr>
  <tr>
    <td height="20"><div align="right">Nombre</div></td>
    <td colspan="3"><div align="left">&nbsp;&nbsp;<span id="nombre" class="cartera"  ></span></div></td>   
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">Valor Inicial</div></td>
    <td><div align="left">&nbsp;&nbsp;<span id="valorInicial" class="cartera" ></span></div></td>
    <td><div align="right">Abono Inicial</div></td>
    <td colspan="3"><div align="left">&nbsp;&nbsp;<span id="abonoInicial" class="cartera" ></span></div></td>
     </tr>
     <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">valor por Cuota</div></td>
    <td><div align="left">&nbsp;&nbsp;<span id="valorCuota" ></span></div></td>
    <td><div align="right">Cuotas</div></td>
    <td ><div align="left">&nbsp;&nbsp;<span id="numCuotas" class="cartera" ></span></div>     </td>
     <td ><div align="right">intervalo</div></td>
    <td colspan="3" ><div align="left">&nbsp;&nbsp;<span id="intervalo" class="cartera" ></span></div>   </td>
     </tr>
    
     <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">Total valor inicial 
    </div></td>
    <td rowspan="2"><div align="left">
        <h1><span id="TotalInicial" ></span></h1>
    </div>      </td>
    <td><div align="right">TotalActual</div></td>
    <td colspan="3" rowspan="2"><div align="left">&nbsp;&nbsp;&nbsp;
        <h1><span id="TotalActual" ></span></h1></div>      </td>
     </tr><tr>
    <td colspan="3">&nbsp;</td>
  </tr>
     </table>

</div>
<div id="nuevoAbono" style=" padding:10Px;color: #ffffff; font-weight: bold;position:absolute; background-color:#006699;z-index: 5;left: 20%; top:200px; width:500px; height:230px">
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
<div id="liquidar"style=" padding:10Px;color: #ffffff; font-weight: bold;position:absolute; background-color:#006699;z-index: 5;left: 20%; top:200px; width:500px; height:230px">
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
<table border="0" id=" Tablacolor" width="100%"><tr><td>
             <table  border="0" id="listarTablaAbono" bordercolor="#71D8E3"  width="100%"    >
  				<tr  id="cabPac" align="center"   class="ui-widget-header">
      	<td width="12%"  >IdAbono</td>
	   <td width="16%"  >idCliente</td>
				<td   width="12%">idFactura</td>		
        <td   width="12%">valorAbono</td>
        <td   width="12%">fecha</td>
      
      </tr><tr><td colspan="5">
      <span id=""></span>
      </td></tr>
    </table> </td></tr><tr><td>
      <div align="center" id="tablasListaAbono"  ></div>    
     <div align="center" id="indiceListaAbono" ></div>
       </td></tr></table>
</div>
</div>
</body>
</html>
