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




function cargarBDSession ($dbWork = NULL,$hostdb = NULL , $passdb = NULL , $userdb = NULL){
	session_start();
   $database= is_null($dbWork) ? $_SESSION["database"] : $dbWork;
   $host = is_null($hostdb) ? $_SESSION["host"] : $hostdb;
   $pass = is_null($passdb) ? $_SESSION["clavedb"] : $passdb;
   $user = is_null($userdb) ? $_SESSION["usuariodb"] : $userdb;
if(($_SERVER['SERVER_NAME']=="localhost")||($_SERVER['SERVER_NAME']=="LOCALHOST"))
{
$mysqli = new mysqli('localhost','root','juniorjmd',$database);}
else
{if(filter_var($_SERVER['SERVER_NAME'], FILTER_VALIDATE_IP))
	{$mysqli = new mysqli($_SERVER['SERVER_NAME'],'usuarioExterno','juniorjmd',$database);}
	else{
		$mysqli = new mysqli($host,$user,$pass,$database);}}
if (mysqli_connect_errno()) { 
    printf("Connect failed: %s\n", mysqli_connect_error());
   return false ;
}else{
return $mysqli;
}
}
?>
