<?php include '../php/inicioFunction.php';
verificaSession_2("../login/"); 
require_once '../Mobile-Detect-master/Mobile_Detect.php';
$detect = new Mobile_Detect();

?>
<?php 
include '../php/db_conection.php';
$mysqli = cargarBD();
$independiente=true;
?>
<link rel="stylesheet" href="../css/loadingStile.css" type="text/css" />
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" src="../js/json2.js"></script>
<script type="text/javascript" src="../js/wp-nicescroll/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="../jsFiles/trim.js" language="javascript1.1" ></script>
<script type="text/javascript" src="../jsFiles/funciones.js"></script>
<script type="text/javascript" src="../jsFiles/fullScreen.js"></script>
<script type="text/javascript" src="../jsFiles/ajax.js"></script>
<script type="text/javascript" src="../jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="../inicioJS/manejadorContenidos.js"></script>
<script src="../inicioJS/punto_de_venta.ini.js"></script>

<style>
#container{display:none}
#header{
	padding:10px;
	height:60px;margin-top : 10px
}

#tabConf td{}

#cantidadVenta{height:40px; width:100%; 
}
#tabConf #nop{ background-color: #006699;}
#izquierda_div {padding:10px;  }
iframe{ border:none}
 #lb_mostrar_header {  position: absolute;  z-index: 5; left: 1%; top: px; display:none   }
 #lb_quitar_header{  position: absolute;  z-index: 5; left: 1%; top: px;   }
 #busquedaArticulo{padding: 10Px; color: #ffffff; font-weight: bold; position: absolute;  left: 25%; top: 80px;  display:none}
#liquidar{padding: 10Px; font-weight: bold; position: absolute;  z-index: 5; left: 50%; top: 160px; width: 250px; height: 339px; display:none}
</style>
<body>
<div class="panel panel-default" >
<div style='height:45px' class="panel-heading">
<div id='cordinates'></div>
<div  style='float:left'>
<span style="font-size:20px; font-family:Consolas, 'Andale Mono', 'Lucida Console', 'Lucida Sans Typewriter', Monaco, 'Courier New', monospace; color:#039;">
<?php echo $_SESSION['sucursalNombre']; ?> </span> </div> 
<div style="float:right; margin-right: 10px">
<a  href="../indexFacVent.php"    ><span class="glyphicon glyphicon-barcode" aria-hidden="true">Fact.&Venta</span></a>
</div>
<div style="float:right ; margin-right: 10px">
 
<a  href="../index.php"    ><span class="glyphicon glyphicon-log-out" aria-hidden="true">MenuPincipal</span></a>

</div>
</div>


 <?php 
$query="SELECT * FROM  `grupo` ;";
$result = $mysqli->query($query);	
$i=0;$contado_botones = 1;

while ($row = $result->fetch_assoc()) {
	$GrupoInicial[$i]=$row['idGrupo'];
	
	//$botones_grupo = $botones_grupo . '<button type="button" class="btn btn-default" id="'.$GrupoInicial[$i].'">'.$row['GRUPO'].'</button>';
	if ($contado_botones == 6)
	{
	$botones_grupo = $botones_grupo . '<button type="button" class="btn btn-default" id="'.$GrupoInicial[$i].'">'.$row['GRUPO'].'</button></div></li><li role="separator" class="divider"></li>';
	$contado_botones = 0 ; 
	}
	else if ($contado_botones == 1){
		$botones_grupo = $botones_grupo . '<li role="presentation"><div class="btn-group btn-group-sm" role="group" aria-label="..."><button type="button" class="btn btn-default" id="'.$GrupoInicial[$i].'">'.$row['GRUPO'].'</button>';
}else{$botones_grupo = $botones_grupo . '<button type="button" class="btn btn-default" id="'.$GrupoInicial[$i].'">'.$row['GRUPO'].'</button>';}
	$i++;
	$contado_botones++ ; 
	}
	if ($contado_botones > 1)
	{
	$botones_grupo = $botones_grupo . '</div></li><li role="separator" class="divider"></li>';
	
	}
	//"SELECT nombre , apellido FROM jkou_124569piokmd.usuarios where id = $usuario;";
	$cajero = $_SESSION["usuario"];

	$query="SELECT * FROM  `marcas` ;";
$result = $mysqli->query($query);	
		$i=0;$contado_botones = 1;

