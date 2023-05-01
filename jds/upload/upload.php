<?php include_once '../php/inicioFunction.php';
session_sin_ubicacion_2("login/");
		$nombreArchivo=$_POST['codigo']."_picture";
		$edit='';
	   //Preguntamos si nuetro arreglo 'archivos' fue definido
	if (isset ($_FILES["archivos"])) {
		require('class.image-resize.php');
		$targetFolder = '/imagenes_productos/'.TRIM($_SESSION["galeria"]); // Relative to the root
		$verifyToken = md5('unique_salt' . $_POST['timestamp']);
	     //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
         //obtenemos la cantidad de elementos que tiene el arreglo archivos
         $tot = count($_FILES["archivos"]["name"]);
         //este for recorre el arreglo
		 if($_POST['archivo']){//unlink("../".$_POST['archivo']);
		 //$edit="edit";
		 }
		for ($i = 0; $i < $tot; $i++){//con el indice $i, poemos obtener la propiedad que desemos de cada archivo/para trabajar con este
         	$tempFile = $_FILES['archivos']['tmp_name'][$i];
			$fileParts = pathinfo($_FILES['archivos']['name'][$i]);
			$contaIN=$contaIN+1;
			$targetPath = "..". $targetFolder;
			$targetFile = rtrim($targetPath,'/') . '/' .$nombreArchivo.$edit.".".$fileParts['extension'];
			$aux1='imagenes_productos/'.TRIM($_SESSION["galeria"]).'/'.$nombreCarpeta.'/tooltips'.'/'.$nombreCarpeta.$contaIN.".".$fileParts['extension']; 
			$aux2='imagenes_productos/'.TRIM($_SESSION["galeria"]).'/'.$nombreCarpeta.'/images'.'/'. $nombreCarpeta.$contaIN.".".$fileParts['extension'];
			//echo "  esto es aux1 ".$aux1." esto es aux2 ".$aux2."</br> esto es $targetFile ".$targetFile;
			
			$targetPath2 = "..". $targetFolder2;
			$newfile = rtrim($targetPath2,'/') . '/' . $nombreCarpeta.$contaIN.".".$fileParts['extension'];
			$fileTypes = array('jpg','jpeg','gif','png','JPG'); // File extensions
			 $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
            $name = $_FILES["archivos"]["name"][$i];
	foreach ($fileTypes as $valor){
				if (file_exists("../imagenes_productos/".TRIM($_SESSION["galeria"]).'/'.$nombreArchivo.".".$valor)) {
					unlink("../imagenes_productos/".TRIM($_SESSION["galeria"]).'/'.$nombreArchivo.".".$valor);
					//echo 'lo eliminio '.$nombreArchivo.".".$valor;
			} 
				}
 			if (in_array($fileParts['extension'],$fileTypes)){
				if(move_uploaded_file($tempFile,$targetFile)){
					echo  'imagenes_productos/'.TRIM($_SESSION["galeria"]).'/' .$nombreArchivo.$edit.".".$fileParts['extension']."?".time();
					$OBJ = new img_opt();
					$OBJ->max_width(600);
   					$OBJ->max_height(600);
   					$OBJ->image_path($targetFile);
   					$OBJ->image_resize();
				}}}}

?>