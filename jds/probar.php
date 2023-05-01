<?php
ini_set('display_errors', '1');
$ventaId ='mv_34';
echo substr($ventaId, strpos($ventaId,"_")+1,strlen($ventaId)- strpos($ventaId,"_")); 
?>