<?php 
$i=29;
$b=30;

$f=$i/$b;
if(is_double($f)){
	echo'es doble';
	echo 'la parte entera es '.intval($f);
}else{echo'no es doble';}
?>