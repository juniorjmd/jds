<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cartera</title>
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
<script type="text/javascript" src="inicioJS/carteraInicio.js"></script>
<script type="text/javascript" src="inicioJS/manejadorContenidos.js"></script>
<link type="text/css" href="css/jquery.alerts.css" rel="stylesheet" />
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.23.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery.colorbox.js"></script>
        <script type="text/javascript" src="js/jquery.alerts.js"></script>
        <script src="js/wp-nicescroll/jquery.easing.js"></script>
<link rel="stylesheet" href="js/Tipsy/tipsy.css" type="text/css" />
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="js/Tipsy/tipsy-docs.css" type="text/css" />
<script type="text/javascript" src="js/Tipsy/jquery.tipsy.js"></script>
<script type="text/javascript" src="js/wp-nicescroll/jquery.nicescroll.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
<style type="text/css">
			body{ font: 75.5%  "Trebuchet MS", sans-serif; margin: 50px;}
			.demoHeaders { margin-top: 2em; }
			#dialog_link {padding: .4em 1em .0em 20px;text-decoration: none;position: relative;}
			#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
			ul#icons {margin: 0; padding: 0;}
			ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
			ul#icons span.ui-icon {float: left; margin: 0 4px;}
			div#tabs {width:800px; height:700px; }	
			div#GridAgendar  {width:100%; height:700px;  }	
			div#CuerpoGrid {width:100%; height:600px;  overflow:auto}	
			#container{position:relative;display:block;margin:auto;overflow:visible;width:980px;z-index:1;background-color:#FFF}#container{box-shadow:0 2px 10px #aaa;-moz-box-shadow:0 2px 10px #aaa;-webkit-box-shadow:0 2px 10px #aaa}
			#muestraFecha{
	position:absolute;
	top:300px;
	right:9px;
	margin-top:-32px;
	background:url(css/images/controls2.1.png) no-repeat top left;
	width:32px;
	height:65px;
	text-indent:-9999px;
}
#muestraFecha:hover{background-position:bottom left;}
			  </style>
</head>

<body>
<div id="cuerpoCartera" width="100%">
<ul >
	<li><a id="Linktabs-1" href="#tabs-1">lista Cuentas Pacientes</a></li>	
    <li><a id="Linktabs-2" href="#tabs-2">Crear Nueva Cuenta</a></li>
	<li><a id="Linktabs-3" href="#tabs-3">lista Creditos Proveedores</a></li>	
<li><a id="Linktabs-4" href="#tabs-4">Crear Creditos</a></li>	

</ul>
           <div id="tabs-1" > 
           <input id="busquedaCarteraFecha" type="text" size="30%" /> <input type="hidden" id="respuesta" /><input type="hidden" id="gridID" />
            <table border="0" id=" Tablacolor" width="100%"><tr><td>
             <table  border="0" id="listarTablaCartera" bordercolor="#71D8E3"  width="100%"    >
  
	  <tr  id="cabPac" align="center"   class="ui-widget-header">
      <td width="12%"  >idCuenta</td>
	   <td width="16%"  >descripcion</td>
		<td   width="12%">fecha</td>		
        <td   width="12%">valor</td>
        <td   width="12%">abono</td>
        <td   width="12%">Cuotas</td>
        <td   width="12%">valorCuota</td>
         <td   width="12%">Total Actual</td>
      </tr><tr><td colspan="8">
      <span id=""></span>
      </td></tr>
    </table> </td></tr><tr><td>
      <div align="center" id="tablasListaCartera" ></div>    
     <div align="center" id="indiceListaCartera" ></div>
       </td></tr></table>
           
           </div>
           
           <div id="tabs-2" >
