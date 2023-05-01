<?php 
include 'php/inicioFunction.php';
include 'db_conection.php';
verificaSession_2("login/");
date_default_timezone_set("America/Bogota"); 
 $conn= cargarBD();
$usuarioID=$_SESSION["usuarioid"];
/*$_SESSION["retefuente_aplica"] == 'S' && floatval($_POST['rfventaNeta']) >= floatval($_SESSION["base_retefuente"] */
//echo $_SESSION["retefuente_aplica"].'  -  '.$_SESSION['base_retefuente'];
$retefuente = '<input type="hidden" value="'.$_SESSION["retefuente_aplica"].'" id="retefuente_aplica"/>'.
'<input type="hidden" value="'.$_SESSION["base_retefuente"].'" id="base_retefuente"/>';
 if(isset($_POST['id_de_Compra'])){
$query2="SELECT * FROM  `listacompra` WHERE `idCompra` =  ".$_POST['id_de_Compra'];
$result = $conn->query($query2);
if($result->num_rows>0){
while ($row = $result->fetch_assoc()) {
	$valorParcial+=$row['valorsiva'];
	$CantVendida+=$row['cantidad'];
	$iva = $row['iva'];
	$valorTotal += $row['valorTotal'];
}
$result->free();

$queryCompra="INSERT INTO  `compras` (`idCompra` ,`codPov` ,`cantidadVendida` ,`valorParcial` ,`descuento` ,`valorTotal` ,`fecha` ,`usuario` ,`estado` ,`idCierre`,`t_iva`)VALUES (
NULL ,  '". $_POST['provedor']."',  '".$CantVendida."',  '".$valorParcial."',  '0',  '".$valorTotal."',  '". $_POST['fechaIngreso']."', '".$_POST['usuarioID']."',  'activo',  '','".$iva."'
);";
//echo 	$queryCompra ;
$stmt = $conn->stmt_init();

 $conexion =\Class_php\DataBase::getInstance();
 
 $link = $conexion->getLink(); 
 
$consulta = $link->prepare($queryCompra);

//$stmt->prepare($queryCompra);
if(!$consulta->execute()){
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear la tabla de ingresos:' . $link->errorCode());
 
}else{
	$auxQuery="UPDATE  `producto` JOIN  `listacompra` ON  `producto`.idProducto =  `listacompra`.`idProducto` SET  `producto`.`cantActual` =  `producto`.`cantActual` +  `listacompra`.`cantidad` ,
`producto`.`compras` =  `producto`.`compras` +  `listacompra`.`cantidad` ,`producto`.`precioCompra` = `listacompra`.`presioCompra` WHERE CONVERT(  `listacompra`.`idCompra` USING utf8 ) ='".$_POST['id_de_Compra']."' ;";		
$result = $conn->query($auxQuery);
	if ($_SESSION["retefuente_aplica"] == 'S' && floatval($_POST['rfventaNeta']) >= floatval($_SESSION["base_retefuente"] )){
		/*$("#rfventaBruta").val(respuesta);
		$("#rfiva").val(respuesta);
		$("#rfventaNeta").val(respuesta);
		$("#rfporcent").html(respuesta);
		$("#rftotalRetenido").html(respuesta);*/
		$queryrf="call insertaRetefuente('".$_POST['usuarioID']."','".$_POST['id_de_Compra']."','".$_POST['rfiva']."','".$_POST['rfventaBruta']."','".$_POST['rfventaNeta']."','".$_POST['rfporcent']."');";
		//echo $queryrf;
		$stmt->prepare($queryrf);
                
$consulta = $link->prepare($queryrf);

//$stmt->prepare($queryCompra);
if(!$consulta->execute()){ 
			//Si no se puede insertar mandamos una excepcion
			throw new Exception('No se pudo crear el registro de retefuente para a compra # :'.$_POST['id_de_Compra'] . $link->errorCode());
			 
		}
	}

	if($_POST['tipo_de_compra']=="2"){
	$query2="SELECT * FROM  `credito` ";
$result = $conn->query($query2);
$cantCartera=$result->num_rows+1;

$query2="SELECT razonSocial FROM  proveedores where nit =  '{$_POST['provedor']}'  ";
$result_nom = $conn->query($query2);
if($result_nom->num_rows>0){
while ($row = $result_nom->fetch_assoc()) {
    hlp_arrayReemplazaAcentos_utf8_encode($row);
	$_POST['NombreProvedor'] =   $row['razonSocial'];
}}
 
$creditoNum=$_POST["provedor"]."_".$cantCartera;
$creditoNum = trim($creditoNum);
$auxObservacion="Credito por Compra con codigo 000".$_POST['id_de_Compra'];
if($_POST["abono"]==''){$_POST["abono"]=0;}
if($_POST["intervalo_pagos"]==''){$_POST["intervalo_pagos"]=30;}
 
$query="INSERT INTO  `credito` (`idCartera` ,`idCuenta` ,`descripcion` ,`idCliente` ,`nombre` ,`fechaIngreso` ,`valorInicial` ,`abonoInicial` 
,`TotalInicial` ,`numCuotas` ,`intervalo` ,`valorCuota` ,`TotalActual`,origen)
VALUES ( NULL, '".$creditoNum."', '".$auxObservacion."', '".$_POST['provedor']."','".$_POST["NombreProvedor"]."', '".$_POST['fechaIngreso']
."', '".$valorTotal."', '".$_POST["abono"]."', '".$_POST["TotalInicial"]."', '".$_POST["numeroCuotas"]."', ".$_POST["intervalo_pagos"].", '".$_POST["valCuota"]."', '".$_POST["TotalInicial"]."' ,'COMPRAS');";
 
                
$consulta = $link->prepare($query);

//$stmt->prepare($queryCompra);
if(!$consulta->execute()){  
//Si no se puede insertar mandamos una excepcion
throw new Exception('No se pudo crear el credito # :'.$_POST['id_de_Compra'] . $link->errorCode());
 
}else{$queryCredito="UPDATE  `compras` SET  `referencia` =  '".$creditoNum."' WHERE  `compras`.`idCompra` ='".$_POST['id_de_Compra']."' ;";
$result = $conn->query($queryCredito);

}}
echo '<script> 
        window.location="compras.php"
     </script>';
}
}}

