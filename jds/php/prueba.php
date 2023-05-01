<?php
header('content-type: application/json'); 
$str_obj_json = $_POST["nombre"];
//var_dump($_POST["respuesta"]);
if ($str_obj_json=="junior")
 {echo ("llego") ;}
 else
{ echo("no llego");}
 ?>



