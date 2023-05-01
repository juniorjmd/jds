	<?php include 'php/inicioFunction.php';
verificaSession_2("login/"); ?>
<?php
include 'php/db_conection.php';
 $conn= cargarBD();
 error_reporting(0);
 $query2="SELECT * FROM  `".$_GET['tabla1']."`  where  `nit` = '".$_GET['idCliente']."'";
 
 ECHO $query2;
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
FROM  `".$_GET['tabla2']."` WHERE `idCliente`  ='".$_GET['idCliente']."'";
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
<link media="screen" rel="stylesheet" href="css/container.css" />
<link media="screen" rel="stylesheet" href="css/estilo.css" />
<link media="screen" rel="stylesheet" href="css/menuDesplegable.css" />

<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script language="javascript1.1" src="jsFiles/trim.js" type="text/javascript"></script>
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="jsFiles/listas.js"></script>
<link media="screen" rel="stylesheet" href="css/colorbox.css" />
<script type="text/javascript" src="js/jquery.colorbox.js"></script>
<script type="text/javascript" src="inicioJS/manejadorContenidos.js"></script>
<script type="text/javascript" src="inicioJS/listadoCreditosProveedor.js"></script>
<style type="text/css">
			body{ font: 75.5%  "Trebuchet MS", sans-serif; margin: 50px;}
			div{ font-family: "Times New Roman", Times, serif; }
			#header{ padding:10px}
			div#container{position:relative;display:block;margin:auto;overflow:visible;width:1000px;z-index:1;background-color:#FFF}
			#container{box-shadow:0 2px 10px #aaa;-moz-box-shadow:0 2px 10px #aaa;-webkit-box-shadow:0 2px 10px #aaa}
			.cabeza{color:#CC9933; font-size:12px}
			.respuesta{color:#0000FF; font-size:14px}
			div{ border:#666666  thin ;}
			#tablasListaProveedor{ font-size:16px}
			#tablasListaProveedor td{ height:25px}
			
			  </style>
        

</head>

<body><input type="hidden" value="<?php echo $_GET['tabla2'];?>" id="tabla2" />
<div id="container" >
<div id="header">
<label class="cabeza" >Cedula o Nit</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="respuesta" id="IdProveedor"><?php echo $nit;?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="regresa"><img src="imagenes/salir.jpg" height="40" width="40" /></a><a href="index.php"><img height="40" width="40"src="imagenes/home_w.png"/></a>
<br /><br /><label  class="cabeza">Razon Social</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label  class="respuesta" id="razonSocial"><?php echo $razonSocial;?></label>
<br /><br /><label class="cabeza" >Direccion</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="respuesta" id="direccion"><?php echo $direccion;?></label>
<br /><br /><label class="cabeza" >email</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label  class="respuesta" id="email"><?php echo $email;?></label>
<label class="cabeza" style="margin-left:40%" >telefono</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="respuesta" id="telefono"><?php echo $telefono;?></label>
<br /><br /><label class="cabeza" >Deuda Total a la fecha</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="respuesta" id="totalDeduda"><?php echo amoneda($totalCredito,'pesos');?></label>
</div>

</div>
<form action="<?php echo $_GET['dir'] ?>"  method="post" autocomplete="off" >
<input id="datoHidden" value="" name="datoHidden" type="hidden" />
<input type="submit" id="enviar" style="display:none" />
</form><br />
<div id="listadoCreditos" >
    <?php  $id_tabla= 'tablasListaProveedor';
                $nombreArchivo= "lista_{$_GET['tabla2']}";$tipoTabla = 2;
         agregarExcel($id_tabla,$nombreArchivo,$tipoTabla);
         ?>  
 <table border="0" id="Tablacolor" width="100%"><tr><td>
      <table  border="0" id="listarTablaProveedor"   width="100%"    >
    <tr  id="cabPac" align="center"   class="ui-widget-header">
      <td width="100"  >CUENTA</td>
	   <td width="300"  >DESCRIPCION</td>
		<td   width="100">FECHA</td>		
        <td   width="70">VALOR</td>
        <td   width="70">ABONOS</td>
        <td   width="70">CUOTAS</td>
        <td   width="70">VALOR CUOTA</td>
        <td   width="70">TOTAL ACTUAL</td> 
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
