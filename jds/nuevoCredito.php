<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Credito</title>

 <!--<script type="text/javascript" language="javascript" src="js/jquery.js"></script>-->


  
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

<script type="text/javascript" src="inicioJS/creditoInicio.js"></script>
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
  
  
</head>

<body>
    
    
   <div id="cuerpoCartera" width="100%">
     <form action="estadoCredito.php"  method="post" autocomplete="off" >
<input id="datoHidden" value="" name="datoHidden" type="hidden" />
<input id="pagina_inicial" value="" name="pagina_inicial" type="hidden" />
<input type="submit" id="enviar" style="display:none" />
</form>    
       
 <ul class="nav nav-tabs" >
	<li class="nav-item">
    <a class="nav-link active"  id="Linktabs-1" href="#tabs-1">lista Creditos Proveedores</a></li>	
<li class="nav-item">
    <a class="nav-link" id="Linktabs-2" href="#tabs-2">Crear Creditos</a></li>	

</ul>
   <br>
<div id="tabs-1" >
   <div class="row">
            <div class="col-md-1 col-sm-12">
             
            <?php  $id_tabla= 'tablasListaCredito';
                $nombreArchivo= 'listaCreditos';$tipoTabla = 2;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?> 
            </div><div class="col-md-4 col-sm-12">
             <input id="fnd_listadoModCartera" data-select_orden="#ordenarPor27072020"
                    type="text" size="30%" class="busquedas form-control" data-invoker="listadoModCredito" 
                        data-url_php="<?php echo URL_BASE."jds/php/db_listar.php"; ?>" /> </div>
            <div class="col-md-2 col-sm-12">
               <select class="form-control ordenarPor27072020" id="ordenarPor27072020" 
                       data-search="#fnd_listadoModCartera" >
                   <option value="">Ninguno</option>
                   <option value="fechaIngreso">Fecha</option>
                   <option value="idCuenta">Núm Cuenta</option>
                   <option value="idCliente">Cliente</option>
                   <option value="fechaIngreso|idCliente">Fecha & Cliente</option>
               </select>
            </div>
            <div class="col-md-2 col-sm-12">
               <select class="form-control" id="tipoOrdena27072020">
                   <option value="ASC">Ascendente</option>
                   <option value="DESC">Descendente</option> 
               </select>
            </div>
               </div>
       <hr>     
    
 <input type="hidden" id="gridID" />
 <input type="hidden" id="respuestaCredito" />

            <table border="0" id=" Tablacolor" width="100%">
                <tr><td>
             <table  border="0" id="listarTablaCredito"  width="100%"    >
  
	  <tr  id="cabPac" class="cabLn" align="center"  >
      <td width="12%"  >idCuenta</td>
	   <td width="16%"  >descripcion</td>
		<td   width="12%">fecha</td>		
        <td   width="12%">valor</td>
        <td   width="12%">abono</td>
        <td   width="12%">Cuotas</td>
        <td   width="12%">valorCuota</td>
         <td   width="12%">Total Actual</td>
      </tr> 
    </table> </td></tr>
                <tr><td>
      <div align="center" id="tablasListaCredito" ></div>    
     <div align="center" id="indiceListaCredito" ></div>
       </td></tr></table>
           
           </div>


           
           <div id="tabs-2"  class="hidden">

        <div class="row"><div class="col-md-1 col-sm-12"></div>
            <div class="col-md-3 col-sm-12">
                <label for="columna" > Credito No.</label> 
             &nbsp;000<label id="labeIDcredito"></label> 
        </div> 
        <div class="col-md-4 col-sm-12">
            <label for="columna">Fecha de ingreso</label>
            <label id="dataLabel2"></label>  </div> 
    
    </div>
        <hr>
         <div class="row"><div class="col-md-1 col-sm-12"></div>
            <div class="col-md-3 col-sm-12">
                <label for="columna" >Identificación</label> 
                <div class="input-group"> 
                    <input type="text" title="identificacion del proveedor" class="busquedas NewCredito form-control" 
             data-invoker="newCreditoProveedor"  data-url_php="<?php echo URL_BASE."jds/php/db_listar.php"; ?>" 
              id="codigoProveedor"  />
             <button class="btn btn-outline-secondary" title="Consultar cliente" id="buscaProveedor"   >
                 <i class="fa fa-search" aria-hidden="true"></i>
             </button>
        </div> </div> 
       
              <div class="col-md-4 col-sm-12">
            <label for="columna">Nombre / Razon Social</label>
            <input title="nombre del cliente" readonly required class="form-control NewCredito"  id="razonSociallb"  
                   type="text"/> </div> 
    
                 </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
             <label class="nuevolink" id="errorProveedor"></label>
             </div>
         </div> 
            
            <div class="row" >
                <div class="col-md-1 col-sm-12"></div>
                <div class="col-md-4 col-sm-12">
                    
               <div class="form-group">
                <label for="columna">Descripcion</label>
                
                <textarea class="form-control NewCredito" id="DescripcionCredito" cols="42"  name="descripcion" rows="3"     
                          
                     ></textarea></div>
            </div>
             <div class="col-md-1 col-sm-12">
                 <label for="columna"> &nbsp;</label>
                 <button class="btn btn-primary" id="guardarCredito">Registrar</button>
            </div>
                <div class="col-md-1 col-sm-12">
                <label for="columna">&nbsp;</label>
                <button class="btn btn-danger" id="cancelarCredito">Cancelar</button>
            </div>
            </div>
            
            
            <div class="row" >
                <div class="col-md-1 col-sm-12"></div>
    <div class="col-md-2 col-sm-12">
            <label for="columna"> Valor total </label> 
            
            <input type="text" value=0 title="valor de la cuenta" class="NewCredito form-control" id="valCredito" />
    </div>
    <div class="col-md-2 col-sm-12">
            <label for="columna">  Abono Inicial</label>  
            <input  id="abonoInicialCredito" class="NewCredito form-control" title="abono inicial" type="text" /> 
            </div>
      <div class="col-md-1 col-sm-12">
            <label for="columna">Cuotas</label>        
     <input value="1"  class="NewCredito form-control" id="numeroCuotasCredito" title="abono inicial" type="number" />
    </div>  
                
                
      <div class="col-md-2 col-sm-12">
            <label for="columna">Pagos</label>   
            <select id="intervalosCredito"   class="NewCredito form-control"  >
     <option value="">--</option>
        <option value="8">semanal(8 dias)</option><option value="15">Quincenal(15 dias)</option>
        <option value="30">Mensual(30 dias)</option><option value="45">mes y medio(45 dias)</option>
        <option value="60">Bimestral</option><option value="90">Timestral</option><option value="180">Semestral</option><option value="365">Anual</option>
    </select></div>
            </div>
                <div  class="row">
                    <div class="col-md-1 col-sm-12">
                        <label for="columna">&nbsp;</label>   </div>
                    <div class="col-md-2 col-sm-12">
                       <label for="columna">Valor Cuota</label>   
                       <div><label  id="valCuotaCredito" class="Newcreditolb"></div>
                    </div>
                       <div class="col-md-2 col-sm-12">
                       <label for="columna">Total Deuda</label>   
                       <div><label  id="totalDeudaCredito" class="Newcreditolb"></div>
                    </div>
                </div>
             
           </div>