$query2="SELECT * FROM  `proveedores`  ";
$result = $conn->query($query2);
$provedor="";
$usuarioID=$_SESSION["usuarioid"];
while ($row = $result->fetch_assoc()) {
    
    hlp_arrayReemplazaAcentos_utf8_encode($row);
	$provedor=$provedor.'<option value="'.$row["nit"].'">'.$row["razonSocial"].'</option>';
}
$result->free();
 $query2="SELECT * FROM  `compras` ORDER BY idCompra";
$compraID=0;
$result = $conn->query($query2);
	while ($row = $result->fetch_assoc()) {
			$compraID=$row["idCompra"];	
		}
$compraID++;
$result->free();
$conn->close();

 ?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Compras...</title>
  
 <!-- se agregan nuevos estilos con bootstrap --> 
   <script src="../vendor/jquery_3.4.1.js" type="text/javascript"></script>
<script src="../node_modules/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<link href="../vendor/bootstrap-4.5.0-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/bootstrap-4.5.0-dist/js/bootstrap.min.js" type="text/javascript"></script>

<link href="../vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
<script src="../vendor/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="js/trim.js"></script>
<link href="../vendor/font-awesome/css/all.css" rel="stylesheet" type="text/css"/> 
<!-- se agregan nuevos estilos con bootstrap -->  
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script> 
<script type="text/javascript" src="jsFiles/listas.js"></script> 
<!--<script type="text/javascript" src="jsFiles/boxover.js"></script>-->
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="js/json2.js"></script>

<script type="text/javascript" src="inicioJS/comprasInicio.js"></script>
<script type="text/javascript" src="inicioJS/manejadorContenidos.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>  
<script type="text/javascript" src="js/wp-nicescroll/jquery.nicescroll.min.js"></script>
  <script type="text/javascript" src="js/jquery.cookie.js"></script>
  <link href="../css/vistas.css" rel="stylesheet" type="text/css"/>
  <link href="../css/generales.css" rel="stylesheet" type="text/css"/>  
  
</head>

<body>
<?php echo $retefuente;?>

<form action="compras.php" autocomplete="off" method="post">
<input type='hidden' value='0'  id='val_subtotal_compra'/>
<div id="credito" align="center" style="font: 15px  'Trebuchet MS', sans-serif; padding:10Px;
color: #ffffff; font-weight: bold;position:absolute; background-color:#006699;z-index: 5;left: 30%; top:200px; width:400px; height:200px; 
display:none">
<table>
<tr>
<td>DEUDA PARCIAL</td>
<td><input type="text" name="costoParcial" id="costoParcial" disabled></td>
</tr>
<tr>
<td>ABONO INICIAL</td>
<td><input type="number" name="abono" id="abono" ></td>
</tr>

