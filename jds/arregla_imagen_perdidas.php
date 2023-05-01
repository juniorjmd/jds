<?php include 'php/inicioFunction.php';
verificaSession_2("login/");
include 'db_conection.php';
 $mysqli= cargarBD();
 $mysqli2= cargarBD();
 //echo $_SESSION["database"] ;
 $query='select * from PRODUCTO limit 1000, 400';
// echo $query;
$result=$mysqli->query($query);
$datosNum=$mysqli->affected_rows;
if($datosNum > 0)
{
while ($row = $result->fetch_assoc()) {
	
$filename1='galerias/'.TRIM($_SESSION["galeria"]).'/'.$row['idProducto'].'_picture.jpg';
$filename2='galerias/'.TRIM($_SESSION["galeria"]).'/'.$row['idProducto'].'_picture.jpeg';
$filename3='galerias/'.TRIM($_SESSION["galeria"]).'/'.$row['idProducto'].'_picture.gif';
$filename4='galerias/'.TRIM($_SESSION["galeria"]).'/'.$row['idProducto'].'_picture.png';
$filename5='galerias/'.TRIM($_SESSION["galeria"]).'/'.$row['idProducto'].'_picture.JPG';
$filename6='galerias/'.TRIM($_SESSION["galeria"]).'/'.$row['idProducto'].'_picture.jpeg';
$filename7='galerias/'.TRIM($_SESSION["galeria"]).'/'.$row['idProducto'].'_picture.gif';
$filename8='galerias/'.TRIM($_SESSION["galeria"]).'/'.$row['idProducto'].'_picture.png';
$filename9='imagenes/Sin_imagen.png';
 echo '<br> imagen actual :'.$row['imagen'].'<br>';
if ( file_exists ( $filename1 )){
	$finalFile=$filename1;
}else if ( file_exists ( $filename2 )){
	$finalFile=$filename2;
}else if ( file_exists ( $filename3 )){
	$finalFile=$filename3;
}else if ( file_exists ( $filename4 )){
	$finalFile=$filename4;
}else if ( file_exists ( $filename5 )){
	$finalFile=$filename5;
}else if ( file_exists ( $filename6)){
	$finalFile=$filename6;
}else if ( file_exists ( $filename7 )){
	$finalFile=$filename7;
}else if ( file_exists ( $filename8 )){
	$finalFile=$filename8;
}else {$finalFile=$filename9;}
 $query2 = "UPDATE PRODUCTO SET imagen = '".$finalFile."' where idProducto= '".$row['idProducto']."';";
 echo $query2.'</br>';
$mysqli2->query($query2); 
  echo 	'imagen final: '.$finalFile.'<br>';
}}


?>