<table width="94%" border="0">

 <tr class="ui-widget-header">
   
  
    <td width="19%"><div align="right">Cartera No.</div></td>
    <td colspan="2"><div align="left">&nbsp;000<label id="labeIDcartera"></label></div></td>
    <td width="14%"><div align="right">Fecha de ingreso</div></td>
    <td colspan="3"><div align="left">&nbsp;<label id="dataLabel"></label></div></td>
  </tr>
  <tr>
    <td colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
  <tr class="ui-widget-content">
    <td height="27"><div align="right">Codigo Cliente</div></td>
    <td colspan="5"><div align="left">&nbsp;&nbsp;
      <input title="identificacion del cliente" class="NewCartera" id="codigoCliente" type="number" />
      &nbsp;&nbsp; <input type="image"  title="Buscar cliente"  height="20" width="30" id="buscaCliente" src="imagenes/buscar_grande.jpg"  tabindex="8"/><label class="nuevolink" id="errorCliente"></label>
      <label>      </label>
    </div>      <div align="right"></div>      <div align="left"></div></td>
    <td rowspan="2"><label>
      <input type="image" name="guardarCartera" id="guardarCartera" title="Guardar nueva Cartera" src="imagenes/abrir.jpg"  tabindex="6"/>
      <input type="image" name="cancelarCartera" id="cancelarCartera" title="borrar nueva Cartera" src="imagenes/equis_naranja.gif" tabindex="7"/>
    </label></td>
  </tr>
  <tr>
    <td colspan="6"><div align="right">&nbsp;</div></td>
    </tr>
  <tr>
    <td><div align="right">Nombre</div></td>
    <td colspan="6"><div align="left">&nbsp;<label class="NewCarteralb" id="nombreYapellido"></label></div></td>
  </tr>
  <tr>
    <td colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
  <tr>
    <td><div align="right">Descripcion</div></td>
    <td colspan="6"><div align="left">&nbsp;&nbsp;<textarea class="NewCartera" id="carteraDescripcion" cols="80px"></textarea></div>      </td>
  </tr>
   <tr>
    <td height="20" colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
  <tr>
    <td><div align="right">Valor total</div></td>
    <td width="12%"><div align="left">&nbsp;&nbsp;<input type="text" value=0 title="valor de la cuenta" class="NewCartera" id="valCartera" /></div></td>
    <td colspan="4"><div align="right">Abono Inicial</div>      <div align="left"></div></td>
    <td width="28%">&nbsp;&nbsp;<input  id="abonoInicial" class="NewCartera" title="abono inicial" type="text" /></td>
  </tr>
  <tr>
    <td colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
 <tr>
     <td width="19%"><div align="right">Nùmero de Cuotas </div></td>
    <td colspan="2"><div align="left">&nbsp;&nbsp;<input value="1"  class="NewCartera" id="numeroCuotas" title="abono inicial" type="number" />
    </div>      </td>
   
   
    <td width="14%"><div align="right">Intervalos </div></td>
    <td colspan="2"><div align="left">&nbsp;&nbsp;<select id="intervalos"   class="NewCartera" >
       <option value="">--</option>
        <option value="8">semanal(8 dias)</option><option value="15">Quincenal(15 dias)</option>
        <option value="30">Mensual(30 dias)</option><option value="45">mes y medio(45 dias)</option>
        <option value="60">Bimestral</option><option value="90">Timestral</option><option value="180">Semestral</option><option value="365">Anual</option>
    </select></div></td>
 </tr>
   <tr>
    <td colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
  
    <tr> <td><div align="right">Valor de La Cuota</div></td>
    <td width="12%"><div align="left">&nbsp;&nbsp;<label  id="valCuota" class="NewCarteralb"> </label></div></td>
    <td width="11%" height="45"><div align="right">Total Deuda</div></td>
    <td  colspan="6">&nbsp;&nbsp;<div align="left" id="totalDeuda" class="NewCarteralb"></div>     </td>
  </tr>
</table>
           </div>

<div id="tabs-3" >
<input id="busquedaCreditoFecha" type="text" size="30%" /> <input type="hidden" id="respuestaCredito" />
            <table border="0" id=" Tablacolor" width="100%"><tr><td>
             <table  border="0" id="listarTablaCredito" bordercolor="#71D8E3"  width="100%"    >
  
	  <tr  id="cabPac" align="center"   class="ui-widget-header">
      <td width="12%"  >idCuenta</td>
	   <td width="16%"  >descripcion</td>
		<td   width="12%">fecha</td>		
        <td   width="12%">valor</td>
        <td   width="12%">abono</td>
        <td   width="12%">Cuotas</td>
        <td   width="12%">valorCuota</td>
         <td   width="12%">Total Actual</td>
      </tr><tr><td colspan="8">
      <span id=""></span>
      </td></tr>
    </table> </td></tr><tr><td>
      <div align="center" id="tablasListaCredito" ></div>    
     <div align="center" id="indiceListaCredito" ></div>
       </td></tr></table>
           
           </div>


           
           <div id="tabs-4" >
