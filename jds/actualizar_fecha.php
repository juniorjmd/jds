<?php 
include 'php/inicioFunction.php';
session_sin_ubicacion("login/"); 


$_SESSION["fechaVentas"]='';
$direccion = '';
if (isset($_POST['fecha'])&& $_POST['fecha'] != ''){
	$_SESSION["fechaVentas"]=trim($_POST['fecha']);
	$direccion = 'indexFacVent.php?KLJ_jkl=19jimas';
	header('Location: '.$direccion);
}
?>
<link rel="stylesheet" href="css/loadingStile.css" type="text/css" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" src="jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="jsFiles/trim.js"language="javascript" ></script>
<script type="text/javascript" src="js/json2.js"></script>
<script type="text/javascript" src="js/wp-nicescroll/jquery.nicescroll.min.js"></script>
<script type="text/javascript" src="jsFiles/trim.js" language="javascript1.1" ></script>
<script type="text/javascript" src="jsFiles/funciones.js"></script>
<script type="text/javascript" src="jsFiles/fullScreen.js"></script>
<script type="text/javascript" src="jsFiles/ajax.js"></script>
<script type="text/javascript" src="jsFiles/ajax_llamado.js"></script>
<script type="text/javascript" src="inicioJS/manejadorDeContenidos.js"></script>
<script type="text/javascript" src="inicioJS/manejadorContenidos.js"></script>
<script src="inicioJS/punto_de_venta.ini.js"></script>
<br>
<style>
div { text-align: center; }
#principal{max-width:250px;}
</style>

<div class='container' id='principal'>
<div class="panel panel-default center">
  <div class="panel-heading">
    <h3 class="panel-title">Actualizar fecha</h3>
  </div>

  <div class="panel-body">
<form  method='post' target='<?php echo $direccion;?>'>
 
<div>

<input type='date' name='fecha' class='form-control'value='<?php echo date('Y-m-d');?>' max="<?php echo date('Y-m-d');?>"> 
</div>
 </br>
<div>
<input type="submit" value="Enviar" class='form-control'>
</div>
</form>
</div>
 </div>
</div> 