while ($row = $result->fetch_assoc()) {
		$LabInicial[$i]=$row['idlab'];
	
	if ($contado_botones == 6)
	{
	$botones_marca = $botones_marca . '<button type="button" class="btn btn-default" id="'.$LabInicial[$i].'">'.$row['laboratorio'].'</button></div></li>';
	$contado_botones = 0 ; 
	}
	else if ($contado_botones == 1){
		$botones_marca = $botones_marca . '<li role="presentation"><div class="btn-group btn-group-sm" role="group" aria-label="..."><button type="button" class="btn btn-default" id="'.$GrupoInicial[$i].'">'.$row['laboratorio'].'</button>';
}else{$botones_marca = $botones_marca . '<button type="button" class="btn btn-default" id="'.$LabInicial[$i].'">'.$row['laboratorio'].'</button>';}
	$i++;
	$contado_botones++ ; 
	}
	if ($contado_botones > 1)
	{
	$botones_marca = $botones_marca . '</div></li>';
		}
//echo'<input type="button" class="combos"  value=" COMBOS ">';//////////////////////////////////////////					
echo'<input type="hidden" value="'.$LabInicial[0].'" id="LabSelect">';
echo'<input type="hidden" value="'.$GrupoInicial[0].'" id="grupoSelect">';

?> 
<?php 
if ($detect->isMobile() or $detect->isTablet() or $detect->isAndroidOS() or $detect->isiOS()){
echo '<button type="button" class="btn btn-default" aria-label="Left Align" id="lb_mostrar_header">
  <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>mostrar
</button><button type="button" class="btn btn-default" aria-label="Left Align" id="lb_quitar_header">
  <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>ocultar
</button>';
}?>

  
  <div id="container" style = 'width:100%;height:100%;margin:0px;'>
  <div class="input-group hidden">      
      <input id="id_producto" type="text" class="form-control" placeholder="ingresar producto..." autofocus="">
	  <span class="input-group-btn">
        <button class="btn btn-default" type="button" id="enviarIdProducto">
				 <span class="glyphicon glyphicon-check" aria-hidden="true"></span>_
		</button>
      </span>
    </div>
  <input type="hidden" id = 'fgl_grupo_marca'>
  
  <div  id="header"  style = 'width:100%; margin: 0px'>
  <div  class="panel panel-default" style ='width:100%;height:60px'>
  <div class="btn-toolbar" role="toolbar" aria-label="..."style=" width:100%; margin:10px;">
  
  <div class="alert alert-success" role="alert" style="margin-right:20px;float: right; "><strong> : <span id='tipoVenta'>EFECTIVO</span></strong>
		  </div>
  
  <div class="dropdown"  style="margin-right:5px;float:right ">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    TIPO DE VENTA
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" id="tipoVentaDD">
    <li><a href="#" id='v_efectivo'>DE CONTADO</a></li>
	<li role="separator" class="divider"></li>
    <li><a href="#" id='v_credito'>A CREDITO</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#" id='v_tarjeta'>CON DATAFONO</a></li>
  </ul>
</div><div class="btn-group " style="margin-right:10px;float:right " id='menu_grupos'>
  <button type="button" class="btn btn-default" id='groupSelect'>Grupos</button>
  <button type="button" class="btn btn-default dropdown-toggle" id='boton_grupos_1' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>&nbsp;
  </button>
   <ul id='lista_grupo' class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="menu1" style=' width: 600px;  max-height :500px; overflow: auto'>
			  <?php echo $botones_grupo; ?>
			
			</ul>
  </div>
  
   <!-- Split button -->
<div class="btn-group" style="float: right" id='menu_marcas' >
  <button type="button" class="btn btn-default" id='marcasSelect'>Marcas</button>
  <button type="button" class="btn btn-default dropdown-toggle" id='boton_marcas_1' data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>&nbsp;
  </button>
   <ul id='lista_lap' class="dropdown-menu  dropdown-menu-right" role="menu" aria-labelledby="menu1" style='min-width: 600px; max-height :500px; overflow: auto'>
			  <?php echo $botones_marca; ?>
			
			</ul>
  </div>
 
  <div class="alert alert-success" role="alert" style="float: right; width:37%"><strong>Cajero : </strong><span id='N_cajero'><?php echo $cajero;?></span>
		  </div>
           <div class="alert alert-success" role="alert" style="float: right; margin-right:10px ">
  &nbsp;  &nbsp;
  <input type="image"title="configuracion de articulos y ventas"  src="../imagenes/gear_256.png" height="40" id="config">  &nbsp; &nbsp;
  <input type="image" src="../imagenes/busqueda_img.png" height="40" title="busqueda de articulos" id="inicioBuscar">&nbsp;  &nbsp;
  <a href="../index.php"><input type="image" src="../imagenes/pic_inicio.png" height="40" title="regresar a menu de inicio"></a>&nbsp;  &nbsp;
  <input type="image" src="../imagenes/cliente_saltando.png" height="40" title="cambiar el cliente" id="cambiaCliente" >&nbsp;  &nbsp;
   <input type="image" src="../imagenes/icono_acceso_usuario.png" height="40" title="cambiar el cajero" id="cambiaCajero" >&nbsp;  &nbsp;
  
		  </div>
          
          </div></div></div>
		  
