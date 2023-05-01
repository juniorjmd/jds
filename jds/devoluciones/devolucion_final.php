<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';
		$mysqli = cargarBD();	

$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
$$tags2[$i]=$valores2[$i]; 
}

?>
<style>
 
.general div{margin-left:10px}
button 	{vertical-align: -webkit-baseline-middle;}
a{vertical-align: -webkit-baseline-middle;}
img {border:none; height:110% ; cursor: pointer} 
.panel-heading {height:8%}

@media screen and (min-width:300px) and (max-width:800px)  {
body{font-size:0.8em;}
a > span {font-size:15px;}
.panel-heading {height:35px}
}

</style>
<title>JDS/Devoluciones</title>
<body>
<div class="panel panel-default">
 
<?php		
		if (trim($df67_5675)!='' ){
				$queryCall ="call  `devolucionTotal` ( '".$df67_5675."', '".$_SESSION["usuarioid"]."',  @estatus , @totalDevuelto ,@ivaDevuelto ,@totalProductos ,@totalPresioVent );";
		if ( !$mysqli->query($queryCall)) {
	echo '<div class="alert alert-danger" role="alert" " align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:3%">
Falla en la iniciaci&oacute;n del procedimiento : cod. error ('.$mysqli->errno.') '.$mysqli->error .' , por favor intente mas tarde
</div>';
}
/*set totalDevuelto =   total_devuelto;
set ivaDevuelto = 		iva_devuelto;
set totalProductos =   ontProductos ;
set totalPresioVent =  precio_venta ;*/
if (!($resultado = $mysqli->query("SELECT @estatus as _p_out , @totalDevuelto as totalDevuelto ,@ivaDevuelto as ivaDevuelto ,@totalProductos as totalProductos,@totalPresioVent as totalPresioVent" ))) {
   echo '<div class="alert alert-danger" role="alert" " align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:3%">
Falla en la optenci&oacute;n de estatus del proceso : cod. error ('.$mysqli->errno.') '.$mysqli->error .' , por favor intente mas tarde
</div>';
}
else{$fila = $resultado->fetch_assoc();
	if ($fila['_p_out'] =='ok'){
		echo '<div class="alert alert-success" role="alert" " align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:3%">
	la factura n&uacute;mero '.$consecutivo.' perteneciente al codigo : ('.$df67_5675.') fue cancelada con exito
</div>';
	echo '<div class="alert alert-success" role="alert" " align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:10px">
	<div>GENERALIDADES</div>
	<div class="general">
	<div> Cantidad total productos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                 :&nbsp;'.rellenar($fila['totalProductos'] ,30,'sp',null) .'</div>
	<div> Monto total a devolver&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       :&nbsp;'.rellenar(amoneda($fila['totalDevuelto'],"pesos"),30,'sp',null)   .'</div>
	<div> Monto equivalente al iva&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                 :&nbsp;'.rellenar(amoneda($fila['ivaDevuelto'],"pesos"),30,'sp',null)     .'</div>
	<div> Monto equivalente a la venta&nbsp;                                     :&nbsp;'.rellenar(amoneda($fila['totalPresioVent'],"pesos"),30,'sp',null) .'</div></div>
		
</div>';

	}elseif ($fila['_p_out'] =='error2'){echo '<div class="alert alert-danger" role="alert" " align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:3%">
la factuara n&uacute;mero '.$consecutivo.' perteneciente a la venta '.$df67_5675 .' ya fue cancelada anteriormente, por favor verifique e intenten de nuevo
</div>';} 
elseif($fila['_p_out'] =='error'){echo '<div class="alert alert-danger" role="alert" " align="center" style="width:90%; margin-left:5%; margin-right:5%; margin-top:3%">
la factuara n&uacute;mero '.$consecutivo.' perteneciente a la venta '.$df67_5675 .' no pudo ser cancelada con exito, por favor verifique e intente de nuevo
</div>';}
 }

		}?>



		
 
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript" >
$(document).ready(function(){

});
</script>

</div></body>
