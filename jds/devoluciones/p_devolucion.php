<?php 
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
include_once '../php/db_conection.php';

$numero2 = count($_POST);
$tags2 = array_keys($_POST); // obtiene los nombres de las varibles
$valores2 = array_values($_POST);// obtiene los valores de las varibles

// crea las variables y les asigna el valor
for($i=0;$i<$numero2;$i++){ 
$$tags2[$i]=$valores2[$i]; 
}?>
<style>
 
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
<body>
<div class="panel panel-default">
 
<?php
echo $num_tipos_productos;
for ($i=1;$i<=$num_tipos_productos; $i++)
	{ echo '<br>'.$_POST['linea_'.$i];
		$linea = $_POST['linea_'.$i];
		if($_POST['select_'.$linea] > 0)
		{echo '<br>'.$_POST['select_'.$linea];}
	}

?>


</div></body>
<meta charset="utf-8">
<title>JDS/Devoluciones</title>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<link type="text/css" href="../css/redmond/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<script type="text/javascript" language="javascript"  >
	$('#devolver_todo').click(function(){
		$('#segundo_form').trigger('click');
	});
</script>