<tr>
<td>VALOR TOTAL DE LA DEUDA</td>
<td><input type="hidden" name="TotalInicial"  id="TotalInicialh"><span id="TotalInicial"></span></td>
</tr>
<tr>
<td>INTERVALOS DE PAGOS</td>
        <td> 
    <select id="aux_intervalo_pagos" name='intervalo_pagos' class="NewCartera" style=" width:100%"><option value="">--</option>
        <option value="8">semanal(8 dias)</option><option value="15">Quincenal(15 dias)</option>
        <option value="30">Mensual(30 dias)</option><option value="45">mes y medio(45 dias)</option>
        <option value="60">Bimestral</option><option value="90">Timestral</option><option value="180">Semestral</option><option value="365">Anual</option></select>
                
              </td>
</tr>
<tr>
<td>NUMERO DE CUOTAS</td>
<td><input type="number" name="numeroCuotas" id="numeroCuotas" value="1" ></td>
</tr>
<tr>
<td>VALOR DE LA CUOTA</td>
<td><input  type="hidden" name="valCuota" id="valCuotah"  ><span id="valCuota"></span></td>
</tr>
<tr>
<tr>
<td><input type="submit" value="registrar" id="cierraCredito"  style="height:40px">
<input type="button" value="Cancelar" class='boton_cancel' data-container='#credito' style="height:40px"></td>
</tr>
<tr>
</table>
</div>


<div id="retefuente_div" align="center" style="font: 15px  'Trebuchet MS', sans-serif; padding:10Px;color: #ffffff; font-weight: bold;position:absolute; background-color:#006699;z-index: 5;left: 30%; top:80px; width:400px; height:200px; display:none">
<table>
<tbody><tr>
<td colspan="2" align="center">Retencion en la fuente</td>
 </tr>
<tr>
<td>Venta Bruta</td>
<td><input type="text" id="v_rfventaBruta" readonly="">
<input type="hidden" name="rfventaBruta" id="rfventaBruta" readonly=""></td>
</tr>
<tr>
<td>Valor IVA</td>
<td><input type="text"  id="v_rfiva" readonly="">
<input type="hidden" name="rfiva" id="rfiva" readonly=""></td>
</tr>

<tr>
<td>Venta neta</td>
<td><input type="text"   id="v_rfventaNeta" readonly="">
<input type="hidden" name="rfventaNeta" id="rfventaNeta" readonly=""></td>
</tr>

<tr>
<td>% retefuente</td>
<td><select id="rfporcent" name="rfporcent">
<option value="2.5">2.5%</option>
<option value="3.5">3.5%</option>
</select></td>
</tr>
<tr>
<td>Total retefuente</td>
<td><input type="text" id="v_rftotalRetenido" readonly="">
<input type="hidden" name="rftotalRetenido" id="rftotalRetenido" readonly=""></td>
</tr>
<tr></tr><tr>
<td><input type="submit" value="enviar" id="cierraRetefuente" style="height:40px">
<input type="button" value="Cancelar" class='boton_cancel' data-container='#retefuente_div' style="height:40px"></td>
</tr>
<tr></tr></tbody></table>
</div>
<input type="hidden" name="usuarioID" value="<?PHP echo $usuarioID;?>" id="usurio">


<div  class="formulario-jds" >
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <h2>Compras</h2>
        </div></div><hr>
    <div class="row">
        <div class="col-md-2 col-sm-12">
            <label class="Estilo1">Compra No.</label>
  <div>0000<?PHP echo $compraID;?><input type="hidden" value="<?PHP echo $compraID;?>"   name="id_de_Compra" id="id_de_Compra">
  </div>  </div>  
        
        <div class="col-md-2 col-sm-12">
            <label class="Estilo1">Tipo de Compra</label>
  <div><select name="tipo_de_compra" id="tipo_de_compra" class="form-control">
        <option value="1" selected>CONTADO</option>
        <option value="2">CREDITO</option></select></div>  </div> 
        
           <div class="col-md-2 col-sm-12">
            <label class="Estilo1">Fecha</label>
  <div>
      <input type="date" id="fechaIngreso" name="fechaIngreso" value="<?php echo date('Y-m-d');?>" class="form-control">
  </div>  </div> 
        
        
           <div class="col-md-3 col-sm-12">
            <label class="Estilo1">Proveedor</label>
  <div class="input-group flex-nowrap"> 
      
      <select name="provedor" id="provedor" class="form-control">
    <option value="0">........NINGUNO........</option>
    <?php echo $provedor; ?>
      </select>
  <div class="input-group-prepend">
      
      <a class="btn btn-default" href="provedores.php?llamado=145632jlhsue" style="text-decoration:none" id="AnuevoProv2">
   <img src="nuevo_proveedor.png" name="nuevoProv2" style=" width: 20px;    height: 32px;"  border="0" align="middle" id="nuevoProv2" title="Nuevo Proveedor">
    </a>

  </div>

      
      <input type="submit" id="enviar"  style="display:none">
  </div>  </div> 

    </div>   
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <label class="Estilo1">Cod. Producto</label>
            <div class="input-group flex-nowrap"> 
            <input type="text" id="codProduto" class="venta form-control" name="codigo_del_producto" autofocus  >
          <div class="input-group-prepend">

            <input data-toggle="modal" data-target="#exampleModal" type="image" src="buscar.png" id="buscarProducto" title="Buscar Producto" align="middle">
        <a href="CreaProductos.php?llamado=145632jlhsue&AUX=1" style="text-decoration:none" id="AnuevoArt">
      <img src="iconoproducto.png" name="nuevoArt" width="26" height="22"  border="0" align="middle" 
           id="nuevoArt" title="Crear Nuevo Producto"></a>
          </div></div></div>
        
        
         <div class="col-md-6 col-sm-12">
            <label class="">Nombre - Descripcion del Producto</label>
            <div> <label class="input-group-text" id="nombreP"  >&nbsp;&nbsp;</label>
                 <input type="hidden" id="InombreP" value="" class="venta" name="nombre_del_producto">