</div>

    <div class="hidden">
        <button id="btn_busquedaProveedor" type="button" class="btn btn-primary" data-toggle="modal" data-target="#busquedaCliente">
  Launch demo modal
</button>      </div> 
        
<div class="modal fade " id="busquedaCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Consulta Clientes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
        <input id="consultaClienteCredito" class="busquedas"
               data-invoker="proveedor_busqueda_nueva_credito" 
               data-url_php="<?php echo URL_BASE."jds/php/db_listar.php"; ?>" type="text" />
                <input type="hidden" id="respuestaProveedor" />
                <input type="hidden" id="gridID" />
            <table class="table" border="0" id=" Tablacolor" width="100%"><tr><td>
                        <table class="table" border="0" id="listarTablaproveedores" 
                               bordercolor="#71D8E3"  width="100%"    >
  
	  <tr  id="cabPac" align="center"   >
     <td width="22%"  >Identificacion</td>
		    <td width="22%"  >Razon Social</td>
			<td   width="22%">telefono</td>		
	        <td   width="34%">Correo Electronico</td>
      </tr>
    </table> </td></tr><tr><td>
      <div align="center" id="tablasListaproveedores" ></div>    
     <div align="center" id="indiceListaproveedores" ></div>
       </td></tr></table>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-targer_modal="tablasListaproveedores" 
                data-dismiss="modal">Close</button> 
      </div>
    </div>
  </div>
</div>

      </body>
     
     </html>
  
 
