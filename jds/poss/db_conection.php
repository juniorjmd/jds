<?php 
function cargarBD ($dbWork = NULL){
	error_reporting(0);
	if (is_null($dbWork)){
	session_start();
   $database= $_SESSION["database"] ;}else{ $database=$dbWork;}
   
 if($database!=''){
//echo $_SERVER['database'];db_djose
if(($_SERVER['SERVER_NAME']=="localhost")||($_SERVER['SERVER_NAME']=="LOCALHOST"))
{
$mysqli = new mysqli('localhost','root','juniorjmd',$database);}
else
{if(filter_var($_SERVER['SERVER_NAME'], FILTER_VALIDATE_IP))
	{$mysqli = new mysqli($_SERVER['SERVER_NAME'],'usuarioExterno','juniorjmd',$database);}
	else{$mysqli = new mysqli('josedominguez1.db.11457158.hostedresource.com','josedominguez1','joseD%2013',$database);}}
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
   return NULL ;
}else{
return $mysqli;
}}else{return NULL;}
}
function cargarBDSession ($dbWork = NULL){
	error_reporting(0);
if (is_null($dbWork)){
	session_start();
   $database= $_SESSION["database"];}
 else{ $database=$dbWork;}
 if($database!=''){
if(($_SERVER['SERVER_NAME']=="localhost")||($_SERVER['SERVER_NAME']=="LOCALHOST"))
{
$mysqli = new mysqli('localhost','root','juniorjmd',$database);}
else
{if(filter_var($_SERVER['SERVER_NAME'], FILTER_VALIDATE_IP))
	{$mysqli = new mysqli($_SERVER['SERVER_NAME'],'usuarioExterno','juniorjmd',$database);}
	else{$mysqli = new mysqli('josedominguez1.db.11457158.hostedresource.com','josedominguez1','joseD%2013',$database);}}
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
   return NULL;
}else{
return $mysqli;
}}else{return NULL;}
}
?>
