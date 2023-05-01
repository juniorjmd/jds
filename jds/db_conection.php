<?php  
function cargarBD ($dbWork = NULL,$hostdb = NULL , $passdb = NULL , $userdb = NULL){

   $database= is_null($dbWork) ? $_SESSION["database"] : $dbWork;
  // echo $database;
   $host = is_null($hostdb) ? $_SESSION["host"] : $hostdb;
   $pass = is_null($passdb) ? $_SESSION["clavedb"] : $passdb;
   $user = is_null($userdb) ? $_SESSION["usuariodb"] : $userdb;
 $mysqli = new mysqli($host,$user ,$pass,$database); 
if (mysqli_connect_errno()) { 
    printf("Connect failed: %s\n", mysqli_connect_error());
   return false ;
}else{
return $mysqli;
}
}  
function cargarBDSession ($dbWork = NULL){
	session_start();
   $database= is_null($dbWork) ? $_SESSION["database"] : $dbWork;
if(($_SERVER['SERVER_NAME']=="localhost")||($_SERVER['SERVER_NAME']=="LOCALHOST"))
{
$mysqli = new mysqli('localhost','root','12345678',$database);}
else
{if(filter_var($_SERVER['SERVER_NAME'], FILTER_VALIDATE_IP))
	{$mysqli = new mysqli($_SERVER['SERVER_NAME'],'root','12345678',$database);}
	else{$host =  is_null($_SESSION["HOST"]) ? 'localhost' :$_SESSION["HOST"] ;//'pedrocontreras4.db.12851752.hostedresource.com'
		$usuarioDB =  is_null($_SESSION["usuarioDB"]) ? 'root' :$_SESSION["usuarioDB"] ;
		$claveDB  = is_null($_SESSION["claveDB"]) ? '12345678' :$_SESSION["claveDB"] ;
		$mysqli = new mysqli($host,$usuarioDB,$claveDB,$database);}}
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
   return false ;
}else{
return $mysqli;
}
}
?>
