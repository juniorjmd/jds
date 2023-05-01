<?php
include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
session_start();
$top=$_POST["top"];
for ($i=1;$i<=$top;$i++){
$auxNombre="nombre_".$i;
$nombre=$_POST[$auxNombre];
$auxNombre="dato_".$i;
$dato=$_POST[$auxNombre];
$_SESSION[$nombre]=$dato;
echo $_SESSION[$nombre];
}


?>