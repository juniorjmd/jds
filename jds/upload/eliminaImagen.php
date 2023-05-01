<?php
$galeria="/";
if($_POST['galeria']){$galeria="/".$_POST['galeria']."/";}

$nombreArchivo=$_POST['nombre'];
$fileTypes = array('jpg','jpeg','gif','png','JPG'); // File extensions
			 $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $_FILES["archivos"]["name"][$i];
	foreach ($fileTypes as $valor){
				if (file_exists("../galerias/".TRIM($_SESSION["galeria"]).'/'.$galeria.$nombreArchivo.".".$valor)) {
					unlink("../galerias/".TRIM($_SESSION["galeria"]).'/'.$galeria.$nombreArchivo.".".$valor);
			} 
				}
?>