<?php
include 'php\inicioFunction.php';
	$prueba = 'jose domigueza padilla';
  $RESP = rellenarTruncar($prueba,20,'&nbsp;',NULL,true) ;
	 echo  $RESP.'5<br/>';
	 	$prueba = 'jose';
	$RESP = rellenarTruncar($prueba,20,'&nbsp;',NULL,true)  ;
	 ECHO $RESP.'5<br/>';
	 ECHO str_pad('F',20,'&nbsp;',STR_PAD_RIGHT).'AJA<br/>';
	 echo str_pad($input, 10);                      // produce "Alien     "
echo str_pad($input, 10, "-=", STR_PAD_LEFT);  // produce "-=-=-Alien"
echo str_pad($input, 10, "_", STR_PAD_BOTH);   // produce "__Alien___"
echo str_pad($input,  6, "___");               // produces "Alien_"
echo str_pad($input,  3, "*");                 // produces "Alien"
	 ?>