<table width="100%" border="0">

 <tr class="ui-widget-header">
   
  
    <td width="17%"><div align="right">Credito No.</div></td>
    <td colspan="2"><div align="left">&nbsp;000<label id="labeIDcredito"></label></div></td>
    <td width="26%"><div align="right">Fecha de ingreso</div></td>
    <td colspan="3"><div align="left">&nbsp;<label id="dataLabel2"></label></div></td>
  </tr>
  <tr>
    <td colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
  <tr class="ui-widget-content">
    <td height="27"><div align="right">Codigo Proveedor </div></td>
    <td colspan="5"><div align="left">&nbsp;&nbsp;
      <input title="identificacion del proveedor" class="NewCredito" id="codigoProveedor" />
      &nbsp;&nbsp; <input type="image"  title="Buscar cliente"  height="20" width="30" id="buscaProveedor" src="imagenes/buscar_grande.jpg"  tabindex="8"/><label class="nuevolink" id="errorProveedor"></label>
      <label>      </label>
    </div>      <div align="right"></div>      <div align="left"></div></td>
    <td rowspan="2"><label>
      <input type="image" name="guardarCredito" id="guardarCredito" title="Guardar nueva credito" src="imagenes/abrir.jpg"  tabindex="6"/>
      <input type="image" name="cancelarCredito" id="cancelarCredito" title="borrar nueva credito" src="imagenes/equis_naranja.gif" tabindex="7"/>
    </label></td>
  </tr>
  <tr>
    <td colspan="6"><div align="right">&nbsp;</div></td>
    </tr>
  <tr>
    <td><div align="right">Razon Social</div></td>
    <td colspan="6"><div align="left">&nbsp;<label class="Newcreditolb" id="razonSociallb"></label></div></td>
  </tr>
  <tr>
    <td colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
  <tr>
    <td><div align="right">Descripcion</div></td>
    <td colspan="6"><div align="left">&nbsp;&nbsp;<textarea class="NewCredito" id="DescripcionCredito" cols="80px"></textarea></div>      </td>
  </tr>
   <tr>
    <td height="20" colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
  <tr>
    <td><div align="right">Valor total</div></td>
    <td width="14%"><div align="left">&nbsp;&nbsp;
	 <input name="text" type="text" class="NewCredito" id="valCredito" value=0 title="valor de la cuenta" />
    </div></td>
    <td colspan="4"><div align="right">Abono Inicial</div>      <div align="left"></div></td>
    <td width="20%">&nbsp;&nbsp;
      <input  id="abonoInicialCredito" class="NewCredito" title="abono inicial" type="text" /></td>
  </tr>
  <tr>
    <td colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
 <tr>
     <td width="17%"><div align="right">Nùmero de Cuotas </div></td>
    <td colspan="2"><div align="left">&nbsp;&nbsp;<input value="1"  class="NewCredito" id="numeroCuotasCredito" title="abono inicial" type="text" />
    </div>      </td>
   
   
    <td width="26%"><div align="right">Intervalos </div></td>
    <td colspan="2"><div align="left">&nbsp;&nbsp;<select id="intervalosCredito"   class="NewCredito" >
     <option value="">--</option>
        <option value="8">semanal(8 dias)</option><option value="15">Quincenal(15 dias)</option>
        <option value="30">Mensual(30 dias)</option><option value="45">mes y medio(45 dias)</option>
        <option value="60">Bimestral</option><option value="90">Timestral</option><option value="180">Semestral</option><option value="365">Anual</option>
    </select></div></td>
 </tr>
   <tr>
    <td colspan="7"><div align="right">&nbsp;</div></td>
  </tr>
  
    <tr> <td><div align="right">Valor de La Cuota</div></td>
    <td width="14%"><div align="left">&nbsp;&nbsp;<label  id="valCuotaCredito" class="Newcreditolb"> </label></div></td>
    <td width="12%" height="45"><div align="right">Total Deuda</div></td>
    <td  colspan="6">&nbsp;&nbsp;<div align="left"> <label id="totalDeudaCredito" class="Newcreditolb"> </label></div>      </td>
  </tr>
</table>
           </div>
</div>

<div style="display:none" width="100%"><div id="busquedaCliente"  width="100%" >
 <input id="busquedaPacienteRegistrado" type="text" /> <input type="hidden" id="respuesta" /><input type="hidden" id="gridID" />
            <table border="0" id=" Tablacolor" width="100%"><tr><td>
             <table  border="0" id="listarTablaPaciente" bordercolor="#71D8E3"  width="100%"    >
  
	  <tr  id="cabPac" align="center"   class="ui-widget-header">
     <td width="18%"  >Identificacion</td>
	   <td width="18%"  >Nombre</td>
		<td width="18%" >Apellido</td>
		<td   width="18%">telefono</td>		
        <td   width="28%">Correo Electronico</td>
      </tr><tr><td colspan="5">
      <span id=""></span>
      </td></tr>
    </table> </td></tr><tr><td>
      <div align="center" id="tablasListaPaciente" ></div>    
     <div align="center" id="indiceListaPaciente" ></div>
       </td></tr></table>
     </div>
	 </div>

<div style="display:none" width="100%"><div id="busquedaProveedor"  width="100%" >
 <input id="busquedaProveedorRegistrado" type="text" /> <input type="hidden" id="respuestaProveedor" /><input type="hidden" id="gridID" />
            <table border="0" id=" Tablacolor" width="100%"><tr><td>
             <table  border="0" id="listarTablaProveedor" bordercolor="#71D8E3"  width="100%"    >
		  <tr  id="cabPac" align="center"   class="ui-widget-header">
	        <td width="22%"  >Identificacion</td>
		    <td width="22%"  >Razon Social</td>
			<td   width="22%">telefono</td>		
	        <td   width="34%">Correo Electronico</td>
      </tr><tr><td colspan="4">
      <span id=""></span>
      </td></tr>
    </table> </td></tr><tr><td>
      <div align="center" id="tablasListaProveedor" ></div>    
     <div align="center" id="indiceListaProveedor" ></div>
       </td></tr></table>
     </div>
	 </div>
      </body>
     
     </html>
  
 
