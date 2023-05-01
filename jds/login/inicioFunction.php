<?php

function verificaSession_1()
{
    session_start();
    if($_SESSION['access'] ==false) 
        { header("location: ../login/");} 
    
}

function verificaSessionInventario_2($destino){
    session_start();
	if(!$destino){$destino="location: ../login.php";}
	if($_SESSION['access']==false) 
        { header($destino);} 
}
?>