</div>
         
         </div> 
        
     
    </div>
        <div class="row"> 
           
    <div class="col-md-2 col-sm-12">
            <label class="Estilo1">Precio</label>
            <div>      
                 
      <input type="number" id="precio" class="venta form-control" 
                 name="precio_de_compra" min="0" step="1">
            </div></div>
       <div class="col-md-2 col-sm-12">
            <label class="Estilo1">Cantidad</label>
            <div>      
<input type="number" id="cantidad" nombre="cantidad"  class="venta form-control" name="Cantidad_a_comprar" min="0" step="1">
            </div></div> 
        <div class="col-md-2 col-sm-12">
            <label class="Estilo1">% IVA</label>
            <div>      
          <SELECT id='p_iva' name='p_iva' class="venta form-control">
        <option value=0 >0</option>
        <option value=19 >19</option>
        <option value=16 >16</option>
        <option value=12 >12</option>
        <option value=10 >10</option>
        <option value=8 >8</option>
        <option value=6 >6</option>
        <option value=5 >5</option>
        <option value=4 >4</option>
        <option value=3 >3</option>
      </SELECT>
            </div></div> 
 
            
            
            
            
         <div class="col-md-2 col-sm-12">
             <label class="">Total</label>
            <div> <input disabled type="text"  align="right" name="total_venta" class="venta form-control" 
                          id="Tventa"  ></div>
         
         </div>
        
                </div><hr>

        
        <div class="row">
            <div class="col-md-2 col-sm-12"></div>
             <div class="col-md-10 col-sm-12">

            <input type="button" value="PROCESAR" id="aceptar" class="btn btn-success" tabindex="14"> 
          
              <a href="compras.php" style="text-decoration:none" id="cancelAll">
            <input type="button" value="CANCELAR" id="cancelar" class="btn btn-primary "></a>
          
            <input type="button" value="FINALIZAR" id="final"class="btn btn-danger" >  
             </div></div>
                
                
        <div class="row"> 
            <div class="col-md-12 col-sm-12" id="tabla_listado_compra">
 
             </div></div>

 
</div>

</form>
<div align="center"   >
<!--<iframe style="border:none;overflow-y: hidden; outline: none" width="100%" height="400px" src="mostrarDetalleFactura.php?tabla=listacompra&dato=<?PHP echo $compraID;?>&col=idCompra" id="frame1" ></iframe>-->
</div>



<div class="modal fade  " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Busqueda de Productos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-1 col-sm-12">
                  Buscar
              </div>   
                <div class="col-md-4 col-sm-12">       <input name="text" type="text" class="busquedas form-control" width="400" data-invoker='articulos' />
 <input type="hidden" id="respuestaArticulo" />
 <input type="hidden" id="gridID" />

          </div> 
          </div>  
          <hr>
          <div class="row">  
    <div id="busquedaArticulo"  class="col-md-12 col-sm-12" >
            <table   id=" Tablacolor" style="width:100%" ><tr><td>
             <table    id="listarTablaproducto"  style="width:100%"    >
		  <tr  id="cabPac" align="center"    >
	        <td width="70"  >CODIGO</td>
		    <td width="400"  >NOMBRE/DESCRIPCION</td>
			<td   width="70">PRECIO</td>		
                  </tr>   </table> </td></tr><tr><td>
		
      <div align="center" id="tablasListaproducto" ></div>    
     <div align="center" id="indiceListaproducto" ></div>
       </td></tr></table>
     </div>
          </div>  
          
          
</div>
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-targer_modal="tablasListaproducto" data-dismiss="modal">Close</button> 
      </div>
 
          </div>
    </div>
  </div> 
<input id='caption' value='compras' type='hidden'>

</body>
</html>