<div align="center">
		  
 		   <div  class="panel panel-default" id="cuerpo" style="width : 70%; height:100%;  float:right ;overflow:none ">
				<?php 
				include 'listadoVentas.php';
				?>
		  </div>
		    <div class="panel panel-default" id= "izquierda_div" style="width : 30%; height:100%; float:right " >
			<div class="panel-heading">
					<h3 class="panel-title"><span id='nombre_cliente'></span></h3>
				  </div>
				  <div class="panel-body">
						<iframe name='frame_facturas' id='frame_facturas' src='facturacion.php' height="100%" width = '100%'></iframe>
			
				  </div>
  </div>
  
  <div id="busquedaArticulo" class="panel panel-default" style="width:650px; height:500px">
  <div class="panel-heading">
					<strong>Busqueda</strong><span class="glyphicon glyphicon-remove" aria-hidden="true" style='float:right; cursor:pointer' id="cerrarBuscar"  title="cerrar" ></span>
				  </div>
				  <div class="panel-body">
	<button type="button" class="btn btn-default" aria-label="Left Align" id='limpiar'>
	  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
	</button>
<div style='width : 80%; float:left'>
	<div class="input-group">
	  <span class="input-group-addon" id="basic-addon1">BUSQUEDA : </span>
	  <input type="text" class="form-control" placeholder="Busca Productos" aria-describedby="basic-addon1" id="busqueda">
	</div>
</div>
	
<iframe id="frameBusqueda" align="top" style="border:none" src="" height="80%" width="100%"></iframe>
</div></div>


<div id="configuracion" align="center" class="alert alert-info" style="font: 15px  'Trebuchet MS', sans-serif; padding:10Px;color: #ffffff; font-weight: bold;position:absolute; z-index: 5;left: 30%; top:100px; width:450px; height:430px; display:none">
<table align="center" id="tabConf" width="390px" class="table">
<tr><td  align="right" valign="middle"  > <h3>CONFIGURACION</h3></td><td  align="right"  > <input type="image" src="../imagenes/close (1).png" id="cerrarConf"></td></tr>

<tr><td align="center"><a href="../grupos.php"><br/><input type="image" src="../imagenes/icono_grupo.jpg" height="50" title="VISTA Y CREACION DE GRUPOS"><br/>GRUPOS</a></td> 
<td align="center"><a href="../laboratorio.php"><br/><input type="image" src="../imagenes/lab.jpg" height="50" title="VISTA Y CREACION DE MARCAS"><br/>MARCAS</a></td></tr>

<tr><td align="center"><a href="../productosVendidos.php"><br/><input type="image"  src="../imagenes/ICOVENTAS2.jpg" height="50" title="REVISION DE LOS PRODUCTOS VENTIDOS EN DETERMINADA FECHA"><br/>PRODUCTOS VENDIDOS</a></td> <td align="center"><a href="../resumenCaja.php"><br/><input type="image" src="../imagenes/resumen.jpg" height="50" title="RESUMEN DE LA CAJA"><br/>RESUMEN DE CAJA</a></td></tr>

<tr><td align="center"><a ><br/><input type="image" src="../imagenes/cierre de caja.jpg" height="50" title="CIERRE DE CAJA" id='btn_cierreCaja'><br/>CIERRE DE CAJA</a></td><td align="center"><br/><input type="image" src="../imagenes/cajon.jpg"  height="50" title="ABRIR CAJON" id="abrirCajon"><br/>ABRIR CAJON</td> </tr>
</table>
</div>
</div> 
</div>
</div>
<input type='hidden' id='IdVenta'/>
<input type='hidden' id='activaContainer'  />
<input type='hidden' id='llamado'  />
<input type='hidden' id='IdCliente_venta' value=''  />
<style>
#mod_usuario{width : 100%; height:100%;  margin : 0px ;
background: url("../imagenes/fondo_2.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;

 }
#cuerpo_cliente{display:none}
#cont_mod_usuario{width : 100%; height:100%; background-color:black; margin : 0px ; opacity: 0.5; }
#mod_insert_user {  position: absolute;   left: 50%;margin-left : -250px; top: 160px; width: 500px; opacity: 1;display:none}
</style>
<div id='mod_usuario'>
<div id='cont_mod_usuario'> </div>
	<div class="alert alert-danger" role="alert" id='mod_insert_user'>
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
Registro del Cliente
  
  <table class='table' >

  <tr>
 <td>
  <div class="input-group" style='max-width:300px'>
  <span class="input-group-addon" id="basic-addon1">CC/NIT/TI...</span>
  <input type="text" class="form-control" id='mod_id_cliente' placeholder="Identificacion" aria-describedby="basic-addon1">
</div>
    </td>
	
	<td><button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" title='(enter) ingresar/crear cliente'id='enterBtn'>
  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
</button>
<button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" title='(f8) Buscar cliente'>
  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
</button></td>
  </tr>
  

  <tbody id='cuerpo_cliente'>
<tr>
 <td>
  <div class="input-group" style='max-width:300px'>
  <span class="input-group-addon" id="basic-addon1">Id_cliente</span>
  <input type="text" class="form-control" id='id_tabla_cliente' placeholder="" aria-describedby="basic-addon1" disabled>
</div>
    </td>  </tr>
  <tr>
   <td colspan='2'>
  <div class="input-group"  style='width:100%'>
  <span class="input-group-addon" id="basic-addon1">Nombre Completo</span>
  <input type="text" class="form-control" placeholder="Nombre & apellido" aria-describedby="basic-addon1" id='auxNombre'>
</div></td>
   
  </tr>
  
  <tr>
   <td colspan='2'>
  <div class="input-group"  style='width:100%'>
  <span class="input-group-addon" id="basic-addon1">Telefono</span>
  <input type="text" class="form-control" placeholder="Telefono" aria-describedby="basic-addon1" id='auxTelefono'>
</div></td>
   
  </tr>
  <tr>
   <td colspan='2'>
  <div class="input-group" style='width:100%'>
  <span class="input-group-addon" id="basic-addon1">Mail</span>
  <input type="text" class="form-control" placeholder="Correo Electronico" aria-describedby="basic-addon1" id='auxEmail'>
</div></td>
  
  </tr>
    <tr>
   <td colspan='2'>
  <div class="input-group" style='width:100%'>
  <span class="input-group-addon" id="basic-addon1">Direccion</span>
  <input type="text" class="form-control" placeholder="Direccion" aria-describedby="basic-addon1" id='auxDireccion'>
</div></td></tr>

</tbody>
  </table>
</div>
</div>


<style>
#mod_Cajero{width : 100%; height:100%;  margin : 0px ;
background: url("../imagenes/fondo_2.jpg") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
display:none
 }
#cont_mod_cajero{width : 100%; height:100%; background-color:black; margin : 0px ; opacity: 0.5; }
#mod_insert_cajero {  position: absolute;   left: 50%;margin-left : -250px; top: 160px; width: 500px; opacity: 1;}
#respuestaOK {  position: absolute;   left: 50%; top: 60px; width: 500px; opacity: 1;}
</style>

<title>JDS/facturar</title>
<div id='mod_Cajero' >

<div id='cont_mod_cajero'> </div>


	<div class="alert alert-danger" role="alert" id='mod_insert_cajero'>
  <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
Loguin Vendedor<br/>

<div class="input-group" style='width:100%'>
  <input type="text" class="form-control" placeholder="Usuario" aria-describedby="basic-addon1" id='auxUsuario'>
</div>
<br/>
<div class="input-group" style='width:100%'>
  <input type="password" class="form-control" placeholder="password" aria-describedby="basic-addon1" id='auxClave'>
</div>
<br/>
<button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" title='aceptar cambio' id='aceptar_cajero'>
  <span class="glyphicon glyphicon-off" aria-hidden="true"></span> aceptar
</button>
<button type="button" class="btn btn-default  btn-lg" aria-label="Left Align" title='cancelar cambio' id='Ccambio_cajero'>
  <span class="glyphicon glyphicon-off" aria-hidden="true"></span> cancelar
</button>
</div></div>

<input type='hidden' id='mostrar_header' value = 'y'>

</body>
